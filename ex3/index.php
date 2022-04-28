<?php
header('Content-Type: text/html; charset=UTF-8');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        print('Спасибо, результаты сохранены.');
    }
    include('form.php');
    exit();
}

$errors = FALSE;
if (empty($_POST['name'])) {
    print('Заполните имя.<br/>');
    $errors = TRUE;
}
if (empty($_POST['email'])) {
    print('Заполните email.<br/>');
    $errors = TRUE;
}
if (empty($_POST['date'])) {
    print('Выберите дату.<br/>');
    $errors = TRUE;
}
if (empty($_POST['gender'])) {
    print('Выберите пол.<br/>');
    $errors = TRUE;
}
if (empty($_POST['limbs'])) {
    print('Выберите количество конечностей.<br/>');
    $errors = TRUE;
}
if (empty($_POST['select'])) {
    print('Выберите суперспособнос(ть/ти).<br/>');
    $errors = TRUE;
}
if (empty($_POST['bio'])) {
    print('Расскажите о себе.<br/>');
    $errors = TRUE;
}
if (empty($_POST['policy'])) {
    print('Ознакомтесь с политикой обработки данных.<br/>');
    $errors = TRUE;
}

if ($errors) {
    exit();
}

$name = $_POST['name'];
$email = $_POST['email'];
$date = $_POST['date'];
$gender = $_POST['gender'];
$limbs = $_POST['limbs'];
$policy = $_POST['policy'];
$powers = implode(',',$_POST['select']);
$user = 'u47559';
$pass = '5877201';
$db = new PDO('mysql:host=localhost;dbname=u47559', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

try {
  $stmt = $db->prepare("INSERT INTO users SET name = ?, email = ?, date = ?, gender = ?, limbs = ?, policy = ?");
  $stmt -> execute(array($name, $email, $date, $gender, $limbs, $policy));
  $power_id = $db->lastInsertId();
  
  $superpowers = $db->prepare("INSERT INTO powers SET power_id = ?, powers = ?");
  $superpowers -> execute(array($power_id, $powers));
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

header('Location: ?save=1');