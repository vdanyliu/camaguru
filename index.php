<?php
	session_start();
	if (!isset($_SESSION['user']))
		$_SESSION['user'] = 'Guest';
//	session_destroy();
//	header("Content-Type: */*");
	require './lib/Dev.php';

	use core\Router;
	use lib\Database;

    spl_autoload_register(function($class)
    {
       //echo '<p>' .$class . '</p>';
       $path = str_replace('\\', '/', $class.'.php');
       if (file_exists($path)) {
	       require $path;
       }
    });

    $router = new Router();
    $dataBase = new Database();
    //$dataBase->exec("INSERT INTO `users` (`id`, `UserName`, `Password`, `Activated`, `Admin`) VALUES (NULL, 'root', '".crypt('root', 'salt')."', NULL, '1')");
    $router->run();

