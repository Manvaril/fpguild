<?php
/**
 * File              : write_charter.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

/**
 * @param $vars
 * @return string
 */
function write_charter($vars) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (strlen($vars["charter"]) > 20000) {
        $err = "The Charter is too long.  It may only be 20000 characters in length.";
    } else {
        $default_query = "update " . TABLE_PREFIX . "settings";
        $default_query .= "   set setting_value = '" . clean_string($vars["charter"]) . "'";
        $default_query .= " where setting_name = 'setting_charter'";
        update_db($default_query);
    }
    return $err;
}

?>