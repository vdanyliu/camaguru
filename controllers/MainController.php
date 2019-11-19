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
			$this->view->render("index page", $vars);;
		}
	}
