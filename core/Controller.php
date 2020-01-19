<?php

	namespace core;

	abstract class Controller
	{
		public $route;
		public $view;
		public $model;

		public function __construct($route)
		{
//			var_dump($this->generateFormToken('token'));
//			var_dump($_POST);
//			if ($this->tokenCheck('token'))
//				$this->generateFormToken('token');
//			else {
////				var_dump($_POST);
////				echo "token error";
//				exit (0);
//			}
//			var_dump($_SESSION);
//			$_POST['boken'] = $_SESSION['token'];
			$this->route = $route;
			$this->view = new View($route);
			$this->model = $this->loadModel($route['controller']);
		}

		public function loadModel($name)
		{
			$path = 'models\\' . ucfirst($name);
			if (class_exists($path)) {
				return new $path;
			}
			return NULL;
		}
	};
