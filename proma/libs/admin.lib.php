<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002-2003 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Admin Library
 * $Id$
 */

function list_users() {
// Prints a list of users

  global $users_userid, $users_name, $users_mail, $users_note, $users_count, $users_admin, $users_closed, $table_users;

  $query = "SELECT
              $users_userid,
              $users_name,
              $users_mail,
              $users_note,
              $users_count,
              $users_admin,
              $users_closed
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
    print "   <th class=\"thh\">Legend</th>\n";
    print "   <td class=\"admin\">Admin</td>\n";
    print "   <td class=\"closed\">New/Closed</td>\n";
    print "   <td class=\"note\">Note</td>\n";
    print "  </tr>\n";
    print "</table>\n\n";

    print "<br />\n\n";

    print "<table>\n";
    print "  <tr>\n";
    print "    <th class=\"thh\">Username</th>\n";
    print "    <th class=\"thh\">Name</th>\n";
    print "    <th class=\"thh\">Mail</th>\n";
    print "    <th class=\"thh\">Logins</th>\n";
    print "    <th class=\"thh\" colspan=\"3\">Action</th>\n";
    print "  </tr>\n\n";

    while ($row = mysql_fetch_array($result)) {
      $userid = stripslashes($row[0]);
      $name   = stripslashes($row[1]);
      $mail   = stripslashes($row[2]);
      $note   = !empty($row[3]);
      $count  = stripslashes($row[4]);
      $admin  = $row[5];
      $closed = $row[6];

      if ($note == 1)
        print "  <tr class=\"note\">\n";
      elseif ($admin == 1)
        print "  <tr class=\"admin\">\n";
      elseif ($closed == 1)
        print "  <tr class=\"closed\">\n";
      else
        print "  <tr>\n";

      print "    <td>$userid</td>\n";
      print "    <td>$name</td>\n";
      print "    <td><a href=\"mailto:$mail\">$mail</a></td>\n";
      print "    <td align=\"right\">$count</td>\n";
      print "    <td><a href=\"?page=admin&amp;action=change&amp;id=$userid\">Change</a></td>\n";
      if ($closed == 1)
        print "    <td><a href=\"?page=admin&amp;action=open&amp;id=$userid\">Open</a></td>\n";
      else
        print "    <td><a href=\"?page=admin&amp;action=close&amp;id=$userid\">Close</a></td>\n";
      print "    <td><a href=\"?page=admin&amp;action=delete&amp;id=$userid\">Delete</a></td>\n";
      print "  </tr>\n\n";
    }

    print "</table>\n\n";
  } else {
    print "<p>No users.</p>";
  }
}

function change($userid) {
// Change user details

  global $HTTP_POST_VARS, $link, $table_users, $users_userid, $users_name, $users_mail, $users_passwd, $users_note, $users_count, $users_admin, $users_closed;

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
    if ($HTTP_POST_VARS[closed] == "on")
      closed($userid, 1);
    else
      closed($userid, 0);

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
                $users_admin,
                $users_closed
              FROM
                $table_users
              WHERE
                $users_userid = '$userid'";
    $result = mysql_query($query) or die("Database query failed.");
    $row = mysql_fetch_array($result);

    $name   = stripslashes($row[0]);
    $mail   = stripslashes($row[1]);
    $note   = stripslashes($row[2]);
    $count  = $row[3];
    $admin  = $row[4];
    $closed = $row[5];

    if ($admin)
      $admin_s = "checked=\"checked\"";
    if ($closed)
      $closed_s = "checked=\"checked\"";

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
  <tr><th class="thv">Closed</th>         <td><input type="checkbox" name="closed" <?php print $closed_s; ?> /></td></tr>
  <tr><th></th>                           <td><input type="submit" name="submit" value="Change" /></td></tr>
</table>

</form>

<?php
  }
}

function closed($userid, $closed) {
// Opens og closes an account

  global $link, $table_users, $users_userid, $users_mail, $users_passwd, $users_closed, $info_host, $mail_from, $mail_notify_account_open;

  $query = "SELECT
              $users_mail,
              $users_passwd
            FROM
              $table_users
            WHERE
              $users_userid = '$userid'";
  $result = mysql_query($query) or die("Database query failed.");
  $row = mysql_fetch_array($result);

  $mail = stripslashes($row[0]);
  $newpasswd = rot13($row[1]);

  $query = "UPDATE
              $table_users
            SET
              $users_passwd = '$newpasswd',
              $users_closed = $closed
            WHERE
              $users_userid = '$userid'";
  $result = mysql_query($query) or die("Database query failed.");

  if (mysql_affected_rows($link) > 0) {
    if ($closed)
      print "<p>The useraccount \"$userid\" was closed.</p>\n";
    else {
      print "<p>The useraccount \"$userid\" was opened.</p>\n";

      if ($mail_notify_account_open) {
        mail($mail,
          "ProMA - $info_host - Account opened",
          "Your account at $info_host with username \"$userid\" has been opened.\n\n-- \nProMA at $info_host",
          "From: $mail_from\n"
          ."X-Mailer: PHP/" . phpversion());
      }
    }
  }
}

function delete($userid) {
// Deletes users after a confirmation 

  global $HTTP_POST_VARS, $table_users, $users_userid;

  if ($HTTP_POST_VARS[delete] == "Yes") {
  // Delete the user if confirmed

    $query = "DELETE FROM
                $table_users
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

    print "<p>Do you want to delete the user \"$userid\"?</p>\n";

    print "<form action=\"?page=admin&amp;action=delete&amp;id=$userid\" method=\"post\">
<input type=\"submit\" name=\"delete\" value=\"Yes\" />
<input type=\"submit\" name=\"delete\" value=\"No\" />
</form>\n";
  }

}

?>
