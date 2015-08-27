<?php
/**
 * File              : write_application.php
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
function write_application($vars) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (strlen($vars["application"]) > 20000) {
        $err = "The Application is too long.  It may only be 20000 characters in length.";
    } else {
        $default_query = "update " . TABLE_PREFIX . "settings";
        $default_query .= "   set setting_value = '" . clean_string($vars["application"]) . "'";
        $default_query .= " where setting_name = 'setting_application'";
        update_db($default_query);
    }
    return $err;
}

?>