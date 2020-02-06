<?php

	namespace controllers;

	use config\Config;
	use core\Controller;

	class MainController extends Controller
	{
		public function indexAction()
		{
			$arr = [];
			//$arr['allPhotos'] = $this->model->getAllPhotos();
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
			//$arr['comments'] = $this->model->getComments();
			//var_dump($arr);
			$this->view->render("Photo", $arr);
		}
	}
