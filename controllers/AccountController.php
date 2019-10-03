<?php

	namespace controllers;

	class AccountController {

		public function loginAction() {
			echo 'Login page';
		}

		public function registerAction() {
			echo 'Register page';
			//debug(mail('ivolodymyrd@gmail.com', "Mail Robot", "Hello"));
			print phpinfo();
		}
	}