<?php
if ($_POST)
{
	session_start();
	require 'connect.php';
	if ($_POST["type"] == "user")
	{
		$query = "DELETE FROM users WHERE userid=:userid;";
		$statement = $db->prepare($query);
		$statement->bindValue(':userid', $_SESSION['userid']);
		$statement->execute();

		//cascade here

		require 'signOut.php';
		die();
	}
}
else
{
	echo "no post";
}
?>
