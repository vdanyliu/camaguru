<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $title; ?></title>
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/css/main.css">
	<base href="/" />
</head>
<body>
<header class="header">
	<p>
		<a href="/" title="Main" class="headerText">Main</a>
        <?php
            if (!isset($_SESSION['user'])) {
                echo "<a href=\"/account/login\" title=\"Sign in\" class=\"headerText\">Sign in</a>";
            }
			if (isset($_SESSION['user'])) {
				echo "<a href=\"/profile/settings\" title=\"My profile\" class=\"headerText\">";
				echo $_SESSION['user'];
				echo "</a>";
				echo "<a href=\"/profile/logout\"> Logout </a>";
			}
		?>
	</p>
    <input id="token" value="<?php echo $_SESSION['token']; ?>">
</header>
<?php echo $content; ?>
</body>
</html>
<?php
