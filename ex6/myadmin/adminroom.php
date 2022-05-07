<?php
if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
    require "../connect/connection.php";
$user = 'u47559';
$pass = '2251704';
$db = new PDO('mysql:host=localhost;dbname=u47559', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

$res = $db->query("SELECT max(id) FROM users6");
$row = $res->fetch();
$count = (int) $row[0];
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])){
    if($_POST['select_user'] == 0){
        header('Location: adminroom.php');
    }
    $user_id =  mysqli_real_escape_string($connect ,$_POST['select_user']);
    $sql = "DELETE FROM users6 WHERE id = '$user_id'";
    mysqli_query($connect, $sql);
    $sql = "DELETE FROM super_power6 WHERE id = '$user_id'";
    mysqli_query($connect, $sql);
}else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])){
    if($_POST['select_user'] == 0){
       header('Location: adminroom.php');
    }
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
    try{
        $id = $_COOKIE['id'];
        $stmt = $db->prepare("UPDATE users6 SET name = ?, mail = ?, bio = ?, date = ?, gender = ?, limbs = ? WHERE id = ?");
        $stmt -> execute(array($_POST['name'],$_POST['email'],$_POST['bio'],$_POST['year'],$_POST['gender'],$_POST['limbs'], $id));
        $stmt = $db->prepare("UPDATE  super_power6 SET superabilities = ? WHERE human_id = ?");
        $stmt -> execute([$ability,$id]);
        setcookie('id','',1);
    }catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    }
}
?>
<!Doctype html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="adminroom.css">
    <title>Комната администратора</title>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class = "body">
    <div class="header">
        <header>
            <div class="top">
                <div class="content"></div>
                <div class="exit">
                    <a class ="quit" href="../index.php">Выйти</a>
                </div>
            </div>
        </header>
    </div>
    <div class="wrapper">
        <div class="main_content">
            <form method="POST" action="adminroom.php">
                <div class="select_user">
                    <select name="select_user" class ="slc_user" id="selector_user">
                    <option selected disabled value ="0">Выбрать пользователя</option>
                        <?php
                        for($index =1 ;$index <= $count;$index++){
                            $check_user = mysqli_query($connect, "SELECT * FROM users6 WHERE id = $index");
                            $user = mysqli_fetch_assoc($check_user);
                            if($user['id'] == $index){
                                print("<option value =" . $index . ">" . "id : ". $user['id'] . " Имя : " . $user['name'] . " Почта : ". $user['mail'] . " Дата рождения : ". $user['date'] . " Пол : ". $user['gender'] . " Кол. конечностей : ". $user['limbs']  ."</option>");//Добавление в список пользователя с существующим айди
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="btn_action">
                    <button name ="edit_user" class="btn_edit" type = "submit">Редактировать пользователя</button>
                    <button name ="delete_user" class="btn_delete" type = "submit">Удалить пользователя</button>
                </div>
                <div class="select_power">
                    <select name ="select_power" class ="slc_power" id = "selector_power">
                        <option value ="1" selected disabled>Выбрать способность</option>
                        <option value ="immortal">бессмертие</option>
                        <option value ="noclip">прохождение сквозь стены</option>
                        <option value ="flying">левитация</option>
                        <option value ="lazer">лазеры из глаз</option>
                    </select>
                </div>
                <div class="btn_action">
                    <button name ="num_power" class ="btn_power" type = "submit">Показать количество способностей</button>
                </div>
                <?php
                    if(isset($_POST['num_power']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
                        if( !isset($_POST['select_power'])){
                            header('Location: adminroom.php');
                         }
                        $user_power =  mysqli_real_escape_string($connect ,$_POST['select_power']);
                        $check_powers = mysqli_query($connect, "SELECT superabilities FROM super_power6 WHERE superabilities LIKE '%$user_power%'");
                        $num_power = mysqli_num_rows($check_powers);
                        print("<div class=" ."num_power" .">
                        <p>Количество людей со способностью " . $_POST['select_power'] . " : " . $num_power."
                        </div>");
                    }
                ?>
            </form>
        </div>
    </div>

<?php
    if(isset($_POST['edit_user']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['select_user'] == 0){
            header('Location: adminroom.php');
        }   
        $user_id =  mysqli_real_escape_string($connect ,$_POST['select_user']);
        $check_user = mysqli_query($connect, "SELECT * FROM users6 WHERE id = '$user_id'");
        $user = mysqli_fetch_assoc($check_user);
        $check_power = mysqli_query($connect, "SELECT * FROM super_power6 WHERE human_id = '$user_id'");
        $power =mysqli_fetch_assoc($check_power);
        setcookie('id',$user['id']);
        $value_ability = explode(',',$power['superabilities']);
        $a = count($value_ability)-1;
        for($a ; $a < 4 ; $a++){
            $value_ability[$a] = '';
        }
    }
        ?>
        <?php
        if(isset($_POST['edit_user'])){
            if($_POST['select_user']== 0){
                header('Location: adminroom.php');
            }
            ?>        
            <div class = "wrapper">
                <form method = "POST" action = "adminroom.php">
                    <div>
                        <input class="webform__form-elem form__input _req"  id="names" type="text" name="name"
                            placeholder="Имя" value= "<?php print($user['name']); ?>" >
                    </div>
                    <div>
                    <input class="webform__form-elem form__input _req _email" id="email" type="email" name="email"
                            placeholder="E-mail" value= "<?php print($user['mail']);?>">
                    </div>
                    <div>
                        <textarea id="comment" class="webform__form-elem form__input _req" type="text" name="bio" placeholder="Биография" ><?php print($user['bio']); ?></textarea>
                    </div>
                    <div class="form_item form-group">
                        <label for="formDate" style="color: white;">Дата рождения:</label>
                        <input type="date" class="form_input form__input _req form-control w-50  bg-white rounded" name="year" id="dates" value="<?php print($user['date']); ?>">
                    </div>
                    <div class="gender">
                        <label style="margin-right: 5px;">Пол : </label>
                        <div>
                            <input type="radio" id="male" name="gender" value="m"
                                <?php
                                    if($user['gender'] == 'm'){
                                        print('checked');
                                    }
                                ?>
                            />
                            <label for="male" id="male">мужской</label>
                        </div>
                        <div>
                            <input type="radio" id="female"name="gender" value="f"
                                <?php
                                    if($user['gender'] == 'f'){
                                        print('checked');
                                    }
                                ?>
                            />
                            <label for="female" id="female">женский</label>
                        </div>
                    </div>

                    <div class="limbs">
                        <label>Количество конечностей :</label>
                        <input type="radio" id="2" name="limbs" value="2"
                            <?php
                                if($user['limbs'] == '2'){
                                    print('checked');
                                }
                                ?>
                        >
                        <label for="2" id="2">2</label>
                        <input type="radio" id="4" name="limbs" value="4"
                                <?php
                                    if($user['limbs'] == '4'){
                                        print('checked');
                                    }
                                ?>
                        >
                        <label for="4" id="4">4</label>
                        <input type="radio" id="8" name="limbs" value="8"
                            <?php
                                if($user['limbs'] == '8'){
                                    print('checked');
                                }
                            ?>
                        >
                        <label for="8" id="8">8</label>
                        <input type="radio" id="16" name="limbs" value="16"
                            <?php
                                if($user['limbs'] == '16'){
                                    print('checked');
                                }
                            ?>
                        >
                        <label for="16" id="16">16</label>
                    </div>

                    <div class="capabilities">
                        <select name="capabilities[]" size="2" multiple>
                            <option value="s1"
                                <?php
                                    if($value_ability[0] == 'immortal'){
                                        print('selected');
                                    }
                                ?>
                            >бессмертие</option>
                            <option value="s2"
                                <?php
                                    if($value_ability[0] == 'noclip' || $value_ability[1] == 'noclip'){
                                        print('selected');
                                    }
                                ?>
                            >прохождение сквозь стены</option>
                            <option value="s3"
                                <?php
                                    if($value_ability[0] == 'flying' || $value_ability[1] == 'flying' || $value_ability[2] == 'flying'){
                                        print('selected');
                                    }
                                ?>
                            >левитация</option>                          
                        </select>
                    </div>
                    <div>
                        <input class="webform__form-btn" type="submit" name="edit" value="Изменить данные пользователя">
                    </div>
                    <div>
                        <button class = "btn_cencel"><a class="cencel" href ="adminroom.php">Отменить редактирование</a></butto>
                    </div>
                </form>
            </div>
    <?php
    }
    ?>
</body>
<?php
}
else
header('Location: ../index.php');

?>