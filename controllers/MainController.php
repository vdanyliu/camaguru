<?php

	namespace controllers;

	use core\Controller;

	class MainController extends Controller
	{

		public function indexAction()
		{
			$result = $this->model->getUsers();
			$vars = [
				'users' => $result,
			];
			var_dump($_SESSION['token']);
			$this->view->render("index page", $vars);
			//phpinfo();
			//var_dump(gd_info());
		}
	}
