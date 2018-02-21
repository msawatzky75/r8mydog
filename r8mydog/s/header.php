<?php
$links[0] = '<a class="nav-link" href="browse.php">Browse</a>';
$links[1] = '<a class="nav-link" href="about.php">About</a>';
session_start();
if ($_SESSION)
{
	$links[2] = '<a class="nav-link" href="profile.php">'.$_SESSION['fname'].'\'s Profile</a>';
}
else
{
	$links[2] = '<a class="nav-link" href="register.php">Register</a>';
}
?>
<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
	<a class="navbar-brand" href="/">r8mydog</a>
	<ul class="navbar-nav">
		<?php foreach ($links as $key => $value) : ?>
			<li class="nav-item">
				<?= $value ?>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
