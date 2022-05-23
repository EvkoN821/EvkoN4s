<?php

$user="u47559";
$pass = '5877201';
$db = new PDO('mysql:host=localhost;dbname=u47559', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

try{
    $stmt = $db->prepare("SELECT pass FROM admin_members WHERE login=:login");
    $stmt->bindParam(':login', $_SERVER['PHP_AUTH_USER']);
    $stmt->execute();
    $result = current(current($stmt->fetchAll(PDO::FETCH_ASSOC)));
}catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}

if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW']) || md5($_SERVER['PHP_AUTH_PW']) != $result) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
}
?>

<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Админка задания 7</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
</head>
<body>
<div class="container-fluid">
<?php

print('<div class="col-12">Вы успешно авторизовались и видите защищенные паролем данные.</div>');

session_start();
$_SESSION['root']=1;

try{
    $stmt1 = $db->prepare("SELECT * FROM members");
    $stmt1->execute();
    $data = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    $stmt2 = $db->prepare("SELECT * FROM powers2");
    $stmt2->execute();
    $powers = $stmt2->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}

$data_name = array('Id', 'Login', 'Pass', 'Name', 'Email', 'Date', 'Gender', 'Limbs', 'Bio', 'Change', 'Delete');
echo '<table class="table">';
echo '<thead>';
echo '<tr>';
foreach ($data_name as $field){
    echo '<th class="col">'.filter_var($field,FILTER_SANITIZE_SPECIAL_CHARS).'</th>';
}
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$power_value = array('endless life', 'through walls', 'levitation');
$powers_amount = array_fill_keys($power_value, 0);

$i = 0;
while(!empty($data[$i])){
    echo '<tr>';
    $powers_array = explode(',', $powers[$i]['powers']);

    if($powers_array != '') {
        foreach ($powers_array as $item) {
            if (in_array($item, $power_value)) {
                $powers_amount[$item]++;
            }
        }
    }
    foreach($data[$i] as $value){
        echo '<th class="col">'.$value.'</th>';
    }
    echo '<th class="col"><form method="POST"><input class="btn btn-outline-warning" type="submit" name="change'.$i.'" value="Change"></form></th>';
    echo '<th class="col"><form method="POST"><input class="btn btn-outline-danger" type="submit" name="delete'.$i.'" value="Delete"></form></th>';
    echo '</tr>';
    $i++;
}
echo '</tbody>';
echo '</table>';

echo '<table class="table">';
echo '<thead>';
echo '<tr>';

foreach($power_value as $item){
    echo '<th class="col">'.$item.'</th>';
}

echo '</thead>';
echo '</tr>';
echo '<tbody>';
echo '<tr>';
foreach($powers_amount as $value){
    echo '<th class="col">'.intval($value).'</th>';
}
echo '</tr>';
echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</body>';

for($i=0; $i<count($data); $i++){
    if(isset($_POST['change'.$i])){
        $_SESSION['login']=$data[$i]['login'];
        $_SESSION['uid']=$data[$i]['id'];
        header('Location: index.php');
        exit();
    }
}

for($i=0; $i<count($data); $i++){
    if(isset($_POST['delete'.$i])){
        try{
            $db = new PDO('mysql:host=localhost;dbname=u47559', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            $delete = $db->prepare("DELETE FROM members WHERE id=?");
            $delete->execute(array($data[$i]['id']));
        }catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        header('Location: admin.php');
        exit();
    }
}

?>

