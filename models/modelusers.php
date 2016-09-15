<?php
namespace models;

use core\models\model;

class ModelUsers extends model
{
	// Класс для работы с пользователями
	private $login;
	private $password;
	private $error;

	protected $table = 'users';
	
	// добавление нового пользователя в БД
	public function add($login, $password)
	{
		$query = "INSERT INTO `".DB_PREFIX.$this->table."` 
			(`login`, `hash`, `create`) VALUES 
			('".htmlspecialchars($login)."', '".md5($password)."','".time()."')";
		return $this->query($query);
	}
	
	// получить пользователя по логину
	public function getOnLogin($login)
	{
		$query = "SELECT * FROM `".DB_PREFIX.$this->table."` WHERE login = '".htmlspecialchars($login)."'";
		return $this->query($query);
	}

	// загрузить и проверить данные для записи
	public function load($login, $password)
	{
		$this->login = $login;
		$this->password = $password;

		return $this->validate();
	}

	// запись данных в БД
	public function save()
	{
		return $this->add($this->login, $this->password);
	}

	// Проверка данных на существование.
	private function validate()
	{
		$this->error = false;
		if(empty($this->login)) {
			$this->error['login'] = "Введите логин";
		}
		if(strlen($this->login) > 255) {
			$this->error['login'] = "Логин слишком длинный";
		}
		if(strlen($this->login) < 3) {
			$this->error['login'] = "Логин слишком короткий";
		}
		if(empty($this->password)) {
			$this->error['password'] = "Введите пароль";
		}
		if(strlen($this->password) > 255) {
			$this->error['password'] = "Пароль слишком длинный";
		}
		if(strlen($this->password) < 3) {
			$this->error['password'] = "Пароль слишком короткий";
		}
		
		return $this->error;
	}
}
