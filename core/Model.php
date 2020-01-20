<?php
namespace core;
use lib\Database;
use config\Config;

	abstract class Model
{
	public $db;

	function __construct()
	{
		$this->db = new Database();
		//$_POST['token'] = $this->generateFormToken('token');
	}

		public function generateFormToken($form)
		{
//			$_SESSION['token'] = [];
			$token = md5(uniqid(microtime(), true));
			echo $token."<br>";
			$_SESSION['token'][] = $token;
			//$_SESSION['time'][] = microtime();
			//exit(1);
			return $token;
		}

		public function checkFormToken($form) {
			// check if a session is started and a token is transmitted, if not return an error
			if(!isset($_SESSION['token'])) {
				return false;
			}
			// check if the form is sent with token in it
			if(!isset($_POST['token'])) {
				return false;
			}
			// compare the tokens against each other if they are still the same
			if ($_SESSION['token'] !== $_POST['token']) {
				echo "Hack-Attempt detected. Got ya!.<br>";
				return false;
			}
			return true;
		}

		public function tokenCheck($token) {
			if (isset($_POST)) {
				if (isset($_SESSION[$token])) {
					if ($this->checkFormToken($token)) {
						return true;
					}
					else
						return false;
				}
				else
					return true;
			}
			else
				return true;
	}
}