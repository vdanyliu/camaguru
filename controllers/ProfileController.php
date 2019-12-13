<?php

	namespace controllers;

	use core\Controller;

	class ProfileController extends Controller
	{

		public function createPhotoAction()
		{
			$this->model->check();
			$this->view->render("addPhoto");
			if (isset($_POST) && isset($_FILES['imageFromForm']))
			{
				$this->model->addPhotoFromPost();
			}
		}

		public function settingsAction()
		{
			//$this->model->check();
			ob_start();
			$this->model->mergeWithLogo("img/5ded55e76debd7.76984004.jpg");
			$arr['dev1'] = ob_get_clean();
			$this->view->render("Settings", $arr);
			//$this->model->mergeWithLogo("img/5ded55e76debd7.76984004.jpg");
		}
	}
