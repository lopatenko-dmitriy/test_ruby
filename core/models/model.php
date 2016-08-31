<?php
namespace core\models;

use core\models\database;


abstract class Model 
{
	// выполнение запроса к БД
	protected function query($query)
	{
		$db = DataBase::connect();
		$result = $db->query($query);
		if($result === false || $result === true) return $result;
		return $this->resultToArray($result);
	}

	// переформатирует результат в масив
	private function resultToArray($result)
	{
		$data = array();
		while($row = mysqli_fetch_assoc($result)) {
				$data[] = $row;
			}
		$result->close;
		return $data;
	}
	
	// выбор записи по id
	public function get($id)
	{
		if(!(int)$id) return false;
		$query = "SELECT * FROM `".DB_PREFIX.$this->table."` WHERE id = '".(int)$id."'";
		$result = $this->query($query);
		return (isset($result[0]) && !empty($result[0]))? $result[0] : fasle;
	}
	
	// выбрать все записи
	public function getAll($order = "'id'")
	{
		$query = "SELECT * FROM `".DB_PREFIX.$this->table."` ORDER BY ".htmlspecialchars($order);
		return $this->query($query);
	}
	
	// удалить все записи
	public function removeAll()
	{
		$query = "DELETE FROM `".DB_PREFIX.$this->table."`";
		return $this->query($query);
	}
	
	// удалить запись по id
	public function remove($id)
	{
		$query = "DELETE FROM `".DB_PREFIX.$this->table."` WHERE `id` = '".(int)$id."'";;
		return $this->query($query);
	}
	
	// редактирование имени по id
	public function editName($id, $name)
	{
		$query = "UPDATE `".DB_PREFIX.$this->table."` SET `name` = '".htmlspecialchars($name)."' WHERE `id` = '".(int)$id."'";
		return $this->query($query);
	}
	
	// поднимает по сортировке запись
	public function orderMove($id, $move, $where = "")
	{
		if($move == "up") {
			$move = '>';
			$order = "";
		} elseif($move == "down") {
			$move = '<';
			$order = "DESC";
		}else return false;
		if(!(int)$id) return false;
		$query = "SELECT * FROM `".DB_PREFIX.$this->table."` WHERE `id` = '".(int)$id."'";
		$result_up = $this->query($query);
		if(isset($result_up[0]) && !empty($result_up[0])){
			
			$query = "SELECT * FROM `".DB_PREFIX.$this->table."` WHERE `order` ".$move." '".$result_up[0]['order']."' ".$where." ORDER BY `order` ".$order." LIMIT 1";
			$result_down = $this->query($query);
			print_r($query);
			if(isset($result_down[0]) && !empty($result_down[0])){
				$query = "UPDATE `".DB_PREFIX.$this->table."` SET `order` = '".$result_up[0]['order']."' WHERE `id` = '".$result_down[0]['id']."'";
				$this->query($query);
				$query = "UPDATE `".DB_PREFIX.$this->table."` SET `order` = '".$result_down[0]['order']."' WHERE `id` = '".$result_up[0]['id']."'";
				$this->query($query);
				return true;
			}
		}
		return false;
	}

}
