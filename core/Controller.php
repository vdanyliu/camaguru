<?php

	namespace core;

	abstract class Controller
	{
		public $route;
		public $view;
		public $model;

		public function __construct($route)
		{
			if (!isset($_SESSION['token'])) {
				$this->generateFormToken('token');
			}
			if (!empty($_POST)) {
				if (!$this->checkFormToken('token')) {
					var_dump($_POST);
					var_dump($_SESSION);
					echo "token error";
					die(0);
				}
			}
			$this->generateFormToken('token');
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

		public function generateFormToken($form)
		{
			$token = md5(uniqid(microtime(), true));
			$_SESSION[$form] = $token;
			//echo $token;
			return $token;
		}

		public function checkFormToken($form)
		{
			// check if a session is started and a token is transmitted, if not return an error
			if (!isset($_SESSION[$form])) {
				echo "net tokena v sessii";
				var_dump($_SESSION);
				return false;
			}
			// check if the form is sent with token in it
			if (!isset($_POST[$form])) {
				echo "Net tokena v post";
				var_dump($_POST);
				return false;
			}
			// compare the tokens against each other if they are still the same
			if ($_SESSION[$form] !== $_POST[$form]) {;
				return false;
			}
			return true;
		}
	};
