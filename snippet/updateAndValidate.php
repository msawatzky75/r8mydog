<?php
if ($_POST)
{
	session_start();
	require 'connect.php';
	if ($_POST['type'] == 'user')
	{
		$fname = filter_var(trim($_POST['fname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$lname = filter_var(trim($_POST['lname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$email = strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

		if (strlen($fname) == 0 || strlen($lname) == 0 || strlen($email) == 0)
		{
			//send the bad data back with error flag
			//header("location:profile?updateFailed".(strlen($fname) == 0 ? "&".urlencode($fname) : '').(strlen($lname) == 0 ? "&".urlencode($lname) : '').(strlen($email) == 0 ? "&".urlencode($email) : ''));
			die();
		}

		$query = "UPDATE users SET fname=:fname, lname=:lname, email=:email WHERE userid=:userid;";
		$statement = $db->prepare($query);
		$statement->bindValue(':fname', $fname);
		$statement->bindValue(':lname', $lname);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':userid', $_SESSION['userid']);
		$statement->execute();

		//update session
		require 'setSession.php';
		SetSession($_SESSION['userid']);

		header('location:/profile?details'); //status 302
		die();
	}
	//something else we can use later
	// else if ($_POST['type'] == '')
	// {
	// 	$query = "INSERT INTO table (col) VALUES (:col);";
	// 	$statement = $db->prepare($query);
	// 	$statement->bindValue(':col', $col);
	// 	$statement->execute();
	// 	header('location:/'); //status 302
	// 	die();
	// }
	else
	{
		//no type
		header("location:/");
	}
}
else
{
	//no post
	header("location:/");
}
?>
