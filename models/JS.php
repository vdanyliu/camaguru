<?php

namespace models;

use core\Model;
use mysql_xdevapi\Exception;

class JS extends Model
{
	public function imageSrc()
	{
		$imgDest = $_POST['imageSrc'];

		if (exif_imagetype($imgDest)) {
			$ex = explode(',', $imgDest);
			$textData = base64_decode($ex[1]);
			if (!$idImg = @imagecreatefromstring($textData)) {
				echo "wrong image data";
				exit (0);
			}
		}
		$idLogo = imagecreatefrompng("img/cat2.png");
		imagealphablending($idLogo, true);
		imagesavealpha($idLogo, true);

//		$blind = imagecolorat($idLogo, 20, 20);
//		$rgb = imagecolorat($idLogo, 20, 20);
//		$r = ($rgb >> 16) & 0xFF;
//		$g = ($rgb >> 8) & 0xFF;
//		$b = $rgb & 0xFF;
		$blind = 2147483647; //white color
		var_dump($blind);
		imagecolortransparent($idLogo, $blind);

		imagecopymerge($idImg, $idLogo, 100, 100, 0, 0, 514, 428, 100);
		//imagecopymerge($idImg, $idLogo, 700, 500, 0, 0, 514, 428, 100);
		$resultimage = "img/122.jpg";
		ob_start();
		imagegif($idImg, "img/122.gif");
		imagegif($idImg);
		$i = ob_get_clean();
		echo "<img src='data:image/png;base64," . base64_encode($i) . "' alt=”animated”>";
	}
}