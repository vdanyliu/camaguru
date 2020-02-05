<?php

	namespace controllers;

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
			$arr['photo'] = $this->model->getPhoto();
			$arr['likes'] = $this->model->getLikes();
			$arr['selfLike'] = $this->model->getSelfLike();
			//$arr['comments'] = $this->model->getComments();
			var_dump($arr);
			$this->view->render("Photo", $arr);
		}
	}
