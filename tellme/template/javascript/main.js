/*Ошибки*/
var flag = 0;
/*Для регистрации*/
var regular = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
/*Другие переменные*/
var warnings = document.getElementById('warnings');

/*При нажатии в поле регистрации*/
function ClickRegister(){
    var flag = 0;
    if (flag == 1) {
        warnings.innerHTML = '';
        flag = 0;
    }
    if ($('#name').val() == '' || ($('#name').val()).length > 30 || ($('#name').val()).length == 1) {
        $('#name').css({
            "border-bottom": "1px solid red"
        });
        warnings.innerHTML = 'Не верные данные';
        flag = 1;
    }
    if ($('#secondname').val() == '' || ($('#secondname').val()).length > 30 || ($('#secondname').val()).length == 1) {
        $('#secondname').css({
            "border-bottom": "1px solid red"
        });
        warnings.innerHTML = 'Не верные данные';
        flag = 1;
    }

    if (!(($('#connect_info').val()).match(regular)) || $('#connect_info').val() == '' || $('#password').val().length > 50) {
        $('#connect_info').css({
            "border-bottom": "1px solid red"
        });
        warnings.innerHTML = 'Не верные данные';
        flag = 1;
    }

    if ($('#password').val() == '') {
        $('#password').css({
            "border-bottom": "1px solid red"
        });
        warnings.innerHTML = 'Не верные данные';
        flag = 1;
    }

    if ($('.sex1').checked == false && $('.sex2').checked == false) {
        warnings.innerHTML = 'Не верные данные';
        flag = 1;
    }

    if ($("#day option:selected").val() == 0) {
        warnings.innerHTML = 'Не верные данные';
        flag = 1;
    }

    if ($("#month option:selected").val() == 0) {
        warnings.innerHTML = 'Не верные данные';
        flag = 1;
    }

    if ($("#year option:selected").val() == 0) {
        warnings.innerHTML = 'Не верные данные';
        flag = 1;
        return false;
    }
    if ($('#password').val() != '') {
        if (!(($('#connect_info').val()).match(regular)) || $('#connect_info').val() == '' || $('#password').val().length > 50) {
            $('#connect_info').css({
                "border-bottom": "1px solid red"
            });
            warnings.innerHTML = 'Не верные данные';
            flag = 1;
            return false;
        }
        if ($('#password').val().length < 6) {
            $('#password').css({
                "border-bottom": "1px solid red"
            });
            warnings.innerHTML = 'Пароль должен быть длинее 6 символов';
            flag = 1;
            return false;
        }

        if (!$('#password').val().match(/[A-z]/) || !$('#password').val().match(/[A-Z]/) || !$('#password').val().match(/[0-9]/)) {
            if($('#password').val().length < 11){
                $('#password').css({
                    "border-bottom": "1px solid red"
                });
                warnings.innerHTML = 'Слишком легкий пароль';
                flag = 1;
                return false;
            }   else {
                flag = 0;
            }
        }
    }

    /*Если ошибок нет выполняем ajax*/
    if (flag != 1) {
        var sex = ($('.sex1').checked == true) ? 0 : 1;
        var birthday = "Day: " + $("#day option:selected").val() + "; Month: " + $("#month option:selected").val() + "; Year: " + $("#year option:selected").val();
        $.ajax({
            type: 'POST',
            url: "/user/signin",
            data: ({
                connect_info: $('#connect_info').val(),
                name: $('#name').val(),
                secondname: $('#secondname').val(),
                password: $('#password').val(),
                sex: sex,
                birthday: birthday
            }),
            success: function (result) {
                if (result == '0') {
                    warnings.innerHTML = 'Такой пользователь существует';
                } else if (result == '1') {
                    warnings.innerHTML = 'Не верные данные';
                } else {
                    warnings.innerHTML = '';
                    window.location.href = "/user";
                }
            }
        });
    }
}
/*Функция при нажатии на кнопку входа*/
function ClickLogin(){
    if (flag == 1) {
        warnings.innerHTML = '';
        flag = 0;
    }
    if ($('#password').val() == '') {
        $('#password').css({
            "border-bottom": "1px solid red"
        });
        warnings.innerHTML = 'Не верные данные';
        flag = 1;
    }
    if (!(($('#connect_info').val()).match(regular)) || $('#connect_info').val().length > 50 || $('#connect_info').val() == '') {
        $('#connect_info').css({
            "border-bottom": "1px solid red"
        });
        warnings.innerHTML = 'Не верные данные';
        flag = 1;
    }
    /*Если ошибок нет выполняем ajax*/
    if (flag != 1) {
        $.ajax({
            type: 'POST',
            url: "/user/login",
            data: ({
                connect_info: $('#connect_info').val(),
                password: $('#password').val()
            }),
            success: function (result) {
                if (result == '0') {
                    $('#connect_info').css({
                        "border-bottom": "1px solid red"
                    });
                    warnings.innerHTML = 'Такого пользователя не существует';
                } else if (result == '1') {
                    $('#password').css({
                        "border-bottom": "1px solid red"
                    });
                    warnings.innerHTML = 'Не верный пароль';
                } else {
                    warnings.innerHTML = '';
                    window.location.href = "/user";
                }
            }
        });
    }
}


/*При нажатии на кнопу вход на странице регистрации*/
function FormButton(){
    if (flag == 1) {
        warnings.innerHTML = '';
        flag = 0;
    }
    if (!(($('#form_connect_info').val()).match(regular)) || $('#form_connect_info').val() == '' || $('#form_connect_info').val().length > 50) {
        $('#form_connect_info').css({
            "border-bottom": "1px solid red"
        });
        flag = 1;
    }

    if ($('#form_password').val() == '') {
        $('#form_password').css({
            "border-bottom": "1px solid red"
        });
        flag = 1;
    }
    /*Если ошибок нет выполняем ajax*/
    if (flag != 1) {
        $.ajax({
            type: 'POST',
            url: "/user/login",
            data: ({
                connect_info: $('#form_connect_info').val(),
                password: $('#form_password').val()
            }),
            success: function (result) {
                if (result == '1') {
                    var info = "form_password=0&connecting_info=" + $('#form_connect_info').val();
                    callPHP(info);
                } else if (result == '0') {
                    var info = "form_password=0&connecting_info=0";
                    callPHP(info);
                } else {
                    window.location.href = "/user";
                }
            }
        });
    }
}

/*Функция нажатия на кнопку 'У меня ести аккаунт' в окне регистрац*/
var topFormButton = {
    $button: document.querySelector('.button'),
    $my_account: document.querySelector('.my_account'),
    $log: document.querySelector('.log-in'),
    init: function init() {
        var self = this;
        self.$button.addEventListener('click', function () {
            if (!self.$my_account.classList.contains('is-active')) {
                self.$my_account.classList.add('is-active');
                self.$log.classList.add('is-active');
            }
        })
    }
}

/*Функция отправки POST*/
function callPHP(params) {
    var xml = new XMLHttpRequest();
    var url = "/user/login";
    xml.open("POST", url, true);

    xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xml.setRequestHeader("Content-Type", params.length);

    xml.send(params);
    window.location.href = "/user/login";
}

/*При загрузке документа*/
$(document).ready(function () {
    var load = document.getElementById('load');
    var sex = document.getElementsByName('sex');
    var form = document.getElementById('register');

    /*Проверка количества символов при вводе текста*/
    $('#name').keypress(function () {
        var simbols = $('#name').val();
        simbols = simbols.length;
        $('#length_name').text(simbols);
    });

    $('#name').keyup(function () {
        var simbols = $('#name').val();
        simbols = simbols.length;
        if (simbols > 30) {
            $(this).css({
                "border-bottom": "1px solid red"
            });
            warnings.innerHTML = 'Не верные данные';
        } else {
            $(this).removeAttr("style");
            warnings.innerHTML = '';
        }
        $('#length_name').text(simbols);
    });

    $('#secondname').keypress(function () {
        var simbols = $('#secondname').val();
        simbols = simbols.length;
        $('#length_secondname').text(simbols);
    });

    $('#secondname').keyup(function () {
        var simbols = $('#secondname').val();
        simbols = simbols.length;
        if (simbols > 30) {
            $(this).css({
                "border-bottom": "1px solid red"
            });
            warnings.innerHTML = 'Не верные данные';
        } else {
            $(this).removeAttr("style");
            warnings.innerHTML = '';
        }
        $('#length_secondname').text(simbols);
    });

    $('#connect_info').keypress(function () {
        var simbols = $('#connect_info').val();
        simbols = simbols.length;
        $('#length_gmail').text(simbols);
    });

    $('#connect_info').keyup(function () {
        var simbols = $('#connect_info').val();
        simbols = simbols.length;
        if (simbols > 50) {
            $(this).css({
                "border-bottom": "1px solid red"
            });
            warnings.innerHTML = 'Не верные данные';
        } else {
            $(this).removeAttr("style");
            warnings.innerHTML = '';
        }
        $('#length_gmail').text(simbols);
    });



    $('#form_connect_info').keypress(function () {
        var simbols = $('#form_connect_info').val();
        simbols = simbols.length;
        $('#length_form_gmail').text(simbols);
    });

    $('#form_connect_info').keyup(function () {
        var simbols = $('#form_connect_info').val();
        simbols = simbols.length;
        if (simbols > 50) {
            $(this).css({
                "border-bottom": "1px solid red"
            });
        } else {
            $(this).removeAttr("style");
        }
        $('#length_form_gmail').text(simbols);
    });

    /*Убрать ошибку при вводе*/
    document.getElementById('password').oninput = function () {
        document.getElementById('password').removeAttribute("style");
    }
    document.getElementById('connect_info').oninput = function () {
        document.getElementById('connect_info').removeAttribute("style");
    }

    /*При нажатии на кнопку войти*/
    $('#login').click(function () {
        ClickLogin();
    });
    /*При нажатии на кнопку Регистрация*/
    $('#register').click(function () {
        ClickRegister();
    });

    /*Фориа с верху на странице регистриции*/
    $('#form_button').click(function () {
        FormButton();
    });

});
