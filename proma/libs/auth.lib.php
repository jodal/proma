<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002-2004 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Authorization Library
 * $Id$
 */

function login()
{
// Performs the login and the initial creation of the cookie

	global $HTTP_POST_VARS, $users_userid, $users_passwd, $users_admin, $table_users;

	$userid = addslashes($HTTP_POST_VARS[userid]);
	$passwd = addslashes($HTTP_POST_VARS[passwd]);

	$query = "SELECT
			$users_userid,
			$users_passwd
		FROM
			$table_users
		WHERE
			$users_admin	= 1 AND
			$users_userid = '$userid' AND
			$users_passwd = PASSWORD('$passwd')";
	$result = mysql_query($query) or die("Failed to query database.");
	$row = mysql_fetch_assoc($result);

	$cookie_array[userid] = $row[$users_userid];
	$cookie_array[password] = $row[$users_passwd];

	$cookie_value = serialize($cookie_array);
	setcookie("proma", $cookie_value, time()+3600);

	$is_admin = mysql_num_rows($result);
	return $is_admin;
}

function logout()
{
// Logs out by deleting the cookie and setting runlevel to 0

	setcookie("proma", "", time()-3600);

	return 0;
}

function check_cookie()
{
// Runned every time a page in the admin section is accessed
// Checks if the cookies data matches the database and the user still is admin
// Renews the cookie

	global $HTTP_COOKIE_VARS, $users_userid, $users_passwd, $users_admin, $table_users;

	$cookie_value = stripslashes($HTTP_COOKIE_VARS[proma]);
	$cookie_array = unserialize($cookie_value);
	setcookie("proma", "", time()-3600);
	
	$query = "SELECT
			$users_userid
		FROM
			$table_users
		WHERE
			$users_admin	= 1 AND
			$users_userid = '$cookie_array[userid]' AND
			$users_passwd = '$cookie_array[password]'";
	$result = mysql_query($query) or die("Failed to query database.");
	$is_admin = mysql_num_rows($result);

	if ($is_admin) {
		setcookie("proma", $cookie_value, time()+3600);
	}

	return $is_admin;
}

?>
