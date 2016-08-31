<?php
use core\request;

class Route {

	static function start()
	{
			// класс построения логики обращения к контроллерам и их методам, согласно запросу в URL

			// задаем значение по умолчанию
			$name = 'controllerindex';
			$action = 'index';

			// отрезаем GET состовляющую
			$url = $_SERVER['REQUEST_URI'];
			$pos_get = strpos($url, '?');
			if($pos_get !== false) $url = substr($url, 0, $pos_get);

			// разбиваем запрашиваемый URL
			$routes = explode('/', $url);

			// сохранение GET, POST, FILES данных в класс Request
			Request::$get = $_GET;
			Request::$post = $_POST;
			Request::$files = $_FILES;

			//запрашиваемый контроллер
			if ( !empty($routes[1]) )
			{	
				$name = 'controller'.$routes[1];
			}
			
			//запрашиваемый экшн
			if ( !empty($routes[2]) )
			{
				$pos = strpos($routes[2], "?");
				if($pos !== false){
					$action = substr($routes[2], 0, $pos);
				}
				else $action = $routes[2];

			}

			//далее ничего быть не должно
			if (!empty($routes[3]))
			{	
				// некорректный URL, переход на страницу NotFound404
				self::ErrorPage();
				return;
			}

			// определяем контроллер, экшн и модель.
			$controller = strtolower($name.'.php');
			$action = strtolower('action'.$action);

			// подключаем контроллер в соответствии с URL
			$controller_file = __SITE_PATH.'/controllers/'.$controller;

			if(file_exists($controller_file))
			{
				include $controller_file;
			}
			else
			{
				// если контроллер не определен, переход на страницу NotFound404
				self::ErrorPage();
				//return;
			}

			 	// Реализуем объект контроллера
			$model = new $name;

			if(method_exists($model, $action))
			{
				$model->$action();
			}
			else{
				// если метод не определен, переход на страницу NotFound404
				self::ErrorPage();
				return;
			}
	}

	static function ErrorPage()
	{
			// 404 redirect при запросе несуществующей страницы
	        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
	        header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
			header('Location:'.$host.'pagenotfound');
			exit;
	}


}