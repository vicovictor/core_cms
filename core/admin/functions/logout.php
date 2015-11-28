<?php

$b = $_SERVER['REQUEST_URI'];
$b = substr($b,0,mb_strrpos($b,"/core/"));
$http = "http://" . $_SERVER['HTTP_HOST'] . substr($b,0,strlen($b));

	session_start();
	session_unregister("password");
	session_unregister("sessid");
	session_destroy();
	header('location:'.$http);
?>
