<?php

/* ProMA (ProFTPd MySQL Admin), Copyright (C) 2002 Stein Magnus Jodal
 * ProMA comes with ABSOLUTELY NO WARRANTY.
 * This is free software, and you are welcome to redistribute it
 * under the terms of the GNU General Public License.
 * Read 'COPYING' for further information.
 */

/* ProMA Register Processing Page
 * $Id$
 */

?>

<h2>Register new account</h2>

<?php

if ($HTTP_POST_VARS["submit"] == 1) {
// If the register form is submitted and should be processed

$passwd1  = addslashes($HTTP_POST_VARS[passwd1]);
$passwd2  = addslashes($HTTP_POST_VARS[passwd2]);
$userid   = addslashes($HTTP_POST_VARS[userid]);
$name     = addslashes($HTTP_POST_VARS[name]);
$mail     = addslashes($HTTP_POST_VARS[mail]);

if ($userid == "" || $passwd1 == "")
  print "<p>Userid or password is empty. <a href=\"?page=register\">Try again</a></p>\n";

elseif ($passwd1 != $passwd2)
  print "<p>The passwords are not identical. <a href=\"?page=register\">Try again</a></p>\n";

else {
  $query = "INSERT INTO
              $table_newusers
            SET
              $users_userid  = '$userid',
              $users_name    = '$name',
              $users_mail    = '$mail',
              $users_passwd  = PASSWORD('$passwd1')";
  $result = mysql_query($query) or die("Database query failed.");
  print "<p>You are registered. When an admin accepts your registration you can connect using the information on the main page.</p>";
}

} else {
// If the register form is not submitted, print it

if ($policy != "") {
  print "<p>$policy</p>";
}
?>

<form action="?page=register" method="post">
<input type="hidden" name="submit" value="1" />

<table>
  <tr><th class="thv">Userid</th>   <td><input type="text" name="userid" /> Your login</td></tr>
  <tr><th class="thv">Name</th>     <td><input type="text" name="name" /> Your full real name</td></tr>
  <tr><th class="thv">Mail</th>     <td><input type="text" name="mail" /> Your mail adress</td></tr>
  <tr><th class="thv">Password</th> <td><input type="password" name="passwd1" /></td></tr>
  <tr><th class="thv">Password</th> <td><input type="password" name="passwd2" /> And again</td></tr>
  <tr><th></th>                     <td><input type="submit" value="Register" /></td></tr>
</table>

</form>

<?php
}
?>
