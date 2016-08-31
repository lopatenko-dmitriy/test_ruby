<?php
namespace core\models;

class DataBase
{
	private static $connect;
	private $mysqli;

	private function __construct()
	{
		$this->mysqli = new \mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		$this->mysqli->query("SET NAMES 'utf8'");
	}

	// метод создания подключения к БД 
	public static function connect()
	{
		if(!isset(self::$connect)) self::$connect = new DataBase();
		if(!isset(self::$connect) || !self::$connect) die('Ошибка при подключении к базе данных'); 
		return self::$connect;
	}

	// выполнение запроса
	public function query($query) 
	{
		return $this->mysqli->query($query);
	}

	private function __clone(){}
}