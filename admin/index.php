<!DOCTYPE html>
<html>
<head>
	<title>Browse - r8mydog</title>
	<?php require "../snippet/bootstrap.html"; ?>
	<link rel="stylesheet" href="admin.css">
</head>
<body>
	<?php require "../snippet/header.php"; ?>
	<?php
	if (!(isset($_SESSION["admin"]) ? $_SESSION["admin"] : false))
	{
		header("location:/");
		die();
	}
	if (!isset($_GET["table"]) || !in_array($_GET["table"], array("posts", "ratings", "users")))
	{
		header("location:/admin?table=posts");
		die();
	}
	include "tableData.php";
	?>
	<section class="container">
		<br>
		<h3 class="text-center">Administration</h3>
		<br>

		<ul class="nav nav-tabs">
			<?php $pages = array("posts", "ratings", "users");
			foreach ($pages as $value): ?>
				<li class="nav-item">
					<a href="?table=<?=$value?>" class="text-capitalize nav-link<?=$_GET["table"] == $value ? " active" : ""?>"><?=$value?></a>
				</li>
			<?php endforeach; ?>
		</ul>

		<table class="table table-sm table-striped table-responsive-xl table-hover">
			<thead>
				<tr>
					<?php foreach ($columnNames as $value) : ?>
							<th class="border-top-0" scope="col"><?=$value["column_name"]?></th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($rowData as $row) : ?>
					<tr id="post-<?=$row["postid"]?>">
						<?php foreach ($row as $key => $value): ?>
							<?php if (!is_numeric($key)) : //not the numeric indexed ones, leave out the doubles ?>
								<td>
									<?php switch ($key) {
										case "postid":
											?><a href="/post?id=<?=$value?>"><?=$value?></a><?php
											break;
										case "userid":
											?><a href="/post?userid=<?=$value?>"><?=$value?></a><?php
											break;
										case "ratingid":
											?><a href="/post?id=<?=$row["postid"]?>#rating-<?=$value?>"><?=$value?></a><?php
											break;
										default:
											?><?=$value?><?php
											break;
									} ?>
								</td>
							<?php endif; ?>
						<?php endforeach; ?>
						<td>
							<form method="post" action="/snippet/delete.php">
								<input type="hidden" name="type" value="<?=$_GET["table"]?>" />
								<input type="hidden" name="return" value="/admin?table=<?=$_GET["table"]?>" />
								<?php //figue out value for button
								$value = 0;
								switch ($_GET["table"])
								{
									case "posts":
										$value = $row["postid"];
										break;
									case "ratings":
										$value = $row["ratingid"];
										break;
									case "users":
										$value = $row["userid"];
										break;
								}
								?>
								<button type="submit" class="btn btn-sm btn-danger" name="delete" value="<?=$value?>">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<br>
	</section>
</body>
</html>
