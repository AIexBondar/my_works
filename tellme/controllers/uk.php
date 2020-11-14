<?php
	// ExtendClass - класс наследия
	class UserController extends ExtendClass {
			public function sqlQuery($type, $info = ''){
			if (strcasecmp($type, 'select')) {
				if($info != ''){
					$sqlSelect = ''
					foreach ($info as $key => $value) {
						$sqlSelect .= $key.' = :'.$key;
					}
					$sql = 'SELECT * FROM user WHERE '.$sqlSelect.' = :'.$sqlSelect;
					return $sql
				}
			}
		}
		//Перенаправление, если был вход - на аккаунт
		public function actionIndex(){
			echo $this->sqlQuery('select', array('Type' => 'data'));
			return true;
		}
	}