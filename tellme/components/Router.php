<?php
    /**
     * Компонент для работы с маршрутами
     */
    class Router 
    {
        // Переменная с сылкой
        private $url;
        // Функция получения данных для контроллера
        public function __construct()
        {
            $this->url = $_SERVER['REQUEST_URI'];
        }
        // Функция получения названия контроллера
        private function getController () {
            if($this->url == "/"){
                return 'Site';
            }   else if(preg_match('([0-9a-zA-Z]+)', $this->url)) {
                return explode('/', $this->url);
            }   else {
                return '404';
            }            
        }


        // Функция открытия необходимого контроллера с передачей данных
        public function run(){
            // Берем название контроллера и данные
            $urli = $this->getController();
            // Удаляем первый пробелл если нужно
            if (!is_string($urli)) {
                $urli = array_splice($urli, 1);
            }
            // Работа с контроллерами и их данными
            if(is_array($urli)){
                // Данные о названиях и путях 
                $actionName = 'action'.ucfirst($urli[0]);
                $controllerName = ucfirst($urli[0]).'Controller';
                $controllerFile = ROOT.'/controllers/' . $controllerName . '.php';
                $parameters = array();
                // Удаляем лишний элемент с массива
                $urli = array_splice($urli, 1);
                // Проверяем пустой ли массив, если да то заканчиваем работу
                if(empty($urli[0]) || empty($urli)){
                    $flag = false;
                    // Проверяем на существование файл и подключаем, если нет файла - 404
                    if(file_exists($controllerFile)){
                        include_once($controllerFile);
                        $controllerObject = new $controllerName;
                        $actionName = 'actionIndex';
                        foreach($controllerObject->array_function as $is_action){
                            if($actionName == $is_action){
                                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                                $flag = false;
                                break;
                            }   else {
                                $flag = true;
                            }                            
                        }
                        //Ищем в SiteController если нет то 404
                    }   else if( file_exists(ROOT.'/controllers/SiteController.php') ){
                        include_once(ROOT.'/controllers/SiteController.php');
                        $controllerObject = new SiteController();
                        foreach($controllerObject->array_function as $is_action){
                            if($actionName == $is_action){
                                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                                $flag = false;
                                break;
                            }   else {
                                $flag = true;
                            }                            
                        }
                    }   else{
                        echo "404 - 1";
                    }
                    if ($flag) {
                        echo "404 - 2";
                    }
                } else {
                    // Создаем action 
                    $actionName = 'action'.ucfirst($urli[0]);

                    $urli = array_splice($urli, 1);
                    // если массив urli не пустой (остаток - параметры) передаем его значения
                    if (!empty($urli)){
                        $parameters = $urli;
                    }
                    // проверяем существование файла если нет - 404
                    if(file_exists($controllerFile)){
                        // Создаем обьект
                        $controllerObject = new $controllerName;
                        include_once($controllerFile);
                        $flag = false;
                        // Если actionName есть в классе то подключаем, нет - 404
                        foreach($controllerObject->array_function as $is_action){
                            if($actionName == $is_action){
                                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                                $flag = false;
                                break;
                            }   else {
                                $flag = true;
                            }
                        }
                        if ($flag) {
                            echo "404 - 3";
                        }
                    }   else {
                        echo "404 - 4";
                    }
                }
            }   else if($urli == '404'){
                echo "404 - 5";
            }   else {
                echo "<a href='/user'>sign-in</a>";
            }
        }

    }