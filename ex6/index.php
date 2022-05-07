<?php
require 'connect/db.php';
header('Content-Type: text/html; charset=UTF-8');
if(isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] == 'GET' ){ 
    $value['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
    $value['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $value['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
    $value['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
    $value['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $value['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
    if(empty($_COOKIE['ability_value'])){
    $value_ability[] = array();
    $value_ability[0] = ' ';
    $value_ability[1] = ' ';
    $value_ability[2] = ' ';
    $value_ability[3] = ' ';
    }else{
        $value_ability = explode(',',$_COOKIE['ability_value']);
        $a = count($value_ability)-1;
        for($a ; $a < 4 ; $a++){
            $value_ability[$a] = '';
        }
    }
    $value['agree'] = empty($_COOKIE['agree_value']) ? '' : $_COOKIE['agree_value'];
    $message = array();
    $message['alert'] = TRUE;
    if(!empty($_COOKIE['save'])){
        setcookie('save','',1);
        $message['success'] = TRUE;
        $message['alert'] = FALSE;
    }
    $error = array();
    $error['name_empty'] = !empty($_COOKIE['name_error_empty']);
    $error['name'] = !empty($_COOKIE['name_error']);
    $error['email_empty'] = !empty($_COOKIE['email_error_empty']);
    $error['email'] = !empty($_COOKIE['email_error']);
    $error['email'] = !empty($_COOKIE['email_error']);
    $error['bio'] = !empty($_COOKIE['bio_error']);
    $error['year'] = !empty($_COOKIE['year_error']);
    $error['gender'] = !empty($_COOKIE['gender_error']);
    $error['limbs'] = !empty($_COOKIE['limbs_error']);
    $error['ability'] = !empty($_COOKIE['ability_error']);
    $error['agree'] = !empty($_COOKIE['agree_error']);
    if($error['name_empty']){
        setcookie('name_error_empty','',1);
        $message['name_empty'] = TRUE;
        $message['name'] = FALSE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if($error['name']){
        setcookie('name_error','',1);
        $message['name_empty'] = FALSE;
        $message['name'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if($error['email_empty']){
        setcookie('email_error_empty','',1);
        $message['email_empty'] = TRUE;
        $message['email'] = FALSE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if($error['email']){
        setcookie('email_error','',1);
        $message['email'] = TRUE;
        $message['email_empty'] = FALSE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if($error['bio']){
        setcookie('bio_error','',1);
        $message['bio'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if ($error['year']) {
        setcookie('year_error', '', 100000);
        $message['year'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if ($error['gender']) {
        setcookie('gender_error', '', 100000);
        $message['gender'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if ($error['limbs']) {
        setcookie('limbs_error', '', 100000);
        $message['limbs'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if($error['ability']){
        setcookie('ability_error','',1);
        $message['ability'] = TRUE;
        $message['success'] = FALSE;
    }
    if($error['agree']){
        setcookie('agree_error','',1);
        $message['agree'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    include('form.php');
}else if (!isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $message = array();
    $message['alert'] = TRUE;
    if(!empty($_COOKIE['save'])){
        setcookie('save','',1);
        $message['success'] = TRUE;
        $message['alert'] = FALSE;

        $log = $_COOKIE['login'];
        $passw = $_COOKIE['password'];
    }
    $error = array();
    $error['name_empty'] = !empty($_COOKIE['name_error_empty']);
    $error['name'] = !empty($_COOKIE['name_error']);
    $error['email_empty'] = !empty($_COOKIE['email_error_empty']);
    $error['email'] = !empty($_COOKIE['email_error']);
    $error['email'] = !empty($_COOKIE['email_error']);
    $error['bio'] = !empty($_COOKIE['bio_error']);
    $error['year'] = !empty($_COOKIE['year_error']);
    $error['gender'] = !empty($_COOKIE['gender_error']);
    $error['limbs'] = !empty($_COOKIE['limbs_error']);
    $error['ability'] = !empty($_COOKIE['ability_error']);
    $error['agree'] = !empty($_COOKIE['agree_error']);
    if($error['name_empty']){
        setcookie('name_error_empty','',1);
        $message['name_empty'] = TRUE;
        $message['name'] = FALSE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if($error['name']){
        setcookie('name_error','',1);
        $message['name_empty'] = FALSE;
        $message['name'] = TRUE;
        $message['success'] = FALSE;
    }
    if($error['email_empty']){
        setcookie('email_error_empty','',1);
        $message['email_empty'] = TRUE;
        $message['email'] = FALSE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if($error['email']){
        setcookie('email_error','',1);
        $message['email'] = TRUE;
        $message['email_empty'] = FALSE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if($error['bio']){
        setcookie('bio_error','',1);
        $message['bio'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if ($error['year']) {
        setcookie('year_error', '', 100000);
        $message['year'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if ($error['gender']) {
        setcookie('gender_error', '', 100000);
        $message['gender'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if ($error['limbs']) {
        setcookie('limbs_error', '', 100000);
        $message['limbs'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if($error['ability']){
        setcookie('ability_error','',1);
        $message['ability'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    if($error['agree']){
        setcookie('agree_error','',1);
        $message['agree'] = TRUE;
        $message['alert'] = FALSE;
        $message['success'] = FALSE;
    }
    $value = array();
    $value['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
    $value['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $value['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
    $value['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
    $value['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $value['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
    if(empty($_COOKIE['ability_value'])){
    $value_ability[] = array();
    $value_ability[0] = ' ';
    $value_ability[1] = ' ';
    $value_ability[2] = ' ';
    $value_ability[3] = ' ';
    }else{
        $value_ability = explode(',',$_COOKIE['ability_value']);
        $a = count($value_ability)-1;
        for($a ; $a < 4 ; $a++){
            $value_ability[$a] = '';
        }
    }
    $value['agree'] = empty($_COOKIE['agree_value']) ? '' : $_COOKIE['agree_value'];
    include('form.php');
}else if(isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] == 'POST' ){
    $regname ='/^[а-яЁё]+$/iu';
    $errors = FALSE;
    $power1=in_array('s1',$_POST['capabilities']) ? '1' : '0';
    $power2=in_array('s2',$_POST['capabilities']) ? '1' : '0';
    $power3=in_array('s3',$_POST['capabilities']) ? '1' : '0';
    if($power1 == 1){
        $ability = 'immortal' . ',';
    }
    if($power2 == 1 && !empty($ability)){
        $ability .= 'noclip' . ',';
    }else if($power2 == 1 && empty($ability)){
        $ability = 'noclip' . ',';
    }
    if($power3 == 1 && !empty($ability)){
        $ability .= 'flying' . ',';
    }else if($power3 == 1 && empty($ability)){
        $ability = 'flying' . ',';
    }
    if($power4 == 1 && !empty($ability)){
        $ability .= 'lazer' . ',';
    }else if($power4 == 1 && empty($ability)){
        $ability = 'lazer' . ',';
    }
    if(empty(htmlentities($_POST['name']))){
        setcookie('name_error_empty','1',time() + 24 * 60 * 60);
        $errors = TRUE;
    }else if(!preg_match($regname, $_POST['name'])){
        setcookie('name_error','1',time() + 24 * 60 * 60);
        setcookie('name_value',$_POST['name']);
        $errors = TRUE;
    }else{
        setcookie('name_value',$_POST['name'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($_POST['email'])){
        setcookie('email_error_empty','1',time() + 24 * 60 * 60);
        $errors = TRUE;
    }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        setcookie('email_error','1',time() + 24 * 60 * 60);
        setcookie('email_value',$_POST['email']);
        $errors = TRUE;
    }else{
        setcookie('email_value',$_POST['email'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($_POST['bio'])){
        setcookie('bio_error','1',time() + 24 * 60 *60);
        $errors = TRUE;
    }else{
        setcookie('bio_value',$_POST['bio'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($_POST['year'])){
        setcookie('year_error','1',time() + 24 * 60 *60);
        $errors = TRUE;
    }else{
        setcookie('year_value',$_POST['year'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($_POST['gender'])){
        setcookie('gender_error','1',time() + 24 * 60 *60);
        $errors = TRUE;
    }else{
        setcookie('gender_value',$_POST['gender'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($_POST['limbs'])){
        setcookie('limbs_error','1',time() + 24 * 60 *60);
        $errors = TRUE;
    }else{
        setcookie('limbs_value',$_POST['limbs'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($ability)){
        setcookie('ability_error','1',time() + 24 * 60 *60);
        $errors = TRUE;
    }else{
        setcookie('ability_value',$ability,time() + 24 * 60 * 60 * 30 * 12 );
    }
    if (empty($_POST['agree'])) {
        setcookie('agree_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }
      else {
        setcookie('agree_value', $_POST['agree'], time() + 12 * 30 * 24 * 60 * 60);
      }
    if ($errors) {
        header('Location: index.php');
        $message['success'] = FALSE;
        $message['alert'] = FALSE;
        exit();
    }
    else {
        setcookie('name_error_empty','', 1);
        setcookie('name_error', '', 100000);
        setcookie('email_error_empty','',1);
        setcookie('email_error', '', 1);
        setcookie('bio_error','', 1);
        setcookie('year_error', '', 1);
        setcookie('gender_error', '', 1);
        setcookie('limbs_error', '', 1);
        setcookie('ability_error','', 1);
        setcookie('checkbox_error', '', 1);
    }
    try{
        $id = $_SESSION['user']['id'];
        $stmt = $db->prepare("UPDATE users6 SET name = ?, mail = ?, bio = ?, date = ?, gender = ?, limbs = ? WHERE id = ?");
        $stmt -> execute(array($_POST['name'],$_POST['email'],$_POST['bio'],$_POST['year'],$_POST['gender'],$_POST['limbs'], $id));
        $stmt = $db->prepare("UPDATE  super_power6 SET superabilities = ? WHERE human_id = ?");
        $stmt -> execute([$ability,$id]);
    }catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    }
setcookie('save','1');
header('Location: index.php');
}else if(!isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $regname ='/^[а-яЁё]+$/iu';
    $errors = FALSE;
    $power1=in_array('s1',$_POST['capabilities']) ? '1' : '0';
    $power2=in_array('s2',$_POST['capabilities']) ? '1' : '0';
    $power3=in_array('s3',$_POST['capabilities']) ? '1' : '0';
    if($power1 == 1){
        $ability = 'immortal' . ',';
    }
    if($power2 == 1 && !empty($ability)){
        $ability .= 'noclip' . ',';
    }else if($power2 == 1 && empty($ability)){
        $ability = 'noclip' . ',';
    }
    if($power3 == 1 && !empty($ability)){
        $ability .= 'flying' . ',';
    }else if($power3 == 1 && empty($ability)){
        $ability = 'flying' . ',';
    }
    if($power4 == 1 && !empty($ability)){
        $ability .= 'lazer' . ',';
    }else if($power4 == 1 && empty($ability)){
        $ability = 'lazer' . ',';
    }
    if(empty(htmlentities($_POST['name']))){
        setcookie('name_error_empty','1',time() + 24 * 60 * 60);
        $errors = TRUE;
    }else if(!preg_match($regname, $_POST['name'])){
        setcookie('name_error','1',time() + 24 * 60 * 60);
        setcookie('name_value',$_POST['name']);
        $errors = TRUE;
    }else{
        setcookie('name_value',$_POST['name'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($_POST['email'])){
        setcookie('email_error_empty','1',time() + 24 * 60 * 60);
        $errors = TRUE;
    }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        setcookie('email_error','1',time() + 24 * 60 * 60);
        setcookie('email_value',$_POST['email']);
        $errors = TRUE;
    }else{
        setcookie('email_value',$_POST['email'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($_POST['bio'])){
        setcookie('bio_error','1',time() + 24 * 60 *60);
        $errors = TRUE;
    }else{
        setcookie('bio_value',$_POST['bio'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($_POST['year'])){
        setcookie('year_error','1',time() + 24 * 60 *60);
        $errors = TRUE;
    }else{
        setcookie('year_value',$_POST['year'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($_POST['gender'])){
        setcookie('gender_error','1',time() + 24 * 60 *60);
        $errors = TRUE;
    }else{
        setcookie('gender_value',$_POST['gender'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($_POST['limbs'])){
        setcookie('limbs_error','1',time() + 24 * 60 *60);
        $errors = TRUE;
    }else{
        setcookie('limbs_value',$_POST['limbs'],time() + 24 * 60 * 60 * 30 * 12 );
    }
    if(empty($ability)){
        setcookie('ability_error','1',time() + 24 * 60 *60);
        $errors = TRUE;
    }else{
        setcookie('ability_value',$ability,time() + 24 * 60 * 60 * 30 * 12 );
    }
    if (empty($_POST['agree'])) {
        setcookie('agree_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }
      else {
        setcookie('agree_value', $_POST['agree'], time() + 12 * 30 * 24 * 60 * 60);
      }
    if ($errors) {
        header('Location: index.php');
        $message['success'] = FALSE;
        $message['alert'] = FALSE;
        exit();
    }
    else {
        setcookie('name_error_empty','', 1);
        setcookie('name_error', '', 100000);
        setcookie('email_error_empty','',1);
        setcookie('email_error', '', 1);
        setcookie('bio_error','', 1);
        setcookie('year_error', '', 1);
        setcookie('gender_error', '', 1);
        setcookie('limbs_error', '', 1);
        setcookie('ability_error','', 1);
        setcookie('checkbox_error', '', 1);
    }
        try{
            $log = generateLogin(6);
            $passw =generatePassword(6);
            $hash = password_hash($passw, PASSWORD_DEFAULT);
            setcookie('login',$log);
            setcookie('password',$passw);
            $stmt = $db->prepare("INSERT INTO users6 SET login = ?, pass = ?, name = ?, mail = ?, bio = ?, date = ?, gender = ?, limbs = ?");
            $stmt -> execute(array($log,$hash,$_POST['name'],$_POST['email'],$_POST['bio'],$_POST['year'],$_POST['gender'],$_POST['limbs']));
            $res = $db->query("SELECT max(id) FROM users6");
            $row = $res->fetch();
            $count = (int) $row[0];
            $stmt = $db->prepare("INSERT INTO super_power6 SET human_id = ?, superabilities = ?");
            $stmt -> execute([$count, $ability]);
            setcookie('name_value','',1);
            setcookie('email_value','',1);
            setcookie('bio_value','',1 );
            setcookie('year_value','',1);
            setcookie('gender_value','',1);
            setcookie('limbs_value','',1);
            setcookie('ability_value','',1);
            setcookie('agree_value', '', 1);
            $message['success']= TRUE;
        }catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
    setcookie('save','1');
    header('Location: index.php');
}
function generateLogin($length = 6)
{
	$chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
	$size = strlen($chars) - 1;
	$login = '';
	while($length--) {
		$login .= $chars[random_int(0, $size)];
	}
	return $login;
}
function generatePassword($length = 6){
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ1234567890';
    $numChars = strlen($chars);
    $password = '';
    for ($i = 0; $i < $length; $i++) {
      $password .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $password;
  }
  function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>