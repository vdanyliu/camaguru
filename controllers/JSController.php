<?php

	namespace controllers;

	use core\Controller;

	class JSController extends Controller
	{

		public function requestAction()
		{
			if ($_POST)
			{
					$method = key($_POST);
					$this->model->$method();
			}
			else {
				header("Location: / ");
				die (0);
			}
		}
	}
