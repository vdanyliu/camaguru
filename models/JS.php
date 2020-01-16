<?php

namespace models;

use core\Model;
use mysql_xdevapi\Exception;

class JS extends Model
{
	public function imageSrc()
	{
		$widthNew = 640;
		$heightNew = 480;
		$widthLogo = 150;
		$heightLogo = 150;
		$forbiddenImages = [
			false => false,
			IMAGETYPE_GIF => true,
			IMAGETYPE_JPEG => true,
			IMAGETYPE_PNG => true,
			IMAGETYPE_SWF => false,
			IMAGETYPE_PSD => false,
			IMAGETYPE_BMP => false,
			IMAGETYPE_TIFF_II => false,
			IMAGETYPE_TIFF_MM => false,
			IMAGETYPE_JPC => false,
			IMAGETYPE_JP2 => false,
			IMAGETYPE_JPX => false,
			IMAGETYPE_JB2 => false,
			IMAGETYPE_SWC => false,
			IMAGETYPE_IFF => false,
			IMAGETYPE_WBMP => false,
			IMAGETYPE_XBM => false,
			IMAGETYPE_ICO => false,
			IMAGETYPE_WEBP => false
		];

		$imgDest = $_POST['imageSrc'];

		if ($forbiddenImages[exif_imagetype($imgDest)]) {
			$ex = explode(',', $imgDest);
			$textData = base64_decode($ex[1]);
			$infoPhoto = getimagesize($imgDest);
			$width = $infoPhoto[0];
			$height = $infoPhoto[1];
			if (!$idImg = imagecreatefromstring($textData)) {
				echo "wrong image data";
				exit (0);
			}
		}
		else {
			echo "wrong image data";
			exit (0);
		}

		$blind = 2147483647; //white color


		$new = imagecreatetruecolor($widthNew, $heightNew);
		imagealphablending($new, true);
		imagesavealpha($new, true);
		imagefill($new, 0, 0, $blind);
		imagecolortransparent($new, $blind);
		$tw = ceil($heightNew / ($height / $width));
		$th = ceil($widthNew / ($width / $height));
		if ($tw < $widthNew) {
			imagecopyresampled($new, $idImg, ceil(($widthNew - $tw) / 2), 0, 0, 0, $tw, $heightNew, $width, $height);
		}
		else {
			imagecopyresampled($new, $idImg, 0, ceil(($heightNew - $th) / 2), 0, 0, $widthNew, $th, $width, $height);
		}
		imagedestroy($idImg);
		$idImg = $new;

		$idLogo = imagecreatefrompng("img/cat2.png");
		$infoPhoto = getimagesize("img/cat2.png");
		$width = $infoPhoto[0];
		$height = $infoPhoto[1];

		$new = imagecreatetruecolor($widthLogo, $heightLogo);
		imagealphablending($new, true);
		imagesavealpha($new, true);
		imagefill($new, 0, 0, $blind);
		imagecolortransparent($new, $blind);
		$tw = ceil($heightLogo / ($height / $width));
		$th = ceil($widthLogo / ($width / $height));
		if ($tw < $widthLogo) {
			imagecopyresampled($new, $idLogo, ceil(($widthLogo - $tw) / 2), 0, 0, 0, $tw, $heightLogo, $width, $height);
		}
		else {
			imagecopyresampled($new, $idLogo, 0, ceil(($heightLogo - $th) / 2), 0, 0, $widthLogo, $th, $width, $height);
		}
		imagedestroy($idLogo);
		$idLogo = $new;



		imagecopymerge($idImg, $idLogo, 200, 200, 0, 0, $widthLogo, $heightLogo, 100);
		//imagecopymerge($idImg, $idLogo, 700, 500, 0, 0, 514, 428, 100);
		$resultimage = "img/122.jpg";
		ob_start();
		//imagegif($idImg, "img/122.gif");
		imagepng($idImg);
		$i = ob_get_clean();
		//echo "<img src='data:image/png;base64," . base64_encode($i) . "' alt=”animated”>";
		echo "data:image/png;base64," . base64_encode($i);
		//imagepng($idImg);
	}
}