********************
Upgrade instructions
********************

It is always recommended to move the old installation to another
location and install from scratch. That way you get rid of old
deprecated files. Sometimes you can easily use the old configuration.
Please read the instructions below for further information about
configuration changes.

0.7 to 0.8
==========

- The new field ``closed`` is needed in the database.  It can be added with
  this SQL query::

      ALTER TABLE users ADD closed INT(1) DEFAULT '0' AFTER admin;

  Remember to replace ``users`` and ``admin`` with your column names if they
  are changed from the default.

  The new field requires a new line in config.inc.php. Please insert
  the following between line 43 and 44, or simply create a new config from
  scratch.

  ::

      $users_closed          = "closed";

- The table ``newusers`` are no longer used, and can be removed::

      DROP TABLE newusers;

  Remember to replace ``newusers`` with your column name if it is changed from
  the default.

  The line starting with ``$table_newusers`` in config.inc.php can be removed.

- The entire mail part of ``config.inc.php`` are new, so you'll have to copy it
  from ``config.inc.php-example``, or even better, just create a new fresh
  config from scratch.


0.6 to 0.7
==========

The new field ``note`` is needed in the database.  It can be added with this
SQL query::

    ALTER TABLE users ADD note text NULL default '' AFTER homedir;

Remember to replace ``users`` and ``homedir`` with your column names if they
are changed from the default.

The new field requires a new line in ``config.inc.php``. Please insert the
following between line 40 and 41::

    $users_note            = "note";

There are no other changes to the config file.
