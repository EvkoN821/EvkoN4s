<?php
header('Content-Type: text/html; charset=UTF-8');

  $user = 'u47559';
  $pass = '5877201';
  $db = new PDO('mysql:host=localhost;dbname=u47559', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.<br>';
    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
  }
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['kon'] = !empty($_COOKIE['kon_error']);
  $errors['super'] = !empty($_COOKIE['super_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['contr_check'] = !empty($_COOKIE['contr_check_error']);
  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    $messages['name_message'] = '<div class="error">Заполните имя.<br>Поле может быть заполнено символами только русского или только английского алфавитов</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages['email_message'] = '<div class="error">Заполните e-mail.<br>Поле может быть заполнено только символами английского алфавита, цифрами и знаком "@"</div>';
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages['year_message'] = '<div class="error">Выберите год рождения</div>';
  }
  if ($errors['gender']) {
    setcookie('gender_error', '', 100000);
    $messages['gender_message'] = '<div class="error">Укажите ваш пол</div>';
  }
  if ($errors['kon']) {
    setcookie('kon_error', '', 100000);
    $messages['kon_message'] = '<div class="error">Веберите количество конечностей</div>';
  }
  if ($errors['super']) {
    setcookie('super_error', '', 100000);
    $messages[] = '<div class="error">Веберите хотя бы одну сверхспособность</div>';
  }
  if ($errors['bio']) {
    setcookie('bio_error', '', 100000);
    $messages['bio_message'] = '<div class="error">Расскажите о себе</div>';
  }
  if ($errors['contr_check']) {
    setcookie('contr_check_error', '', 100000);
    $messages['contr_check_message'] = '<div class="error">Вы не можете отправить форму, не ознакомившись с контрактом</div>';
  }
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['kon'] = empty($_COOKIE['kon_value']) ? '' : $_COOKIE['kon_value'];
  $values['super'] = [];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['contr_check'] = empty($_COOKIE['contr_check_value']) ? '' : $_COOKIE['contr_check_value']; 
  $super = array(
    '1' => "1",
    '2' => "2",
    '3' => "3",
  ); 
  if(!empty($_COOKIE['super_value'])) {
    $super_value = unserialize($_COOKIE['super_value']);
    foreach ($super_value as $s) {
      if (!empty($super[$s])) {
          $values['super'][$s] = $s;
      }
    }
  }
  if (!empty($_COOKIE[session_name()]) &&
  session_start() && !empty($_SESSION['login'])) {
    try{
      $sth = $db->prepare("SELECT id FROM users6 WHERE login = ?");
      $sth->execute(array($_SESSION['login']));
      $user_id = ($sth->fetchAll(PDO::FETCH_COLUMN, 0))['0']; 
      $sth = $db->prepare("SELECT * FROM application6 WHERE id = ?");
      $sth->execute(array($user_id));
      $user_data = ($sth->fetchAll(PDO::FETCH_ASSOC)); 
      foreach ($user_data as $key=>$val){
        $values[$key] = $val;
      }
      $values['super'] = [];
      $super_value = unserialize($_COOKIE['super_value']);
        foreach ($super_value as $s) {
            if (!empty($super[$s])) {
                $values['super'][$s] = $s;
            }
        }
      } 
      catch(PDOException $e) {
          print($e->getMessage());
          exit();
      }
  }
  include('form.php');
}
else {
  $errors = FALSE;
if (empty($_POST['name'])) {
    setcookie('name_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if(!preg_match("/^[а-яё]|[a-z]$/iu", $_POST['name'])){
    setcookie('name_error', $_POST['name'], time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['email'])){
    setcookie('email_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+.[a-zA-Z.]{2,5}$/", $_POST['email'])){
    setcookie('email_error', $_POST['email'], time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }
  if ($_POST['year']=='') {
    setcookie('year_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['gender'])) {
    setcookie('gender_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else{
  setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['kon'])) {
    setcookie('kon_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('kon_value', $_POST['kon'], time() + 30 * 24 * 60 * 60);
  }
  $super=array();
  if(empty($_POST['super'])){
    setcookie('super_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else{
    foreach ($_POST['super'] as $key => $value) {
      $super[$key] = $value;
    }
    setcookie('super_value', serialize($super), time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['bio'])) {
    setcookie('bio_error', ' ', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['contr_check'])) {
    setcookie('contr_check_error', ' ', time() + 24 * 60 * 60);
    setcookie('contr_check_value', '', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('contr_check_value', $_POST['contr_check'], time() + 30 * 24 * 60 * 60);
  }

  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('kon_error', '', 100000);
    setcookie('super_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('contr_check_error', '', 100000);
  }
  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
    try {
      $stmt = $db->prepare("SELECT id FROM users6 WHERE login =?");
      $stmt -> execute(array($_SESSION['login'] ));
      $user_id = ($stmt->fetchAll(PDO::FETCH_COLUMN))['0'];

      $stmt = $db->prepare("UPDATE application6 SET name = ?, email = ?, year = ?, gender = ?, kon = ?, bio = ? WHERE id =?");
      $stmt -> execute(array(
          $_POST['name'],
          $_POST['email'],
          $_POST['year'],
          $_POST['gender'],
          $_POST['kon'],
          $_POST['bio'],
          $user_id,
      ));
      $sth = $db->prepare("DELETE FROM Superpowers6 WHERE id = ?");
      $sth->execute(array($user_id));
      $stmt = $db->prepare("INSERT INTO Superpowers6 SET id = ?, superpowers = ?");
      foreach($_POST['super'] as $s){
          $stmt -> execute(array(
            $user_id,
            $s,
          ));
        }
      }
    catch(PDOException $e){
      print('Error: ' . $e->getMessage());
      exit();
    }
  }
  else {
    $sth = $db->prepare("SELECT login FROM users6");
    $sth->execute();
    $login_array = $sth->fetchAll(PDO::FETCH_COLUMN);
    $flag=true;
    do{
      $login = rand(1,1000);
      $pass = rand(1,10000);
      foreach($login_array as $key=>$value){
        if($value == $login)
          $flag=false;
      }
    }while($flag==false);
    $hash = password_hash((string)$pass, PASSWORD_BCRYPT);
    setcookie('login', $login);
    setcookie('pass', $pass);
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
      $id_db = $db->lastInsertId();
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
  setcookie('save', '1');
  header('Location: index.php');
}
