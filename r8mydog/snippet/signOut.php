<?php
session_start();
unset($_SESSION);
session_destroy();
//remove cookies
// echo '<pre>';
// print_r($_COOKIE);
// echo '</pre>';
// unset($_COOKIE['userid']);
// unset($_COOKIE['fname']);
// unset($_COOKIE['lname']);
// unset($_COOKIE['email']);
// unset($_COOKIE['admin']);
// unset($_COOKIE);
// echo '<pre>';
// print_r($_COOKIE);
// echo '</pre>';
//redirect
header("location:/");
?>
