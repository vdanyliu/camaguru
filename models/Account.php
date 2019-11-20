<?php

namespace models;

use core\Model;

class Account extends Model
{
	public function getUser($userName)
	{
		$result = $this->db->query("SELECT * FROM users WHERE UserName ='$userName'");
		return $result;
	}

	public function getEmail($userEmail)
	{
		$result = $this->db->query("SELECT * FROM users WHERE UserEmail='$userEmail'");
		return $result;
	}

	public function addNewUser()
	{
		extract($_POST);
		//echo "INSERT INTO `users` (`id`, `UserName`, `UserEmail`, `Password`, `Activated`, `Admin`) VALUES (NULL, '$u_nickname', '$u_email', '".password_hash($u_pass, PASSWORD_BCRYPT)."', '".password_hash($u_nickname, PASSWORD_BCRYPT)."', '0')";
		$this->db->execute("INSERT INTO `users` (`id`, `UserName`, `UserEmail`, `Password`, `Activated`, `Admin`) VALUES (NULL, '$u_nickname', '$u_email', '".password_hash($u_pass, PASSWORD_BCRYPT)."', '".password_hash($u_nickname, PASSWORD_BCRYPT)."', '0')");
	}

	public function sendRegistrationMail()
	{

	}

	public function getUserByVerify($verify)
	{
		$id =  $this->db->query("SELECT 'id' FROM users WHERE Activated='$verify'");
		return $id;
	}

	public function doActivate($verify)
	{
		$id = $verify['id'];
		$this->db->execute("UPDATE `users` SET `Activated` = 'yes' WHERE `users`.`id` = $id");
	}
}
