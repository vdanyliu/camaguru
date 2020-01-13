<?php

namespace models;

use core\Model;

class JS extends Model
{
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
		imagepng($idImg);
		$i = ob_get_clean();
		echo "<img src='data:image/png;base64," . base64_encode( $i )."'>";

	}
}