<?php
//writes pure json for the ajax request from the posts page for the list of users
require '../snippet/connect.php';
$query = "SELECT userid, fname, lname, CONCAT(CONCAT(fname, ' '), lname) AS fullname FROM users;";
$statement = $db->prepare($query);
$statement->execute();
echo json_encode($statement->fetchAll());
?>
