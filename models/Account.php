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
	public function addNewUser($post)
	{
		extract($post);
		//echo "INSERT INTO `users` (`id`, `UserName`, `UserEmail`, `Password`, `Activated`, `Admin`) VALUES (NULL, '$u_nickname', '$u_email', '".password_hash($u_pass, PASSWORD_BCRYPT)."', '".password_hash($u_nickname, PASSWORD_BCRYPT)."', '0')";
		$this->db->execute("INSERT INTO `users` (`id`, `UserName`, `UserEmail`, `Password`, `Activated`, `Admin`) VALUES (NULL, '$u_nickname', '$u_email', '".password_hash($u_pass, PASSWORD_BCRYPT)."', '".password_hash($u_nickname, PASSWORD_BCRYPT)."', '0')");
	}
}


//u_nickname->a!
//u_email->fretalk@ukr.net
//u_pass->111111
//u_passCheck->111111
//submit->Submit