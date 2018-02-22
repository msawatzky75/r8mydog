<?php
$notFound = false;
if ($_POST)
{
	require '../snippet/connect.php';
	$email = strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
	$pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

	$query = "SELECT userid, fname, lname, email, admin FROM users WHERE :email = email AND :passhash = passhash;";
	$statement = $db->prepare($query);
	$statement->bindValue(':email', $email);
	$statement->bindValue(':passhash', $pass);
	$statement->execute();

	//grab the user if it exists
	if ($statement->rowCount() == 1)
	{
		$row = $statement->fetch();

		//set the session
		session_start();
		$_SESSION['userid'] = $row['userid'];
		$_SESSION['fname'] = $row['fname'];
		$_SESSION['lname'] = $row['lname'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['admin'] = $row['admin'];

		if (isset($_POST['dest']))
			header("Location: ".$_POST['dest']);
		else
			header("location:/profile");
	}
	else
		header("location:/login?notfound");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>r8mydog - Login</title>
	<?php require '../snippet/bootstrap.html'; ?>
</head>
<body>
	<?php require '../snippet/header.php'; ?>
	<section class="container">
		<br/><h1>Log in:</h1><br/>
		<form method="post">

			<?php if(isset($_GET["notfound"])) : ?>
				<div class="alert alert-danger" role="alert">
					<strong>Whoops!</strong> Your email or password is incorrect!
				</div>
			<?php endif; ?>

			<div class="form-group">
				<label for="email">Email:</label>
				<input id="email" class="form-control" type="email" name="email" placeholder="email@domain.com" required/>
			</div>

			<div class="form-group">
				<label for="password">Password:</label>
				<input id="password" class="form-control" type="password" name="password" required/>
			</div>

			<br>
			<input type="submit" name="submit" value="Login" />
		</form>
		<br>
	</section>
</body>
</html>
