<!DOCTYPE html>
<html>
<head>
	<title>Browse - r8mydog</title>
	<?php require '../snippet/bootstrap.html'; ?>
	<link rel="stylesheet" href="post.css">
	<script type="text/javascript" src="post.js"></script>
</head>
<body>
	<?php require '../snippet/header.php'; ?>
	<section class="container">
		<main class="col">
			<section id="content" class="col-12 col-xl">
				<?php if (!isset($_GET["id"])) : ?>
					<?php if (!isset($_GET["userid"])) : ?>
						<h3 class="text-center mt-2">
							Today's top rated posts
						</h3>

					<?php else : ?>
						<h3 class="text-center mt-2">
							<?= isset($_GET['userid']) ? getUserName($_GET['userid'])["fname"]."'s posts" : "" ?>
						</h3>

					<?php endif; ?>
					<br>
					<nav class="pagination-fill">
						<ul class="pagination pagination-lg d-flex justify-content-center"></ul>
					</nav>
					<br>
					<div id="posts" class="row"></div>
					<br>
					<nav class="pagination-fill">
						<ul class="pagination pagination-lg d-flex justify-content-center"></ul>
					</nav>

				<?php else : ?>
					<!-- single post -->

				<?php endif; ?>
			</section>
		</main>
	</section>
</body>
</html>
