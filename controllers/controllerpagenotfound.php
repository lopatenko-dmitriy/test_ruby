<?php
use core\controllers\controller;

class ControllerPagenotfound extends controller
{

	// контроллер страница не найдена
	public function actionIndex()
	{
		$this->display('pagenotfound');
	}
}