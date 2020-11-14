<?php


/**
 * Класс Db
 * Компонент для работы с базой данных
 */
class Db
{

    /**
     * Устанавливает соединение с базой данных
     * @return \PDO <p>Объект класса PDO для работы с БД</p>
     */
    public static function DbRequest($sql, $info_array = false, $db_name = "facebook")
    {
        // Получаем параметры подключения из файла
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);

        // Устанавливаем соединение
        $dsn = "mysql:host={$params['host']};dbname={$db_name}";
        $pdo = new PDO($dsn, $params['user'], $params['password']);

        //Подготавливаем запрос к выполнению
        $result = $pdo->prepare($sql);
        //Если есть в массиве даные для sql запроса, добавляем параметры
        if ($info_array) {
            foreach($info_array as $name => $value){
                if (is_numeric($value)) {
                    $result->bindParam(':'.$name, $info_array[$name], PDO::PARAM_INT);
                } else {
                    $result->bindParam(':'.$name, $info_array[$name], PDO::PARAM_STR);
                }
            }
        }
        //Указываем что результат в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        //Запускаем подготовленный запрос
        $result->execute();
        $i = 0;
        $res = array();
        //Создаем массив с данными
        while ($row = $result->fetch()) {
            $res[$i]= $row;
            $i ++;
        }
        // Кодировка
        $pdo->exec("set names utf8");

        return $res;
    }

}