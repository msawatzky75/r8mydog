<?php
require '../snippet/connect.php';

$query = "SELECT column_name FROM information_schema.columns WHERE table_schema = 'spiffpitt_r8mydog' AND table_name = :table";
$statement = $db->prepare($query);
$statement->bindValue(":table", filter_var($_GET['table'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$statement->execute();
$columnNames = $statement->fetchAll();

$query = "SELECT * FROM ".$_GET['table'];//it wont bind
$statement = $db->prepare($query);
$statement->execute();
$rowData = $statement->fetchAll();
?>
