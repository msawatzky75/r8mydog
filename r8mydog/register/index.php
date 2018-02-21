<!DOCTYPE html>
<html>
<head>
	<title>r8mydog - Search</title>
	<?php require '../snippet/bootstrap.html'; ?>
</head>
<body>
	<?php require '../snippet/header.php'; ?>
	<section class="container">
		<br/><h1>Create a new account:</h1><br/>
		<form action="../snippet/insertAndValidate.php" method="post">

			<div class="form-row">
				<div class="col">
					<label>Full Name:</label>
				</div>
			</div>
			<div class="form-row">
				<div class="col">
					<input id="fname" class="form-control" type="text" name="fname" placeholder="First" required/>
				</div>
				<div class="col">
					<input id="lname" class="form-control" type="text" name="lname" placeholder="Last" required/>
				</div>
			</div>
			<br>

			<div class="form-group">
				<label for="email">Email:</label>
				<input id="email" class="form-control" type="email" name="email" placeholder="email@domain.com" required/>
			</div>

			<div class="form-group">
				<label for="password">Password:</label>
				<input id="password" class="form-control" type="password" name="password" required/>
			</div>

			<div class="form-group">
				<label for="confirmPassword">Confirm Password:</label>
				<input id="confirmPassword" class="form-control" type="password" name="confirmPassword" required/>
			</div>

			<br>
			<input type="hidden" name="type" value="register" />
			<input type="submit" name="submit" value="Create Account" />
		</form>
		<br>
	</section>
</body>
</html>
