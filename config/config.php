<?php

	namespace config;


	class Config
	{
		static function dsn()
		{
			return [
				'host' => 'localhost',
				'db_name' => 'camaguru',
				'username' => 'root',
				'password' => 'qwerty',
				'charset' => 'utf8'
			];
		}

		/**
		 * @return string
		 */
		static function userTable($PDO)
		{
			$table = "users";
			$sql = "CREATE TABLE $table(
				id int(11) AUTO_INCREMENT PRIMARY KEY,
				UserName CHAR (255) NOT NULL,
				Password char (255) not null,
				Activated char (255) null,
				Admin int (1) not null);";
			$PDO->exec($sql);
			$PDO->exec("INSERT INTO `users` (`id`, `UserName`, `Password`, `Activated`, `Admin`) VALUES (NULL, 'root', '".crypt('root', 'salt')."', NULL, '1')");
		}
	}
//	return [
//		'host' => 'localhost',
//		'db_name' => 'camaguru',
//		'username' => 'root',
//		'password' => 'qwerty',
//		'charset' => 'utf8'
//	];