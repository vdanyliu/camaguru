<?php

	namespace controllers;

	use core\Controller;

	class JSController extends Controller
	{

		public function requestAction()
		{
			if ($_POST)
			{
					$metod = key($_POST);
					$this->model->$metod();
			}
			else {
				header("Location: / ");
				die (0);
			}
		}
	}
