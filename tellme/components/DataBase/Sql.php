<?php 
    class Sql{
        //функция построения запросов к бд
        public static function sqlQuery($type, $nfo = '', $table = '', $what_select = '*', $add_array = '', $add_info = ''){
            if($table == ''){
                return 'WARNING 1';
            }
            $sql = '';
            $info = array();
            foreach($nfo as $key => $value){
                $value = trim($value);
                $value = stripcslashes($value);
                $value = strip_tags($value);
                $value = htmlspecialchars($value);
                $info[$key] = $value;
            }
            //Если select строем запрос
			if (strcasecmp($type, 'select') == 0) {
				if($info != ''){
					$sqlSelect = '';
					foreach ($info as $key => $value) {
						$sqlSelect .= $key.' = :'.$key.' AND ';
					}
                    $sqlSelect = substr($sqlSelect, 0, -5);
					$sql = 'SELECT '.$what_select.' FROM '.$table.' WHERE '.$sqlSelect;
				}   else {
                    $sql = 'SELECT '.$what_select.' FROM '.$table;
                }
                if($add_info != ''){
                    $sql .= ' '.$add_info;
                }
                //Если insert строем запрос
			}    else if(strcasecmp($type, 'insert') == 0){
                if($info == ''){
                    return 'WARNING 2';
                }   else {
                    $sqlInsertTable = '';
                    $sqlInsertInfo  = '';
                    foreach($info as $key => $value){
                        $sqlInsertTable .= ' '.$key.', ';
                        $sqlInsertInfo  .= ' :'.$key.', ';
                    }
                    $sqlInsertTable  =  substr($sqlInsertTable, 0, -2);
                    $sqlInsertInfo   =  substr($sqlInsertInfo , 0, -2);
                    $sql = 'INSERT INTO '.$table.' ( '.$sqlInsertTable.' ) VALUES ( '.$sqlInsertInfo.' )';
                }
                //Если update строем запрос
            }   else if(strcasecmp($type, 'update') == 0){
                 if($info == ''){
                    return 'WARNING 3';
                }   else {
                     $sqlInsert = '';
                     foreach($info as $key => $value){
                         $sqlInsert .=  $key.' = :'.$key;
                     }
                     $sqlAddInsert = '';
                     foreach($add_array as $key => $value){
                         $sqlAddInsert .= $key.' = :'.$key;
                     }
                     $sql = 'UPDATE '.$table.' SET '.$sqlInsert.' WHERE '.$sqlAddInsert;
                 }               
            }
            // Есть доп. данные? Добавляем их к запросу
            if($add_info != ''){
                $sqlAddInfo = '';
                 foreach($add_array as $key => $value){
                     $sqlAddInsert .= $key.' = :'.$key;
                 }
                $sql .= ' '.$add_info.' '.$sqlAddInsert;
            }
            // Всё ОК, выполняем запрос и завершаем работу
            if($sql != ''){
                // Есть $add_array ? Добавляем его к основному массиву $info
                if($add_array != ''){
                    $info = array_merge($info, $add_array);
                }
                $result = Db::DbRequest($sql, $info);
                return $result;
            }   else {
                return 'Что то пошло не так';
            }
		}
    }
