<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002-2003 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Authorization Library
 * $Id$
 */

function rot13($ascii) {
// Scrambles the password hash for new/closed accounts.

  for ($i = 0; $i < strlen($ascii); $i++) {
    $ascii_array[] = substr($ascii, $i, 1);
  }

  for ($i = 0; $i < sizeof($ascii_array); $i++) {
    $x = ord($ascii_array[$i]);

    // Uppercase
    if ($x >= 65 && $x <= 90) {
      $y = $x + 13;
      $z = $y - 90;
      if ($z > 0)
        $y = 64 + $z;
      $rot13 .= chr($y);

    // Lowercase
    } elseif ($x >= 97 && $x <= 122) {
      $y = $x + 13;
      $z = $y - 122;
      if ($z > 0)
        $y = 96 + $z;
      $rot13 .= chr($y);

    // Other
    } else {
      $rot13 .= chr($x);
    }
  }

  return $rot13;
}

function admin_mail() {
// Returns list of admin mail adresses

  global $table_users, $users_mail, $users_admin;

  $query = "SELECT
              $users_mail
            FROM
              $table_users
            WHERE
              $users_admin = 1";
  $result = mysql_query($query) or die("Failed to query database.");
  
  while ($row = mysql_fetch_array($result)) {
    $mail_array[] = $row[0];
  }

  $mail = implode(", ", $mail_array);

  return $mail;
}

?>
