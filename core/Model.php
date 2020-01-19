<?php
namespace core;
use lib\Database;
use config\Config;

	abstract class Model
{
	public $db;

	function __construct()
	{
		$this->db = new Database();
	}

}