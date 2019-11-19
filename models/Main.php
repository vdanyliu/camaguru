<?php

namespace models;

use core\Model;

class Main extends Model
{
	public function getUsers()
	{
		$result = $this->db->query("SELECT * FROM users");
		return $result;
	}
}