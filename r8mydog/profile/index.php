<!DOCTYPE html>
<html>
<head>
	<title>r8mydog - Search</title>
	<?php require '../snippet/bootstrap.html'; ?>
</head>
<body>
	<?php require '../snippet/header.php'; ?>
	<section class="container">
		<h1><?=$_SESSION['fname'].' '.$_SESSION['lname']?>'s profile</h1>
		<p>Email: <?=$_SESSION['email']?></p>
		<p>Admin: <?=$_SESSION['admin'] ? "Yes" : "No"?></p>
	</section>
</body>
</html>
