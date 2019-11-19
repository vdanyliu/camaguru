<?php

	namespace controllers;
	use core\Controller;

	class AccountController extends Controller {

		public function loginAction() {

			$this->view->render("Login page");
		}

		public function registerAction() {
			if (!empty($_POST))
			{
				array_walk($_POST, 'trim_value');
				trim($_POST['u_nickname']);
				foreach ($_POST as $key => $value) {
					echo $key . '->' . $value . '<br>';
				}
				if ((!$_POST['u_nickname']) || !$_POST['u_email'] || !$_POST['u_pass'])
					$_POST['error'][] = "Fill in all the fields";
				if (strlen($_POST['u_pass']) <= 5)
					$_POST['error'][] = "Password must be at least six characters";
				if ($_POST['u_pass'] != $_POST['u_passCheck'])
					$_POST['error'][] = "Password mismatch";
				if ($this->model->getUser($_POST['u_nickname']) || $this->model->getEmail($_POST['u_email']))
					$_POST['error'][] = "Login or Email already exists";
				if (empty($_POST['error']))
				{
					$this->model->addNewUser($_POST);
					header("Location: /account/login?mailVerify=1");
					exit();
				}
			}
			$this->view->render("Register page");
			//debug(mail('ivolodymyrd@gmail.com', "Mail Robot", "Hello"));
			//print phpinfo();
		}
	}