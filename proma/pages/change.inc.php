<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002-2004 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Change Account Information Page
 * $Id$
 */

?>

<h2>Change Account Information</h2>

<?php

if (!empty($HTTP_POST_VARS[submit])) {
// If the change form is submitted and should be processed

$old_userid	= addslashes($HTTP_POST_VARS[old_userid]);
$old_passwd	= addslashes($HTTP_POST_VARS[old_passwd]);
$new_userid	= addslashes($HTTP_POST_VARS[new_userid]);
$new_passwd1	= addslashes($HTTP_POST_VARS[new_passwd1]);
$new_passwd2	= addslashes($HTTP_POST_VARS[new_passwd2]);

if ($old_userid == "" || $old_passwd == "" || $new_passwd1 != $new_passwd2) {
	print "<p>Old userid or password is empty, or new passwords are not identical. <a href=\"?page=change\">Try again</a></p>\n";
} else {
	
	if ($new_userid == "" && $new_passwd1 != "") {
		$query = "UPDATE
				$table_users
			SET
				$users_passwd = PASSWORD('$new_passwd1')
			WHERE
				$users_userid = '$old_userid' AND
				$users_passwd = PASSWORD('$old_passwd')";
	} elseif ($new_userid != "" && $new_passwd1 == "") {
		$query = "UPDATE
				$table_users
			SET
				$users_userid = '$new_userid'
			WHERE
				$users_userid = '$old_userid' AND
				$users_passwd = PASSWORD('$old_passwd')";
	} elseif ($new_userid != "" && $new_passwd1 != "") {
		$query = "UPDATE
				$table_users
			SET
				$users_userid = '$new_userid',
				$users_passwd = PASSWORD('$new_passwd1')
			WHERE
				$users_userid = '$old_userid' AND
				$users_passwd = PASSWORD('$old_passwd')";
	}

	if (isset($query)) {
		$result = mysql_query($query) or die("Failed to query database.");
		$affected = mysql_affected_rows($link);

		if ($affected == 1) {
			print "<p>Changes performed without problems.</p>\n";
		} elseif ($affected == 0) {
			print "<p>Error: Possible password mismatch. <a href=\"?page=change\">Try again</a></p>\n";
		}
	} else {
		print "<p>No values to update with. <a href=\"?page=change\">Try again</a></p>\n";
	}
}

} else {
// If the change form is not submitted, print it
?>

<form action="?page=change" method="post">

<h3>Old Information</h3>

<table>
	<tr>
		<th class="thv">Userid</th>
		<td><input type="text" name="old_userid" /> Required</td>
	</tr>

	<tr>
		<th class="thv">Password</th>
		<td><input type="password" name="old_passwd" /> Required</td>
	</tr>
</table>

<h3>New Information</h3>

<table>
	<tr>
		<th class="thv">Userid</th>
		<td><input type="text" name="new_userid" />
			Only required if changing userid</td>
	</tr>

	<tr>
		<th class="thv">Password</th>
		<td><input type="password" name="new_passwd1" />
			Only required if changing password</td>
	</tr>

	<tr>
		<th class="thv">Password</th>
		<td><input type="password" name="new_passwd2" />
			Repeat password if changing</td>
	</tr>
</table>

<p><input type="submit" name="submit" value="Change" /></p>

</form>

<?php
}
?>
