<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002-2004 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Main File
 * $Id$
 */

// Configuration
if (file_exists("config.inc.php")) {
	require("config.inc.php");
} else {
	die("Please copy 'config.inc.php-example' to 'config.inc.php' and edit it to fit your setup.");
}

// Libraries
require("libs/auth.lib.php");
require("libs/admin.lib.php");
require("libs/common.lib.php");

// PEAR
/*
$required_files_path = $DOCUMENT_ROOT . "/libs/pear";
ini_set("include_path", ini_get("include_path") . ":" . $required_files_path);
require_once("DB.php");
*/

// Database
$link = mysql_connect($db_host, $db_user, $db_password);
mysql_select_db($db_name);

// Database
/*
$dsn = "$db_type://$db_user:$db_pass@$db_host/$db_name";
$db =& DB::connect($dsn, true);

if (DB::isError($db)) {
        die($db->getMessage());
}
*/

// Prepare subpage
$page = $HTTP_GET_VARS["page"];

if (empty($page)) {
	$page = "main";
}

// Admin
if ($page == "admin") {

	// Runlevel
	$runlevel = 0;

	// If cookie is set
	if ($HTTP_COOKIE_VARS["proma"] != "" && $HTTP_GET_VARS["action"] != "logout") {
		$runlevel = check_cookie();

		if ($runlevel == 0) {
			$message = "The session has timed out.";
		}
	}

	// If login info is entered
	if (!empty($HTTP_POST_VARS["login"])) {
		$runlevel = login();

		if ($runlevel == 0) {
			$message = "Wrong username or password, or you're not an admin.";
		}
	}

	// If logout-link is clicked
	if ($HTTP_GET_VARS["action"] == "logout") {
		$runlevel = logout();

		if ($runlevel == 0) {
			$message = "Logged out.";
		}
	}

}

// Top
print "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>ProMA - <?php print $info_host; ?></title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

<h1>ProMA - <?php print $info_host; ?></h1>

<p class="menu">
<a href="?page=main">Information / Statistics</a> |
<a href="?page=register">Register Account</a> |
<a href="?page=change">Change Account Information</a> |
<a href="?page=admin">Administration</a>
</p>

<?php

// Main
// Include the content of the page

$filename = "pages/$page.inc.php";

if (file_exists($filename)) {
	include($filename);
} else {
	print "<h2>File not found</h2>\n";
}

// Bottom
?>

<p class="bottom">
<a href="http://proma.sourceforge.net/">ProMA 0.8.2</a> &#149;
Copyright &copy; 2002-2004 <a href="http://www.jodal.no/">Stein Magnus Jodal</a>. All rights reserved. &#149;
Distributed under the GNU General Public License.
</p>

</body>

</html>
