<?php
if ($_POST)
{
	require '../snippet/connect.php';
	$email = strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

	$query = "SELECT userid, fname, lname, email, admin, passhash FROM users WHERE :email = email;";
	$statement = $db->prepare($query);
	$statement->bindValue(':email', $email);
	$statement->execute();

	//grab the user if it exists
	if ($statement->rowCount() == 1)
	{
		$row = $statement->fetch();
		if(password_verify($_POST['password'], $row['passhash']))
		{
			//set the session
			session_start();
			$_SESSION['userid'] = $row['userid'];
			$_SESSION['fname'] = $row['fname'];
			$_SESSION['lname'] = $row['lname'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['admin'] = $row['admin'];

			if($_POST['remember'])
			{
				// setcookie('userid', $row['userid'], time()+(86400 * 30));
				// setcookie('fname', $row['fname'], time()+(86400 * 30));
				// setcookie('lname', $row['lname'], time()+(86400 * 30));
				// setcookie('email', $row['email'], time()+(86400 * 30));
				// setcookie('admin', $row['admin'], time()+(86400 * 30));
			}

			if (isset($_POST['dest']))
				header("Location: ".$_POST['dest']);
			else
				header("location:/post");
		}
		else
		{
			header("location:/login?incorrectpassword&email=".urlencode($email));

		}
	}
	else
	{
		header("location:/login?notfound");
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login - r8mydog</title>
	<?php require '../snippet/bootstrap.html'; ?>
</head>
<body>
	<?php require '../snippet/header.php'; ?>
	<section class="container">
		<div class="row">
			<div class="col-md-6 col-12">
				<br/>
				<h1>Log in:</h1>
				<br/>
				<form method="post" id="logInForm">
					<?php if(isset($_GET["notfound"])) : ?>
						<div class="alert alert-danger" role="alert">
							<strong>Whoops!</strong> That user doesent exist!
						</div>
					<?php endif; ?>

					<?php if(isset($_GET["incorrectpassword"])) : ?>
						<div class="alert alert-danger" role="alert">
							<strong>Whoops!</strong> Your password is incorrect!
						</div>
					<?php endif; ?>

					<div class="form-group">
						<label for="email">Email:</label>
						<input id="email" class="form-control" type="email" name="email" placeholder="email@domain.com" value="<?= isset($_GET['email']) ? $_GET['email'] : '' ?>" required/>
					</div>

					<div class="form-group">
						<label for="password">Password:</label>
						<input id="password" class="form-control" type="password" name="password" required/>
					</div>
					<input id="remember" type="checkbox" name="remember" />
					<label for="remember">Remember Me</label>
					<br>
					<br>
					<input class="btn btn-primary" type="submit" name="submit" value="Login" />
				</form>
			</div>
			<div class="col-md-6 col-12">
				<br/>
				<h1>Register:</h1>
				<br/>
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
					<input class="btn btn-primary" type="submit" name="submit" value="Create Account" />
				</form>
			</div>
		</div>
	</section>
</body>
</html>
