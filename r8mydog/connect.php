<?php
	define('DB_DSN','mysql:host=localhost;dbname=spiffpitt_r8mydog');
	define('DB_USER','spiffpitt');
	define('DB_PASS','!weedlord69');
	try {
		$db = new PDO(DB_DSN, DB_USER, DB_PASS);
	} catch (PDOException $e) {
		print "Error: " . $e->getMessage();
		die(); // Force execution to stop on errors.
	}
?>
