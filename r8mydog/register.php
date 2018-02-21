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
			<form class="login" action="insertAndValidate.php" method="post">
				<label for="fname">First Name:</label>
				<input id="fname" type="text" name="fname" required/><br>

				<label for="lname">Last Name:</label>
				<input id="lname" type="text" name="lname" required/><br>

				<label for="email">Email:</label>
				<input id="email" type="email" name="email" required/><br>

				<label for="password">Password:</label>
				<input id="password" type="password" name="password" required/><br>

				<label for="confirmPassword">Confirm Password:</label>
				<input id="confirmPassword" type="password" name="confirmPassword" required/><br>

				<input type="hidden" name="type" value="register" />
				<input type="submit" name="submit" />
			</form>
		</section>
	</body>
</html>
