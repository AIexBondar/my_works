<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Restore</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
	<div id="warnings"></div>
	<form action="#" id="login_form" method="post" name="login_form">
		<input class="input" id="connect_info" name="connect_info" size="32"  type="text" value="" placeholder="Котактные данные"><br><br>
		<input class="button" id="restore" name= "restore" type="button" value="Отправить">
		<label id="restore" for="restore"></label>
	</form>
	<script type="text/javascript">
		$(document).ready(function(){
			var warnings = document.getElementById('warnings');
			var reg_str_connect = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
			var reg_str_phone_1 = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/;
			function functionBefore(){
				var restore = document.getElementById('restore');
				restore.innerHTML = '<img src="/img/35.gif" width="20px">';
			}
			function open_login(){
				window.location.href = "/user/login";
			}
			$('#restore').click(function(){
				var flag = 0;
				if (flag == 0){
					warnings.innerHTML = '';
					flag = 0;
				}
				if (!(( $('#connect_info').val()).match(reg_str_connect)) && !(($('#connect_info').val()).match(reg_str_phone_1)) ){
					warnings.innerHTML += 'Неправильные контактные данные. <br>';
					flag = 1;
				}		
				if(flag != 1){
					$.ajax({	
						type: 'POST',
						url: "/user/restore",
						data: ({connect_info: $('#connect_info').val()}),
						beforeSend: functionBefore,
						success: function(result){
							if (result == '0') {
								warnings.innerHTML += '<br> Такого пользователя не существует';
							}	else{
								warnings.innerHTML += '<br> Новый пароль отправлен';
								setTimeout(open_login, 5000);
							}
						}	
					});
				}
			});
		});
	</script>
</body>
</html>