-------
Changes
-------

- 2011-01-31 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Switched version control from SVN to Git.
  - Switched project hosting from SourceForge to GitHub.
  - Convert docs to reStructuredText.

- 2007-10-25 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Changed statistics to just count active accounts. In CVS since 2004.
  - Replace $HTTP_{GET,POST,COOKIE}_VARS with $_{GET,POST,COOKIE}. Needed to
    support PHP5. Contributed by Kaspar Lyngsie <k@pacroon.dk>.
  - Add "" around array indexes.
  - Remove unused branch from switch in pages/admin.inc.php..
  - Remove unused PEAR code in index.php.
  - Change copyright from 2002-2004 to 2002-2007.
  - Release 0.8.3.

- 2004-07-26 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Reduced text size in lists.
  - Updated about text in 'docs/README'.
  - Released version 0.8.2.

- 2004-07-15 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Updated footnote text.
  - Estetic changes to the stylesheet.
  - Fixed tab indentation in all files.
  - Cleaned up the forms and tables.
  - Removed size on MRTG img-tag, so it will work well with other traffic
    graphs like RRD or Munin.
  - Merged name and mail fields in user list.
  - Added title-attribute with notes to the user list, so you can see the start
    of the note by pointing at the specific users row.
  - Moved docs to the new subdir 'docs'.
  - Updated copyright in the header of all files.

- 2004-07-08 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Added support for setting homedir per user.
  - Fixed priority on userlist colors.

- 2004-06-23 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Fixed typo in the new user mail.

- 2004-06-12 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Fixed typo in 'change.inc.php'.

- 2004-02-13 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Added check for 'config.inc.php' in 'index.php'.

- 2003-11-25 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Fixed bug in libs/admin.lib.php. Thanks to Ben Lentz
    <blentz@channing-bete.com>.
  - Added more info about 'config.inc.php' in INSTALL.
  - Changed text and design of pages/change.inc.php.
  - Moved legend to bottom of user list.
  - Released version 0.8.1.

- 2003-08-23 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Changed the font sizes and table look a bit.
  - Fixed a bug in INSTALL. Thanks to Mark A. Miller <mamiller@ualr.edu>.
  - Added the server name to the web page headers.
  - Added a new field to 'users', which made the 'newusers' table obsolete.
  - Added code to use this new field, including support for closing accounts.
  - Removed code spesific to the 'newusers' table.
  - Updated the copyrights to include 2003.
  - Added mail notifiers.
  - Released version 0.8.

- 2002-09-19 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Fixed a bug in pages/main.inc.php. Thanks to Daniel Perez.
  - Released version 0.7.3.

- 2002-08-20 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Added status messages to the admin page.
  - Released version 0.7.2.

- 2002-08-11 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Fixed error regarding SQLConnectInfo in the INSTALL file.

- 2002-07-22 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Rewrote the installation instructions.
  - Released version 0.7.1.

- 2002-07-02 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Added number of logins to the 'change'-page.

- 2002-06-21 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Started using CVS in the development.

- 2002-04-24 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Rewrote 'make admin' and 'remove admin' as a part of the change function.
  - Changed the color scheme a bit.
  - Changed cookie-format.
  - Fixed a bug in the logout procedure.
  - Added 'note' field to the users.
  - Released version 0.7.

- 2002-04-07 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Gave the install instructions a walk-over and fixed some bugs.
  - Improved output from the 'accept user' function.
  - New function for the admin to change user settings and passwords.
  - Moved parts of admin.lib.php to the new file auth.lib.php.

- 2002-03-17 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Divided the information table into two tables: information and statistics.
  - Added totalt number of logins to the stats at the main page.

- 2002-02-02 Stein Magnus Jodal <stein.magnus@jodal.no>

  - Released version 0.6. The first public release.
