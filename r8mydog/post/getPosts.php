<?php
//writes pure html for the ajax request from the posts page
if(!$_POST)
{
	die();
}

require '../snippet/func.php';
session_start();

$loggedin = LoggedIn();
$data = null;
$data['postid'] =  filter_var($_POST['postid'], FILTER_SANITIZE_NUMBER_INT);
$data['userid'] =  filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
$data['title'] =   filter_var(trim($_POST['title']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$data['ratingL'] = filter_var($_POST['ratingL'], FILTER_SANITIZE_NUMBER_INT);
$data['ratingH'] = filter_var($_POST['ratingH'], FILTER_SANITIZE_NUMBER_INT);
$data['sort'] =    filter_var($_POST['sort'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$data['desc'] =    $_POST['desc'];//boolean

if ($data['title'])
	$data['title'] = '%'.$data['title'].'%';

require '../snippet/connect.php';

$query = "SELECT
	posts.postid,
	users.userid,
	fname,
	lname,
	email,
	epoch,
	posts.title,
	posts.description,
	imagetype,
	IFNULL(ROUND((SELECT AVG(rating) FROM ratings WHERE posts.postid = ratings.postid)), :defaultRating) AS \"rating\"
FROM users JOIN posts USING (userid)".
($data['postid'] > 0 ? "\nWHERE posts.postid = :postid" :
	"\nWHERE IFNULL(ROUND((SELECT AVG(rating) FROM ratings WHERE posts.postid = ratings.postid)), :defaultRating) BETWEEN ".$data['ratingL']." AND ".$data['ratingH'].
	($data['title'] ? "\nAND posts.title LIKE :title": "").
	($data['userid'] > 0 ? "\nAND users.userid = :userid" : "").
	(in_array($data["sort"], array("epoch", "rating", "title")) ? "\nORDER BY ".$data['sort']." ".($data['desc'] == 'true' ? "DESC" : "ASC") : "")
);
//echo "<pre>".$query."</pre>";
//bind values takes care of sql injection
$statement = $db->prepare($query);
$statement->bindValue(":defaultRating", 0);
if ($data['postid'] > 0)
{
	$statement->bindValue(":postid", $data['postid']);
}
else
{
	if ($data['userid'] > 0)
	{ $statement->bindValue(":userid", $data['userid']); }
	if ($data['title'])
	{ $statement->bindValue(":title", $data['title']); }
	// $statement->bindValue(":ratingL", $data['ratingL']);
	// $statement->bindValue(":ratingH", $data['ratingH']);
	// $statement->bindValue(":sort", $data['sort']);
}
$statement->execute();

echo json_encode($statement->fetchAll());

// echo "<pre>";
// echo "POST ";
// print_r($_POST);
// echo "DATA ";
// print_r($data);
// echo "</pre>";
// echo $query;

?>
