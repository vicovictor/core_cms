<?php
error_reporting(0);
session_start();

function s($str) {
	return addslashes($str);
}

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

$connection = mysql_connect($db_server, $db_user, $db_pass);
if(!$connection){
	debug("<span class=\"err\">ERROR</span>: There was an error connecting to the database server");
	debug(mysql_error());
	$fatal=true;
}else{
	debug("Connected to database server.");
	if(!mysql_select_db($db_name, $connection)){
		debug("<span class=\"err\">ERROR</span>: There was an error selecting the database");
		debug(mysql_error());
		$fatal=true;
	}
}


if($fatal) {
	debug("There was a fatal error. Exiting.");
	echo debug_echo();
	?>
    <p class="btn add" onclick="loadData('get_db_input.php')">Back</p>
    <?
	die();
}

if(!check_table("core_entries")){
	debug("Creating table \"core_entries\"");
	if(!mysql_query("
	CREATE TABLE `core_entries` (
	`entry_id` int(10) unsigned NOT NULL auto_increment,
	`entry_position` int(11) NOT NULL default '0',
	`entry_date` date NOT NULL default '0000-00-00',
	`entry_title` varchar(255) NOT NULL default '',
	`entry_text` text NOT NULL,
	`entry_client` varchar(255) NOT NULL default '',
	`entry_extra1` text NOT NULL,
	`entry_extra2` text NOT NULL,
	`entry_new` smallint(6) NOT NULL default '1',
	`entry_show` smallint(6) NOT NULL default '1',
	`hits` int(10) unsigned NOT NULL default '0',
	PRIMARY KEY  (`entry_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
	")){
		debug("<span class=\"err\">ERROR</span>: There was an error creating table \"core_entries\"");
		debug(mysql_error());
		$fatal = true;
	}
}else{
	debug("Table core_entries does already exist, skipping creation");
}


if($upgrade) {
	debug("Transferring from old tables");
	if(check_table("data")) {
		$entries = mysql_query("SELECT * FROM `data`");
		$i = 0;
		
		$new = mysql_query("SELECT * FROM `core_entries`");
		if(mysql_num_rows($new) < 1) {
			while($e = mysql_fetch_array($entries)) {
				$entry_date = s($e['DATE']);
				$entry_title = s($e['TITLE']);
				$entry_text = s($e['TEXT']);
				$entry_client = s($e['CLIENT']);
				$entry_extra1 = s($e['EXTRA']);
				$entry_extra2 = s($e['EXTRA2']);
				$entry_new = $e['NEW'];
				
				if(!mysql_query("
					INSERT INTO `core_entries` (
					`entry_position`,
					`entry_date` ,
					`entry_new`,
					`entry_title` ,
					`entry_text` ,
					`entry_client` ,
					`entry_extra1` ,
					`entry_extra2`
					) VALUES (
					$i, \"$entry_date\", $entry_new, \"$entry_title\", \"$entry_text\", \"$entry_client\", \"$entry_extra1\", \"$entry_extra2\"
					);")){
						debug(mysql_error()); 
				   }
				
				$i++;
			}	
		} else {
			debug("There is already content in core_entries. No transfer of old content made");
		}
	} else {
		debug("No table with the name \"data\" found, no transfer of old content made");
	}
}


if(!check_table("core_entry2tag")){
	debug("Creating table \"core_entry2tag\"");
	if(!mysql_query("
CREATE TABLE `core_entry2tag` (
  `entry_id` int(10) unsigned NOT NULL default '0',
  `tag_id` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
")){
		debug("<span class=\"err\">ERROR</span>: There was an error creating table \"core_entries\"");
		debug(mysql_error());
		$fatal = true;
	}
}else{
	debug("Table core_entry2tag does already exist, skipping creation");
}

if(!check_table("core_pages")){
	debug("Creating table \"core_pages\"");
	if(!mysql_query("
CREATE TABLE `core_pages` (
  `page_id` smallint(5) unsigned NOT NULL auto_increment,
  `page_title` varchar(255) NOT NULL default '',
  `page_url` varchar(30) NOT NULL default '',
  `page_position` smallint(5) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`page_id`),
  UNIQUE KEY `page_title` (`page_title`,`page_url`,`page_position`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
")){
		
		debug("<span class=\"err\">ERROR</span>: There was an error creating table \"core_entries\"");
		debug(mysql_error());
		$fatal = true;
	}
}else{
	debug("Table core_pages does already exist, skipping creation");
}

if(!check_table("core_tags")){
	debug("Creating table \"core_tags\"");
	if(!mysql_query("
CREATE TABLE `core_tags` (
  `tag_id` int(10) unsigned NOT NULL auto_increment,
  `tag_text` varchar(255) character set latin1 NOT NULL default '',
  `tag_position` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tag_id`),
  UNIQUE KEY `tag_text` (`tag_text`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
")){
		
		debug("<span class=\"err\">ERROR</span>: There was an error creating table \"core_entries\"");
		debug(mysql_error());
		$fatal = true;
	}
}else{
	debug("Table core_tags does already exist, skipping creation");
}

if($fatal) {
	debug("There was a fatal error. Exiting.");
	echo debug_echo();
	?>
    <p class="btn add" onclick="loadData('get_db_input.php')">Back</p>
    <?
	die();
} else {
	debug("Database tables created.");
	if($debug) {
		debug("End of PHP, displaying html.");
		debug_echo();
	}
}
?>

<p class="title-head">Tables created!</p>

You are all done, please continue to the summary.

<p class="margin"></p>
<p class="btn add" onclick="loadData('summary.php')">Continue</p>