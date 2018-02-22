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
		$query = "SELECT * FROM users WHERE email = :email;";
		$statement = $db->prepare($query);
		$statement->bindValue(':email', $email);
		$statement->execute();

		if ($statement->rowCount() > 0)
		{
			//send back to register
			header("location:/register?userexists&email=".urlencode($email)."&fname=".urlencode($fname)."&lname=".urlencode($lname));
		}
		else
		{
			if (strlen($_POST['password']) > 0 && $_POST['password'] == $_POST['confirmPassword'])
			{
				if (strlen($fname) > 0 && strlen($lname) > 0)
				{
					if (filter_var($email, FILTER_VALIDATE_EMAIL))
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
						$query = "SELECT userid, fname, lname, email, admin FROM users WHERE :email = email; AND :passhash = passhash;";
						$statement = $db->prepare($query);
						$statement->bindValue(':email', $email);
						$statement->bindValue(':passhash', $pass);
						$statement->execute();
						$row = $statement->fetch();

						session_start();
						$_SESSION['userid'] = $row['userid'];
						$_SESSION['fname'] = $row['fname'];
						$_SESSION['lname'] = $row['lname'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['admin'] = $row['admin'];
						//send back to register
						header("location:/register?success");
					}
					else
					{
						//invalid email
						//send back to register
						header("location:/register?invalidemail&email=".urlencode($email)."&fname=".urlencode($fname)."&lname=".urlencode($lname));
					}
				}
			}
			else
			{
				//send back to register
				header("location:/register?incorrectpassword&email=".urlencode($email)."&fname=".urlencode($fname)."&lname=".urlencode($lname));
			}
		}
	}
	//something else we can use later
	// else if ($_POST['type'] == '')
	// {
	// 	$status = $tweet;
	// 	$query = "INSERT INTO table (col) VALUES (:col);";
	// 	$statement = $db->prepare($query);
	// 	$statement->bindValue(':col', $col);
	// 	$statement->execute();
	// 	header('Location: index.php'); //status 302
	// 	die();
	// }
	else
	{
		//no insert type
		header("location:/");
	}
}
else
{
	//no post
	header("location:/");
}
?>
