<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<?php
$db_user = 'u47559';   
$db_pass = '5877201';
$db = new PDO('mysql:host=localhost;dbname=u47559', $db_user, $db_pass, array(
    PDO::ATTR_PERSISTENT => true
));
$login = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
$stmt = $db->prepare("SELECT * FROM admin WHERE login = ?");
      $stmt->execute(array(
        $login
      ));
$admin_pass = $stmt->fetch();
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' ||
    $_SERVER['PHP_AUTH_PW']!='admin'){
      header('HTTP/1.1 401 Unanthorized');
      header('WWW-Authenticate: Basic realm="My site"');
      print('<h1>401 Требуется авторизация</h1>');
      exit();
}
print('Вы успешно авторизовались и видите защищенные паролем данные.<br>');
function show_tables($db){
  $sql = 'SELECT  application6.*, 
                    SuperDef.name as power,
                    users6.login
            FROM application6
            INNER JOIN Superpowers6
                ON application6.id = Superpowers6.id
            INNER JOIN SuperDef 
                ON Superpowers6.superpowers = SuperDef.id
            INNER JOIN users6 
                ON users6.id = application6.id;';
  ?>
  <table class="table">
  <caption>users' data</caption> 
    <tr><th>id</th><th>name</th><th>e-mail</th><th>year</th><th>gender</th><th>kon</th><th>bio</th><th>superpower</th><th>login</th><th colspan="3">action</th></tr><!--ряд с ячейками заголовков-->
  <?php
	  foreach ($db->query($sql, PDO::FETCH_ASSOC) as $row) {
      print('<tr>');
      foreach ($row as $v){
        print('<td>'.$v. '</td>');
      }
      print('<td colspan="2"> <a href="?act=edit_article&edit_id='.$row["id"].'">edit</a></td>   ');print('<td> <a href="?act=delete_article&delete_id='.$row["id"].'">delete</a></td>');
    } 
    print('</tr></table>');
    print('<td> <a href="?act=add_article">add</a></td><br>');
    $sql = 'SELECT SuperDef.name as superpower, COUNT(superpowers) as number_of_users
            FROM Superpowers6 
            LEFT JOIN SuperDef
            ON Superpowers6.superpowers=SuperDef.id
            GROUP BY superpowers;';
    ?>
    <table class="table">
    <caption>superpowers' statistics</caption> 
      <tr><th>superpower</th><th>number_of_users</th></tr>
    <?php
    foreach ($db->query($sql, PDO::FETCH_ASSOC) as $row) {
      print('<tr>');
      foreach ($row as $k=>$v){
	  	  print('<td>'.$v. '</td>');
      }
    }print('</tr></table>');
    print('<br><a href=login.php?do=logout> Выход</a><br>');
}

function errors(){
  $errors = FALSE;
    if (empty($_POST['name'])&&empty($_GET['edit_id'])) {
      $errors = TRUE;
    }
    else if(!empty($_POST['name'])&&!preg_match("/^[а-яё]|[a-z]$/iu", $_POST['name'])){
      $errors = TRUE;
    }
    if (empty($_POST['email'])&&empty($_GET['edit_id'])){
      $errors = TRUE;
    }
    else if(!empty($_POST['email'])&&!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+.[a-zA-Z.]{2,5}$/", $_POST['email'])){
      $errors = TRUE;
    }
    if (empty($_POST['year'])&&empty($_GET['edit_id'])){
      $errors = TRUE;
    }
    if (empty($_POST['gender'])&&empty($_GET['edit_id'])) {
      $errors = TRUE;
    }
    if (empty($_POST['kon'])&&empty($_GET['edit_id'])) {
      $errors = TRUE;
    }
    $super=array();
    if(empty($_POST['super'])&&empty($_GET['edit_id'])){
      $errors = TRUE;
    }
    else if(!empty($_POST['super'])){
      foreach ($_POST['super'] as $key => $value) {
        $super[$key] = $value;
      }
    }
    if (empty($_POST['bio'])&&empty($_GET['edit_id'])) {
      $errors = TRUE;
    }
    if ($errors) {
      return true;
    }
    else{
      return false;
    }
}
function form($db){
  ?>
  <label for='name'>Имя</label>
    <input name='name'><br>
  <label for='email'>E-mail</label>
    <input name='email'><br>
  <label for='year'>Год</label>
  <select name='year'>
		<?php 
      echo '<option>' . '' . '</option>';
			for ($i = 1980; $i <= 2014; $i++)
				echo '<option>' . $i . '</option>';
		?>
	</select><br>
  <label>Пол:</label>
	  <input type="radio" value="male" name='gender'>Мужской
	  <input type="radio" value="female" name=gender>Женский<br>  
  <label>Количество конечностей:</label>
	  <input type="radio" name='kon' value='1'>1
	  <input type="radio" name='kon' value='2'>2
	  <input type="radio" name='kon' value='3'>3
	  <input type="radio" name='kon' value='4'>4<br>	
  <label>Сверхспособности:</label>
	  <?php
	  	$sql = 'SELECT * FROM SuperDef';
	  	foreach ($db->query($sql) as $row) {
	  		?><input type="checkbox" value=<?php print $row['id']?> name=super[]> 
	  		<?php print $row['name'] . "\t";
	  	}
	  ?><br>
  <label for="bio">Биография</label>
	  <textarea name='bio'></textarea><br>
  <?php
}
function delete_user($db, $del){
  try{
    $sth = $db->prepare("DELETE FROM application6 WHERE id = ?");
    $sth->execute(array($del));
    $sth = $db->prepare("DELETE FROM Superpowers6 WHERE id = ?");
    $sth->execute(array($del));
    $sth = $db->prepare("DELETE FROM users6 WHERE id = ?");
    $sth->execute(array($del));
  }
  catch(PDOException $e){
    print('Error: ' . $e->getMessage());
    exit();
  }
}
function add_user($db){
  $sth = $db->prepare("SELECT login FROM users6");
  $sth->execute();
  $login_array = $sth->fetchAll(PDO::FETCH_COLUMN);
  $flag=true;
  do{
    $login = rand(1,1000);
    $pass = rand(1,10000);
    foreach($login_array as $value){
      if($value == $login)
        $flag=false;
    }
  }while($flag==false);
  $hash = password_hash((string)$pass, PASSWORD_BCRYPT);
  try {
    $stmt = $db->prepare("INSERT INTO application6 SET name = ?, email = ?, year = ?, gender = ?, kon = ?, bio = ?");
    $stmt -> execute(array(
        $_POST['name'],
        $_POST['email'],
        $_POST['year'],
        $_POST['gender'],
        $_POST['kon'],
        $_POST['bio'],
      )
    );
    $id_db = $db->lastInsertId("application6");
    $stmt = $db->prepare("INSERT INTO Superpowers6 SET id = ?, superpowers = ?");
    foreach($_POST['super'] as $s){
        $stmt -> execute(array(
          $id_db,
          $s,
        ));
      }
    $stmt = $db->prepare("INSERT INTO users6 SET login = ?, pass = ?");
    $stmt -> execute(array(
        $login,
        $hash,
      )
    );
  } 
  catch(PDOException $e){
    print('Error: ' . $e->getMessage());
    exit();
  }
}
function edit_user($db, $edit){
  try {
    $stmt = $db->prepare('SELECT * FROM application6 WHERE id=?');
    $stmt -> execute(array($edit));
    $a = array();
    $old_data = ($stmt->fetchAll(PDO::FETCH_ASSOC))['0'];
    foreach ($old_data as $key=>$val){
      $a[$key] = $val;
    }
    $name = empty($_POST['name']) ? $a['name'] : $_POST['name'];
    $email = empty($_POST['email']) ? $a['email'] : $_POST['email'];
    $year = empty($_POST['year']) ? $a['year'] : $_POST['year'];
    $gender = empty($_POST['gender']) ? $a['gender'] : $_POST['gender'];
    $kon = empty($_POST['kon']) ? $a['kon'] : $_POST['kon'];
    $bio = empty($_POST['bio']) ? $a['bio'] : $_POST['bio'];
    $stmt = $db->prepare("UPDATE application6 SET name = ?, email = ?, year = ?, gender = ?, kon = ?, bio = ? WHERE id =?");
    $stmt -> execute(array(        $name,        $email,       $year,        $gender,        $kon,        $edit    ));
    if(!empty($_POST['super'])){
      $sth = $db->prepare("DELETE FROM Superpowers6 WHERE id = ?");
      $sth->execute(array($edit));
      $stmt = $db->prepare("INSERT INTO Superpowers6 SET id = ?, superpowers = ?");
      foreach($_POST['super'] as $s){
          $stmt -> execute(array(
            $edit,
            $s,
          ));
        }
    }
  }
  catch(PDOException $e){
    print('Error: ' . $e->getMessage());
    exit();
  }
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
  show_tables($db);
  if(isset($_GET['act'])&&$_GET['act']=='edit_article'){
    ?><form action="" method="post">
      <h5>Редактировать профиль с id=<?php print($_GET['edit_id']); ?></h5>
    <p>
      <?php form($db);?>
    </p>
    <p><button type="submit" value="send">Отправить</button></p>
    </form>
    <?php
  }
  else if(isset($_GET['act'])&&$_GET['act']=='add_article'){
    ?><form action="" method="post">
      <h5>Добавить профиль</h5>
    <p>
      <?php form($db);?>
    </p>
    <p><button type="submit" value="send">Отправить</button></p>
    </form>
    <?php
     }
  else if(isset($_GET['act'])&&$_GET['act']=='delete_article'){
    ?>
    <form action="" method="post">
    <h5>Удалить пользователя c id=<?php print($_GET['delete_id']);?>?</h5>
    <p><button type="submit" value="send">Ок</button></p>
    </form>
    <?php
    }
}
else{
  try {
    if(!empty($_GET['delete_id'])){delete_user($db, $_GET['delete_id']);}
    if(!empty($_GET['edit_id']))if(!errors()){edit_user($db, $_GET['edit_id']);}
    if(isset($_GET['act'])&&$_GET['act']=='add_article'){add_user($db);}
  }
  catch(PDOException $e) {
    echo 'Ошибка: ' . $e->getMessage();
    exit();
  }
  header('Location: admin.php');
}


