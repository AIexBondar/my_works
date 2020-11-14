<?php 
    // Класс с разными функциями 
    class Functions{
        //Шифрование и проверка пароля
        public static function Pass($type, $password, $password_db, $salt = ''){
            //Шифрование
            if($type == 'encryption'){
                $salt = rand(99, 999999);
                $password = md5(md5($password).$salt);
                return array('salt'=>$salt,'password'=>$password);
            }
            //Проверка
            if($type == 'validate'){
                if($password_db != md5(md5($password).$salt)){
                    return false;
                }   else {
                    return true;
                }
            }
        }
        
        // Генирация случайных паролей
        public static function VPGenerator($number){
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
			 for ($i=0; $i < $number; $i++) { 
			 	$index = rand(0, count($arr) - 1);
			 	$pass .= $arr[$index];
			 }
			 return $pass;
		}
        
        //Функция кэширования страниц
        //$type - что берем r, w, g; $data - тип файла html или другие; $filename - имя файла; $cachetime - время кэша; $id - id пользователя
        public static function CacheFiles($type = '', $data = '', $filename = '', $cachetime = 1440, $id){
            $file = ROOT.'/Cache/Dir-'.$id;
            if($filename == ''){          
                $link = $_SERVER['REQUEST_URI'];
                $link = explode('/', $link);
                $filename = '';
                foreach ($link as $key => $value) {
                	$filename .= ucfirst($value);
                }
                $filename = 'cached-'.$filename.'.html';
                $filename = $file.'/'.$filename;
            }   else {
                $filename = $file.'/'.$filename;   
            }
            if($type == 'r'){
                if($data == 'html'){
                    if(!file_exists($file)){
                        mkdir($file);
                        fopen($filename, 'w');
                    }   else {
                        if(file_exists($filename)){
                            if((time() - $cachetime) < filemtime($filename)){
                                echo file_get_contents($filename);
                                exit;
                            }  else {
                                unlink($filename);
                            }
                        }  else {
                            fopen($filename, 'w');
                        }   
                    }
                }
                if($data == 'any'){
                    if(!file_exists($file)){
                         mkdir($file);
                         fopen($filename, 'w');
                    }                    
                }
                ob_start();   
            }
            if($type == 'w'){
                $buffer = ob_get_contents();
                ob_end_flush();
                $handle = fopen($filename, 'w');
                fwrite($handle, $buffer);
                fclose($handle);
            }
            if($type == 'g'){
                if(file_exists($filename)){
                    $data = file_get_contents($filename);
                    return $data;
                }   else {
                    return false;
                }
            }
        }
        //Проверка длины строки
        public static function CheckLength($value = "", $min, $max){
            $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
            return !$result;
        }
    }
