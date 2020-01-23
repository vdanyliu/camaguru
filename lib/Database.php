<?php
	namespace lib;
	use \PDO;
	use config\Config;

	class Database
	{
		private $link;

		function __construct()
		{
			$this->connect();
		}

		private function connect()
		{
			try {
				$config = Config::dsn();
				$dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
				$this->link = new PDO($dsn, $config['username'], $config['password'], Config::getOption());
				$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $this;
			}
			catch (\PDOException $e)
			{
				try {
					$this->link = new PDO('mysql:host=' . $config['host'], $config['username'], $config['password']);
					$dbname = "`" . str_replace("`", "``", $config['db_name']) . "`";
					$this->link->query("CREATE DATABASE IF NOT EXISTS $dbname");
					$this->link->query("use $dbname");
					$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					Config::userTable($this->link);
					Config::photoTable($this->link);
					return $this;
				}
				catch (\PDOException $e)
				{
					echo $e;
					echo "Connection failed: contact to your administrator";
					exit (0);
				}
			}
		}


		public function execute($sql, $arr = [])
		{
			$sth = $this->link->prepare($sql);
			return $sth->execute($arr);
		}

		public function query($sql, $arr = [])
		{
			$sth = $this->link->prepare($sql);
			$sth->execute($arr);
			//$result = $sth->fetchAll(PDO::FETCH_ASSOC);
			$result = $sth->fetchAll();

			if ($result == false)
			{
				return [];
			}

			return $result;
		}
	}