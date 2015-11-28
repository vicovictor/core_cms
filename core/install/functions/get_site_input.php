<?php
error_reporting(0);
session_start();

$current_root = $_SESSION["current_root"];

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

include($current_root . "functions/active.php");

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

if($pass) {
	die("You've already run the installer, if you wish to run it again delete the contents of core/user/configuration.php");
}

if($_SESSION["title"]){
	debug("Session variable \"title\" found");
	$db_val_t = "value=\"".$_SESSION["title"]."\" ";
}
if($_SESSION["user"]){
	debug("Session variable \"user\" found");
	$db_val_u = "value=\"".$_SESSION["user"]."\" ";
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

<p class="title-head">Core configuration</p>
<form>
<input type="text" id="title" <? echo $db_val_t; ?>/><p class="form-title">&mdash;Website title</p><p class="clear"></p>
<input type="text" id="user" <? echo $db_val_u; ?>/><p class="form-title">&mdash;User</p><p class="clear"></p>
<input type="password" id="pass" /><p class="form-title">&mdash;Pass</p><p class="clear"></p>
</form>
<p class="margin"></p>
These options aren't permanent and can be changed whenever you want through the admin login.
<p class="margin"></p>

<p class="btn add" onclick="loadData('write_site_config.php')">Continue</p>