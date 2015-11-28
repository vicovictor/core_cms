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

$new_db_user = $_SESSION["db_user"] = $_REQUEST["db_user"];
if(!$new_db_user){
	debug("No input for variable \"db_user\" (database user).");
}
$new_db_pass = $_REQUEST["db_pass"];
if(!$new_db_user){
	debug("No input for variable \"db_pass\" (database pass).");
}
$new_db_name = $_SESSION["db_name"] = $_REQUEST["db_name"];
if(!$new_db_user){
	debug("No input for variable \"db_name\" (database name).");
}
$new_db_server = $_SESSION["db_server"] = $_REQUEST["db_server"];
if(!$new_db_user){
	debug("No input for variable \"db_server\" (database server).");
}

if($fatal) {
	debug("There was a fatal error. Exiting.");
	echo debug_echo();
	?>
    <p class="btn add" onclick="loadData('get_db_input.php')">Back</p>
    <?
	die();
}

$connection = mysql_connect($new_db_server, $new_db_user, $new_db_pass);
if(!$connection){
	debug("<span class=\"err\">ERROR</span>: There was an error connecting to the database server");
	debug(mysql_error());
	$fatal = true;
}

if($fatal) {
	debug("There was a fatal error. Exiting.");
	echo debug_echo();
	?>
    <p class="btn add" onclick="loadData('get_db_input.php')">Back</p>
    <?
	die();
}

if(!mysql_select_db($new_db_name, $connection)){
	debug("<span class=\"err\">ERROR</span>: There was an error selecting the database");
	debug(mysql_error());
	$fatal = true;
}

if($fatal) {
	debug("There was a fatal error. Exiting.");
	echo debug_echo();
	?>
    <p class="btn add" onclick="loadData('get_db_input.php')">Back</p>
    <?
	die();
}

$str = 
"<?php
\$title = \"".$title."\";
\$theme = \"darkthumbs\";
\$user = \"".$user."\";
\$pass = \"".$pass."\";
\$db_user = \"".$new_db_user."\";
\$db_pass = \"".$new_db_pass."\";
\$db_name = \"".$new_db_name."\";
\$db_server = \"".$new_db_server."\";
\$show_empty = 0;
\$use_rss = 0;	
?>";

$path = $root . "user/configuration.php";

if(!is_file($path)) {
	$fatal = true;
	debug("<span class=\"err\">ERROR</span>: $path was not found");
}

if($fatal) {
	debug("There was a fatal error. Exiting.");
	echo debug_echo();
	?>
    <p class="btn add" onclick="loadData('get_db_input.php')">Back</p>
    <?
	die();
}

if(!fopen($path,"w")){
	debug("<span class=\"err\">ERROR</span>: Could not open file in write mode, permission error, be sure file is CHMOD to 0777");
	$fatal = true;
} else {
	$file = fopen($path,"w");
}

if(!fwrite($file, $str)){
	debug("<span class=\"err\">ERROR</span>: File was emptied but could not be written to. File is still blank");
	$fatal = true;
}

if($fatal) {
	debug("There was a fatal error. Exiting.");
	echo debug_echo();
	?>
    <p class="btn add" onclick="loadData('get_db_input.php')">Back</p>
    <?
	die();
} else {
	debug("Database configuration saved.");
	if($debug) {
		debug("End of PHP, displaying html.");
		debug_echo();
	}
}
?>

<p class="title-head">Database working!</p>

Please continue to creation of database tables, note that this will not remove or change any information that you currently have in existing database tables.

<p class="margin"></p>
<p class="btn add" onclick="loadData('create_db_tables.php','step5')">Continue</p>