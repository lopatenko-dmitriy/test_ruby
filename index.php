<?php
	session_start();
	ini_set('display_errors', 1);

	// определяем в константу путь к файлам
	$site_path = realpath(dirname(__FILE__));
 	define ('__SITE_PATH', $site_path);

 	// подключаем загрузчик для использования пространства имен
 	require_once 'core/autoloader.php';
	use Core\Autoloader\Autoloader;
	Autoloader::autoloadRegister();

	// подключаем файл с настройками
	require_once 'core/config.php';

 	// запускаем обработку URL
	require_once 'core/route.php';
	Route::start();




