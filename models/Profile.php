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

	public function viewMyPhotos()
	{
		$sql = "SELECT dest FROM photos WHERE userId = ? ORDER BY date DESC";
		$arr = [
			$_SESSION['user']
		];
		$result = $this->db->query($sql, $arr);
		if (!is_null($result))
			ob_start();
		foreach ($result as $key) {
			echo "
				<a href='/postReader?dest=" . $key['dest'] . "'>
				<img id='" . $key['dest'] . "' src='" . $key['dest'] . "'>
				</a>
			";
			echo '<br>';
		}
		return ob_get_clean();
	}
}