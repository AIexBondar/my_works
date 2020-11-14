<?php
	//Этот класс будут наследовать другие классы. Он сделан для создания массива со всем функциями класса.
	class ExtendClass{
		public $array_function;
		public function __construct(){
			$this->array_function = get_class_methods($this);
		}
	}