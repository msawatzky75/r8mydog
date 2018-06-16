<?php if(isset($_GET['id'])) header("location:/post?".http_build_query($_GET)) ?>
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
		<section class="col">
			<section id="content" class="col-12 col-xl">
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
			</section>
		</section>
	</section>
</body>
</html>
