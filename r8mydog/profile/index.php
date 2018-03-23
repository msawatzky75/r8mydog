<!DOCTYPE html>
<html>
<head>
	<title>Details - Profile - r8mydog</title>
	<?php require '../snippet/bootstrap.html'; ?>
</head>
<body>
	<?php require '../snippet/header.php'; ?>
	<section class="container"> <!-- maybe we should do this in js-->
		<?php if (isset($_SESSION['userid'])) : ?>
			<?php if (isset($_GET['details']) || isset($_GET['edit'])) : ?>
				<h1 class="mt-1"><?=$_SESSION['fname'].' '.$_SESSION['lname']?>'s profile <span class='badge badge-info float-right mt-2 d-none d-lg-block'><?=$_SESSION['admin'] ? "Administrator" : "Standard"?></span></h1>
				<hr>
				<form method="post" action="/snippet/updateAndValidate.php">
					<!-- fname -->
					<div class="form-group row">
						<label for="email" class="col-md-2 col-form-label">First Name</label>
						<div class="col-md-10">
							<input type="text" name="fname" <?= isset($_GET['details']) ? 'readonly class="form-control-plaintext"' : 'class="form-control"' ?> id="fname" value="<?=$_SESSION['fname']?>">
						</div>
					</div>

					<!-- lname -->
					<div class="form-group row">
						<label for="email" class="col-md-2 col-form-label">Last Name</label>
						<div class="col-md-10">
							<input type="text" name="lname" <?= isset($_GET['details']) ? 'readonly class="form-control-plaintext"' : 'class="form-control"' ?> id="lname" value="<?=$_SESSION['lname']?>">
						</div>
					</div>

					<!-- email -->
					<div class="form-group row">
						<label for="email" class="col-md-2 col-form-label">Email</label>
						<div class="col-md-10">
							<input type="email" name="email" <?= isset($_GET['details']) ? 'readonly class="form-control-plaintext"' : 'class="form-control"' ?> id="email" value="<?=$_SESSION['email']?>">
						</div>
					</div>

					<!-- buttons -->
					<div class="form-group row justify-content-end">

						<?php if (isset($_GET['details'])) : ?>
							<div class="col-md-2 col-sm-4">
								<a class="btn btn-secondary col-sm-12" href="/profile?edit" name="edit">Edit</a>
							</div>

						<?php elseif (isset($_GET['edit'])): ?>
							<div class="col-md-2 col-sm-4">
								<a class="btn btn-secondary col-sm-12" href="/profile?details">Back</a>
							</div>
							<div class="col-md-2 col-sm-4 mt-2 mt-sm-0">
								<input class="btn btn-primary col-sm-12" name="type" type="submit" value="Update">
							</div>
							<div class="col-md-2 col-sm-4 mt-2 mt-sm-0">
								<input class="btn btn-danger col-sm-12" name="type" type="submit" value="Delete">
							</div>

						<?php endif; ?>
					</div>
				</form>
				<!-- end details veiw -->
			<?php else : ?>

			<?php endif;  //if $_GET ?>
		<?php endif;  //if session is set ?>
	</section>
</body>
</html>
