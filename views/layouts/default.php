<script>
	if (document.addEventListener) {
		window.addEventListener('pageshow', function (event) {
				if (event.persisted || window.performance &&
					window.performance.navigation.type === 2)
				{
					location.reload();
				}
			},
			false);
	}
</script>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo $title; ?></title>
<!--	<link href="https://fonts.googleapis.com/css?family=Indie+Flower&display=swap" rel="stylesheet">-->
	<link rel="stylesheet" type="text/css" href="/css/main.css">
	<base href="/" />
<!--	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">-->
<!--	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>-->
<!--	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>-->
<!--	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>
<body class="bg-secondary">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item active">
					<a href="/" title="Main" class="nav-link">Home</a>
				</li>
				<?php
					if (!isset($_SESSION['user'])) {
						echo "<a href=\"/account/login\" title=\"Sign in\" class=\"nav-link\">Sign in</a>";
					}
					else {
						echo "<a href=\"/profile/settings\" title=\"My profile\" class=\"nav-link\" id='userName'>";
						echo $_SESSION['user'];
						echo "</a>";
						echo "<a href=\"/profile/logout\" class=\"nav-link\"> Logout </a>";
					}
				?>
			</ul>
		</div>
	</nav>
<!--	<p>-->
<!--		<a href="/" title="Main" class="headerText">Main</a>-->
<!--        --><?php
//            if (!isset($_SESSION['user'])) {
//                echo "<a href=\"/account/login\" title=\"Sign in\" class=\"headerText\">Sign in</a>";
//            }
//			if (isset($_SESSION['user'])) {
//				echo "<a href=\"/profile/settings\" title=\"My profile\" class=\"headerText\" id='userName'>";
//				echo $_SESSION['user'];
//				echo "</a>";
//				echo "<a href=\"/profile/logout\"> Logout </a>";
//			}
//		?>
<!--	</p>-->
    <input hidden id="token" readonly value="<?php echo $_SESSION['token']; ?>">
<?php echo $content; ?>
</body>
</html>
<?php
