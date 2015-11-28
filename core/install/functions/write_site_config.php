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

if($pass) {
	die("You've already run the installer, if you wish to run it again delete the contents of core/user/configuration.php");
}

$new_title = $_SESSION["title"] = $_REQUEST["title"];
$new_user = $_SESSION["user"] = $_REQUEST["user"];
$new_pass = $_REQUEST["pass"];

if($new_user && $new_pass) {
	$salt = substr(md5($new_user),0,15);
	$pass_salted = sha1($new_pass . $salt);
} else {
	$fatal = true;
	debug("There was no valid password/user inputed, please try again");
}

if($fatal) {
	debug("There was a fatal error. Exiting.");
	echo debug_echo();
	?>
    <p class="btn add" onclick="loadData('get_site_input.php')">Back</p>
    <?
	die();
}

debug("Generated password.");

$str = "<?php
\$title = \"".$new_title."\";
\$user = \"".$new_user."\";
\$pass = \"".$pass_salted."\";
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
    <p class="btn add" onclick="loadData('get_site_input.php')">Back</p>
    <?
	die();
}


debug("Configuration file found.");

$file = fopen($path,"w");
if(!$file){
	debug("<span class=\"err\">ERROR</span>: Could not open file in write mode, permission error, be sure file is CHMOD to 0777");
	$fatal = true;
}else{
	if(!fwrite($file, $str)){
		debug("<span class=\"err\">ERROR</span>: File was emptied but could not be written to. File is still blank");
		$fatal = true;
	}
}

if($fatal) {
	debug("There was a fatal error. Exiting.");
	echo debug_echo();
	?>
    <p class="btn add" onclick="loadData('get_site_input.php')">Back</p>
    <?
	die();
} else {
	debug("Configuration saved.");
	if($debug) {
		debug("End of PHP, displaying html.");
		debug_echo();
	}
}
?>
<p class="title-head">Configuration written!</p>

Please continue!

<p class="margin"></p>

<p class="btn add" onclick="loadData('get_db_input.php')">Continue</p>