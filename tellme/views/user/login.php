<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Log in</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/template/style/style.css">
	<link rel="stylesheet" type="text/css" href="/template/style/log-in/style.css">
</head>
<body>
	<div class="head_menu">
		<div class="logany">
			<div class="logo">
				<div class="logo_image">TM</div>
				<div class="name">TELLME</div>
				<div class="link">TM.com</div>
			</div>
		</div>
	</div>
	<div class="log-in">
		<center><p><b>Вход</b></p></center>
		<form action="#" id="registration_form" method="post" name="registration_form">
			<div class="group_input gmail">
				<input class="input" id="connect_info" name="connect_info" size="32" value="<?php if (isset($fconnect)) {if($fconnect != '0'){echo $fconnect;}}?>" type="text" onkeydown="if(event.keyCode == 13){ClickLogin();}" required>
				<span class="bar"><span id="length_gmail">0</span>/50</span>
				<label>Электронная почта</label>
			</div><br>
			<div class="group_input password">
				<input class="input" id="password" name="password" size="32"  type="password" onkeydown="if(event.keyCode == 13){ClickLogin();}" required>
				<span class="bar"></span>
				<label>Пароль</label>
			</div>
			<center><input class="button" id="login" name= "login" type="button" value="Вход">
			<label id="load" for="login"></label></center><br>
			<a href="/user/restore">Забыли пароль ?</a>
			<div class="container">
				<hr>
				<div class="or">или зарегистрируйтесь</div>
			</div>
		
			<a href="/user/signin" class="register">
				Регистрация
			</a>				
		
		</form><br>
		<div id="warnings">
			<?php if (isset($fconnect)) {
				if ($fconnect == '0') {
					echo "Такого пользователя не существует<br>";
				}
			}   if (isset($fpass)){
				if ($fpass == '0' && $fconnect !== '0') {
					echo "Не верный пароль";
				}
			}	?>
		</div>
	</div>
	<script src="/template/javascript/main.js"></script>
</body>
</html>