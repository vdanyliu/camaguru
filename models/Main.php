<?php

namespace models;

use core\Model;

class Main extends Model
{
	private $photoTable;
	private $userTable = NULL;
	public $likesCount = 0;
	public $selfLike = 0;

	function __construct()
	{
		parent::__construct();
		if (isset($_SESSION['user'])) {
			$arr[] = $_SESSION['user'];
			$this->userTable = current($this->db->query("SELECT * FROM users WHERE UserName = ?", $arr));
		}
	}

	public function init(){
		$this->getPhotoTable();
		$this->getLikes();
		$this->getSelfLike();
		//var_dump($this->likesCount);
	}

	protected function getPhotoTable() {
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
	}

	protected function getLikes() {
		$arr[] = $this->photoTable['id'];
		$likes = current($this->db->query("SELECT COUNT(*) FROM likes WHERE photoid = ?", $arr));
		$this->likesCount = current($likes);
	}

	protected function getSelfLike() {
		if (!$this->userTable)
			return 0;
		$arr[] = $this->userTable['id'];
		$arr[] = $this->photoTable['id'];
		$result = $this->db->query("SELECT * FROM likes WHERE userid = ? && photoid = ?", $arr);
		if ($result)
			$this->selfLike = 1;
		return 0;
	}

	public function getImage() {
		ob_start();
		echo "
			<img id='" . $this->photoTable['dest'] . "' src='" . $this->photoTable['dest'] . "'>
		";
		return ob_get_clean();
	}
}