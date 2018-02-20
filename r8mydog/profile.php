<?php
session_start();
if (!$_SESSION) :
	//if not logged in
	header("Location: login.php");
else : ?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<title><?=$_SESSION['fname']?>'s profile</title>
		</head>
		<body>
			<h1><?=$_SESSION['fname'].' '.$_SESSION['lname']?>'s profile</h1>
			<p>Email: <?=$_SESSION['email']?></p>
			<p>Admin: <?=$_SESSION['admin'] ? "Yes" : "No"?></p>
		</body>
	</html>
<?php endif; ?>
