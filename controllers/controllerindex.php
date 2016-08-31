<?php
use core\controllers\controller;
use core\request;
use models\modelprojects;
use models\modeltasks;

class ControllerIndex extends Controller
{

	public function actionindex()
	{
		$model_projects = new ModelProjects;
		$model_tasks = new ModelTasks;
		$data = array();
		
		// получает все проекты
		$data['projects'] = $model_projects->getAll("`order` DESC");
		
		// получает актывный проект для вывода его задач
		$data['active_project'] = (isset($data['projects'][0]))? $data['projects'][0] : 0;
		if(isset(Request::$get['active_project'])){
			$data['active_project'] =  $model_projects->get(Request::$get['active_project']);
		}
		
		// получить все задачи для первого проекта
		if(isset($data['active_project']) && !empty($data['active_project'])){
			$data['tasks'] = $model_tasks->getAllOnProject($data['active_project']['id'], "`order` DESC");
		} else $data['tasks'] = false;
		
		// если признак AJAX запроса выводит без heade и footer иначе с ними
		if(isset(Request::$get['ajax']) && Request::$get['ajax']) $this->displayPartial('index', $data);
		else $this->display('index', $data);
	}
	
	// перемещение проекта
	public function actionmoveproject()
	{
		if(isset(Request::$post['id']) && isset(Request::$post['move'])){
			$model_projects = new ModelProjects;
			return $model_projects->orderMove(Request::$post['id'], Request::$post['move']);
		} else return false;
	}
	
	// перемещение задачи
	public function actionmovetask()
	{
		if(isset(Request::$post['id']) && isset(Request::$post['project_id']) && isset(Request::$post['move'])){
			$model_tasks = new ModelTasks;
			return $model_tasks->orderMove(
										Request::$post['id'], 
										Request::$post['move'], 
										"AND `project_id` = '".(int)Request::$post['project_id']."'"
										);
		} else return false;
	}
	
	// создание проекта
	public function actioncreateproject()
	{
		if(isset(Request::$post['name'])){
			$model = new ModelProjects;
			$result = $model->add(Request::$post['name']);
			if($result !== false) echo true;
			return;
		}
		return false;
	}
	
	// создание задачи
	public function actioncreatetask()
	{
		if(isset(Request::$post['name']) && isset(Request::$post['project_id'])){
			$model = new ModelTasks;
			$result = $model->add(Request::$post['name'], Request::$post['project_id']);
			if($result !== false) echo true;
			return;
		}
		return false;
	}
	
	// удаление проекта или задачи по id
	public function actionremoveitem()
	{
		if(isset(Request::$post['id']) && isset(Request::$post['type'])){
			if(Request::$post['type'] == 'project') $model = new ModelProjects;
			elseif(Request::$post['type'] == 'task') $model = new ModelTasks;
			else return false;
			$result = $model->remove(Request::$post['id']);
			if($result !== false) echo true;
			return;
		}
		return false;
		
	}
	
	// редактирование имени проекта или задачи по id
	public function actionedit()
	{
		if(isset(Request::$post['id']) && isset(Request::$post['name']) && isset(Request::$post['type'])){
			if(Request::$post['type'] == 'project') $model = new ModelProjects;
			elseif(Request::$post['type'] == 'task') $model = new ModelTasks;
			else return false;
			$result = $model->editName(Request::$post['id'], Request::$post['name']);
			if($result !== false) echo true;
			return;
		}
		return false;
	}
}