<?php
function SetSession($userId)
{
	require 'connect.php';
	//log them in, there can only be one of them
	$query = "SELECT userid, fname, lname, email, admin FROM users WHERE userid=:userid;";
	$statement = $db->prepare($query);
	$statement->bindValue(':userid', $userId);
	$statement->execute();
	$row = $statement->fetch();

	if ($statement->rowCount() == 0)
	{
		//no user
		return false;
	}
	
	$_SESSION['userid'] = $row['userid'];
	$_SESSION['fname'] = $row['fname'];
	$_SESSION['lname'] = $row['lname'];
	$_SESSION['email'] = $row['email'];
	$_SESSION['admin'] = $row['admin'];
	return true;
}
?>
