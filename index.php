<?php
session_start();

$b = $_SERVER['REQUEST_URI'];
$b = substr($b,0,strrpos($b,"/"))."/core/";
$root = $_SERVER['DOCUMENT_ROOT'] . $b;
$http = "http://" . $_SERVER['HTTP_HOST'] . substr($b,0,strlen($b)-5);

require_once($root . "user/configuration.php");
require_once($root . "functions/session.php");
require_once($root . "themes/" . $theme . "/configuration.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<base href="<? echo $http; ?>" />
<title><? echo $title ?></title>
<? require_once($root . "head.php"); ?>
<? if($use_rss == 1) { ?><link href="core/rss-feed.php" type="application/rss+xml" rel="alternate"><? } ?>
<? LOAD_THEME(); ?>
</head>
<body>

<?
$entry = $_GET["entry"];
if(is_numeric($entry)) {
	require_once($root . "functions/get_entry.php");
} else {
	require_once($theme_path . "index.php");
}
?>

</body>
</html>