<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002-2007 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Administration Page
 * $Id$
 */

?>

<h2>Administration</h2>

<?php

if ($runlevel == 1) {
// If logged in and everything is well, give full access

	print "<p class=\"menu\">
<a href=\"?page=admin\">User List</a> |
<a href=\"?page=admin&amp;action=logout\">Logout</a>
</p>\n";

	$action = addslashes($_GET["action"]);
	$id = addslashes($_GET["id"]);

	// These functions are included from libs/admin.lib.php

	switch ($action) {
		case "change":
			change($id);
			break;
		case "delete":
			delete($id);
			break;
		case "open":
			closed($id, 0);
			break;
		case "close":
			closed($id, 1);
			break;
		default:
			list_users();
	}

} else {
// If not logged in, logged out or something failed, print login form
?>

<form action="?page=admin" method="post">

<table>
	<tr>
		<th class="thv">Username</th>
		<td><input type="text" name="userid" /></td>
	</tr>

	<tr>
		<th class="thv">Password</th>
		<td><input type="password" name="passwd" /></td>
	</tr>
</table>

<p><input type="submit" name="login" value="Login" /></p>

</form>

<?php
	if (!empty($message)) {
		print "<p class=\"message\">$message</p>\n";
	}
}
?>
