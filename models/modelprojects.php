<?php
namespace models;

use core\models\model;

class ModelProjects extends model
{
	// ����� ��� ���������� ��������� � ������ �����

	private $name;
	private $error;

	protected $table = 'projects';
	
	// ���������� ������ ������� � ��
	public function add($name)
	{
		$query = "INSERT INTO `".DB_PREFIX.$this->table."` 
			(`name`, `create`, `status`, `order`, `user_id`) VALUES 
			('".htmlspecialchars($name)."','".time()."','1','".time()."','".$_SESSION['user']['id']."')";
		return $this->query($query);
	}

	// ��������� � ��������� ������ ��� ������
	public function load($name)
	{
		$this->name = $name;

		return $this->validate();
	}

	// ������ ������ � ��
	public function save()
	{
		return $this->add($this->name);
	}

	// �������� ������ �� �������������.
	private function validate()
	{
		$this->error = false;
		if(empty($this->name)) {
			$this->error['name'] = "������� ���";
		}
		if(strlen($this->name) > 255) {
			$this->error['name'] = "��� ������� �������";
		}
		return $this->error;
	}
}
