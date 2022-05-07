<?php
$user = 'u47559';
$pass = '5877201';
$db = new PDO('mysql:host=localhost;dbname=u47559', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

if(!isset($_SESSION)){
    session_start();
}
?>