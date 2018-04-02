<?php
include '../snippet/func.php';
session_start();
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
?>

<div class="col-12 col-lg-6 col-xl-4 card mb-2" id="<?=$_POST['postid']?>">
	<a href="?id=<?=$_POST['postid']?>">
		<img class="card-img-top" src="/image/post/<?=$_POST['postid']?>_thumb.<?=$_POST['imagetype']?>" alt="<?=$_POST['fname']?>'s dog" onerror="this.onerror=null;this.src='/image/noImageFound.svg';">
	</a>
	<div class="card-body">
		<h4 class="card-title"><?=$_POST['title']?></h4>
		<a href="/rate?post=<?=$_POST['postid']?>">
			<img src="/image/rating/<?=$_POST['rating']?>.svg" class="rating mb-2" alt="<?=$_POST['rating']?>">
		</a>
		<p class="card-text"><?=$_POST['description'] ? $_POST['description'] : "No description provided." ?></p>
	</div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item">
			<div class="row">
				<div class="col-7"><a href="<?= $_POST['userid'] == $_SESSION['userid'] ? "/profile?details" : "/post?userid=".$_POST['userid'] ?>"><?=$_POST['fname'].' '.$_POST['lname']?></a></div>
				<div class="col-5 text-right"><small><?= TimeAgo($_POST['epoch']) ?></small></div>
			</div>
		</li>
	</ul>
</div>
