<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002-2004 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Register Account Page
 * $Id$
 */

?>

<h2>Register Account</h2>

<?php

if (!empty($HTTP_POST_VARS["submit"])) {
// If the register form is submitted and should be processed

$passwd1	= addslashes($HTTP_POST_VARS[passwd1]);
$passwd2	= addslashes($HTTP_POST_VARS[passwd2]);
$userid		= addslashes($HTTP_POST_VARS[userid]);
$name		= addslashes($HTTP_POST_VARS[name]);
$mail		= addslashes($HTTP_POST_VARS[mail]);

if ($userid == "" || $passwd1 == "") {
	print "<p>Username or password is empty. <a href=\"?page=register\">Try again</a></p>\n";
} elseif ($passwd1 != $passwd2) {
	print "<p>The passwords are not identical. <a href=\"?page=register\">Try again</a></p>\n";
} else {
	$query = "SELECT
			PASSWORD('$passwd1')";
	$result = mysql_query($query) or die("Database query failed.");

	$enc_passwd = mysql_fetch_array($result);
	// rot13 on the encrypted password disables access, and can be reversed to
	// open for access again. A bit dirty, but it works.
	$rot13_passwd = rot13($enc_passwd[0]);

	$query = "INSERT INTO
		 	$table_users
		SET
			$users_userid	= '$userid',
			$users_name	= '$name',
			$users_mail	= '$mail',
			$users_uid	= '$users_uid_default',
			$users_gid	= '$users_gid_default',
			$users_passwd	= '$rot13_passwd',
			$users_shell	= '$users_shell_default',
			$users_homedir	= '$users_homedir_default',
			$users_count	= 0,
			$users_admin	= 0,
			$users_closed	= 1";
	$result = mysql_query($query) or die("Database query failed.");

	if ($mail_notify_new_user) {
		mail(admin_mail(),
			"ProMA - $info_host - New user",
"A new user has registered and is waiting for your authorization.

Username: $userid
Name: $name
Mail: $mail

-- 
ProMA at $info_host",
			"From: $mail_from\n"
			."X-Mailer: PHP/" . phpversion());
	}

	print "<p>You are registered. When an admin accepts your registration, you can connect using the information on the main page.</p>";
}

} else {
// If the register form is not submitted, print it

?>

<form action="?page=register" method="post">

<table>
	<tr>
		<th class="thv">Username</th>
		<td><input type="text" name="userid" /> Your login</td>
	</tr>
	<tr>
		<th class="thv">Name</th>
		<td><input type="text" name="name" /> Your full real name</td>
	</tr>
	<tr>
		<th class="thv">Mail</th>
		<td><input type="text" name="mail" /> Your mail adress</td>
	</tr>
	<tr>
		<th class="thv">Password</th>
		<td><input type="password" name="passwd1" /></td>
	</tr>
	<tr>
		<th class="thv">Password</th>
		<td><input type="password" name="passwd2" /> And again</td>
	</tr>
</table>

<?php
if (!empty($policy)) {
	print "<p>$policy</p>\n";
}
?>
	
<p><input type="submit" name="submit" value="Register" /></p>

</form>

<?php
}
?>
