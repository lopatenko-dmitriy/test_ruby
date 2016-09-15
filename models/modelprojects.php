<?php
namespace models;

use core\models\model;

class ModelProjects extends model
{
	// Класс для добавления валидации и вывода задач

	private $name;
	private $error;

	protected $table = 'projects';
	
	// добавление нового проекта в БД
	public function add($name)
	{
		$query = "INSERT INTO `".DB_PREFIX.$this->table."` 
			(`name`, `create`, `status`, `order`, `user_id`) VALUES 
			('".htmlspecialchars($name)."','".time()."','1','".time()."','".$_SESSION['user']['id']."')";
		return $this->query($query);
	}

	// загрузить и проверить данные для записи
	public function load($name)
	{
		$this->name = $name;

		return $this->validate();
	}

	// запись данных в БД
	public function save()
	{
		return $this->add($this->name);
	}

	// Проверка данных на существование.
	private function validate()
	{
		$this->error = false;
		if(empty($this->name)) {
			$this->error['name'] = "Введите имя";
		}
		if(strlen($this->name) > 255) {
			$this->error['name'] = "Имя слишком длинное";
		}
		return $this->error;
	}
}
