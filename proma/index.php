<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002-2003 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Main File
 * $Id$
 */

// Config
require("config.inc.php");
require("libs/auth.lib.php");
require("libs/admin.lib.php");
require("libs/common.lib.php");

// Database
$link = mysql_connect($db_host, $db_user, $db_password);
mysql_select_db($db_name);

// Prepare subpage
$page = $HTTP_GET_VARS["page"];

if (!isset($page))
  $page = "main";

// Admin
if ($page == "admin") {

  // Runlevel
  $runlevel = 0;

  // If cookie is set
  if ($HTTP_COOKIE_VARS["proma"] != "" && $HTTP_GET_VARS["action"] != "logout") {
    $runlevel = check_cookie();
    if ($runlevel == 0)
      $message = "The session has timed out.";
  }

  // If login info is entered
  if ($HTTP_POST_VARS["login"] == 1) {
    $runlevel = login();
    if ($runlevel == 0)
      $message = "Wrong username or password, or you're not an admin.";
  }

  // If logout-link is clicked
  if ($HTTP_GET_VARS["action"] == "logout") {
    $runlevel = logout();
    if ($runlevel == 0)
      $message = "Logged out.";
  }

}

// Top
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
<a href="?page=main">Main</a> |
<a href="?page=register">Register</a> |
<a href="?page=change">Change</a> |
<a href="?page=admin">Admin</a>
</p>

<?php

// Main
// Include the content of the page

$filename = "pages/$page.inc.php";

if (file_exists($filename))
  include($filename);
else
  print "<h2>File not found</h2>\n";

// Bottom
?>

<hr />

<p class="bottom">
<a href="http://www.jodal.no/projects/proma/">ProMA 0.8 (ProFTPd MySQL Admin)</a><br />
Copyright &copy; 2002-2003 <a href="http://www.jodal.no/">Stein Magnus Jodal</a>. All rights reserved.<br />
Distributed under the GNU General Public License.
</p>

</body>

</html>
