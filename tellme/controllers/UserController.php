<?php
	// ExtendClass - класс наследия
	
	class UserController extends ExtendClass {

		public function actionIndex(){
			if(isset($_SESSION['id'])){
				header("Location: /user/account/");
			}	else {
				header("Location: /user/signin/");
			}
			return true;
		}

		public function actionLogin(){
			if (isset($_POST['form_password'])) {
				$pass = $_POST['form_password'];
				if ($_POST['form_password'] == '0') {
					setcookie('Fpass', 0, time()+450);
				}
				if ($_POST['connecting_info'] == '0') {
					setcookie('Fconnect', 0, time()+450);
				}	else{
					setcookie('Fconnect', $_POST['connecting_info'], time()+450);
				}
				return true;
			}

			if(isset($_COOKIE['Fpass'])){
				$fpass = $_COOKIE['Fpass'];
				unset($_COOKIE['Fpass']);
				setcookie('Fpass', 0, time()-450);
			}
			if(isset($_COOKIE['Fconnect'])){
				$fconnect = $_COOKIE['Fconnect'];
				unset($_COOKIE['Fconnect']);
				setcookie('Fconnect', 0, time()-450);
			}

			if(isset($_POST['connect_info'])){
				$sql = 'SELECT id, password, salt FROM users WHERE connection_info = :connection_info';
				$info_array = array('connection_info'=>$_POST['connect_info']);
				$result = Db::DbRequest($sql, $info_array);
				//$res = func('SELEC', 'id, password, salt', array('a ='));
				if ($result == false) {
				 	echo "0";
				 	return true;
				 } else {
				 	$password = md5(md5($_POST['password']).$result[0]['salt']);
				 	if($password != $result[0]['password']){
				 		echo "1";
				 		return true;
				 	}	else {
				 		$_SESSION['id'] = $result[0]['id'];
				 		$sql = 'UPDATE users SET activity = :activity WHERE id = :id';
				 		$info_array = array('activity' => '1', 'id'=>$result[0]['id']);
				 		$result = Db::DbRequest($sql, $info_array);
                        if($result = Functions::CacheFiles('g', 'any', '_cacheJsonData.json', '', $_SESSION['id'])){
                            $result =  json_decode($result);
                            $result['activity'] = 1;
                        }
				 		return true;
				 	}
				 	return true;
				 }
			}
			include_once(ROOT.'/views/user/login.php');
			return true;
		}

		public function actionSignin(){
			if(isset($_POST['connect_info'])){
				$connect_info = $_POST['connect_info'];
				$sql = 'SELECT id FROM users WHERE connection_info = :connection_info';
				$info_array = array("connection_info" => $connect_info);
				$result = Db::DbRequest($sql, $info_array);
				if ($result != false) {
					echo "0";
					return true;
				}	else {
					$verify_password = $this->PasswordGeneration();
					$salt = rand(99, 999999);
					$password = md5(md5($_POST['password']).$salt);
					$registration_date = "Date: ".date('d')."; Month: ".date('n')."; Year: ".date('Y');
					$sql = 'INSERT INTO `users` (`id`, `name`, `second_name`, `connection_info`, `birthday_date`, `sex`, `password`, `registration_date`, `salt`, `activity`, `verify`) VALUES (NULL, :name, :second_name, :connection_info,:birthday_date, :sex, :password, :registration_date, :salt, :activity, :verify)';
					$info_array = array("name"=>$_POST['name'], "second_name"=>$_POST['secondname'], "connection_info" => $_POST['connect_info'], "birthday_date" => $_POST['birthday'], "sex" => $_POST['sex'], "password" => $password, "registration_date" => $registration_date , "salt" => intval($salt), "activity"=> "1", "verify" => $verify_password);
					$result = Db::DbRequest($sql, $info_array);
					$sql = 'SELECT id FROM users ORDER BY ID DESC LIMIT 1';
					$result = Db::DbRequest($sql);
					if(preg_match('/^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i', $_POST['connect_info'])){
						mail($_POST['connect_info'], 'password', $verify_password);
					}
					$_SESSION['id'] = $result[0]['id'];
                    unset($info_array["password"]);
                    Functions::CacheFiles('r', 'any', '_cacheJsonData.json', 1440, $id = $result[0]['id']);
                    echo json_encode($info_array);
                    Functions::CacheFiles('w', 'any', '_cacheJsonData.json', 1440, $id = $result[0]['id']);
					return true;
				}
			}
            
			include_once(ROOT.'/views/user/register.php');
            
			return true;
		}

		public function actionAccount(){

			if(isset($_POST['go_in'])){
		 		$sql = 'UPDATE users SET activity = :activity WHERE id = :id';
		 		$info_array = array('activity' => "1", 'id'=>$_SESSION['id']);
		 		$result = Db::DbRequest($sql, $info_array);	
				$sql = 'SELECT name, second_name, connection_info, birthday_date, sex, registration_date, activity, verify FROM users WHERE id=:id';
				$info_array = array('id'=>$_SESSION['id']);
				$result = Db::DbRequest($sql, $info_array);
				echo $result[0]['activity'];
		 		return true;		
			}

			$sql = 'SELECT name, second_name, connection_info, birthday_date, sex, registration_date, activity, verify FROM users WHERE id=:id';
			$info_array = array('id'=>$_SESSION['id']);
			$result = Db::DbRequest($sql, $info_array);
			$verify = $result[0]['verify'];
			var_dump(Functions::CacheFiles('g', 'any', '_cacheJsonData.json', '', $_SESSION['id']));
			if (isset($_COOKIE['clicks'])) {
				if(isset($_COOKIE['id_click'])){
					if($_COOKIE['id_click'] != $_SESSION['id']){
						unset($_COOKIE['id_click']);
						unset($_COOKIE['clicks']);
						if(isset($_COOKIE['time_verify'])){
							unset($_COOKIE['time_verify']);
						}
					}
				}
			}

			if (isset($_POST['verify_password'])) {
				if($_POST['verify_password'] != $verify){
					echo "0";
					return true;
				}	else {
					$sql = 'UPDATE users SET verify = :verify WHERE id = :id';
					$info_array = array('verify' => '1', 'id'=>$_SESSION['id']);
					$result = Db::DbRequest($sql, $info_array);
					return true;
				}
			}

			if (isset($_POST['send_verify'])) {
				if(isset($_COOKIE["clicks"])){
					$_COOKIE["clicks"]+=1;
					setcookie('clicks', $_COOKIE["clicks"], time()+1800);
				}	else {
					$value = 0;
					setcookie('clicks', $value, time()+1800);
					setcookie('id_click', $_SESSION['id'], time()+1800);
				}
				$verify_password = $this->PasswordGeneration();
				mail($result[0]['connection_info'], 'password', $verify_password);
		 		$sql = 'UPDATE users SET verify = :verify WHERE id = :id';
 				$info_array = array('verify' => $verify_password, 'id'=>$_SESSION['id']);
	 			$result = Db::DbRequest($sql, $info_array);
	 			if(isset($_COOKIE['clicks'])){
	 				if($_COOKIE['clicks'] == 4){
		 				$time = date('H').':'.date('i');
		 				setcookie('time_verify', $time, time()+1800);
		 				echo "0";
	 				}
	 			}
	 			return true;
			}
			if(isset($_COOKIE['time_verify'])){
				$time_array = explode(':', $_COOKIE['time_verify']);
				if ($time_array[1]>29) {
					$time_minut_now = date('i');
					if($time_minut_now >= 0 && $time_minut_now < 29){
						$time_minut_now += 60;
					}
					$time_wait = ($time_array[1]+30) - $time_minut_now;
				}	else {
					$time_wait = ($time_minutes = $time_array[1] + 30) - date('i');
				}

			}
			if(isset($_POST['my_time'])){
				if(isset($_COOKIE['time_verify'])){
					$time_array = explode(':', $_COOKIE['time_verify']);
					if ($time_array[1]>29) {
						$time_minut_now = date('i');
						if($time_minut_now >= 0 && $time_minut_now < 29){
							$time_minut_now += 60;
						}
						$time_wait = ($time_array[1]+30) - $time_minut_now ;
						echo $time_wait;
						return true;
					}	else {
						$time_wait =  date('i') - $time_minutes = $time_array[1];
						echo $time_wait;
						return true;
					}
				}
				return true;		
			}
			if(isset($_POST['go_out'])){
				$date = "Date: ".date('d')."; Time: ".date('H').":".date('i')."; Day: ".date('l');
		 		$sql = 'UPDATE users SET activity = :activity WHERE id = :id';
		 		$info_array = array('activity' => $date, 'id'=>$_SESSION['id']);
		 		$result = Db::DbRequest($sql, $info_array);			
			}
                Functions::CacheFiles('r', 'html', '', 1440, $id = $_SESSION['id']);
                include_once(ROOT.'/views/user/account.php');
                Functions::CacheFiles('w', 'html', '', 1440, $id = $_SESSION['id']);
            
			return true;
		}

		public function actionRestore(){
			if (isset($_POST['connect_info'])) {
				$sql = 'SELECT id FROM users WHERE connection_info=:connection_info';
				$info_array = array('connection_info'=>$_POST['connect_info']);
				$result = Db::DbRequest($sql, $info_array);
				if ($result == false) {
					echo "0";
					return true;
				}	else {
					$salt = rand(99, 999999);
					$password = $this->PasswordGeneration();
					mail($_POST['connect_info'], 'password', $password);
					$password = md5(md5($password).$salt);
					$connect_info = $_POST['connect_info'];
					$sql = 'UPDATE users SET password = :password WHERE connection_info = :connection_info';
					$info_array = array("password" => $password, "connection_info" => $connect_info);
					$result = Db::DbRequest($sql, $info_array);
					return true;
				}
			}
            Functions::CacheFiles('r', 'html', $id = $_SESSION['id']);
            include_once(ROOT.'/views/user/restore.php');
            Functions::CacheFiles('w', 'html', $id = $_SESSION['id']);   
          
			return true;
		}

		public function actionLogout(){

			$date = "Date: ".date('d')."; Time: ".date('H').":".date('i')."; Day: ".date('l');
	 		$sql = 'UPDATE users SET activity = :activity WHERE id = :id';
	 		$info_array = array('activity' => $date, 'id'=>$_SESSION['id']);
	 		$result = Db::DbRequest($sql, $info_array);
			unset($_SESSION['id']);
			header("Location: /user");
			return true;
		}
		
		private function PasswordGeneration(){
			 $arr = array('a','b','c','d','e','f',
			 'g','h','i','j','k','l',
			 'm','n','o','p','r','s',
			 't','u','v','x','y','z',
			 'A','B','C','D','E','F',
			 'G','H','I','J','K','L',
			 'M','N','O','P','R','S',
			 'T','U','V','X','Y','Z',
			 '1','2','3','4','5','6',
			 '7','8','9','0');
			 $pass = "";
			 for ($i=0; $i < 10; $i++) { 
			 	$index = rand(0, count($arr) - 1);
			 	$pass .= $arr[$index];
			 }
			 return $pass;
		}

	}
