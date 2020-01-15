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
		var_dump($filetmp);
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
		//$idImg = imagecreatefromjpeg($imgDest);
		$idImg = imagecreatefrompng($imgDest);
		//$idLogo = imagecreatefrompng("img/text.png");
		$idLogo = imagecreatefrompng("img/cat2.png");
		imagealphablending($idLogo, true);
		imagesavealpha($idLogo, true);
		$blind = imagecolorat($idLogo, 20, 20);
		imagecolortransparent($idLogo, $blind);

		imagecopymerge($idImg, $idLogo, 100, 100, 0, 0, 514, 428, 100);
		//imagecopymerge($idImg, $idLogo, 700, 500, 0, 0, 514, 428, 100);
		$resultimage = "img/122.jpg";
		imagepng($idImg, $resultimage);
		ob_start();
		imagepng($idLogo);
		$i = ob_get_clean();
		echo "<img src='data:image/png;base64," . base64_encode( $i )."'>";
		ob_start();
		imagepng($idImg);
		$i = ob_get_clean();
		echo "<img src='data:image/png;base64," . base64_encode( $i )."'>";

	}
}