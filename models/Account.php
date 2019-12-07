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
		$_POST['1'] = password_hash($u_nickname, PASSWORD_BCRYPT);
		$this->db->execute("INSERT INTO `users` (`id`, `UserName`, `UserEmail`, `Password`, `Activated`, `Admin`) VALUES (NULL, '$u_nickname', '$u_email', '".password_hash($u_pass, PASSWORD_BCRYPT)."', '".$_POST['1']."', '0')");
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

	public function getUserByEmail($mail)
	{
		$result = $this->db->query("SELECT * FROM users WHERE UserEmail ='$mail'");
		if ($result)
			return $result[0];
		return $result;
	}

	public function doCheckVerify($userArr)
	{
		if ($userArr['Activated'] == 'yes')
			return TRUE;
		return FALSE;
	}

	public function doCheckPassword($userArr)
	{
		return password_verify($_POST['u_pass'], $userArr['Password']);
	}
}
