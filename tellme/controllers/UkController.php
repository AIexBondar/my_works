<?php
	// ExtendClass - класс наследия
	class UkController extends ExtendClass {
		//Перенаправление, если был вход - на аккаунт
		public function actionIndex(){
//			if(isset($_SESSION['id'])){
//				header("Location: /user/account/");
//			}	else {
//				header("Location: /user/signin/");
//			}
			return true;
		}
        //Функция срабатывает при регистрации
        public function actionSignin(){
            if(isset($_SESSION['id'])){
				header("Location: /user/account/");
			}
            if(isset($_POST['connection_info'])){
                //Берем id с users
                $result = Sql::SqlQuery('select', array('connection_info' => $_POST['connection_info']), 'users', 'id' );
                // Если есть id возращаем 0
                if($result != false){
                    echo "0";
                    return true;
                }   else {
                    $fn = new Functions();
                    if($fn->CheckLength($_POST['name'], 3, 30) || $fn->CheckLength($_POST['secondname'], 3, 30) || $fn->CheckLength($_POST['password'], 3, 30) || $fn->CheckLength($_POST['connect_info'], 3, 30) || $_POST['sex'] == 0 || $_POST['birthday'] == 0 || filter_var($_POST['connect_info'], FILTER_VALIDATE_EMAIL)){
                        echo "1";
                        return true;
                    }
                    // Проль валидации
                    $verify_password = Functions::VPGenerator(15);
                    // Зашифрованый пароль
                    $password = Functions::Pass('encryption', $_POST['password']);
                    // Дата регистрации
                    $registration_date = date('d')." ".date('n')." ".date('Y');
                    // Регистрируем пользователя
                    $info = array("name"=>$_POST['name'], "second_name"=>$_POST['secondname'], "connection_info" => $_POST['connect_info'], "birthday_date" => $_POST['birthday'], "sex" => $_POST['sex'], "password" => $password['password'], "registration_date" => $registration_date , "salt" => intval($password['salt']), "activity"=> "1", "verify" => $verify_password, 'IP' => $_SERVER['REMOTE_ADDR']);
                    $result = Sql::SqlQuery('insert', $info, 'users');
                    //Возращаем последний id
                    $user_id = Sql::SqlQuery('select', '', 'users', 'id', '', 'ORDER BY ID DESC LIMIT 1');
                    //Отправляем пароль верификации на почту
                    if(filter_var($_POST['connect_info'], FILTER_VALIDATE_EMAIL)){
                        mail($_POST['connect_info'], 'password', $verify_password);
                    }
                    //Ставим сессию при регистрации
                    $_SESSION['id'] = $user_id[0]['id'];
                    //Кэш данных
                    unset($info["password"]);
                    unset($info["salt"]);
                    unset($info["IP"]);
                    Functions::CacheFiles('r', 'any', '_cacheJsonData.json', 1440, $id = $user_id[0]['id']);
                    echo json_encode(sort($json));
                    Functions::CacheFiles('w', 'any', '_cacheJsonData.json', 1440, $id = $user_id[0]['id']);
                    
                    return true;
                }
            }
        }
        
        //Функция срабатывает при входе
        public function actionLogin(){
            //При входе через страницу регистрации
            if(isset($_POST['form_password'])){
                // Если пароль не верный
                if($_POST['form_password'] == '0'){
                    setcookie('FP', 0, time()+450);
                }
                // Если контактные данные не верные
                if($_POST['connection_info'] == '0'){
                    setcookie('FC', 0, time()+450);
                // Если контактные данные верные
                }   else {
                    setcookie('FC', $_POST['connection_info'], time()+450);
                }
                return true;
            }

            // Работа с cookie которые установлены при неверных данных
            if(isset($_COOKIE['FP'])){
                $fp = $_COOKIE['FP'];
                //Удаляем куки
                setcookie('FP', 0, time()-450);
            }
            if(isset($_COOKIE['FC'])){
                $fc = $_COOKIE['FC'];
                //Удаляем куки
                setcookie('FC', 0, time()-450);
            }

            // Работа со страницей входа
            if(isset($_POST['connect_info'])){
                // Берем данные из БД
                $result = Sql::sqlQuery('select', array('connection_info' => $_POST['connect_info']), 'users', 'id, name, second_name, connection_info, birthday_date, sex, activity, verify');
                // Если пользователь не найден
                if($result == false){
                    echo "0";
                    return true;
                // Если пользователь найден
                }   else {
                    $password = md5(md5($_POST['password']).$result[0]['salt']);
                    // Если пароли не совпадают
                    if($password != $result[0]['password']){
                        echo "1";
                        return true;
                    }   else {
                        $_SESSION['id'] = $result[0]['id'];
                        // Устанавливаем что пользователь онлайн
                        $result = Sql::sqlQuery('insert', array('activity' => '1'), 'users', '', array('id' => $result[0]['id']));
                        if($result = Functions::CacheFiles('g', 'any', '_cacheJsonData.json', '', $_SESSION['id'])){
                            $result =  json_decode($result);
                            $result['activity'] = 1;
                        }
                    }
                }               
                return true;
            }
            include_once(ROOT.'/views/user/login.php');
            return true;
        }

        //Функция срабатывает во время активной сессии
        public function actionAccount(){
            
            // Если есть кэш файл не выплняем запрос
            if($result = Functions::CacheFiles('g', 'any', '_cacheJsonData.json', '', $_SESSION['id'])){
                
            }   else {
                // Если нет кэш файла - выполняем запрос
                $result = Sql::sqlQuery('select', array('id' => $_SESSION['id']), 'users', 'name, second_name, connection_info, birthday_date, sex, registration_date, activity, verify');
                // Кэшируем данные
                Functions::CacheFiles('r', 'any', '_cacheJsonData.json', 1440, $id = $_SESSION['id']);
                echo json_encode($result);
                Functions::CacheFiles('w', 'any', '_cacheJsonData.json', 1440, $id = $_SESSION['id']);
            }

            //Подключаем вид
            
            return true;
        }
    }
