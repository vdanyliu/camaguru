<?php
	namespace lib;
	use \PDO;

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
				$config = require_once 'config/config.php';
				$dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
				$this->link = new PDO($dsn, $config['username'], $config['password']);
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
					return $this;
				}
				catch (\PDOException $e)
				{
					echo "Connection failed: $e";
					exit (0);
				}
			}
		}

		public function execute($sql)
		{
			$sth = $this->link->prepare($sql);

			return $sth->execute();
		}

		public function query($sql)
		{
			$sth = $this->link->prepare($sql);
			$sth->execute();
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);

			if ($result == false)
			{
				return [];
			}

			return $result;
		}
	}