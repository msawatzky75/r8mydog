<!DOCTYPE html>
<html>
<head>
	<title>r8mydog - Search</title>
	<?php require '../snippet/bootstrap.html'; ?>
</head>
<body>
	<?php require '../snippet/header.php'; ?>
	<section class="container">
		<br/><h1>Create a new account:</h1>
		<small class="badge badge-info">All fields are required</small>
		<br/><br/>

		<!--
		possible messages:
			success
			invalidemail
			incorrectpassword
			userexists
			errorAdding
		-->
		<?php if(isset($_GET["success"])) : ?>
			<div class="alert alert-success" role="alert">
				<strong>Success!</strong> <?=$_SESSION['fname']?>, <a href="/profile">Your account</a> has been made!
			</div>
		<?php endif; ?>
		<?php if(isset($_GET["invalidemail"])) : ?>
			<div class="alert alert-danger" role="alert">
				<strong>Invalid email!</strong> Your email is invalid!
			</div>
		<?php endif; ?>
		<?php if(isset($_GET["incorrectpassword"])) : ?>
			<div class="alert alert-danger" role="alert">
				<strong>Wrong password!</strong> Your passwords do not match!
			</div>
		<?php endif; ?>
		<?php if(isset($_GET["userexists"])) : ?>
			<div class="alert alert-danger" role="alert">
				<strong>Already exists!</strong> That email is connected to an account already!
			</div>
		<?php endif; ?>
		<?php if(isset($_GET["errorAdding"])) : ?>
			<div class="alert alert-danger" role="alert">
				<strong>Failed to create account!</strong> The user was not added due to an unknown problem.
			</div>
		<?php endif; ?>

		<form action="../snippet/insertAndValidate.php" method="post">

			<div class="form-row">
				<div class="col">
					<label>Full Name:</label>
					<!-- <small class="badge badge-pill badge-danger">*</small> we could do this -->
				</div>
			</div>

			<div class="form-row">
				<div class="col">
					<input id="fname" class="form-control" type="text" name="fname" placeholder="First" <?= isset($_GET['fname']) ? 'value="'.$_GET['fname'].'"' : '' ?> required/>
				</div>
				<div class="col">
					<input id="lname" class="form-control" type="text" name="lname" placeholder="Last" <?= isset($_GET['lname']) ? 'value="'.$_GET['lname'].'"' : '' ?> required/>
				</div>
			</div>
			<br>

			<div class="form-group">
				<label for="email">Email:</label>
				<input id="email" class="form-control" type="email" name="email" placeholder="email@domain.com" <?= isset($_GET['email']) ? 'value="'.$_GET['email'].'"' : '' ?> required/>
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
