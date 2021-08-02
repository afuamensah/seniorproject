<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="../js/function.js"></script>
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	<title>Herdr - Admin</title>
	</head>
    <body>
		<header class="border-right">
		<?php
			if (isset($_SESSION['valid_user']))
			{
				echo '<a href="logout.php" class="logout">Log Out</a>';
				echo '<br><br>';
				echo '<p class="name"><b>'.$_SESSION['valid_user'].'</b></p>';
				echo '<img src="logo.png">';
			}
		?>
			<ul class="list-group list-group-flush">
				<li><a href="dashboard.php" class="list-group-item list-group-item-action ">Dashboard</a></li>
				<li><a href="matches.php" class="list-group-item list-group-item-action ">Matches Center</a></li>
				<li><a href="reports.php" class="list-group-item list-group-item-action">Reports Center</a></li>
				<li><a href="help.php" class="list-group-item list-group-item-action">Help Center</a></li>
			</ul>
		</header>