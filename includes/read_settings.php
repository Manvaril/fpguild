<?php
/**
 * File              : read_settings.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

/**
 * @param $setting
 */
function read_settings(&$setting) {

    $query = "select *";
    $query .= "  from " . TABLE_PREFIX . "settings";

    $config["count"] = query_db($query, $config, true);

    for ($i = 0; $i < $config["count"]; $i++) {
        $setting[$config[$i]["setting_name"]] = $config[$i]["setting_value"];
    }

}

?>