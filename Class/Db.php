<?php

/*
 *  Класс, отвечающий за подключение к Базе данных
 */

class Db
{
    /*
     *  Метод подключается к БД и возвращает объект PDO
     */

	public static function getConnection()
	{
	
		$params = Config::$dbParams;
		$dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
		$db = new PDO($dsn, $params['user'], $params['password']);
		return $db;
	}
}