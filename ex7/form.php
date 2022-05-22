<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
	<title>Ex 6</title>
</head>
<body>
	<div class="d-flex  flex-md-row align-items-center p-3 px-md-1 border-bottom shadow-sm " style="background-color: white;">
		<div class="d-flex flex-column px-md-3">
			<a href="login.php" style="text-decoration: none; color: #de530e;">Войти</a>
			<a href="admin.php" style="text-decoration: none; color: #de530e;">Войти как админ</a>	
		</div>
		<div class="d-flex flex-column px-md-5" style="margin-left: 350px">
			<h1> Заполните информацию</h1>
		</div>
	</div>
	<?php 
		function csrf(){
			return $_SESSION['csrf']=md5(uniqid("", true));
		}
		if (!empty($messages)) {
			if(isset($messages['save'])) print('<div id="messages" class="ok">'); else print('<div id="messages">');
			foreach ($messages as $message) {
				print($message);
			}
		  print('</div>');
		}
	?>
	<div class="container">
	
		<form action="" method="POST">
			<input name="csrf" type="hidden" value="<?php print csrf(); ?>" > 
			<p><label for="name">Имя</label>
			<input type="text" name="name" <?php if (!empty($errors['name'])) print 'class="error"'; ?> <?php if(empty($errors['name'])&&!empty($values['name'])) print 'class="ok"';?> value="<?php isset($_COOKIE['name_error'])? print trim($_COOKIE['name_error']) : print $values['name']; ?>"> </p>
			<p><label for="email">E-mail</label>
			<input type="text" id="email" name="email" <?php if(!empty($errors['email']))  print 'class="error"';?> <?php if(empty($errors['email'])&&!empty($values['email'])) print 'class="ok"';?> value="<?php isset($_COOKIE['email_error'])? print trim($_COOKIE['email_error']) : print $values['email']; ?>"> </p>		
			<p><label for="year">Год рождения</label>
			<select id="year" name="year" <?php if(!empty($errors['year']))  print 'class="error"';?> <?php if(empty($errors['year'])&&!empty($values['year'])) print 'class="ok"';?>>
				<option selected ><?php !empty($values['year']) ? print ($values['year']) : print '' ?></option>
				<?php 
					for ($i = 1980; $i <= 2014; $i++)
						echo '<option>' . $i . '</option>';
				?>
			</select>
			
			<p><label <?php if(!empty($errors['gender'])) print 'class="error_check"'?>>Пол:</label>
			<input type="radio" id="male" value="male" name="gender" <?php if (isset($values['gender'])&&$values['gender'] == 'male') print("checked"); ?>>Мужской
			<input type="radio" id="female" value="female" name="gender" <?php if (isset($values['gender'])&&$values['gender'] == 'female') print("checked"); ?>>Женский</p>

			<p><label <?php if(isset($_COOKIE['kon_error'])) print 'class="error_check"'?>>Количество конечностей:</label>
			<input type="radio" id="1" name="kon" value='1'<?php if (isset($values['kon'])&&$values['kon'] == '1') print("checked"); ?>>1
			<input type="radio" id="2" name="kon" value='2'<?php if (isset($values['kon'])&&$values['kon'] == '2') print("checked"); ?>>2
			<input type="radio" id="3" name="kon" value='3'<?php if (isset($values['kon'])&&$values['kon'] == '3') print("checked"); ?>>3
			<input type="radio" id="4" name="kon" value='4'<?php if (isset($values['kon'])&&$values['kon'] == '4') print("checked"); ?>>4</p>
			<p><label <?php if(!empty($errors['super'])) print 'class="error_check"'?>>Сверхспособности:</label>
			<?php
				$sql = 'SELECT * FROM SuperDef';
				foreach ($db->query($sql) as $row) {
					?><input type="checkbox" value=<?php print $row['id']?> name=super[] <?php if(isset($values['super'][$row['id']])&&empty($_COOKIE['super_error']))print("checked"); print "\t"; ?>> 
					<?php print $row['name'] . "\t";
				}
			?>
			<p><label for="bio">о себе</label>
			<textarea id="bio" name="bio" <?php if(!empty($errors['bio']))  print 'class="error"';?> <?php if(empty($errors['bio'])&&!empty($values['bio'])) print 'class="ok"';?>><?php isset($_COOKIE['bio_error']) ? print trim($_COOKIE['bio_error']) : print $values['bio'] ?></textarea>			
			<p><label <?php if(!empty($errors['contr_check'])) print 'class="error_check"'?>>Согласен с политикой</label>
			<input type="checkbox" id="contr_check" name="contr_check" value="contr_check" <?php if (isset($values['contr_check'])&&$values['contr_check'] == 'contr_check') print("checked"); ?>></p>			
			<p><button type="submit" value="send">Отправить</button></p>
		</form>
		<?php if(!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) print( '<div id="footer">Вход с логином ' . $_SESSION["login"]. '<br> <a href=login.php?do=logout> Выход</a><br></div>');?>
	</div>
</body>
</html>
