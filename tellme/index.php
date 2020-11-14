<?php

// FRONT CONTROLLER

// Общие настройки
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();
// Подключение файлов системы
define('ROOT', dirname(__FILE__));
define('EXTEND', dirname(__FILE__).'\components\ExtandClasses\ExtendClass.php');
require_once(ROOT.'/components/Autoload.php');
require_once(EXTEND);

// Вызов Router
$router = new Router();
$router->run();
