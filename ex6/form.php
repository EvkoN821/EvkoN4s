<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <title> EX 6 </title>
        <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body class="webform">

<div class="wrapper">
        <header class="lock-padding">
            <div class="login__btn">
                <?php if(isset($_SESSION['user'])){
                     print('Здравствуйте, ' . $_SESSION['user']['name'] . '<br>');
                     print('<a class="popup-link log__btn" href="/ex6/logout.php">Выйти</a>');
                }else{
                    print('<a class="popup-link log__btn" href="/ex6/login.php">Войти</a>');
                }
                ?>

            </div>
        </header>
    </div>

    <div class="webform">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="webform__form d-flex justify-content-center">
                        <form class="form__body" method="post" action="">
                            <div class="alert
                                <?php
                                    if($message['success'] == TRUE){
                                        print('alert-success');
                                    }else{
                                        print('alert-danger');
                                    }
                                ?>"
                                role="alert"
                                <?php
                                    if($message['alert'] == TRUE){
                                        print('hidden');
                                    }
                                ?>
                            >
                                <?php
                                    if($message['success'] == TRUE && !isset($_SESSION['user'])) {
                                        print('Данные успешно сохранены<br>');
                                        print('Ваш логин : ');
                                        print($log . '<br>');
                                        print('Ваш пароль : ');
                                        print($passw . '<br>');
                                    }else if($message['success'] == TRUE && isset($_SESSION['user'])){
                                        print('Данные успешно изменены<br>');
                                    }else{
                                        print('Неправильно введены данные');
                                    }
                                ?>
                            </div>
                            <div>
                                <input class="webform__form-elem form__input _req <?php
                                                    if($message['name_empty'] == TRUE || $message['name'] == TRUE){
                                                    print('_error');
                                                    }
                                                ?>"  id="names" type="text" name="name"
                                    placeholder="Имя" value= "<?php print(e($value['name'])); ?>" >
                                    <div class="text-danger err "
                                        <?php
                                            if(!$error['name_empty'] && !$error['name']){
                                                print('hidden');
                                            }
                                        ?>
                                    >
                                        <?php
                                            if($message['name_empty'] == TRUE){
                                                print('Поле не может быть пустым');
                                            }else if($message['name'] == TRUE){
                                                print('Введите имя кирилицей');
                                            }
                                        ?>
                                    </div>
                            </div>
                             <div>
                                <input class="webform__form-elem form__input _req _email <?php
                                                    if($message['email_empty'] == TRUE || $message['email'] == TRUE){
                                                    print('_error');
                                                    }
                                                ?>" id="email" type="email" name="email"
                                        placeholder="E-mail" value= "<?php print(e($value['email'])); ?>">
                                        <div class="text-danger err "
                                        <?php
                                            if(!$error['email_empty'] && !$error['email']){
                                                print('hidden');
                                            }
                                        ?>
                                        >
                                        <?php
                                            if($message['email_empty'] == TRUE){
                                                print('Поле не может быть пустым');
                                            }else if($message['email'] == TRUE){
                                                print('Введите почту в правильном формате');
                                            }
                                        ?>
                                    </div>
                            </div>
                            <div>
                                <textarea id="comment" class="webform__form-elem form__input _req <?php
                                                    if($message['bio'] == TRUE){
                                                    print('_error');
                                                    }
                                                ?> " type="text" name="bio" placeholder="Биография" ><?php print(e($value['bio'])); ?></textarea>
                                <div class="text-danger err "
                                    <?php
                                        if(!$error['bio']){
                                            print('hidden');
                                        }
                                    ?>
                                >
                                        <?php
                                            if($message['bio'] == TRUE){
                                                print('Поле не может быть пустым');
                                            }
                                        ?>
                                </div>
                            </div>
                            <div class="form_item form-group">
                                <label for="formDate" style="color: white;">Дата рождения:</label>
                                <input type="date" class="form_input form__input _req form-control w-50  bg-white rounded <?php
                                if($message['year'] == TRUE){
                                    print('_error');
                                    }?>" name="year" id="dates" value="<?php print(e($value['year'])); ?>">
                                <div class="text-danger err "
                                <?php
                                        if(!$error['year']){
                                            print('hidden');
                                        }
                                    ?>
                                >
                                        <?php
                                            if($message['year'] == TRUE){
                                                print('Укажите дату рождения');
                                            }
                                        ?>
                                </div>
                            </div>
                            <div class="gender">
                                <label style="margin-right: 5px;">Пол : </label>
                                <div>
                                    <input type="radio" id="male" name="gender" value="m"
                                        <?php
                                            if(e($value['gender']) == 'm'){
                                                print('checked');
                                            }
                                        ?>
                                    />
                                    <label for="male" id="male">мужской</label>
                                </div>
                                <div>
                                    <input type="radio" id="female"name="gender" value="f"
                                        <?php
                                            if(e($value['gender']) == 'f'){
                                                print('checked');
                                            }
                                        ?>
                                    />
                                    <label for="female" id="female">женский</label>
                                </div>
                                <div class="text-danger err "
                                <?php
                                        if(!$error['gender']){
                                            print('hidden');
                                        }
                                    ?>
                                >
                                        <?php
                                            if($message['gender'] == TRUE){
                                                print('Укажите пол');
                                            }
                                        ?>
                                </div>
                            </div>
                            <div class="limbs">
                                <label>Количество конечностей :</label>
                                <input type="radio" id="2" name="limbs" value="2"
                                    <?php
                                        if(e($value['limbs']) == '2'){
                                            print('checked');
                                        }
                                        ?>
                                >
                                <label for="2" id="2">2</label>
                                <input type="radio" id="4" name="limbs" value="4"
                                        <?php
                                            if(e($value['limbs']) == '4'){
                                                print('checked');
                                            }
                                        ?>
                                >
                                <label for="4" id="4">4</label>
                                <input type="radio" id="8" name="limbs" value="8"
                                    <?php
                                        if(e($value['limbs']) == '8'){
                                            print('checked');
                                        }
                                    ?>
                                >
                                <label for="8" id="8">8</label>
                                <input type="radio" id="16" name="limbs" value="16"
                                    <?php
                                        if(e($value['limbs']) == '16'){
                                            print('checked');
                                        }
                                    ?>
                                >
                                <label for="16" id="16">16</label>
                                <div class="text-danger err "
                                <?php
                                        if(!$error['limbs']){
                                            print('hidden');
                                        }
                                    ?>
                                >
                                        <?php
                                            if($message['limbs'] == TRUE){
                                                print('Укажите количество конечностей');
                                            }
                                        ?>
                                </div>
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
                                <div class="text-danger err "
                                <?php
                                        if(!$error['ability']){
                                            print('hidden');
                                        }
                                    ?>
                                >
                                        <?php
                                            if($message['ability'] == TRUE){
                                                print('Укажите одну или несколько способностей');
                                            }
                                        ?>
                                </div>
                            </div>
                            <div class="form__checkbox">
                                <input class="checkbox__input _req <?php if($message['agree'] == TRUE){
                                                    print('_error');
                                                    }?>"  type="checkbox" id="userAgreement"  name="agree"
                                    <?php
                                        if($value['agree']){
                                            print('checked');
                                        }
                                    ?>
                                >
                                 <label class="checkbox__label" for="userAgreement">Отправляя заявку, я даю согласие на<a>обработку своих персональных данных</a>.<span>*</span></label>
                            </div>
                            <div class="text-danger err "
                            <?php
                                        if(!$error['agree']){
                                            print('hidden');
                                        }
                                    ?>
                            >
                                        <?php
                                            if($message['agree'] == TRUE){
                                                print('Пожалуйста подтвердите согласие на обработку данных');
                                            }
                                        ?>
                                </div>

                            <div>
                                <input class="webform__form-btn" type="submit" name="submit" value="Отправить">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>