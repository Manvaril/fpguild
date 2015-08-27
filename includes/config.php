<?php
/**
 * File              : config.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

/**
 * Database & System Config
 *
 * HOSTNAME:        SQL Database Hostname
 * DATABASE:        SQL Database Name
 * LOGIN:           SQL Username
 * PASSWORD:        SQL Password
 * TABLE_PREFIX:    Your Database tables prefix
 *                  If you dumped your tables with the prefix of "fpguild_"
 *                  then you would put in fpguild_ in the quotes
 *
 * DIR_PATH:        The direct system path to the installation (i.e. /home/mysite/public_html/)
 * HTTP_PATH:       The http path to the installation (i.e. http://www.mysite.com/)
 *                  ***Both of these paths need the forward slash (/) at the end!***
 */

// Sets the timezone for the website
date_default_timezone_set('America/New_York');
//--------------------------------------------

define("HOSTNAME",     "localhost");
define("DATABASE",     "fpguild");
define("LOGIN",        "root");
define("PASSWORD",     "");
define("TABLE_PREFIX", "fpguild_");

define("PHPBB_HOSTNAME",     "localhost");
define("PHPBB_DATABASE",     "fpguild");
define("PHPBB_LOGIN",        "root");
define("PHPBB_PASSWORD",     "");
define("PHPBB_TABLE_PREFIX", "phpbb_");

define("DIR_PATH",        "C:/wamp/www/fpguild/");
define("HTTP_PATH",       "http://localhost/fpguild/");
define("GAL_THUMB_SIZE",  "225");
define("GAL_PAGE_SIZE",   "950");
define("GAL_THUMB_PREFIX", "thumb_");
define("GAL_PAGE_PREFIX",  "page_");
define("GAL_JPEG_QUALITY", "90");
?>