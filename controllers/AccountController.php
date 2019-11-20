<?php

	namespace controllers;
	use core\Controller;

	class AccountController extends Controller {

		public function loginAction() {

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
				}
			}
			$this->view->render("Verify page");
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
					//$this->model-> sendRegistrationMail($_POST);
					//header("Location: /account/verify?mailVerify=1");
					// Временное решение :)
					$verify = $_POST['1'];
					echo "<a href=\"/account/verify?check=".$verify."\" title=\"/account/verify?check=".$verify."\" class=\"headerText\">/account/verify?check=".$verify."</a>";
					exit();
				}
			}
			$this->view->render("Register page");
			//debug(mail('ivolodymyrd@gmail.com', "Mail Robot", "Hello"));
		}
	}