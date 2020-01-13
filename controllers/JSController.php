<?php

	namespace controllers;

	use core\Controller;

	class JSController extends Controller
	{

		public function requestAction()
		{
			if (isset($_POST['imageSrc']))
			{
				$this->model->mergeWithLogo($_POST['imageSrc']);
			}
		}
	}
