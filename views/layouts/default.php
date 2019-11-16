<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="/css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower&display=swap" rel="stylesheet">
	<base href="/" />
</head>
<body>
<header class="header">
	<p>
		<a href="/" title="Main" class="headerText">Main</a>
		<a href="#" title="My profile" class="headerText">My profile</a>
		<a href="/account/login" title="Login" class="headerText">Login</a>
	</p>
</header>
<?php echo $content; ?>
</body>
</html>
<?php
