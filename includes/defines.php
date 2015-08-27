<?php
/**
 * File              : defines.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

if (!isset($nam_root_path)) {
    $fpg_root_path = "./";
}
include $fpg_root_path . "includes/config.php";
include $fpg_root_path . "includes/database.php";
include $fpg_root_path . "includes/phpbb_database.php";
include $fpg_root_path . "includes/read_settings.php";

$err = read_settings($setting);

// If GZip Compression is enabled, Start buffering the output
if (($setting["setting_enable_gzip"] == '1') && ($ext_zlib_loaded = extension_loaded('zlib')) && (PHP_VERSION >= '4')) {
    // Check to see if the zlib library is enabled in the php.ini file if not use internal ob_ compressors
    if (($ini_zlib_output_compression = (int)ini_get('zlib.output_compression')) < 1) {
        // Checking the version just in case someone is running older PHP (knowing the requirments are higher)
        if (PHP_VERSION >= '4.0.4') {
            ob_start('ob_gzhandler');
        } else {
            ob_start();
            ob_implicit_flush();
        }
    } else {
        ini_set('zlib.output_compression_level', $setting["setting_gzip_level"]);
    }
}

$RECRUITING = array();
$RECRUITING[1] = "<span class=\"green\">High</span>";
$RECRUITING[2] = "<span class=\"yellow\">Medium</span>";
$RECRUITING[3] = "<span class=\"orange\">Low</span>";
$RECRUITING[4] = "<span class=\"red\">None</span>";

$CLASS = array();
$CLASS[1] = "Bard";
$CLASS[2] = "Beastlord";
$CLASS[3] = "Berserker";
$CLASS[4] = "Cleric";
$CLASS[5] = "Druid";
$CLASS[6] = "Enchanter";
$CLASS[7] = "Magician";
$CLASS[8] = "Monk";
$CLASS[9] = "Necromancer";
$CLASS[10] = "Paladin";
$CLASS[11] = "Ranger";
$CLASS[12] = "Rogue";
$CLASS[13] = "Shadow Knight";
$CLASS[14] = "Shaman";
$CLASS[15] = "Warrior";
$CLASS[16] = "Wizard";

$TRADE_SKILL = array();
$TRADE_SKILL[1] = "Alchemy";
$TRADE_SKILL[2] = "Baking";
$TRADE_SKILL[3] = "Blacksmithing";
$TRADE_SKILL[4] = "Brewing";
$TRADE_SKILL[5] = "Fishing";
$TRADE_SKILL[6] = "Fletching";
$TRADE_SKILL[7] = "Jewelcrafting";
$TRADE_SKILL[8] = "Poison Making";
$TRADE_SKILL[9] = "Pottery";
$TRADE_SKILL[10] = "Research";
$TRADE_SKILL[11] = "Tailoring";
$TRADE_SKILL[12] = "Tinkering";

$CHAR_TYPE = array();
$CHAR_TYPE[0] = "Main";
$CHAR_TYPE[1] = "Alt";

$RAID_HOUR = array();
$RAID_HOUR[2] = "Hour 2";
$RAID_HOUR[3] = "Hour 3";
$RAID_HOUR[4] = "Hour 4";
$RAID_HOUR[5] = "Hour 5";
$RAID_HOUR[6] = "Hour 6";
$RAID_HOUR[7] = "Hour 7";
$RAID_HOUR[8] = "Hour 8";

?>