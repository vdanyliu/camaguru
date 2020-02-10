<?php

	namespace controllers;

	use config\Config;
	use core\Controller;

	class ProfileController extends Controller
	{

		public function __construct($route) {
			parent::__construct($route);
			if (!isset($_SESSION['user'])) {
				header("Location: /");
				die();
			}
		}

		public function createPhotoAction()
		{
			$arr['photos'] = $this->model->viewSelectablimgs(Config::selectableImages());
			$arr['myPhotos'] = $this->model->viewMyPhotos();
			$this->view->render("addPhoto", $arr);
		}

		public function settingsAction()
		{
			
			$this->view->render("Settings");
		}

		public function logoutAction() {
			unset($_SESSION);
			session_destroy();
			header("Location: /");
		}
	}
