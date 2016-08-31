<?php
namespace core\controllers;

abstract class Controller 
{
	// обязательно в каждом контролере должен присуцтвовать метод actionIndex()
	abstract public function actionIndex();

	// перенаправление на заданную страницу
	public function redirect($redirect)
	{
		if(!preg_match("/^http:/", $redirect))	$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		header('Location:'.$host.$redirect);
		exit;
	}

	// соединение заданных представлений в одно и вывод в браузер.
	public function display($name, $data = array())
	{
		require_once(__SITE_PATH.'/views/header.php');
		require_once(__SITE_PATH.'/views/'.$name.'.php');
		require_once(__SITE_PATH.'/views/footer.php');
	}
	
	// вывод в браузер только представление.
	public function displayPartial($name, $data = array())
	{
		require_once(__SITE_PATH.'/views/'.$name.'.php');
	}

}
