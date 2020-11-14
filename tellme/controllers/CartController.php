<?php
	// ExtendClass - класс наследия
	include_once(ROOT.'/components/ExtendClass.php');
	class CartController extends ExtendClass {
		public function actionIndex(){
			echo " CartControllers ";
			return true;
		}
		static function actionAs(){
			echo "actionAs";
			return true;
		}
	}