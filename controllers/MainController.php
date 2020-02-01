<?php

	namespace controllers;

	use core\Controller;

	class MainController extends Controller
	{

		public function indexAction()
		{
			$arr['allPhotos'] = $this->model->getAllPhotos();
			$this->view->render("index page", $arr);
		}
	}
