<?php

	namespace controllers;
	use core\Controller;

	class AccountController extends Controller {

		function __construct($route)
		{
			parent::__construct($route);
			if (isset($_SESSION['user'])) {
				header("Location: /");
				die();
			}
		}

		public function loginAction() {
			if (!empty($_POST))
			{
				array_walk($_POST, 'sanitizee');
				$userARR = $this->model->getUserByEmail($_POST['u_email']);
				if (!$userARR)
					$_POST['error'][] = "Email incorrect";
				else {
					if (!$this->model->doCheckVerify($userARR))
						$_POST['error'][] = "You have not verified your email<br>";
					if (!$this->model->doCheckPassword($userARR))
						$_POST['error'][] = "Password is incorrect<br>";
					if (empty($_POST['error'])) {
						$_SESSION['user'] = $userARR['UserName'];
						header("Location: /");
						die();
					}
				}
			}
			$this->view->render("Login page");
		}

		public function verifyAction()
		{
			if (isset($_GET['check']) && $_GET['check'] != 'yes')
			{
				$id = $this->model->getUserByVerify($_GET['check']);
				if ($id)
				{
					$this->model->doActivate($id[0]);
					echo "ACCOUNT ACTIVATED";
					//////////////////////////////////////////////////////////////////////////////////////////////////////
				}
			}
			$this->view->render("Verify page");
		}

		public function registerAction() {
			if (!empty($_POST))
			{
				array_walk($_POST, 'sanitizee');
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
					$this->model-> sendRegistrationMail();
					header("Location: /account/verify?mailVerify=1");
					// Временное решение :)
//					$verify = $_POST['1'];
//					$mail_body = "<a href=\"/account/verify?check=".$verify."\" title=\"/account/verify?check=".$verify."\" class=\"headerText\">/account/verify?check=".$verify."</a>";
//					mail($_POST['u_email'], "Camaguru", $mail_body);
					//echo "<a href=\"/account/verify?check=".$verify."\" title=\"/account/verify?check=".$verify."\" class=\"headerText\">/account/verify?check=".$verify."</a>";
					//exit();
				}
			}
			$this->view->render("Register page");
			//debug(mail('ivolodymyrd@gmail.com', "Mail Robot", "Hello"));
		}
	}