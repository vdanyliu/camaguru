<?php

	namespace core;

	class Router
	{

		protected $params = [];
		protected $routes = [];

		public function __construct()
		{
			//echo "class Router has been created\n";
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
			//debug($_SERVER['REQUEST_URI']);
			foreach ($this->routes as $route => $param) {
				if (preg_match($route, $url, $matches)) {
					//echo 'preg mutch = '.$url.$route;
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
				//echo '<p>controller: <b>'.$this->params['controller'].'</b></p>';
				//echo '<p>action: <b>'.$this->params['action'].'</b></p>';
				//echo '<p>path: <b>'.$path.'</b></p>';
			}
			else
				echo "404 xD ";
		}

	}