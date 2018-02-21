<?php
session_start();
session_destroy();
//remove cookies

header("location:/");
?>
