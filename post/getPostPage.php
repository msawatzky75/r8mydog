<?php
include '../snippet/func.php';
session_start();
?>
<br>
<div class="col-12 card mb-2">
	<h3 class="card-title text-center"><?=$_POST['title']?></h3>
		<img class="card-img-top" src="/image/post/<?=$_POST['postid']?>.<?=$_POST['imagetype']?>" alt="<?=$_POST['fname']?>'s dog" onerror="this.onerror=null;this.src='/image/noImageFound.svg';">
	<div class="card-body">
		<a href="/rate?post=<?=$_POST['postid']?>">
			<img src="/image/rating/<?=$_POST['rating']?>.svg" class="rating mb-2" alt="<?=$_POST['rating']?>">
			(<?=$_POST['totalratings']?>)
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
<section id="ratings"></section>
