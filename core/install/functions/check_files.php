<?php
error_reporting(0);
session_start();
$fatal = false;

$current_root = $_SESSION["current_root"] = $_POST["current_root"];

if(!include($current_root . "install_session.php")){
	debug("Could not include install_session.php. Path: ".$current_root."install_session.php");
} else {
	debug("Included install_session.php.");
}

if($_POST["debugging"]) {
	debug("Debugging enabled.");
	$debug_str = "";
	$debug = $_SESSION["debug"] = true;
}

if($_POST["upgrading"]) {
	debug("Upgrade enabled.");
	$_SESSION["upgrade"] = true;
}


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
} else {
	debug("Included user configuration.");
}

if($pass) {
	die("You've already run the installer, if you wish to run it again delete the contents of core/user/configuration.php");
}

function file_test($file,$dir,$chmod) {
	global $fatal;
	$return = false;
	if($dir) {
		if(!is_dir($file)) {
			$return = "<span class=\"err\">ERROR: </span>$file is not a directory.";
			$fatal = true;
		}
		if($chmod) {
			if(!is_writable($file)) {
				chmod($file,"0777") or $return = "<span class=\"err\">ERROR: </span>$file is not writable, you will have to change permissions by chmodding the file to 0777.";
				$fatal = true;
			}
		}
	} else {
		if(!is_file($file)) {
			$return = "<span class=\"err\">ERROR: </span>$file is not a file.";
			$fatal = true;
		}
		if($chmod) {
			if(!is_writable($file)) {
				chmod($file,"0777") or $return = "<span class=\"err\">ERROR: </span>$file is not writable, you will have to change permissions by chmodding the file to 0777.";
				$fatal = true;
			}
		}
	}
	if($return) {
		debug($return);
	} else {
		debug("$file was found, no errors reported.");
	}
}

$root = set_root();

file_test($root,true,false);
file_test($root . "admin",true,false);
file_test($root . "user",true,false);
file_test($root . "user/uploads",true,true);
file_test($root . "user/cache",true,true);
file_test($root . "functions",true,false);
file_test($root . "themes",true,false);
file_test($root . "user/configuration.php",false,true);
file_test($root . "functions/session.php",false,false);
file_test($root . "functions/get_entry.php",false,false);

if($fatal) {
	debug("There was a fatal error. Exiting.");
	echo debug_echo();
	?>
    <p class="btn add" onclick="loadData('get_site_input.php')">Try to install anyway?</p>
    <?
	die();
} else {
	if($debug){
		debug("End of PHP, displaying html.");
		debug_echo();
	}
}
?>
<p class="title-head">File check</p>
All files where in place. Please continue!
<p class="margin"></p>

<p class="btn add" onclick="loadData('get_site_input.php')">Continue</p>