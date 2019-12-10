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
			$this->view->render("Settings");
		}
	}
