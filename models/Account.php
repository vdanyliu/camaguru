<?php

namespace models;

use core\Model;

class Account extends Model
{
	public function getUser($userName)
	{
		$arr = [
			$userName
		];
		$result = $this->db->query("SELECT * FROM users WHERE UserName =?", $arr);
		return $result;
	}

	public function getEmail($userEmail)
	{
		$arr = [
			$userEmail
		];
		$result = $this->db->query("SELECT * FROM users WHERE UserEmail=?", $arr);
		return $result;
	}

	public function addNewUser()
	{
		extract($_POST);
		$_POST['1'] = password_hash($u_nickname, PASSWORD_BCRYPT);
		$arr = [
			NULL,
			$u_nickname,
			$u_email,
			password_hash($u_pass, PASSWORD_BCRYPT),
			$_POST['1'],
			'0'
		];
//		$this->db->execute("INSERT INTO `users` (`id`, `UserName`, `UserEmail`, `Password`, `Activated`, `Admin`) VALUES (NULL, '$u_nickname', '$u_email', '".password_hash($u_pass, PASSWORD_BCRYPT)."', '".$_POST['1']."', '0')");
		$this->db->execute("INSERT INTO `users` (`id`, `UserName`, `UserEmail`, `Password`, `Activated`, `Admin`) VALUES (?, ?, ?, ?, ?, ?)", $arr);
	}

	public function sendRegistrationMail()
	{
		$verify = $_POST['1'];
		$mail_body = "<a href=\"".$_SERVER["HTTP_HOST"]."/account/verify?check=".$verify."\" title=\"/account/verify?check=".$verify."\" class=\"headerText\">/account/verify?check=".$verify."</a>";
		mail($_POST['u_email'], "Camaguru", $mail_body);
	}

	public function getUserByVerify($verify)
	{
		$arr = [
			$verify,
		];
		$id =  $this->db->query("SELECT id FROM users WHERE Activated = ?", $arr);
		return $id;
	}

	public function doActivate($verify)
	{
		$arr = [
			$verify['id'],
		];
		//$id = $verify['id'];
		$this->db->execute("UPDATE `users` SET `Activated` = 'yes' WHERE `users`.`id` = ? ", $arr);
	}

	public function getUserByEmail($mail)
	{
//
		$arr = [
			$mail
		];
		$result = $this->db->query("SELECT * FROM users WHERE UserEmail = ?", $arr);
		if ($result)
			return $result[0];
		return $result;
	}

	public function doCheckVerify($userArr)
	{

		if ($userArr['Activated'] == 'yes' || !$userArr['Activated'])
			return TRUE;
		return FALSE;
	}

	public function doCheckPassword($userArr)
	{
//
		return password_verify($_POST['u_pass'], $userArr['Password']);
	}
}
