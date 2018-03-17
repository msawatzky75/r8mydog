<?php
$links[1] = '<a class="nav-link" href="/about">About</a>';
$links[0] =
'<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="#" id="navbarPostDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Posts</a>
	<div class="dropdown-menu" aria-labelledby="navbarPostDropdown">
		<a class="dropdown-item" href="/posts">Browse</a>
		<a class="dropdown-item" href="/posts/new">New</a>
	</div>
</li>';
session_start();
$loggedin = false;
if ($_SESSION)
{
	if ($_SESSION['userid'] == "")
	{
		//if empty delete
		session_destroy();
	}
	else
	{
		$loggedin = true;
	}
}
else
{
	if(isset($_COOKIE['userid']))
	{
		//cookies are set, log them in
		$_SESSION['userid'] = $_COOKIE['userid'];
		$_SESSION['fname'] = $_COOKIE['fname'];
		$_SESSION['lname'] = $_COOKIE['lname'];
		$_SESSION['email'] = $_COOKIE['email'];
		$_SESSION['admin'] = $_COOKIE['admin'];
		$loggedin = true;
	}
}
if($loggedin)
{
	$links[2] =
'<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="#" id="navbarAccountDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		'.$_SESSION['fname'].'\'s Account
	</a>
	<div class="dropdown-menu" aria-labelledby="navbarAccountDropdown">
		<a class="dropdown-item" href="/profile?details">View Profile</a>
		<a class="dropdown-item" href="/profile?edit">Edit Profile</a>
		<a class="dropdown-item text-danger" href="/snippet/signOut.php">Sign Out</a>
	</div>
</li>';
	$form =
'<form class="form-inline d-none d-lg-block" action="/search" method="get">
	<div class="input-group btn-group">
		<input type="text" class="form-control" name="search" placeholder="Search">
		<button type="submit" class="btn btn-dark">Search</button>
	</div>
</form>';
	if ($_SESSION['admin'])
	{
		$links[3] =
'<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="#" id="navbarAccountDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Admin Functions
	</a>
	<div class="dropdown-menu" aria-labelledby="navbarAccountDropdown">
		<a class="dropdown-item" href="/admin?editProfiles">Edit Profiles</a>
		<a class="dropdown-item" href="/admin?editPosts">Edit Posts</a>
	</div>
</li>';
	}
}
else
{
	$links[2] = '<a class="nav-link" href="/register">Register</a>';
	$links[3] = '<a class="nav-link" href="/login">Log In</a>';
	$form =
'<form class="form-inline d-none d-lg-block" action="/login" method="post">
	<div class="input-group">
		<input type="email" class="form-control" name="email" placeholder="Email">
		<input type="password" class="form-control" name="password" placeholder="Password">
		<input type="hidden" name="src" value="nav">
		<button type="submit" class="btn btn-dark">Log in</button>
	</div>
</form>';
}
?>
<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
	<a class="navbar-brand" href="/">r8mydog</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
	<div class="collapse navbar-collapse" id="navbarToggle">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			<?php foreach ($links as $key => $value) : ?>
				<li class="nav-item">
					<?= $value ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?= $form ?>
	</div>
</nav>
