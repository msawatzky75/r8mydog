<?php
require 'snippet/func.php';
session_start();
$loggedin = LoggedIn();
if ($loggedin)
{
	header("location:/post");
	die();
}
else
{
	header("location:/welcome");
	die();
}
?>
