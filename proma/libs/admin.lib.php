<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Admin Library
 * $Id$
 */

function list_new_users() {
// Prints a list of new not yet approved users, together with 'Add', 'Change' and 'Delete' links 

  global $users_userid, $users_name, $users_mail, $table_newusers;

  print "<h3>New users</h3>\n\n";

  $query = "SELECT
              $users_userid,
              $users_name,
              $users_mail
            FROM
              $table_newusers
            ORDER BY
              $users_userid ASC";
  $result = mysql_query($query) or die("Database query failed.");
  $num_rows = mysql_num_rows($result);

  if ($num_rows > 0) {
    print "<table>\n";
    print "  <tr>\n";
    print "    <th class=\"thh\">Userid</th>\n";
    print "    <th class=\"thh\">Name</th>\n";
    print "    <th class=\"thh\">Mail</th>\n";
    print "    <th colspan=\"2\" class=\"thh\">Action</th>\n";
    print "  </tr>\n";

    while ($row = mysql_fetch_array($result)) {
      $userid = stripslashes($row[0]);
      $name   = stripslashes($row[1]);
      $mail   = stripslashes($row[2]);

      print "  <tr>\n";
      print "    <td>$userid</td>\n";
      print "    <td>$name</td>\n";
      print "    <td><a href=\"mailto:$mail\">$mail</a></td>\n";
      print "    <td><a href=\"?page=admin&amp;action=accept&amp;id=$userid\">Accept</a></td>\n";
      print "    <td><a href=\"?page=admin&amp;action=delete_new&amp;id=$userid\">Delete</a></td>\n";
      print "  </tr>\n\n";
    }

    print "</table>\n\n";
  } else {
    print "<p>No new users.</p>";
  }

}

function list_users() {
// Prints a list of existing users, with 'Change' and 'Delete'-links, and a link to toggle the admin status

  global $users_userid, $users_name, $users_mail, $users_note, $users_count, $users_admin, $table_users;

  print "<h3>Users</h3>\n\n";

  $query = "SELECT
              $users_userid,
              $users_name,
              $users_mail,
              $users_note,
              $users_count,
              $users_admin
            FROM
              $table_users
            ORDER BY
              $users_count DESC,
              $users_userid ASC";
  $result = mysql_query($query) or die("Database query failed.");
  $num_rows = mysql_num_rows($result);

  if ($num_rows > 0) {
    print "<table>\n";
    print "  <tr>\n";
    print "   <td class=\"admin\">Admin</td>\n";
    print "   <td class=\"hasnote\">Has note</td>\n";
    print "  </tr>\n";
    print "</table>\n\n";

    print "<br />\n\n";

    print "<table>\n";
    print "  <tr>\n";
    print "    <th class=\"thh\">Userid</th>\n";
    print "    <th class=\"thh\">Name</th>\n";
    print "    <th class=\"thh\">Mail</th>\n";
    print "    <th class=\"thh\">Logins</th>\n";
    print "    <th class=\"thh\" colspan=\"2\">Action</th>\n";
    print "  </tr>\n\n";

    while ($row = mysql_fetch_array($result)) {
      $userid = stripslashes($row[0]);
      $name   = stripslashes($row[1]);
      $mail   = stripslashes($row[2]);
      $note   = !empty($row[3]);
      $count  = stripslashes($row[4]);
      $admin  = $row[5];

      if ($admin == 1)
        print "  <tr class=\"admin\">\n";
      elseif ($note == 1)
        print "  <tr class=\"hasnote\">\n";
      else
        print "  <tr>\n";

      print "    <td>$userid</td>\n";
      print "    <td>$name</td>\n";
      print "    <td><a href=\"mailto:$mail\">$mail</a></td>\n";
      print "    <td align=\"right\">$count</td>\n";
      print "    <td><a href=\"?page=admin&amp;action=change&amp;id=$userid\">Change</a></td>\n";
      print "    <td><a href=\"?page=admin&amp;action=delete&amp;id=$userid\">Delete</a></td>\n";
      print "  </tr>\n\n";
    }

    print "</table>\n\n";
  } else {
    print "<p>No users.</p>";
  }
}

function accept($userid) {
// Moves users from the 'newusers' table to the 'users' table so they can access the FTP server

  global $users_userid, $users_name, $users_mail, $users_uid, $users_uid_default, $users_gid, $users_gid_default, $users_passwd, $users_shell, $users_shell_default, $users_homedir, $users_homedir_default, $users_count, $users_admin, $table_users, $table_newusers;

  print "<p>\n";

  $query = "SELECT
              $users_userid,
              $users_name,
              $users_mail,
              $users_passwd
            FROM
              $table_newusers
            WHERE
              $users_userid = '$userid'";
  $result = mysql_query($query) or die("Database query failed.");
  $num_rows = mysql_num_rows($result);

  if ($num_rows) {
    $row = mysql_fetch_array($result);
    $name   = $row[1];
    $mail   = $row[2];
    $passwd = $row[3];
  } else {
    print "Select user from new users failed.\n";
    die();
  }

  $query = "INSERT INTO
              $table_users
            SET
              $users_userid  = '$userid',
              $users_name    = '$name',
              $users_mail    = '$mail',
              $users_uid     = '$users_uid_default',
              $users_gid     = '$users_gid_default',
              $users_passwd  = '$passwd',
              $users_shell   = '$users_shell_default',
              $users_homedir = '$users_homedir_default',
              $users_count   = 0,
              $users_admin   = 0";
  $result = mysql_query($query) or die("Database query failed.");
  $num_rows = mysql_affected_rows();

  if (!$num_rows) {
    print "Insert user into users table failed.\n";
    die();
  }

  $query = "DELETE FROM
              $table_newusers
            WHERE
              $users_userid = '$userid'";
  $result = mysql_query($query) or die("Database query failed.");
  $num_rows = mysql_affected_rows();

  if (!$num_rows) {
    print "Delete user from new users failed.\n";
    die(); 
  }

  print "The user has been accepted and the account is now active.\n";

  print "</p>\n";
}

function change($userid) {
// Change user details

  global $HTTP_POST_VARS, $link, $table_users, $users_userid, $users_name, $users_mail, $users_passwd, $users_note, $users_count, $users_admin;

  if ($HTTP_POST_VARS["submit"]) {
  // The change form is submitted and should be processed

    $new_userid  = addslashes($HTTP_POST_VARS[userid]);
    $new_name    = addslashes($HTTP_POST_VARS[name]);
    $new_mail    = addslashes($HTTP_POST_VARS[mail]);
    $new_passwd1 = addslashes($HTTP_POST_VARS[new_passwd1]);
    $new_passwd2 = addslashes($HTTP_POST_VARS[new_passwd2]);
    $new_note    = addslashes($HTTP_POST_VARS[note]);
    if ($HTTP_POST_VARS[admin] == "on")
      $new_admin = 1;
    else
      $new_admin = 0;

    if ($new_userid == "" || $new_passwd1 != $new_passwd2) {
      print "<p>Old userid or password is empty, or new passwords are not identical. <a href=\"?page=admin&amp;action=change&amp;id=$userid\">Try again</a></p>\n";
    } else {
      $query = "UPDATE
                  $table_users
                SET
                  $users_userid = '$new_userid',
                  $users_name   = '$new_name',
                  $users_mail   = '$new_mail',
                  $users_note   = '$new_note',
                  $users_admin  = '$new_admin'";

      if ($new_passwd1 != "")
        $query .= ", $users_passwd = PASSWORD('$new_passwd1')";

      $query .= " WHERE $users_userid = '$userid'";

      $result = mysql_query($query) or die("Failed to query database.");

      print "<p>Changes applied.</p>\n";
    }

  } else {
  // If the change form is not submitted, print it

    $query = "SELECT
                $users_name,
                $users_mail,
                $users_note,
                $users_count,
                $users_admin
              FROM
                $table_users
              WHERE
                $users_userid = '$userid'";
    $result = mysql_query($query) or die("Database query failed.");
    $row = mysql_fetch_array($result);

    $name  = stripslashes($row[0]);
    $mail  = stripslashes($row[1]);
    $note  = stripslashes($row[2]);
    $count = $row[3];
    $admin = $row[4];

    if ($admin)
      $admin_s = "checked=\"checked\"";

?>

<form action="?page=admin&amp;action=change&amp;<?php print "table=$table_short&amp;id=$userid"; ?>" method="post">

<table>
  <tr><th class="thv">Userid</th>         <td><input type="text" name="userid" value="<?php print $userid; ?>" /></td></tr>
  <tr><th class="thv">Name</th>           <td><input type="text" name="name" value="<?php print $name; ?>" /></td></tr>
  <tr><th class="thv">Mail</th>           <td><input type="text" name="mail" value="<?php print $mail; ?>" /></td></tr>
  <tr><th class="thv">New password</th>   <td><input type="password" name="new_passwd1" /> Leave blank if you wont change</td></tr>
  <tr><th class="thv">New password</th>   <td><input type="password" name="new_passwd2" /> Again</td></tr>
  <tr><th class="thv">Note</th>           <td><textarea name="note" cols="60" rows="6"><?php print $note; ?></textarea></td></tr>
  <tr><th class="thv">Logins</th>         <td><?php print $count; ?></td></tr>
  <tr><th class="thv">Admin</th>          <td><input type="checkbox" name="admin" <?php print $admin_s; ?> /></td></tr>
  <tr><th></th>                           <td><input type="submit" name="submit" value="Change" /></td></tr>
</table>

</form>

<?php
  }
}

function delete($userid, $table) {
// Deletes users, both from 'users' and 'newusers'
// Also asks for confirmation 

  global $HTTP_POST_VARS, $users_userid, $table_users, $table_newusers;

  if ($HTTP_POST_VARS[delete] == "Yes") {
  // Delete the user if confirmed

    if ($table == "new")
      $table = $table_newusers;
    else
      $table = $table_users;

    $query = "DELETE FROM
                $table
              WHERE
                $users_userid = '$userid'";
    $result = mysql_query($query) or die("Failed to query database.");
    $num_rows = mysql_affected_rows();

    if ($num_rows)
      print "<p>The user \"$userid\" was deleted.</p>\n";
  } elseif ($HTTP_POST_VARS[delete] == "No") {
  // If the user is not to be deleted

    print "<p>The user \"$userid\" was NOT deleted.</p>\n";
  } else {
  // Print request for confirmation

    if ($table == "new")
      $action = "delete_new";
    else
      $action = "delete";

    print "<p>Do you want to delete the user \"$userid\"?</p>\n";

    print "<form action=\"?page=admin&amp;action=$action&amp;id=$userid\" method=\"post\">
<input type=\"submit\" name=\"delete\" value=\"Yes\" />
<input type=\"submit\" name=\"delete\" value=\"No\" />
</form>\n";
  }

}

?>
