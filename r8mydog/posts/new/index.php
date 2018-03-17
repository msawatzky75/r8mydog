<!DOCTYPE html>
<html>
<head>
	<title>r8mydog - New Post</title>
	<?php include '../../snippet/bootstrap.html'; ?>
	<link rel="stylesheet" href="/styles/img-preview.css">
	<script src="/js/img-preview.js"></script>

</head>
<body>
	<?php include '../../snippet/header.php'; ?>
	<section class="container">
			<form action="/snippet/insertAndValidate.php" method="post">
				<h2 class="text-center mt-3">Create a new post</h2>

				<div class="row">
					<div class="col-xl-6 col-12">
						<div class="form-group">
							<input type="file" class="d-flex m-auto text-center" id="dogImgControl" accept="image/*" name="dog" required />
							<div id="imgContain" class="m-auto">
								<img id="dogImgPreview" src="/images/noImageSelected.svg" alt="preview" class="d-block m-auto">
							</div>
						</div>
					</div>

					<div class="col-xl-6 col-12">
						<div class="form-group">
							<label for="title" class="d-block text-center">Title</label>
							<input id="title" type="text" class="d-block m-auto" name="title" required />
						</div>

						<div class="form-group">
							<label for="description" class="d-block text-center">Description</label>
							<textarea id="description" class="d-block m-auto" name="description" rows="4" cols="50" maxlength="200">My beautiful dog.</textarea>
						</div>

						<input type="hidden" name="type" value="post" />
						<input id="submit" type="submit" name="submit" value="Post" class="btn btn-primary d-block m-auto" />
					</div>
				</div>
			</form>
	</section>
</body>
</html>
