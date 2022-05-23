<?php

header('Content-Type: text/html; charset=UTF-8');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf(
        'Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass'])
      );
    }
  }
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['date'] = !empty($_COOKIE['date_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['select'] = !empty($_COOKIE['select_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['policy'] = !empty($_COOKIE['policy_error']);

  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    $messages[] = '<div class="error">Введите имя.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Введите верный email.</div>';
  }
  if ($errors['date']) {
    setcookie('date_error', '', 100000);
    $messages[] = '<div class="error">Введите корректную дату рождения.</div>';
  }
  if ($errors['gender']) {
    setcookie('gender_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
  }
  if ($errors['limbs']) {
    setcookie('limbs_error', '', 100000);
    $messages[] = '<div class="error">Выберите количество конечностей.</div>';
  }
  if ($errors['select']) {
    setcookie('select_error', '', 100000);
    $messages[] = '<div class="error">Выберите суперспособнос(ть/ти).</div>';
  }
  if ($errors['bio']) {
    setcookie('bio_error', '', 100000);
    $messages[] = '<div class="error">Расскажите о себе.</div>';
  }
  if ($errors['policy']) {
    setcookie('policy_error', '', 100000);
    $messages[] = '<div class="error">Ознакомтесь с политикой обработки данных.</div>';
  }

  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : strip_tags($_COOKIE['name_value']);
  $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
  $values['date'] = empty($_COOKIE['date_value']) ? '' : strip_tags($_COOKIE['date_value']);
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : strip_tags($_COOKIE['gender_value']);
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : strip_tags($_COOKIE['limbs_value']);
  $values['select'] = empty($_COOKIE['select_value']) ? '' : strip_tags($_COOKIE['select_value']);
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : strip_tags($_COOKIE['bio_value']);
  $values['policy'] = empty($_COOKIE['policy_value']) ? '' : strip_tags($_COOKIE['policy_value']);

  $error = true;
  foreach($errors as $item){
      if($item){
          $error = false;
          break;
      }
  }

  if ($error && !empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) {
    try {
      $user = 'u47559';
      $pass = '5877201';
      $member = $_SESSION['login'];
      $db = new PDO('mysql:host=localhost;dbname=u47559', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
      $stmt = $db->prepare("SELECT * FROM members WHERE login = ?");
      $stmt->execute(array($member));
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $values['name'] = filter_var($result['name'],FILTER_SANITIZE_SPECIAL_CHARS);
      $values['email'] = filter_var($result['email'],FILTER_SANITIZE_SPECIAL_CHARS);
      $values['date'] = filter_var($result['date'],FILTER_SANITIZE_SPECIAL_CHARS);
      $values['gender'] = filter_var($result['gender'],FILTER_SANITIZE_SPECIAL_CHARS);
      $values['limbs'] = intval($result['limbs']);
      $values['bio'] = filter_var($result['bio'],FILTER_SANITIZE_SPECIAL_CHARS);;
      $values['policy'] = filter_var($result['policy'],FILTER_SANITIZE_SPECIAL_CHARS);

      $powers = $db->prepare("SELECT * FROM powers2 WHERE user_login = ?");
      $powers->execute(array($member));
      $result = $powers->fetch(PDO::FETCH_ASSOC);
      $values['select'] = $result['powers'];
    } catch (PDOException $e) {
      print('Error : ' . $e->getMessage());
      exit();
    }
    if(isset($_SESSION['root'])){
        printf('<div>Изменение данных пользователя %s, uid %d</div>', $_SESSION['login'], $_SESSION['uid']);
    } else {
        printf('<div>Вход с логином %s, uid %d</div>', $_SESSION['login'], $_SESSION['uid']);
    }
  }
  include('form.php');
}
else if(isset($_SESSION['csrf']) && $_POST['csrf']==$_SESSION['csrf']){
  $errors = FALSE;
  if (!preg_match('/^[a-z0-9_\s]+$/i', $_POST['name'])) {
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('name_value', $_POST['name'], time() + 12 * 30 * 24 * 60 * 60);
  }
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('email_value', $_POST['email'], time() + 12 * 30 * 24 * 60 * 60);
  }
  $date= explode('-', $_POST['date']);
  $age = (int)date('Y') - (int)$date[0];
  if ($age > 100 || $age < 0) {
    setcookie('date_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('date_value', $_POST['date'], time() + 12 * 30 * 24 * 60 * 60);
  }

  if (empty($_POST['gender'])) {
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('gender_value', $_POST['gender'], time() + 12 * 30 * 24 * 60 * 60);
  }

  if (empty($_POST['limbs'])) {
    setcookie('limbs_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('limbs_value', $_POST['limbs'], time() + 12 * 30 * 24 * 60 * 60);
  }

  if (empty($_POST['select'])) {
    setcookie('select_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('select_value', $_POST['select'], time() + 12 * 30 * 24 * 60 * 60);
  }

  if (empty($_POST['bio'])) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('bio_value', $_POST['bio'], time() + 12 * 30 * 24 * 60 * 60);
  }

  if (empty($_POST['policy'])) {
    setcookie('policy_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('policy_value', $_POST['policy'], time() + 12 * 30 * 24 * 60 * 60);
  }

  if ($errors) {
    header('Location: index.php');
    exit();
  } else {
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('date_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('select_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('policy_error', '', 100000);
  }
  $user = 'u47559';
  $pass = '5877201';
  $name = $_POST['name'];
  $email = $_POST['email'];
  $date = $_POST['date'];
  $gender = $_POST['gender'];
  $limbs = $_POST['limbs'];
  $bio = $_POST['bio'];
  $policy = $_POST['policy'];
  $powers = implode(',', $_POST['select']);
  $member = $_SESSION['login'];

  $db = new PDO('mysql:host=localhost;dbname=u47559', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
    try {
      $stmt = $db->prepare("UPDATE members SET name = ?, email = ?, date = ?, gender = ?, limbs = ?, bio = ?, policy = ? WHERE login = ?");
      $stmt->execute(array($name, $email, $date, $gender, $limbs, $bio, $policy, $member));

      $superpowers = $db->prepare("UPDATE powers2 SET powers = ? WHERE user_login = ? ");
      $superpowers->execute(array($powers, $member));
    } catch (PDOException $e) {
      print('Error : ' . $e->getMessage());
      exit();
    }
  } else {

    $login = uniqid();
    $password = uniqid();
    $hash = md5($password);
    setcookie('login', $login);
    setcookie('pass', $password);

    try {
      $stmt = $db->prepare("INSERT INTO members SET login = ?, pass = ?, name = ?, email = ?, date = ?, gender = ?, limbs = ?, bio = ?, policy = ?");
      $stmt->execute(array($login, $hash, $name, $email, $date, $gender, $limbs, $bio, $policy));

      $superpowers = $db->prepare("INSERT INTO powers2 SET powers = ?, user_login = ? ");
      $superpowers->execute(array($powers, $login));
    } catch (PDOException $e) {
      print('Error : ' . $e->getMessage());
      exit();
    }
  }

  if(session_start() && isset($_SESSION['root'])){
      header('Location: admin.php');
      exit();
  } else {
      setcookie('save', '1');
      header('Location: ./');
  }

}