<?php

	namespace config;
	use \PDO;


	class Config
	{
		static function dsn()
		{
			return [
				'host' => 'localhost',
				'db_name' => 'camaguru',
				'username' => 'root',
				'password' => 'qwerty',
//                'password' => 'root',
				'charset' => 'utf8'
			];
		}
		static function getOption()
		{
			$opt = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];
			return $opt;
		}

		static function forbiddenImages()
		{
			return [
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
		}
		
		static function selectableImages()
		{
			$arr = [];
			foreach (glob("img/_*.*") as $img)
			{
				array_push($arr, $img);
			}
			return $arr;
		}

        /**
         * @param $PDO
         * @return string
         */
		static function userTable($PDO) {
			$table = "users";
			$sql = "CREATE TABLE $table(
				id int(11) AUTO_INCREMENT PRIMARY KEY,
				UserName CHAR (255) NOT NULL,
				UserEmail CHAR (255) NOT NULL,
				Password char (255) not null,
				Activated char (255) null,
				Admin int (1) not null);";
			$PDO->exec($sql);
			$PDO->exec("INSERT INTO `users` (`id`, `UserName`, `UserEmail`, `Password`, `Activated`, `Admin`) VALUES (NULL, 'root', 'a@ukr.net', '".crypt('root', 'salt')."', NULL, '1');");
			$PDO->exec("INSERT INTO `users` (`id`, `UserName`, `UserEmail`, `Password`, `Activated`, `Admin`) VALUES (NULL, 'admin', 'admin@ukr.net', '".crypt('admin', 'admin')."', NULL, '1');");
			return (0);
		}

		static function photoTable($PDO) {
			$table = "photos";
			$sql = "CREATE TABLE $table(
				id int(11) AUTO_INCREMENT PRIMARY KEY,
				dest CHAR (255) NOT NULL,
				userId CHAR (255) NOT NULL,
				date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);";
			$PDO->exec($sql);
		}

		static function likesTable($PDO) {
			$table = 'likes';
			$sql = "CREATE TABLE $table(
				photoid INT NOT NULL,
				userid INT NOT NULL);
			)";
			$PDO->exec($sql);
		}

		static function commentsTable($PDO) {
			$table = 'likes';
			$sql = "CREATE TABLE $table(
				photoid INT NOT NULL,
				userid INT NOT NULL
				body CHAR (255) NOT NULL,
				date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
				);
			)";
			$PDO->exec($sql);
		}
	}
