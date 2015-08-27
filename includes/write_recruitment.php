<?php
/**
 * File              : write_recruitment.php
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
function write_recruitment($vars) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        foreach($vars as $key => $value) {
            $class_id = substr($key, 5);

            $query  = "select class_id";
            $query .= "  from " . TABLE_PREFIX . "recruitment";
            $query .= " where class_id = '" . $class_id . "'";

            query_db($query, $check_exist);

            if ($check_exist["class_id"]) {
                $default_query  = "update " . TABLE_PREFIX . "recruitment";
                $default_query .= "   set class_value = '" . trim($value) . "'";
                $default_query .= " where class_id = '" . $check_exist["class_id"] . "'";
                update_db($default_query);
            } else {
                $err = "That class does not exist in the database.";
            }
        }
    }
    return $err;
}

?>