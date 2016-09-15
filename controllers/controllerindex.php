<?php
use core\controllers\controller;
use core\request;
use models\modelprojects;
use models\modeltasks;
use models\modelusers;

class ControllerIndex extends Controller
{

	public function actionindex()
	{
		// если пользователь не авторизован, редирект на страницу входа
		if(!isset($_SESSION['user']['id']) || !$_SESSION['user']['id']) {
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: http://".$_SERVER['HTTP_HOST']."/index/login");
			exit();
		}
		$model_projects = new ModelProjects;
		$model_tasks = new ModelTasks;
		$data = array();
		
		// получает все проекты
		$data['projects'] = $model_projects->getAll("`order` DESC", $_SESSION['user']['id']);
		
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
	
	// вход пользователей
	public function actionlogin()
	{
		// создает пустые обязательные переменные
		$data['errors'] = '';
		$data['login'] = '';
		$data['password'] = '';
		
		// проверяет наличие в post запросе переменных login и password
		if(isset(Request::$post['login']) && isset(Request::$post['password'])){
			$model_users = new ModelUsers;
			$user = $model_users->getOnLogin(Request::$post['login']);
			// проверяет на наличие логина в системе
			if(!empty($user) && $user[0]) {
				if($user[0]['hash'] == md5(Request::$post['password'])){
					// запись данных пользователя в сессию
					$_SESSION['user'] = $user[0];
					// редирект на главную
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: http://".$_SERVER['HTTP_HOST']);
					exit();
				} else {
					$data['errors'] = 'Неправильный логин и/или пароль!';
				}
			} else {
				$data['errors'] = 'Такого логина не существует!';
			}
		}
		$this->display('login', $data);
	}
	
	// выход пользователей
	public function actionlogout()
	{
		// удаление данных пользователя из сессии
		if(isset($_SESSION['user'])) unset($_SESSION['user']);
		// редирект на вход
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: http://".$_SERVER['HTTP_HOST']."/index/login");
		exit();
	}
	
	// регистрация пользователей
	public function actionregistration()
	{
		// создает пустые обязательные переменные
		$data['errors']['login'] = '';
		$data['errors']['password'] = '';
		$data['login'] = '';
		$data['password'] = '';
		$data['errors']['server_error'] = false;
		
		// проверяет наличие в post запросе переменных login и password
		if(isset(Request::$post['login']) && isset(Request::$post['password'])){
			$model_users = new ModelUsers;
			// проверяет на уникальнсть логина
			if(empty($model_users->getOnLogin(Request::$post['login']))) {
				// загружает переменные в модель и проводит валидацию
				$errors = $model_users->load(Request::$post['login'], Request::$post['password']);
				// проверка валидации
				if(!$errors){
					// сожранение данных пользователя в БД
					$result = $model_users->save();
					if(!$result) $data['errors']['server_error'] = true;
					else{
						// редирект на форму входа
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: http://".$_SERVER['HTTP_HOST']."/index/login?success=success");
						exit();
					} 
				} else {
					$data['errors'] = $errors + $data['errors'];
				}
				$data['login'] = Request::$post['login'];
				$data['password'] = Request::$post['password'];
			} else {
				$data['errors']['login'] = 'Такой логин уже существует';
			}
		}
		$this->display('registration', $data);
	}
	
	// перемещение проекта
	public function actionmoveproject()
	{
		if(isset(Request::$post['id']) && isset(Request::$post['move'])){
			$model_projects = new ModelProjects;
			return $model_projects->orderMove(Request::$post['id'], Request::$post['move'], '', $_SESSION['user']['id']);
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