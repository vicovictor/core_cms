<?php
error_reporting(0);
session_start();
$active_disable = false;
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
	debug("<span class=\"err\">ERROR</span>: Could not include user configuration. Path: ".$root."user/configuration.php");
	$fatal = true;
} else {
	debug("Included user configuration.");
}

unset($_SESSION['db_name']);
unset($_SESSION['db_server']);
unset($_SESSION['db_user']);
unset($_SESSION['title']);
unset($_SESSION['user']);
debug("Deleted stored session variables");

$file = fopen($current_root . "functions/active.php","w");
if(!$file) {
	debug("<span class=\"err\">ERROR</span>: Can't open active file.");
	$active_disable = true;
}

$str = "<?
\$active = 0; 
?>";

if(!fwrite($file, $str)){
  debug("<span class=\"err\">ERROR</span>: Could not write to active.php, installer still active");
	$active_disable = true;
}
?>	

<p class="title-head">Summary</p>
<?
if($active_disable){
?>
The installer was not able to deactivate itself. You can either modify the "active"-file youself it's located at install/functions/active.php, change the variable to 0. Other than that all appeards to have went well.<br /><br />
<?
} else {
?>
All appears to have went well. The installer has now deactivated itself to disallow anyone from using it/having any possibility at all to access stored data. You can reactivate it in the admin panel. But don't make a habbit of having it activated if not using it.<br /><br />
<?
}
?>

I encourage you to give me bug information, feedback and general thoughts about this, still young, CMS.<br />
I want you to include a link back to <a href="http://core.weareastronauts.org/" target="_blank">Core</a> but other than that there are no requirements, if you feel generous and you enjoy using Core, don't hesitate to make a <a href="http://weareastronauts.org/core-cms/" target="_blank">donation</a>, any contribution is very appreciated.<br /><br />
<?
if($upgrade){
	?>
The installer transfered the old data into new tables, but it did not copy the data (entry folders, images, sound, media), so you have to do this youself, move/copy the old folders to "core/user/uploads/" and upload it to your server.
<p class="margin"></p>
<p class="title-head">Options</p>

<form>
<input type="password" id="pass" /><p class="form-title">&mdash;Pass</p><p class="clear"></p>
</form>
<p class="margin"></p>
   <p class="btn add" onclick="loadData('delete_old_db.php')">Remove old database tables</p><p class="clear"></p>

<?
}
?>

<p class="margin"></p>

<p class="title-head">What now?</p>

Well, I suggest you start adding some content to the CMS aswell as check out the configuration settings. By default, entries made won't show up unless you put some content in the entry folder (all explained in the admin panel).<br /><br />

If you forget your password, some manual interaction with the configuration file is required, run passgen.php which was included in the Core_CMS_v1.21.zip file and follow the instructions.

<a href="../admin/" target="_blank">Link to the admin panel</a><br /><br />
