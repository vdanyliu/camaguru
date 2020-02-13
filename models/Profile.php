<?php

namespace models;

use core\Model;

class Profile extends Model
{
	public function viewSelectablimgs($imgArr)
	{
		ob_start();
		foreach ($imgArr as $key => $value)
		{
			echo "<img id='".$key."' onClick=\"picLoad(this.id)\" src='" . $value."'<br>";
		}
		return ob_get_clean();
	}
	
	protected function getUserIdByUsername($username) {
		$arr[] = $username;
		$result = current($this->db->query("SELECT id FROM users WHERE UserName = ?", $arr));
		return $result['id'];
	}
	
	public function viewMyPhotos()
	{
		$sql = "SELECT dest FROM photos WHERE userId = ? ORDER BY date DESC";
		$arr = [
			$this->getUserIdByUsername($_SESSION['user']),
		];
		$result = $this->db->query($sql, $arr);
		if (!is_null($result))
			ob_start();
		foreach ($result as $key) {
			echo "
				<a href='/postReader?dest=" . $key['dest'] . "'>
				<img id='" . $key['dest'] . "' src='" . $key['dest'] . "'>
				</a>
				<button onclick=\"deletePost('" . $key['dest'] . "')\">DeletePhoto</button>
			";
			echo '<br>';
		}
		return ob_get_clean();
	}
}