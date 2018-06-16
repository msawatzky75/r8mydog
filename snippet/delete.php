<?php
if ($_POST)
{
	session_start();
	require "connect.php";
	if ($_POST["type"] == "user" || $_POST["type"] == "users")
	{
		//delete all posts
		$query = "SELECT postid FROM posts WHERE userid=:id";
		$statement = $db->prepare($query);
		$statement->bindValue(":id", filter_var($_POST["delete"], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$statement->execute();

		foreach ($statement->fetchAll() as $value)
		{
			DeletePost($db, $value["postid"]);
		}

		//delete user
		$query = "DELETE FROM users WHERE userid=:id";
		$statement = $db->prepare($query);
		$statement->bindValue(":id", filter_var($_POST["delete"], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$statement->execute();

		echo "<br>Deleted user ".$_POST["delete"];

		//sign them out if the sigined in user was deleted.
		if ($_SESSION["userid"] == $_POST["delete"])
		{
			require "signOut.php";
		}
	}
	else if ($_POST["type"] == "post" || $_POST["type"] == "posts")
	{
		DeletePost($db, $_POST["delete"]);
	}
	else if ($_POST["type"] == "rating" || $_POST["type"] == "ratings")
	{
		DeleteRating($db, $_POST["delete"]);
	}
	if (isset($_POST["return"]))
	{
		header("location:".filter_var($_POST["return"], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
	}
}
else
{
	echo "no post";
}

function DeletePost($db, $id)
{
	//delete all ratings
	$query = "SELECT ratingid FROM ratings WHERE postid=:id";
	$statement = $db->prepare($query);
	$statement->bindValue(":id", filter_var($id, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
	$statement->execute();

	foreach ($statement->fetchAll() as $value)
	{
		DeleteRating($db, $value["ratingid"]);
	}

	$query = "SELECT imagetype FROM posts WHERE postid=:id";
	$statement = $db->prepare($query);
	$statement->bindValue(":id", filter_var($id, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
	$statement->execute();

	//delete file
	$type = $statement->fetch()["imagetype"];
	unlink("../image/post/".$id.".".$type);//returns success boolean
	unlink("../image/post/".$id."_thumb.".$type);//returns success boolean

	$query = "DELETE FROM posts WHERE postid=:id";
	$statement = $db->prepare($query);
	$statement->bindValue(":id", filter_var($id, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
	$statement->execute();

	echo "<br>Deleted post ".$id;
}

function DeleteRating($db, $id)
{
	$query = "DELETE FROM ratings WHERE ratingid=:id";
	$statement = $db->prepare($query);
	$statement->bindValue(":id", filter_var($id, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
	$statement->execute();

	echo "<br>Deleted rating ".$id;
}
?>
