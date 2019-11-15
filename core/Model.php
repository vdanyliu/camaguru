<?php
namespace core;
use lib\Database;

	abstract class Model
{
	public $db;

	function __construct()
	{
		$this->db = new Database();
	}
}