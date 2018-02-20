<?php
if ($_POST)
{
	require 'connect.php';
	//register a new user
	if ($_POST['type'] == 'register')
	{
		//sanitize
		$fname = filter_var($_POST['fname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$lname = filter_var($_POST['lname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$email = strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
		$pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

		//verify email is not in use already
		$query = "SELECT COUNT(*) FROM users WHERE email = :email;";
		$statement = $db->prepare($query);
		$statement->bindValue(':email', $email);
		$statement->execute();
		if ($statement->rowCount() > 0)
		{
			$messages[0] = 'That user already exists!';
			$messages[1] = '<a href="login.php?email='.$email.'">Login here</a>';
		}

		else if (strlen($_POST['password']) > 0 && $_POST['password'] == $_POST['confirmPassword'])
		{
			if (strlen($fname) > 0 && strlen($lname) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				//insert
				$query = "INSERT INTO users (fname, lname, email, passhash, admin) VALUES (:fname, :lname, :email, :passhash, false);";
				$statement = $db->prepare($query);
				$statement->bindValue(':fname', $fname);
				$statement->bindValue(':lname', $lname);
				$statement->bindValue(':email', $email);
				$statement->bindValue(':passhash', $pass);
				$statement->execute();

				//log them in
				require 'login.php';
				$messages[0] = "No Errors";
			}
		}
		else
		{
			if (isset($messages))
			{
				$messages[sizeof($messages)] = "Passwords do not match!";
			}
			else
			{
				$messages[0] = "Passwords do not match!";
			}
		}
	}
	//something else we can use later
	// else if ($_POST['type'] == '')
	// {
	// 	$status = $tweet;
	// 	$query = "INSERT INTO Tweets (status) VALUES (:status);";
	// 	$statement = $db->prepare($query);
	// 	$statement->bindValue(':status', $status);
	// 	$statement->execute();
	// 	header('Location: index.php'); //status 302
	// 	die();
	// }
	else
	{
		if (isset($messages))
		{
			$messages[sizeof($messages)] = "There was no post type attached.";
		}
		else
		{
			$messages[0] = "There was no post type attached.";
		}
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
	</head>
	<body>
		<?php foreach ($messages as $key => $value): ?>
			<p><?=$value?></p>
		<?php endforeach; ?>
	</body>
</html>
