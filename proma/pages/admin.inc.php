<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Admin Page
 * $Id$
 */

?>

<h2>Admin</h2>

<?php

if ($runlevel == 1) {
// If logged in and everything is well, give full access

  print "<p>
<a href=\"?page=admin\">Userlist</a> |
<a href=\"?page=admin&amp;action=logout\">Logout</a>
</p>\n";

  $action = addslashes($HTTP_GET_VARS["action"]);
  $id = addslashes($HTTP_GET_VARS["id"]);

  // These functions are included from libs/admin.lib.php

  switch ($action) {
    case "accept":
      accept($id);
      break;
    case "change":
      change($id);
      break;
    case "delete":
      delete($id, NULL);
      break;
    case "delete_new":
      delete($id, "new");
      break;
    default:
      list_new_users();
      list_users();
  }

} else {
// If not logged in, logged out or something failed, print login form
?>

<form action="?page=admin" method="post">
<input type="hidden" name="login" value="1" />

<table>
  <tr><th class="thv">Userid</th>   <td><input type="text" name="userid" /></td></tr>
  <tr><th class="thv">Password</th> <td><input type="password" name="passwd" /></td></tr>
  <tr><th></th>                     <td><input type="submit" value="Login" /></td></tr>
</table>

</form>

<?php
}
?>