<?php

	namespace core;

	abstract class Controller
	{
		public $route;
		public $view;
		public $model;

		public function __construct($route)
		{
			var_dump($_SESSION);
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
			$_POST['token'] = $this->generateFormToken('token');
			$this->route = $route;
			$this->view = new View($route);
			$this->model = $this->loadModel($route['controller']);
		}

		public function loadModel($name)
		{
			$path = 'models\\'.ucfirst($name);
			if(class_exists($path))
			{
				return new $path;
			}
				return NULL;
		}

		public function generateFormToken($form)
		{
//			$_SESSION['token'] = [];
			$token = md5(uniqid(microtime(), true));
			echo $token;
			$_SESSION['token'][] = $token;
			exit(1);
			return $token;
		}

		public function checkFormToken($form) {
			// check if a session is started and a token is transmitted, if not return an error
			if(!isset($_SESSION['token'])) {
				return false;
			}
			// check if the form is sent with token in it
			if(!isset($_POST['token'])) {
				return false;
			}
			// compare the tokens against each other if they are still the same
			if ($_SESSION['token'] !== $_POST['token']) {
				echo "Hack-Attempt detected. Got ya!.<br>";
				return false;
			}
			return true;
		}

		public function tokenCheck($token) {
			if (isset($_POST)) {
				if (isset($_SESSION[$token])) {
					if ($this->checkFormToken($token)) {
						return true;
					}
					else
						return false;
				}
				else
					return true;
			}
			else
				return true;
		}
	}
