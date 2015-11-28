<?
error_reporting(0);
$active = "";

$current_root = getenv('DOCUMENT_ROOT') . $_SERVER['REQUEST_URI'];
include($current_root . "install_session.php");
include($current_root . "functions/active.php");

if($active != 1) {
	die("installer not active");
}

$root = set_root();
require($root . "/user/configuration.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CORE Install</title>
<link rel="stylesheet" type="text/css" href="../admin/style.css"/>
<link rel="stylesheet" type="text/css" href="style.css"/>
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
var loaderElem = "<img src='../admin/ajax-loader.gif' />";

function loadData(url) {
	var vars = "";
		
	$(":input[checked],:input[type!=checkbox]").each(function(){
		vars = vars + $(this).attr("id") + "=" + encodeURIComponent($(this).val()) + "&";
	});
	
	var url = "functions/" + url;
	
	$("#content").html(loaderElem);
	
	$.ajax({
		type: "POST",
		url: url,
		data: vars,
		success: function(data){
			$("#content").html(data);
   		}
 	});
}
</script>
</head>

<body>
<?

if($pass) {
	die("You've already run the installer, if you wish to run it again delete the contents of core/user/configuration.php");
}

if(ini_get('register_globals')) {
	die("You have \"register globals\" on in your PHP configuration, Core was not designed with this in mind, and will not be able to install if you don't turn them off. <a href=\"http://www.google.com/search?q=turn+off+register+globals\" target=\"_blank\">Google search</a>");
}
?>
<div id="content">
<p class="title-head">Licence</p>
Core CMS v1.21<br /><br />

Copyright (C) 2009  Simon Jakobsson<br /><br />

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.<br /><br />

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
<p class="margin"></p>
<p class="title-head">CORE Installer</p>
This is the installer of Core v1.21<br /><br />

During installing you will be prompted for your database information, so you might aswell look that up now.<br /><br />

Here are a few options to the installer, if this is the first time you are using Core, you probably should leave the checkboxes unchecked.<br /><br />

If you are upgrading from v05/v06, be sure to use the same database information as your old core version does. The upgrader won't touch your old data, so you can run both versions simultaneously.
<p class="margin"></p>
<form>
<p class="form-obj">
<input id="upgrading" type="checkbox" />Upgrading?</p>
<p class="form-obj">
<input id="debugging" type="checkbox" />Debugging?</p>
<p class="clear"></p>
<input id="current_root" type="hidden" value="<? echo $current_root; ?>" />
</form>

<p class="btn add" onclick="loadData('check_files.php')">Continue</p>
</div>

</body>
</html>