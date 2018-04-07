<?php
require 'func.php';
session_start();

$loggedin = LoggedIn();
$links = GetNavLinks($loggedin, isset($_SESSION['admin']) ? $_SESSION['admin'] : false);
if ($loggedin)
{
	//update session
	require 'setSession.php';
	SetSession($_SESSION['userid']);
}
?>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
	<a class="navbar-brand" href="/">r8mydog</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarToggle">
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			<?php foreach ($links as $key => $value) : ?>
					<?= $value ?>
			<?php endforeach; ?>
		</ul>
		<form class="form-inline d-none d-lg-block" action="/post/search" method="get">
			<div class="input-group btn-group">
				<input type="text" class="form-control" name="postTitle" placeholder="Search">
				<button type="submit" class="btn btn-primary mr-2">Search</button>
			</div>
		</form>
		<?php if ($loggedin) : ?>
			<div class="d-none d-lg-block">
				<a href="/snippet/signOut.php" class="btn btn-danger">Sign Out</a>
			</div>
		<?php else : ?>
			<div class="d-none d-lg-block">
				<a href="/login" class="btn btn-success">Log In / Register</a>
			</div>
		<?php endif; ?>
	</div>
</nav>
