<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $_SESSION['message'] = FALSE;
    $mess = empty($_COOKIE['message']) ? '0' : $_COOKIE['message'];
    setcookie('message','1',1);
}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
require 'connect/connection.php';
$login = $_POST['login'];
$password =$_POST['password'];

$check_user = mysqli_query($connect, "SELECT * FROM users6 WHERE login = '$login'");
if(mysqli_num_rows($check_user) > 0){
    $user = mysqli_fetch_assoc($check_user);
    if(password_verify($password,$user['pass'])){
        session_start();
        $id = $user['id'];
        $check_power = mysqli_query($connect, "SELECT * FROM super_power6 WHERE human_id = $id");
        $power =mysqli_fetch_assoc($check_power);
        $_SESSION['user'] = [
            "id" => $user['id'],
            "name" => $user['name'],
            "email" => $user['mail'],
            "bio" => $user['bio'],
            "year" => $user['date'],
            "gender" => $user['gender'],
            "limbs" => $user['limbs'],
            "ability" =>$power['superabilities']
        ];
        setcookie('name_value',$_SESSION['user']['name'],time() + 12 * 30 * 24 * 60 * 60);
        setcookie('email_value',$_SESSION['user']['email'], time() + 12 * 30 * 24 * 60 * 60);
        setcookie('bio_value',$_SESSION['user']['bio'], time() + 12 * 30 * 24 * 60 * 60);
        setcookie('year_value',$_SESSION['user']['year'], time() + 12 * 30 * 24 * 60 * 60);
        setcookie('gender_value',$_SESSION['user']['gender'], time() + 12 * 30 * 24 * 60 * 60);
        setcookie('limbs_value',$_SESSION['user']['limbs'],time() + 12 * 30 * 24 * 60 * 60) ;
        setcookie('ability_value',$_SESSION['user']['ability'], time() + 12 * 30 * 24 * 60 * 60);
        setcookie('agree_value', '1', time() + 12 * 30 * 24 * 60 * 60) ;
        setcookie('message','1',1);

        header('Location: index.php');
    }else{
        $_SESSION['message'] = TRUE;
        header('Location: login.php');
        setcookie('message','1');
    }
}else{
    $_SESSION['message'] = TRUE;
    setcookie('message','1');
    header('Location: login.php');
}
}
?>
<!DOCTYPE html>
<html>
   <head>
        <meta charset="utf-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <title>Вход</title>
        <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    <form  method="post" action="login.php">
        <div class="alert alert-danger"role="alert" <?php
         if($mess == '0'){
            print('hidden');
         }else{
            print(' ');
         }
         ?>>
            <?php
            if($mess == '1'){
                print('Неправильный логин или пароль');
            }
            ?>
        </div>
        <div class="popup" id="popup">
            <div class="popup__body">
                <div class="popup__content">
                    <div class="popup__title">Вход</div>
                    <div class="popup__text">
                            <div>
                                <input type="text" name="login" class="login__elem" placeholder="Логин">
                            </div>
                            <div>
                                <input type="text" name="password" class="login__elem" placeholder="Пароль">
                            </div>
                        <div>
                            <input type="submit" class="popup__btn" value="Войти" name="do_login">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>