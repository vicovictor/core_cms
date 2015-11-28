<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Generate pass</title>
</head>

<body>
<?php
	if($_POST["pass"] && $_POST["username"]) {
		$user = $_POST["username"];
		$pass = $_POST["pass"];
		$salt = substr(md5($user),0,15);
		$pass_salted = $pass . $salt;
		echo sha1($pass_salted);
		echo "<br />";
		echo "Now put this string of characters into the \$pass variable in core/user/configuration.php, make sure that your \$user variable matches the name you put in here.<br /> Then you can delete this file (passgen.php) from the server<br />";
	} else {
	?>
    <form action="passgen.php" method="post">
    <input name="username" type="text" /> Username<br />
    <input name="pass" type="password" /> Password<br />
    <input type="submit" value="generate pass" />
    </form>
	<?
	}
?>
</body>
</html>