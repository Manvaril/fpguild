<?php
/**
 * File              : write_links.php
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
function add_link($vars) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!trim($vars["link_name"])) {
        $err = "The link name cannot be blank.";
    } elseif (strlen($vars["link_name"]) > 50) {
        $err = "The link name is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z0-9 ]+$/", $vars["link_name"])) {
        $err = "The link name contains invalid symbols.";
    } elseif (!trim($vars["link_url"])) {
        $err = "The link url cannot be blank.";
    } elseif (strlen($vars["link_url"]) > 150) {
        $err = "The link url is too long.  It may only be 150 characters in length.";
    } else {
        $values  = "0,";
        $values .= "'" . $vars["link_name"] . "',";
        $values .= "'" . $vars["link_url"] . "'";

        $query  = "insert into " . TABLE_PREFIX . "links (link_id, link_name, link_url) ";
        $query .= "values ($values)";

        update_db($query);
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function edit_link($vars) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!trim($vars["link_name"])) {
        $err = "The link name cannot be blank.";
    } elseif (strlen($vars["link_name"]) > 50) {
        $err = "The link name is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z0-9 ]+$/", $vars["link_name"])) {
        $err = "The link name contains invalid symbols.";
    } elseif (!trim($vars["link_url"])) {
        $err = "The link url cannot be blank.";
    } elseif (strlen($vars["link_url"]) > 150) {
        $err = "The link url is too long.  It may only be 150 characters in length.";
    } else {
        $link_query  = "update " . TABLE_PREFIX . "links";
        $link_query .= "   set link_name = '" . trim($vars["link_name"]) . "', ";
        $link_query .= "       link_url = '" . trim($vars["link_url"]) . "'";
        $link_query .= " where link_id = '" . trim($vars["link_id"]) . "'";

        update_db($link_query);
    }
    return $err;
}

/**
 * @param $link_id
 * @return string
 */
function delete_link($link_id) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        $delete_link_query = "delete";
        $delete_link_query .= "  from " . TABLE_PREFIX . "links";
        $delete_link_query .= " where link_id = '" . $link_id . "'";

        update_db($delete_link_query);
    }
    return $err;
}

?>