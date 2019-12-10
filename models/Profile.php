<?php

namespace models;

use core\Model;

class Profile extends Model
{
	public function check()
	{
		echo "rabotaet";
	}

	public function addPhotoFromPost()
	{
		$fileName = $_FILES['imageFromForm']['name'];
		$filetmp = $_FILES['imageFromForm']['tmp_name'];
		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));
		if($filetmp != NULL && exif_imagetype($filetmp))
		{
			$newfilename = "img/" . uniqid("", true) . "." . $fileActualExt;
			move_uploaded_file($filetmp, $newfilename);
			foreach ($_POST as $key => $value)
				echo $key . "=>" . $value . "<br>";
			foreach ($_FILES['imageFromForm'] as $key => $value)
				echo $key . "=>" . $value . "<br>";
			echo $newfilename . "<br>";
			$this->mereWithLogo($newfilename);
		}
	}

	public function mereWithLogo($imgDest)
	{
		$idImg = imagecreatefromjpeg($imgDest);
		$idLogo = imagecreatefrompng("img/maxresdefault111.png");
		imagealphablending($idImg, false);
		imagesavealpha($idImg, true);
		//imagetruecolortopalette($idImg, true, 128);
		imagealphablending($idLogo, false);
		imagesavealpha($idLogo, true);

		//imagecopymerge($idImg, $idLogo, 500, 200, 300, 300, 300, 300, 100);
		$resultimage = "img/122.jpg";
		imagepng($idImg, $resultimage);
		echo "<img src=".$resultimage.">";
	}
}