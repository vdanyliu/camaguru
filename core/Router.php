<?php

	namespace core;

	class Router
	{

		protected $params = [];
		protected $routes = [];

		public function __construct()
		{
			echo "class Router has been created\n";
			$arr = require 'config/routes.php';
			debug($arr);
			foreach ($arr as $route => $param) {
				$this->add($route, $param);
			}
		}

		public function add($route, $val) {
			$route = '#^'.$route.'#';
			$this->routes[$route] = $val;
		}

		public function match() {
			$url = trim($_SERVER['REQUEST_URI'], '/');
			debug($_SERVER['REQUEST_URI']);
			foreach ($this->routes as $route => $param) {
				if (preg_match($route, $url, $mathes)) {
					$this->params = $param;
					return true;
				}
			}
			return false;
		}

		public function run() {
			echo 'start';
			if ($this->match()) {
				echo '<p>controller: <b>'.$this->params['controller'].'</b></p>';
				echo '<p>action: <b>'.$this->params['action'].'</b></p>';
			}
			else
				echo "404 xD ";
		}

	}