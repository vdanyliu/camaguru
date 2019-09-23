<?php
	require './lib/Dev.php';
	use core\Router;
	use lib\Db;

    echo "Lol";

    spl_autoload_register(function($class)
    {
       echo '<p>' .$class . '</p>';
       $path = str_replace('\\', '/', $class.'.php');
       if (file_exists($path)) {
	       require $path;
       }
    });

    session_start();

    $router = new Router();
    $dataBase = new Db();
    $router->run();