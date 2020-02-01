<?php

namespace models;

use core\Model;

class Main extends Model
{
	public function getAllPhotos() {
		$photos = $this->db->query("SELECT dest FROM photos ORDER BY date DESC", NULL);
		ob_start();
		foreach ($photos as $value) {
			echo "<img id='".$value['dest']."' onClick=\"picLoad(this.id)\" src='" .$value['dest']."'<br>";
		}
		return ob_get_clean();
	}
}