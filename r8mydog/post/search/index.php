<!DOCTYPE html>
<html>
<head>
	<title>Browse - r8mydog</title>
	<?php require '../../snippet/bootstrap.html'; ?>
	<link rel="stylesheet" href="../post.css">
	<script type="text/javascript" src="advSearch.js"></script>
</head>
<body>
	<?php require '../../snippet/header.php'; ?>
	<section class="container">
		<br>
		<h3 class="text-center">Search</h3>
		<?php include 'searchForm.php' ?>
		<main class="col">
			<section id="content" class="col-12 col-xl">
				<div id="posts" class="row"></div>
			</section>
		</main>
	</section>
</body>
</html>
