<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002-2007 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Main Page
 * $Id$
 */

?>

<h2>Information</h2>

<?php

$query = "SELECT
		COUNT($users_userid) AS users,
		SUM($users_count) AS logins
	FROM
		$table_users
	WHERE
		$users_closed != 1";
$result = mysql_query($query) or die("Failed to query database.");

if ($result) {
	$row = mysql_fetch_assoc($result);
	$num_users = $row["users"];
	$num_logins = $row["logins"];
}

if (!$num_users > 0) {
	$num_users = 0;
}

if (!$num_logins > 0) {
	$num_logins = 0;
}

?>

<table>
	<tr>
		<th class="thv">Host</th>
		<td class="tdb"><?php print $info_host; ?></td>
	</tr>
	<tr>
		<th class="thv">Port</th>
		<td class="tdb"><?php print $info_port; ?></td>
	</tr>
	<tr>
		<th class="thv">Passive</th>
		<td class="tdb"><?php print $info_passive; ?></td>
	</tr>
	<tr>
		<th class="thv">Login</th>
		<td class="tdb"><?php print $info_login; ?></td>
	</tr>
	<tr>
		<th class="thv">Limits</th>
		<td class="tdb"><?php print $info_limits; ?></td>
	</tr>
</table>

<h2>Statistics</h2>

<table>
	<tr>
		<th class="thv">Size</th>
		<td class="tdb"><?php print $info_size; ?></td>
	</tr>
	<tr>
		<th class="thv">Speed</th>
		<td class="tdb"><?php print $info_speed; ?></td>
	</tr>
	<tr>
		<th class="thv">Users</th>
		<td class="tdb"><?php print $num_users; ?></td>
	</tr>
	<tr>
		<th class="thv">Logins</th>
		<td class="tdb"><?php print $num_logins; ?></td>
	</tr>
</table>

<?php

if ($mrtg_enable == true) {
	print "<h2>Traffic</h2>\n\n";

	print "<p>\n";

	if (!empty($mrtg_link)) {
		print "<a href=\"$mrtg_link\">\n";
	}

	print "<img src=\"$mrtg_image\" alt=\"Traffic\" />\n";

	if (!empty($mrtg_link)) {
		print "</a>\n";
	}

	print "</p>\n";
}

?>
