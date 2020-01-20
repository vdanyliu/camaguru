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
			$this->view->render("index page", $vars);
			var_dump($_SESSION);
			$_POST['token'] = $this->model->generateFormToken('token');
			//phpinfo();
			//var_dump(gd_info());
		}
	}
