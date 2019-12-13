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
			$this->mergeWithLogo($newfilename);
		}
	}

	public function mergeWithLogo($imgDest)
	{
		$idImg = imagecreatefromjpeg($imgDest);
		$idLogo = imagecreatefrompng("img/text.png");
		//imagealphablending($idImg, false);
		//imagesavealpha($idImg, true);
		//imagetruecolortopalette($idImg, true, 128);
		imagealphablending($idLogo, false);
		imagesavealpha($idLogo, true);
		//$blind = imagecolorallocate($idLogo, 30,30,30);
		$blind = imagecolorat($idLogo, 10, 10);
		//imagefill($idLogo, 10, 10, $blind);
		imagecolortransparent($idLogo, $blind);

		imagecopymerge($idImg, $idLogo, 240, 500, 0, 0, 514, 428, 100);
		imagecopymerge($idImg, $idLogo, 700, 500, 0, 0, 514, 428, 100);
		$resultimage = "img/122.jpg";
		imagepng($idImg, $resultimage);
		//imagepng($idLogo);
		//echo "<img src=".$resultimage." style=\"width:70%; border-radius: 50%\" class=\"img1\"><br>";
		echo "<img src=".$resultimage." class=\"img1\"><br>";

	}
}