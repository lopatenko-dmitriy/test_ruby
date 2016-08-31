<?php
namespace models;

use core\models\model;

class ModelTasks extends model
{
	// Класс для добавления валидации и вывода задач

	private $name;
	private $project_id;
	private $error;

	protected $table = 'tasks';
	
	// добавление новой задачи в БД
	public function add($name, $project_id)
	{
		$query = "INSERT INTO `".DB_PREFIX.$this->table."` 
			(`name`, `project_id`, `create`, `status`, `order`) VALUES 
			('".htmlspecialchars($name)."', '".(int)$project_id."','".time()."','1','".time()."')";
		return $this->query($query);
	}
	
	// получить все задачи для проекта
	public function getAllOnProject($project_id, $order = "'id'")
	{
		$query = "SELECT * FROM `".DB_PREFIX.$this->table."` WHERE project_id = '".(int)$project_id."' ORDER BY ".htmlspecialchars($order);
		return $this->query($query);
	}

	// загрузить и проверить данные для записи
	public function load($name, $project_id)
	{
		$this->name = $name;
		$this->project_id = $project_id;

		return $this->validate();
	}

	// запись данных в БД
	public function save()
	{
		return $this->add($this->name, $this->project_id);
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
		if(empty($this->project_id) || !(int)$this->project_id) {
			$this->error['project_id'] = "Введите project_id";
		}
		return $this->error;
	}
}
