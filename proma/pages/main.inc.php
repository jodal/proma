<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002 Stein Magnus Jodal
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

$query = "SELECT COUNT(userid), SUM(count) FROM $table_users";
$result = mysql_query($query) or die("Failed to query database.");

if ($result) {
  $row = mysql_fetch_array($result);
  $num_users = $row[0];
  $num_logins = $row[1];
}

if (!$num_users > 0)
  $num_users = 0;

if (!$num_logins > 0)
  $num_logins = 0;

?>

<table>
  <tr><th class="thv">Host</th>    <td><?php print $info_host; ?></td></tr>
  <tr><th class="thv">Port</th>    <td><?php print $info_port; ?></td></tr>
  <tr><th class="thv">Passive</th> <td><?php print $info_passive; ?></td></tr>
  <tr><th class="thv">Login</th>   <td><?php print $info_login; ?></td></tr>
  <tr><th class="thv">Limits</th>  <td><?php print $info_limits; ?></td></tr>
</table>

<h2>Statistics</h2>

<table>
  <tr><th class="thv">Size</th>    <td><?php print $info_size; ?></td></tr>
  <tr><th class="thv">Speed</th>   <td><?php print $info_speed; ?></td></tr>
  <tr><th class="thv">Users</th>   <td><?php print $num_users; ?></td></tr>
  <tr><th class="thv">Logins</th>  <td><?php print $num_logins; ?></td></tr>
</table>

<?php

if ($mrtg_enable == true) {
  print "<h2>Traffic</h2>\n\n";
  print "<p>\n";
  if ($mrtg_link != "") print "<a href=\"$mrtg_link\">\n";
  print "<img src=\"$mrtg_image\" width=\"500\" height=\"135\" alt=\"Traffic\" />\n";
  if ($mrtg_link != "") print "</a>\n";
  print "</p>\n";
}

?>
