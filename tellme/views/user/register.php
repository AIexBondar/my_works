<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>User</title>
    <link rel="stylesheet" type="text/css" href="/template/style/style.css">
    <link rel="stylesheet" type="text/css" href="/template/style/registration/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

    <div class="head_menu">
        <div class="logany">
            <div class="logo">
                <div class="logo_image">TM</div>
                <div class="name">TELLME</div>
                <div class="link">TM.com</div>
            </div>
            <div class="my_account">
                <div class="button">У меня есть аккаунт</div>
            </div>
            <div class="log-in">
                <form action="#" id="login_form" method="post" name="login_form">
                    <div class="group_input">
                        <input class="form_input" id="form_connect_info" name="connect_info" type="text" autocomplete="off" onkeydown="if(event.keyCode == 13){FormButton();}" required>
                        <span class="bar"><span id="length_form_gmail">0</span>/50</span>
                        <label>Электронный адрес</label>
                    </div>
                    <div class="group_input">
                        <input class="form_input" id="form_password" name="password" type="password" autocomplete="new-password" onkeydown="if(event.keyCode == 13){FormButton();}" required>
                        <span class="bar"></span>
                        <label>Пароль</label>
                    </div>
                    <center><input class="form_button" id="form_button" name="login" type="button" value="Вход" anim="ripple">
                        <a href="/user/restore">Забыли пароль ?</a></center>
                </form>
            </div>
        </div>
    </div>
    <div class="registration">
        <center>
            <p><b>Регистрация</b></p>
        </center>
        <form action="#" id="registration_form" method="post" name="registration_form">
            <div class="name_secondname">
                <div class="group_input">
                    <input class="input" id="name" name="name" type="text" autocomplete="off" onkeydown="if(event.keyCode == 13){ClickRegister();}" required>
                    <span class="bar"><span id="length_name">0</span>/30</span>
                    <label>Имя</label>
                </div>
                <div class="group_input" style="margin: 0 0 0 30px;">
                    <input class="input" id="secondname" name="secondname" autocomplete="off" type="text" onkeydown="if(event.keyCode == 13){ClickRegister();}" required>
                    <span class="bar"><span id="length_secondname">0</span>/30</span>
                    <label>Фамилия</label>
                </div>
            </div><br>
            <div class="group_input gmail">
                <input class="input" id="connect_info" name="connect_info" size="32" type="text" autocomplete="off" onkeydown="if(event.keyCode == 13){ClickRegister();}" required>
                <span class="bar"><span id="length_gmail">0</span>/50</span>
                <label>Электронная почта</label>
            </div><br>
            <div class="group_input password">
                <input id="password" name="password" size="32" type="password" autocomplete="new-password" onkeydown="if(event.keyCode == 13){ClickRegister();}" required>
                <label>Пароль</label>
            </div>
            <h6 style="margin-top: 60px;">Дата рождения:</h6>
            <div class="your_birthday">
                <select id="day">
                    <option selected value="0">День</option>
                    <?php for($i = 1; $i <= 31; $i++): ?>
                    <option value="<?echo $i;?>" <?php if(date('d') == $i) echo("selected"); ?>>
                        <?echo $i;?>
                    </option>
                    <?php endfor?>
                </select>
                <select id="month">
                    <option value="0">Месяц</option>
                    <option value="1" <?php if(date('n') == 1) echo("selected"); ?>>Янв</option>
                    <option value="2" <?php if(date('n') == 2) echo("selected"); ?>>Фев</option>
                    <option value="3" <?php if(date('n') == 3) echo("selected"); ?>>Мар</option>
                    <option value="4" <?php if(date('n') == 4) echo("selected"); ?>>Апр</option>
                    <option value="5" <?php if(date('n') == 5) echo("selected"); ?>>Май</option>
                    <option value="6" <?php if(date('n') == 6) echo("selected"); ?>>Июн</option>
                    <option value="7" <?php if(date('n') == 7) echo("selected"); ?>>Июл</option>
                    <option value="8" <?php if(date('n') == 8) echo("selected"); ?>>Авг</option>
                    <option value="9" <?php if(date('n') == 9) echo("selected"); ?>>Сен</option>
                    <option value="10" <?php if(date('n') == 10) echo("selected"); ?>>Окт</option>
                    <option value="11" <?php if(date('n') == 11) echo("selected"); ?>>Ноя</option>
                    <option value="12" <?php if(date('n') == 12) echo("selected"); ?>>Дек</option>
                </select>
                <select id="year">
                    <option selected value="0">Год</option>
                    <?php for($i = 2019; $i >= 1905; $i--): ?>
                    <option value="<?echo $i;?>">
                        <?echo $i;?>
                    </option>
                    <?php endfor?>
                </select>
            </div>
            <h6>Пол:</h6>
            <div class="mle">
                <label><input name="sex" class="sex sex1" type="radio" value="0"> Мужской </label>
                <label><input name="sex" class="sex sex2" type="radio" value="1"> Женский </label>
            </div>
            <div class="agree">
                Нажимая кнопку Регистрация, вы принимаете
                <a href="#">Условия, Политку использования данных</a> и <a href="#">Политику в отношении файлов cookie</a>.<br> Вы можете получать от нас сообщения, <br>отключить их можно в любой момент
            </div>
            <center><input class="button" id="register" name="register" type="button" value="Регистрация"></center><br>
            <div id="warnings"></div>
        </form>
    </div>

    <script language="JavaScript" type="text/javascript" src="/template/javascript/main.js"></script>
    <script type="text/javascript">
        /*Убрать ошибку при вводе*/
        document.getElementById('name').oninput = function() {
            document.getElementById('name').removeAttribute("style");
        }
        document.getElementById('secondname').oninput = function() {
            document.getElementById('secondname').removeAttribute("style");
        }
        document.getElementById('form_connect_info').oninput = function() {
            document.getElementById('form_connect_info').removeAttribute("style");
        }
        document.getElementById('form_password').oninput = function() {
            document.getElementById('form_password').removeAttribute("style");
        }
        /*Функция нажатия на кнопку 'У меня ести аккаунт' в окне регистрац*/
        topFormButton.init();

    </script>
</body>

</html>
