<?php

	namespace controllers;

	use core\Controller;

	class MainController extends Controller
	{

		public function indexAction()
		{
			var_dump($_SESSION);
			$_POST['token'] = $this->model->generateFormToken('token');
			$result = $this->model->getUsers();
			$vars = [
				'users' => $result,
			];
			$this->view->render("index page", $vars);
			//phpinfo();
			//var_dump(gd_info());
		}
	}
