<?php

namespace models;

use core\Model;
use config\Config;

class JS extends Model
{
	public function imageSrc()
	{
		$widthNew = 640;
		$heightNew = 480;
		$widthLogo = 150;
		$heightLogo = 150;
		$forbiddenImages = Config::forbiddenImages();
		$imgPic = Config::selectableImages();
		$imgDest = $_POST['imageSrc'];
		$idPic = $_POST['imagePic'];

		if (array_key_exists($idPic, $imgPic)) {
			$idPic = $imgPic[$idPic];
		}
		else {
			$idPic = $imgPic['0'];
		}

		if ($forbiddenImages[exif_imagetype($imgDest)]) {
			$ex = explode(',', $imgDest);
			$textData = base64_decode($ex[1]);
			$infoPhoto = getimagesize($imgDest);
			$width = $infoPhoto[0];
			$height = $infoPhoto[1];
			if (!$idImg = imagecreatefromstring($textData)) {
				$json = array(
					"img" => "wrong image data",
					"token" => $_SESSION['token']
				);
				echo json_encode( $json );
				exit (0);
			}
		}
		else {
			$json = array(
				"img" => "wrong image data",
				"token" => $_SESSION['token']
			);
			echo json_encode( $json );
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

		//$idLogo = imagecreatefrompng($idPic);
		//
		//var_dump($idPic);
		$idLogo = file_get_contents($idPic, FILE_USE_INCLUDE_PATH);
		//$idPic = base64_encode($idPic);
		//var_dump($idPic);

		$idLogo = imagecreatefromstring($idLogo);
		//var_dump($idPic);
		//
		$infoPhoto = getimagesize($idPic);
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
		header('Content-Type: application/json');
		$json = array(
			"img" => "data:image/png;base64," . base64_encode($i),
			"token" => $_SESSION['token']
		);
		echo json_encode( $json );
		//echo "data:image/png;base64," . base64_encode($i);
	}

	public function postUserImage()
	{
		$img = $_POST['postUserImage'];
		$user = $_SESSION['user'];
		if ($imgLocation = $this->saveImgOnServer($img)) {
			$this->addImgToDatabase($imgLocation, $user);
			return (0);
		}
	}

	protected function saveImgOnServer($img)
	{
		$dir = "img/usersImage/";
		$ex = explode(',', $img);
		$textData = base64_decode($ex[1]);
		$idImg = imagecreatefromstring($textData);
		imagealphablending($idImg, true);
		imagesavealpha($idImg, true);
		$id = uniqid(NULL, true);
		$filename = $dir.$id.'.png';
		if (imagepng($idImg, $filename)) {
			return $filename;
		}
		else
			return NULL;
	}

	protected function addImgToDatabase($imgLocation, $user) {
		$arr = [
			$imgLocation,
			$user
		];
		$this->db->execute("INSERT INTO photos (dest, userId) VALUES (?, ?)", $arr);
	}
}