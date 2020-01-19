<?php

	namespace controllers;

	use core\Controller;

	class ProfileController extends Controller
	{

		public function createPhotoAction()
		{
			//var_dump($_FILES);
			$this->model->check();
			$this->view->render("addPhoto");
			if (isset($_POST) && isset($_FILES['imageFromForm']))
			{
				$this->model->addPhotoFromPost();
			}
			else if (isset($_POST['imageSrc']))
			{
				$this->model->mergeWithLogo($_POST['imageSrc']);
			}
		}

		public function settingsAction()
		{
			//$this->model->check();
			ob_start();
			$file = file_get_contents("img/cat2.png");
			$img = imagecreatefromstring($file);
			$file = base64_encode($file);
			//var_dump($file);
			ob_start();
			//imagegif($idImg, "img/122.gif");
			imagepng($img);
			$i = ob_get_clean();
			echo "<img src='data:image/png;base64," . base64_encode($i) . "' alt=”animated”>";
			//echo "<img src='data:image/png;base64," . $file . "' alt=”animated”>";
			//$this->model->mergeWithLogo("img/5ded55e76debd7.76984004.jpg");
			$arr['dev1'] = ob_get_clean();
			$this->view->render("Settings", $arr);
		}
	}
