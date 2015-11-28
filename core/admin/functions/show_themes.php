<?
error_reporting(0);
require("_headr.php");
if($_SESSION["password"] != $pass || $_SESSION["sessid"] != session_id()) die(logout());

debug("Password validated, logged in",0);
?>
<p class="title-head">Style/Layout</p>
These are the folders that are inside core/themes/. To use another theme, see CONFIGURATION.
<p class="margin"></p>
<fieldset>
<legend>Themes</legend>
<?

$th_arr = search_folder($root . "themes");
foreach($th_arr as $th) {
	$s = "";
	if($th == $theme)
		$s = " (Currently used)";
	else
		$s = "";
	echo 	"<p class=\"list-item\">\n
			<b><span class=\"list-link\" onclick=\"get_data('get_edit_theme',{'id':'$th'})\">$th</span></b>$s<br />\n
			</p>\n";
   
}
?>
</fieldset>