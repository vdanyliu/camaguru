<?php

	namespace core;

	class Router
	{

		protected $params = [];
		protected $routes = [];

		public function __construct()
		{
			$arr = require_once 'config/routes.php';
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
			foreach ($this->routes as $route => $param) {
				if (preg_match($route, $url, $matches)) {
					$this->params = $param;
					return true;
				}
			}
			return false;
		}

		public function run() {
			if ($this->match()) {
				$path = 'controllers\\'.ucfirst($this->params['controller']).'Controller';
				if (class_exists($path)) {
					$action = $this->params['action'].'Action';
					if (method_exists($path, $action)) {
						$controller = new $path($this->params);
						$controller->$action();
					}
					else
						echo 'Action '.$action.' does not exist';
				}
				else
					echo 'Controller '.$path.' does not exist';
			}
			else
				echo "404 xD ";
		}

	}