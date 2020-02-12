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
			$this->getUserIdByUsername($user),
		];
		$this->db->execute("INSERT INTO photos (dest, userId) VALUES (?, ?)", $arr);
	}

	public function getImagesByNumber() {
		$page = $_POST['getImagesByNumber'];
		$count = $_POST['countOfPhotos'];
		$photoArr = $this->getPhotoFromSql($page, $count);
		ob_start();
		if ($photoArr) {
			foreach ($photoArr as $value) {
				echo "
				<a href='/postReader?dest=" . $value['dest'] . "'>
				<img id='" . $value['dest'] . "' src='" . $value['dest'] . "'>
				</a>
			";
			}
			echo '<br>';
		}
		$img = ob_get_clean();
		$json = [
			'token' => $_SESSION['token'],
			'img' => $img
			];
		echo json_encode( $json );
	}

	protected function getPhotoFromSql($page, $count) {
		$arr = [
			$count,
			$page * $count,
		];
		$sql = $this->db->query("SELECT * FROM photos ORDER BY date DESC LIMIT ? OFFSET ?", $arr);
		return $sql;
	}


	private $photoTable;
	private $userTable;
	public $likesCount = 0;
	public $selfLike = 0;
	private function init($dest) {
		sanitizee($dest);
		$this->getPhotoTable($dest);
		$this->getLikesCount();
		if (isset($_SESSION['user'])) {
            $this->getUserTable($_SESSION['user']);
            $this->getSelfLike();
        }
	}
	protected function getUserTable($user) {
		$arr[] = $user;
		$this->userTable = current($this->db->query("SELECT * FROM users WHERE UserName = ?", $arr));
	}

	protected function getPhotoTable($dest) {
		$arr[] = $dest;
		$this->photoTable = current($this->db->query("SELECT * FROM photos WHERE dest = ?", $arr));
		if (!$this->photoTable) {
			header("Location: /");
			die();
		}
	}

	protected function getLikesCount() {
		$arr[] = $this->photoTable['id'];
		$likes = current($this->db->query("SELECT COUNT(*) FROM likes WHERE photoid = ?", $arr));
		$this->likesCount = current($likes);
	}

	protected function getSelfLike() {
		if (!$this->userTable)
			return 0;
		$arr[] = $this->userTable['id'];
		$arr[] = $this->photoTable['id'];
		$result = $this->db->query("SELECT * FROM likes WHERE userid = ? && photoid = ?", $arr);
		if ($result)
			$this->selfLike = 1;
		return 0;
	}

	protected function getObLike($num) {
		$like_image = Config::getLikeImages();
		ob_start();
		echo '<img id =\'likeBottom\'  src = \''.$like_image[$num].'\'>';
		return ob_get_clean();
	}

	public function getLikes() {
		$this->init(($_POST['getLikes']));
		$json = [
			'token' => $_SESSION['token'],
			'likes' => $this->likesCount,
			'likeImg' => $this->getObLike($this->selfLike),
		];
		echo json_encode($json);
	}

	public function userLike() {
		$this->init($_POST['userLike']);
		$arr = [
			$this->photoTable['id'],
			$this->userTable['id']
		];
		switch ($this->selfLike) {
			case false:
				$this->db->execute("INSERT INTO likes (photoid, userid) VALUES (?, ?)", $arr);
				break;
			case true:
				$this->db->execute("DELETE FROM likes WHERE photoid = ? && userid = ?", $arr);
				break;
		}
		$json = [
			'token' => $_SESSION['token'],
		];
		echo json_encode($json);
	}
	
	protected function getPostsFromSql($page, $count, $dest) {
		$arr = [
			$this->getPhotoTableByDest($dest)['id'],
			$count,
			$page * $count,
		];
		$sql = $this->db->query("SELECT * FROM comments WHERE photoid = ? ORDER BY date DESC LIMIT ? OFFSET ?", $arr);
		return $sql;
	}
	
	protected function getUserNameById($userid) {
		$arr[] = $userid;
		$result = current($this->db->query("SELECT UserName FROM users WHERE id = ?", $arr));
		return $result['UserName'];
	}
	
	public function getPostsByPage() {
		$page = $_POST['getPostsByPage'];
		$count = $_POST['postCount'];
		$dest = $_POST['dest'];
		$photoArr = $this->getPostsFromSql($page, $count, $dest);
		ob_start();
		if ($photoArr) {
			foreach ($photoArr as $value) {
				echo "
				<div class='comment'>
					<div class='user'>
						".$this->getUserNameById($value['userid'])."
					</div>
					<div class='userComment'>
						".$value['body']."
					</div>
				</div>
				<br>
			";
			}
			echo '<br>';
		}
		$htmlText = ob_get_clean();
		$json = [
			'token' => $_SESSION['token'],
			'htmlText' => $htmlText
		];
		echo json_encode( $json );
	}
	
	private function getPhotoTableByDest($dest) {
		sanitizee($dest);
		$arr = [
			$dest
		];
		return (current($this->db->query("SELECT * FROM photos WHERE dest = ?", $arr)));
		
	}
	
	protected function getUserIdByUsername($username) {
		$arr[] = $username;
		$result = current($this->db->query("SELECT id FROM users WHERE UserName = ?", $arr));
		return $result['id'];
	}
	
	protected function getUserTableById($id) {
		$arr[] = $id;
		return current($this->db->query("SELECT * FROM users WHERE id = ?", $arr));
	}
	
	protected function sendNotificationMail($userid) {
		$result = ($this->getUserTableById($userid));
		if ($result['notification']) {
			$mail_body = "u got a new comment";
			mail($result['UserEmail'], "Camaguru", $mail_body);
		}
	}
	
	public function addComment() {
		if (!$_SESSION['user'])
			return 0;
		$sanitazeText = $_POST['addComment'];
		sanitizee($sanitaze);
		$photoTable = $this->getPhotoTableByDest($_POST['dest']);
		$arr = [
			$photoTable['id'],
			$this->getUserIdByUsername($_SESSION['user']),
			$sanitazeText,
		];
		$this->db->execute("INSERT INTO comments (photoid, userid, body) VALUES (?, ?, ?)", $arr);
		$this->sendNotificationMail($photoTable['userId']);
		$json = [
			'token' => $_SESSION['token'],
		];
		echo json_encode($json);
	}
	
	
	protected function uniqNameCheck($name) {
		$arr[] = $name;
		$result = $this->db->query("SELECT * FROM users WHERE UserName = ?", $arr);
		if ($result)
			return 0;
		return 1;
	}
	
	public function changeName() {
		$oldName = $_POST['oldName'];
		$newName = $_POST['newName'];
		$json['token'] = $_SESSION['token'];
		
		if ($oldName == $_SESSION['user'])
		{
			if ($this->uniqNameCheck($newName)) {
				$arr = [
					$newName,
					$oldName,
				];
				$this->db->execute("UPDATE users SET UserName = ? WHERE UserName = ?", $arr);
				$_SESSION['user'] = $newName;
			}
			else
				$json['error'] = 'New user name is already taken';
		}
		else {
			$json['error'] = 'Current name != Old name input';
		}
		echo json_encode($json);
	}
	
	protected function matchPass($pass) {
		$arr[] = $_SESSION['user'];
		$userPass = current(current($this->db->query("SELECT Password FROM users WHERE UserName = ?", $arr)));
		return password_verify($pass, $userPass);
	}
	
	public function changePass() {
		$oldPass = $_POST['oldPass'];
		$newPass = $_POST['newPass'];
		$newPassConfirm = $_POST['newPassConfirm'];
		$json['token'] = $_SESSION['token'];
		
		if ($newPass == $newPassConfirm) {
			if ($this->matchPass($oldPass)) {
				$arr = [
					password_hash($newPass, PASSWORD_BCRYPT),
					$_SESSION['user'],
				];
				$this->db->execute("UPDATE users set Password = ? WHERE UserName = ?", $arr);
			}
			else
				$json['error'] = 'Password mismatch';
		}
		else
			$json['error'] = 'Password mismatch';
		echo json_encode($json);
	}
	
	public function getNotificationStatus() {
		$arr[] = $_SESSION['user'];
		$json['token'] = $_SESSION['token'];
		$result = current($this->db->query("SELECT * FROM users WHERE UserName = ?", $arr));
		$json['status'] = $result['notification'];
		echo json_encode($json);
	}
	
	public function switchNotification() {
		$json['token'] = $_SESSION['token'];
		$arr = [
			$_POST['to'],
			$_SESSION['user']
		];
		$this->db->execute("UPDATE users set notification = ? WHERE UserName = ?", $arr);
		echo json_encode($json);
	}
}