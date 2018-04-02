<?php
require 'func.php';
session_start();

$loggedin = loggedIn();
$links = GetNavLinks($loggedin, isset($_SESSION['admin']) ? $_SESSION['admin'] : false);
$form = GetForm($loggedin);
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
		<?= isset($form) ? $form : '' ?>
	</div>
</nav>
