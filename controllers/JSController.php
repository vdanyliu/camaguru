<?php

	namespace controllers;

	use core\Controller;

	class JSController extends Controller
	{

		public function requestAction()
		{
//			if (isset($_POST['imageSrc']))
//			{
//				$this->model->mergeWithLogo($_POST['imageSrc']);
//			}
			//var_dump($_POST);
			if ($_POST)
			{
					$metod = key($_POST);
					$this->model->$metod();
					//$this->model->imageSrc($key);
			}
		}
	}
