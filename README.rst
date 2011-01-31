***************************
ProMA (ProFTPd MySQL Admin)
***************************

ProMA is a PHP4 based system for administrating a ProFTPd server storing users
in a MySQL database. Features include support for multiple administrators, mail
notifiers when new users register and when accounts are approved, closing of
accounts temporarily, without deleting it or wiping out the password, and a
notepad per user for the admins.


Credits
=======

ProMA is written by Stein Magnus Jodal. Thanks goes out to the bug reporters,
which are named in the change log. I would also like to give some credit to
all the people behind ProFTPd and MySQL for their effort.


Requirements
============

- Webserver (tested with Apache 1.3.29)
- PHP4 with MySQL support (tested with 4.3.4, should work with >=4.1.0)
- MySQL (tested with 4.0.18, should work with 3.x and 4.x)
- ProFTPd (tested with 1.2.9) server with mod_sql and mod_sql_mysql


Changes
=======

Read ``docs/changes.rst`` for details on changes since last release.


Installation
============

Read ``docs/install.rst`` for installation instructions.


Upgrading
=========

Read ``docs/upgrade.rst`` for upgrade instructions.


License
=======

ProMA (ProFTPd MySQL Admin), Copyright (C) 2002-2011 Stein Magnus Jodal
ProMA comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under the terms of the GNU General Public License.
Read 'COPYING' for further information.
