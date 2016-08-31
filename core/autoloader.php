<?php
namespace Core\Autoloader;
 
class Autoloader
{
    // класс автоматического подключения файлов, согласно пространства имен

    public static function loadClass($class)
    {
        $class = ltrim($class, '\\');
 
        if (!defined('PATH_SEPARATOR'))
            define('PATH_SEPARATOR', getenv('COMSPEC')? ';' : ':');
        ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR.dirname(__FILE__));
 
        $filePath = mb_strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $class)) . '.php';
        include $filePath;
    }
 
    public static function autoloadRegister()
    {
        spl_autoload_register('self::loadClass');
    }

}