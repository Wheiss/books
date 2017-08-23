<?php

// 1. Настройки
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));

// 2. Загрузка Всех классов и функций

include_once ROOT . '/includes.php';

session_start();
// 3. Вызов главного контроллера
$application = Application::getInstance();
$application->run();