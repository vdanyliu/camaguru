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
				$fileName = $_FILES['imageFromForm']['name'];
				$filetmp = $_FILES['imageFromForm']['tmp_name'];
				$fileExt = explode('.', $fileName);
				$fileActualExt = strtolower(end($fileExt));
				if($filetmp != NULL && exif_imagetype($filetmp))
				{
					move_uploaded_file($filetmp, "img/" . uniqid("", true) . "." . $fileActualExt);
					foreach ($_POST as $key => $value)
						echo $key . "=>" . $value . "<br>";
					foreach ($_FILES['imageFromForm'] as $key => $value)
						echo $key . "=>" . $value . "<br>";
					//var_dump(exif_imagetype("img/" . $fileName));
				}
				//var_dump(file("img/" . $fileName));
			}
		}

		public function settingsAction()
		{
			$this->model->check();
			$this->view->render("Settings");
		}
	}
