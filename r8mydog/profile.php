<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>r8mydog - Home</title>
		<link rel="stylesheet" href="site.css">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"
			integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
			integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</head>
	<body>
		<?php require 's/header.php'; ?>
		<section class="container">
			<h1><?=$_SESSION['fname'].' '.$_SESSION['lname']?>'s profile</h1>
			<p>Email: <?=$_SESSION['email']?></p>
			<p>Admin: <?=$_SESSION['admin'] ? "Yes" : "No"?></p>
		</section>
	</body>
</html>
