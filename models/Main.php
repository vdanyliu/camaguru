<?php

namespace models;

use core\Model;

class Main extends Model
{
	private $photoTable;
	private $userTable = NULL;

	function __construct()
	{
		parent::__construct();
		if (isset($_SESSION['user'])) {
			$arr[] = $_SESSION['user'];
			$this->userTable = current($this->db->query("SELECT * FROM users WHERE UserName = ?", $arr));
		}
	}

	public function getPhoto() {
		if (!$_GET['dest']){
			header("Location: /");
			die();
		}
		$arr[] = $_GET['dest'];
		$this->photoTable = current($this->db->query("SELECT * FROM photos WHERE dest = ?", $arr));
		if (!$this->photoTable) {
			header("Location: /");
			die();
		}
		return ($this->photoTable);
	}

	public function getLikes() {
		$arr[] = $this->photoTable['id'];
		$likes = current($this->db->query("SELECT COUNT(*) FROM likes WHERE photoid = ?", $arr));
		return $likes;
	}

	public function getSelfLike() {
		if (!$this->userTable)
			return 0;
		$arr[] = $this->userTable['id'];
		$arr[] = $this->photoTable['id'];
		$result = $this->db->query("SELECT * FROM likes WHERE userid = ? && photoid = ?", $arr);
		return $result;
	}
}