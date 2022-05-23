<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();

function csrf(){
    return md5(uniqid("", true));
}

if (!empty($_SESSION['login'])) {
  header('Location: ./');
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['logout'])) {
    session_destroy();
    $_SESSION['login'] = '';
    header('Location: ./');
  }
  if (!empty($_GET['error'])) {
    print('<div>Не верный пароль/логин проверьте корректность введенных данных</div>');
  }
?>

  <form action="" method="POST">
      <input type="hidden" name="csrf" value="<?php print $_SESSION['csrf']=csrf();?>">
    <span>Логин:</span>
    <input name="login" />
    <span>Пароль:</span>
    <input name="pass" />
    <input type="submit" value="Войти" />
  </form>

<?php
}
else if(isset($_SESSION['csrf']) && $_POST['csrf']==$_SESSION['csrf']){
  $user = 'u47559';
  $pass = '5877201';
  $db = new PDO('mysql:host=localhost;dbname=u47559', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

  $member = $_POST['login'];
  $member_pass_hash = md5($_POST['pass']);

  try {
    $stmt = $db->prepare("SELECT * FROM members WHERE login = ?");
    $stmt->execute(array($member));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
  }
  if ($result['pass'] == $member_pass_hash) {

    $_SESSION['login'] = $_POST['login'];
    $_SESSION['uid'] = $result['id'];

    header('Location: ./');
  } else {
    header('Location: ?error=1');
  }
}