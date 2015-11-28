<?php
error_reporting(0);
session_start();

$current_root = $_SESSION["current_root"];
include($current_root . "functions/active.php");

if(!include($current_root . "install_session.php")){
	debug("Could not include install_session.php. Path: ".$current_root."install_session.php");
	$fatal = true;
} else {
	debug("Included install_session.php.");
}

$fatal = false;
$debug = $_SESSION["debug"];
if($debug) {
	debug("Debugging enabled.");
	$debug_str = "";
}

$upgrade = $_SESSION["upgrade"];

if(!include($current_root . "functions/active.php")){
	debug("Could not include active.php. Path: ".$current_root."functions/active.php");
	$fatal = true;
} else {
	debug("Included functions/active.php.");
}

if($active != 1) {
	debug("Installer not active");
	die(debug_echo());
}

$root = set_root();
if(!include($root . "user/configuration.php")){
	debug("Could not include user configuration. Path: ".$root."user/configuration.php");
	$fatal = true;
} else {
	debug("Included user configuration.");
}

if($db_user || $db_name || $db_server || $db_pass) {
	die("You've already run the installer, if you wish to run it again delete the contents of core/user/configuration.php");
}

if($_SESSION["db_user"]){
	debug("Session variable for database user found");
	$db_val_u = "value=\"".$_SESSION["db_user"]."\" ";
}
if($_SESSION["db_name"]){
	debug("Session variable for database name found");
	$db_val_n = "value=\"".$_SESSION["db_name"]."\" ";
}
if($_SESSION["db_server"]){
	debug("Session variable for database server found");
	$db_val_s = "value=\"".$_SESSION["db_server"]."\" ";
}


if($fatal) {
	debug("There was a fatal error. Exiting.");
	echo debug_echo();
	?>
    <p class="btn add" onclick="loadData('get_site_input.php')">Back</p>
    <?
	die();
} else {
	if($debug) {
		debug("End of PHP, displaying html.");
		debug_echo();
	}
}
?>

<p class="title-head">Database information</p>

<input type="text" id="db_user" <? echo $db_val_u; ?>/><p class="form-title">&mdash;Database user</p><p class="clear"></p>
<input type="password" id="db_pass" /><p class="form-title">&mdash;Database pass</p><p class="clear"></p>
<input type="text" id="db_name" <? echo $db_val_n; ?>/><p class="form-title">&mdash;Database name</p><p class="clear"></p>
<input type="text" id="db_server" <? echo $db_val_s; ?>/><p class="form-title">&mdash;Database server</p><p class="clear"></p>

<p class="margin"></p>

<p class="btn add" onclick="loadData('write_db_config.php','step5')">Continue</p>