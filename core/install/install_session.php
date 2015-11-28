<?

function set_root() {
	$b = $_SERVER['REQUEST_URI'];
	$b = substr($b,0,mb_strrpos($b,"/core/")+6);
	$id = $_REQUEST["id"];
	$root = $_SERVER['DOCUMENT_ROOT'] . $b;
	return $root;
}

function check_table($table) {
	$sql = "desc $table";
	if(mysql_query($sql)) {
		return true;
	} else {
		return false;
	}
}

function debug($str) {
	global $debug_str;
	$debug_str = $debug_str . "<br />" . $str;
}

function debug_echo() {
	echo "<p class=\"title-head\">Debug</p>";
	global $debug_str;
	echo "<p class=\"margin\"></p>";
	echo $debug_str;
	echo "<p class=\"margin\"></p>";
}

?>