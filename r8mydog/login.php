<?php
	if ($_POST)
	{
		$email = strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
		$pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

		if(isset($_POST['dest']))//coming from the html form, not the register page
		{
			require 'connect.php';
		}

		$query = "SELECT fname, lname, email, admin FROM users WHERE :email = email; AND :passhash = passhash";
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
			$_SESSION['fname'] = $row['fname'];
			$_SESSION['lname'] = $row['lname'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['admin'] = $row['admin'];
			if (isset($_POST['dest']))
			{
				header("Location: ".$_POST['dest']);
			}
			else
			{
				//no dest specified
				header("Location: profile.php");
			}
		}
		else
		{
			echo "no user found";
			//header("Location: register.html");
		}
	}
	else
	{
		?>
		<form class="login" action="login.php" method="post">
			<label for="email">Email:</label>
			<?php if (isset($_GET['email'])) : ?>
				<input id="email" type="email" name="email" value="<?=$_GET['email']?>" required/><br>
			<?php else : ?>
				<input id="email" type="email" name="email" required/><br>
			<?php endif; ?>

			<label for="password">Password:</label>
			<input id="password" type="password" name="password" required/><br>

			<input type="hidden" name="dest" value="profile.php" />
			<input type="submit" name="submit" />
		</form>
		<?php
	}
?>
