<?php
require 'connect/db.php';
unset($_SESSION['user']);
setcookie('name_value','',1);
setcookie('email_value','',1);
setcookie('bio_value','',1 );
setcookie('year_value','',1);
setcookie('gender_value','',1);
setcookie('limbs_value','',1);
setcookie('ability_value','',1);
setcookie('agree_value', '', 1);
header('Location: index.php');
?>