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
				//'password' => 'qwerty',
                'password' => 'root',
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

        /**
         * @param $PDO
         * @return string
         */
		static function userTable($PDO)
		{
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
		}
	}
