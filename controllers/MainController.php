<?php

	namespace controllers;

	use core\Controller;

	class MainController extends Controller
	{

		public function indexAction()
		{
			$this->view->render("index page");
			//echo 'index page';
		}
	}
