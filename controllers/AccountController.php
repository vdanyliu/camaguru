<?php

	namespace controllers;

	use core\Controller;

	class AccountController extends Controller {

		public function loginAction() {

			$this->view->render("Login page");
		}

		public function registerAction() {
			$this->view->render("Register page");
			//debug(mail('ivolodymyrd@gmail.com', "Mail Robot", "Hello"));
			print phpinfo();
		}
	}