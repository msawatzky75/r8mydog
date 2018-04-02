<?php
//writes pure html for the ajax request from the posts page
if(!$_POST)
{
	header("location:/");
	die();
}

require 'func.php';
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
	date,
	posts.title,
	posts.description,
	imagetype,
	IFNULL(ROUND((SELECT AVG(rating) FROM ratings WHERE posts.postid = ratings.postid)), :defaultRating) AS \"rating\"
FROM users JOIN posts USING (userid)".
($data['postid'] > 0 ? "\nWHERE posts.postid = :postid" :
	"\nWHERE IFNULL(ROUND((SELECT AVG(rating) FROM ratings WHERE posts.postid = ratings.postid)), :defaultRating) BETWEEN ".$data['ratingL']." AND ".$data['ratingH'].
	($data['title'] ? "\nAND posts.title LIKE :title": "").
	($data['userid'] > 0 ? "\nAND users.userid = :userid" : "").
	(in_array($data["sort"], array("date", "rating", "title")) ? "\nORDER BY ".$data['sort']." ".($data['desc'] == 'true' ? "DESC" : "ASC") : "")
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


// echo "<pre>";
// echo "POST ";
// print_r($_POST);
// echo "DATA ";
// print_r($data);
// echo "</pre>";
// echo $query;

?>

<section>
	<?php if ($statement->rowCount() == 0) : ?>
		<!-- no rows -->
		<p>Sorry, there is nothing that matches that critera</p>

	<?php elseif ($statement->rowCount() > 1) : ?>
		<!-- multi row -->
		<div class="row">
			<?php while ($row = $statement->fetch()) : ?>
				<div class="col-12 col-lg-6 card mb-2" id="<?=$row['postid']?>">
					<a href="?id=<?=$row['postid']?>">
						<img id="dogImgPreview" class="card-img-top" src="/image/post/<?=$row['postid']?>_thumb.<?=$row['imagetype']?>" alt="<?=$row['fname']?>'s dog" onerror="this.onerror=null;this.src='/image/noImageFound.svg';">
					</a>
					<div class="card-body">
						<h4 class="card-title"><?=$row['title']?></h4>
						<a href="/rate?post=<?=$row['postid']?>">
							<img src="/image/rating/<?=$row['rating']?>.svg" class="rating mb-2" alt="<?=$row['rating']?>">
						</a>
						<p class="card-text"><?=$row['description'] ? $row['description'] : "No description provided." ?></p>
					</div>
					<ul class="list-group list-group-flush">
						<!-- <?php if ($loggedin && $_SESSION['admin']) : ?>
							<li class="list-group-item">
								<form method="post" action="insertAndValidate.php" enctype="multipart/form-data">
									we are not worried about tampering because only the admin can access this
									<div class="row justify-content-between">
										<input type="submit" class="col-auto btn btn-warning" name="editPost" value="Edit" />
										<input type="submit" class="col-auto btn btn-danger" name="editPost" value="Delete" />
									</div>
									<input type="hidden" name="postid" value="<?=$row['postid']?>" />
									<input type="hidden" name="type" value="postedit" />
								</form>
							</li>
						<?php endif; ?> -->
						<li class="list-group-item">
							<div class="row">
								<div class="col-7">
									<a href="/profile?id=<?=$row['userid']?>"><?=$row['fname'].' '.$row['lname']?></a>
								</div>
								<div class="col-5 text-right">
									<small><?= TimeAgo($row['date']) ?></small>
								</div>
							</div>
						</li>
					</ul>
				</div>
			<?php endwhile; ?>
		</div>

	<?php else : ?>
		<!-- single row -->
		<?php $row = $statement->fetch(); ?>
		<div class="col-12 col-lg-8 m-auto">
			<a href="?id=<?=$row['postid']?>">
				<img id="dogImgPreview" class="card-img-top" src="/image/post/<?=$row['postid']?>.<?=$row['imagetype']?>" alt="<?=$row['fname']?>'s dog">
			</a>
			<div class="card-body">
				<h3 class="card-title"><?=$row['title']?></h3>
				<p class="card-text"><?=$row['description'] ? $row['description'] : "No description provided" ?></p>
			</div>
			<ul class="list-group list-group-flush">
				<li class="list-group-item">
					<div class="row">
						<div class="col-8 col-xs-7">
							<a href="/profile?id=<?=$row['userid']?>"><?=$row['fname'].' '.$row['lname']?></a>
						</div>
						<div class="col-4 col-xs-5 text-right">
							<small><?= TimeAgo($row['date']) ?></small>
						</div>
					</div>
				</li>
			</ul>
		</div>
	<?php endif; ?>
</section>
