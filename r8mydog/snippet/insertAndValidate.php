<?php
if ($_POST)
{
	require 'connect.php';
	//register a new user
	if ($_POST['type'] == 'register')
	{
		//sanitize
		$fname = filter_var(trim($_POST['fname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$lname = filter_var(trim($_POST['lname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
			//maybe send them to the login?
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

						//get postid
						$stmt = $db->query("SELECT LAST_INSERT_ID()");
						$lastId = $stmt->fetchColumn();
						session_start();
						require 'setSession.php';
						SetSession($lastId);
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
	else if ($_POST['type'] == 'post')
	{
		include_once '../lib/securimage/securimage.php';
		$securimage = new Securimage();
		if(!isset($_SESSION))
			session_start();
		if ($securimage->check($_POST['captcha_code']) == false) {
			// the code was incorrect
			// you should handle the error so that the form processor doesn't continue
			// or you can use the following code if there is no validation or you do not know how
			echo "The security code entered was incorrect.<br /><br />";
			echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
			die();
		}
		//img upload
		//title, description
		$title = filter_var(trim($_POST['title']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description = filter_var(trim($_POST['description']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);


		if (strlen($title) > 0)
		{
			require 'image-tools.php';

			if (isset($_FILES['image']) && $_FILES['image']['error'] == 0 && file_is_an_image($_FILES['image']['tmp_name'], $_FILES['image']['name']))
			{
				if ($_SESSION['userid'])
				{
					$query = "INSERT INTO posts (epoch, userid, title, description, imagetype) VALUES (:epoch, :userid, :title, :description, :imagetype);";
					$statement = $db->prepare($query);
					$statement->bindValue(':userid', $_SESSION['userid']);
					$statement->bindValue(':title', $title);
					$statement->bindValue(':epoch', time());
					$statement->bindValue(':description', strlen($description) ? $description : "");
					$statement->bindValue(':imagetype', pathinfo($_FILES['image']['name'])['extension']);
					$statement->execute();

					//get postid
					$stmt = $db->query("SELECT LAST_INSERT_ID()");
					$lastId = $stmt->fetchColumn();
					//print("last id: ".$lastId);

					//save image with postid name to /image/post/
					$fileLocation = file_upload_path($lastId.'.'.pathinfo($_FILES['image']['name'])['extension']);
					//print ' file location: '.$fileLocation;

					move_uploaded_file($_FILES['image']['tmp_name'], file_upload_path($fileLocation));
					$image = new \Gumlet\ImageResize($fileLocation);
					$image->resizeToWidth(200);
					$image->save(file_upload_path($lastId.'_thumb.'.pathinfo($fileLocation)['extension']));

					header('Location: /post?id='.$lastId); //status 302
					die();
				}
				else
				{
					//bad userid
					//print("userid: ".$_SESSION['userid']);
					header("location:/post/new?userid");
				}
			}
			else
			{
				//file upload error
				header("location:/post/new?file=".$_FILES['image']['error']."&isset=".isset($_FILES['image'])."&isimage=".file_is_an_image($_FILES['image']['tmp_name'], $_FILES['image']['name']));
			}
		}
		else
		{
			//title has no chars
			//if this happens, someone is probably tampering
			header("location:/post/new?title");
		}
	}
	//something else we can use later
	// else if ($_POST['type'] == '')
	// {
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
