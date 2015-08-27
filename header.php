<?php
/**
 * File              : header.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>False Prophecy - EverQuest Ragefire Guild</title>
    <meta charset="UTF-8"/>
    <link rel="shortcut icon" href="favicon.ico"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="http://www.magelocdn.com/pack/eq/en/magelo-bar.js#1rdo"></script>
    <script type="text/javascript" src="jquery-1.10.2.min.js"></script>
    <?php
    if ((basename($request->get_super_global(\phpbb\request\request_interface::SERVER)["PHP_SELF"]) == "add_event.php") ||
        (basename($request->get_super_global(\phpbb\request\request_interface::SERVER)["PHP_SELF"]) == "edit_event.php") ||
        (basename($request->get_super_global(\phpbb\request\request_interface::SERVER)["PHP_SELF"]) == "add_adjustment.php") ||
        (basename($request->get_super_global(\phpbb\request\request_interface::SERVER)["PHP_SELF"]) == "edit_adjustment.php") ||
        (basename($request->get_super_global(\phpbb\request\request_interface::SERVER)["PHP_SELF"]) == "mass_adjust.php") ||
        (basename($request->get_super_global(\phpbb\request\request_interface::SERVER)["PHP_SELF"]) == "add_raid.php") ||
        (basename($request->get_super_global(\phpbb\request\request_interface::SERVER)["PHP_SELF"]) == "edit_raid.php") ||
        (basename($request->get_super_global(\phpbb\request\request_interface::SERVER)["PHP_SELF"]) == "import_raid.php")) {
        ?>
        <link href="css/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="jquery.datetimepicker.js"></script>
        <script type="text/javascript" src="custom_ajax.js"></script>
    <?php
    }
    ?>
</head>
<body>
<div id="wrapper">
    <div id="header"><img src="images/sitelogo.gif" width="1022" height="200" alt="False Prophecy"></div>
    <div class="menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="charter.php">Charter</a></li>
            <li><a href="roster.php">Roster</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="trade_skills.php">Trade Skills</a></li>
            <li><a href="dkp.php">DKP</a></li>
            <li><a href="forums">Forum</a></li>
            <li><a href="links.php">Links</a></li>
            <li><a href="application.php">Application</a></li>
        </ul>
    </div>
