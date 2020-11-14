<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Text</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <p>User id: <?php echo $_SESSION['id']?></p>
    <p><a href="/user/logout">Выход</a></p>
    <p>Status: <div id="activity"><?php echo $result[0]['activity']?></div>
    </p>
    <?php if($verify !== '1' && preg_match('/^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i', $result[0]['connection_info']) == 1):?>
    <div id="verificate_div">
        <?php echo  $result[0]['second_name']; ?>
        <p>Почта <?php echo $result[0]['connection_info']; ?> не верефицировна, пароль на почте</p>
        <form action="#" id="verify_form" method="post" name="verify_form">
            <div id="send">
                <?php if(isset($_COOKIE['time_verify'])):?>
                <p>Ожитдайте: <?php echo $time_wait;?>мин. для повторной отправки</p>
                <?php else:?>
                <input class="button" id="send_verify" name="send_verify" type="button" value="Отправить пароль"><br><br>
                <?php endif;?>
            </div>
            <div id="warnings"></div>
            <input class="input" id="verify_password" name="verify_password" size="32" type="verify_password" value="" placeholder="verify password"><br><br>
            <input class="button" id="verificate" name="verificate" type="button" value="Подтвердить"><label id="verificate" for="verificate"></label>
        </form>

    </div>
    <?php else: ?>
    <p>YES</p>
    <?php endif; ?>
    <script type="text/javascript">
        window.onbeforeunload = function() {
            $.ajax({
                type: 'POST',
                url: "/user/account",
                data: ({
                    go_out: 1
                })
            });
        }
        var activity = document.getElementById('activity');
        window.onload = function() {
            $.ajax({
                type: 'POST',
                url: "/user/account",
                data: ({
                    go_in: 1
                }),
                success: function(result) {
                    activity.innerHTML = result;
                }
            });
        };
        $(document).ready(function() {
            var verificate_div = document.getElementById('verificate_div');

            function functionBefore() {
                var load = document.getElementById('verificate');
                load.innerHTML = '<img src="/img/35.gif" width="20px">';
            }

            var send = document.getElementById('send');

            function time_show_ver() {
                var time = "<?php $time_w = (isset($_COOKIE['time_verify'])? $time_wait : 0); echo $time_w;?>";
                return time;
            }

            function time_show() {
                $.ajax({
                    type: 'POST',
                    url: "/user/account",
                    data: ({
                        my_time: 1
                    }),
                    cache: false,
                    success: function(result) {
                        send.innerHTML = "<p>Ожидайте " + result + "мин. для повторной отправки</p>";
                    }
                });
            }
            time_out = time_show_ver();
            if (time_out != "0") {
                setInterval(time_show, 30000);
            }


            var ver = '1';
            $('#send_verify').click(function() {
                $.ajax({
                    type: 'POST',
                    url: "/user/account",
                    data: ({
                        send_verify: ver
                    }),
                    success: function(result) {
                        if (result == '0') {
                            send.innerHTML = "<p>Ожидайте 30мин. для повторной отправки</p>";
                        }
                    }
                });
            });

            $('#verificate').click(function() {
                var warnings = document.getElementById('warnings');
                var flag = 0;
                if (flag == 0) {
                    warnings.innerHTML = '';
                    flag = 1;
                }
                if ($('#verify_password').val() == '') {
                    warnings.innerHTML += 'No Verify password <br>';
                }
                if (flag != 1) {

                    $.ajax({
                        type: 'POST',
                        url: "/user/account",
                        data: ({
                            verify_password: $('#verify_password').val()
                        }),
                        beforeSend: functionBefore,
                        success: function(result) {
                            if (result == '0') {
                                warnings.innerHTML += 'No Correct Verify Password <br>';
                            } else {
                                $('#verificate_div').empty()
                                verificate_div.innerHTML += 'YES';
                            }
                        }
                    });
                }
            });
        });

    </script>
</body>

</html>
