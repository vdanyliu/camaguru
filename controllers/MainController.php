<?php

	namespace controllers;

	use config\Config;
	use core\Controller;

	class MainController extends Controller
	{
		public function indexAction()
		{
			$arr = [];
			$this->view->render("index page", $arr);
		}

		public function postReaderAction()
		{
			$arr = [];
			$this->model->init();
			$arr['image'] = $this->model->getImage();
			$arr['likesCount'] = $this->model->likesCount;
			$arr['selfLike'] = $this->model->selfLike;
			$arr['like_image'] = Config::getLikeImages();
			$this->view->render("Photo", $arr);
		}
	}
