<?php

	namespace core;

	abstract class Controller
	{
		public $route;
		public $view;
		public $model;

		public function __construct($route)
		{
			if (!empty($_POST)) {
				if ($this->checkFormToken('token')) {
					$this->generateFormToken('token');
				} else {
					echo "222";
					var_dump($_POST);
					var_dump($_SESSION);
					echo "token error";
					exit (0);
				}
			}

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
			return $token;
		}

		public function checkFormToken($form)
		{
			// check if a session is started and a token is transmitted, if not return an error
			if (!isset($_SESSION[$form])) {
				return false;
			}
			// check if the form is sent with token in it
			if (!isset($_POST[$form])) {
				return false;
			}
			// compare the tokens against each other if they are still the same
			if ($_SESSION[$form] !== $_POST[$form]) {
				echo "Hack-Attempt detected. Got ya!.<br>";
				return false;
			}
			return true;
		}
	};
