<?php
/**
 * File              : write_dkp.php
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
function add_event($vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!trim($vars["event_name"])) {
        $err = "The Event Name cannot be blank.";
    } elseif (strlen($vars["event_name"]) > 50) {
        $err = "The Event Name is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z0-9 -]+$/", $vars["event_name"])) {
        $err = "The Event Name contains invalid symbols.";
    } elseif (!trim($vars["event_date"])) {
        $err = "The Date/Time cannot be blank.";
    } elseif (!preg_match("/^[0-9]+$/", $vars["event_max_signup"])) {
        $err = "The Maximum  Signups must be numeric.";
    } else {
        $values  = "0,";
        $values .= "'" . $vars["event_name"] . "',";
        $values .= "'" . $vars["event_no_signup"] . "',";
        $values .= "'" . strtotime($vars["event_date"]) . "',";
        if ($vars["event_signup_start"] == "") {
            $values .= "'" . time() . "',";
        } else {
            $values .= "'" . strtotime($vars["event_signup_start"]) . "',";
        }
        $values .= "'" . strtotime($vars["event_signup_end"]) . "',";
        $values .= "'" . clean_string($vars["event_desc"]) . "',";
        $values .= "'" . $vars["event_max_signup"] . "'";

        $query  = "insert into " . TABLE_PREFIX . "events (event_id, event_name, event_no_signup, event_date, event_signup_start, event_signup_end, event_desc, event_max_signup) ";
        $query .= "values ($values)";

        update_db($query);
    }
    return $err;
}

/**
 * @param $event_id
 * @param $vars
 * @return string
 */
function edit_event($event_id, $vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!trim($vars["event_name"])) {
        $err = "The Event Name cannot be blank.";
    } elseif (strlen($vars["event_name"]) > 50) {
        $err = "The Event Name is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z0-9 -]+$/", $vars["event_name"])) {
        $err = "The Event Name contains invalid symbols.";
    } elseif (!trim($vars["event_date"])) {
        $err = "The Date/Time cannot be blank.";
    } elseif (!preg_match("/^[0-9]+$/", $vars["event_max_signup"])) {
        $err = "The Maximum  Signups must be numeric.";
    } else {
        $event_query  = "update " . TABLE_PREFIX . "events";
        $event_query .= "   set event_name = '" . trim($vars["event_name"]) . "', ";
        $event_query .= "       event_no_signup = '" . $vars["event_no_signup"] . "', ";
        $event_query .= "       event_date = '" . strtotime($vars["event_date"]) . "', ";
        $event_query .= "       event_signup_start = '" . strtotime($vars["event_signup_start"]) . "', ";
        $event_query .= "       event_signup_end = '" . strtotime($vars["event_signup_end"]) . "', ";
        $event_query .= "       event_desc = '" . trim(clean_string($vars["event_desc"])) . "', ";
        $event_query .= "       event_max_signup = '" . trim($vars["event_max_signup"]) . "'";
        $event_query .= " where event_id = '" . $event_id . "'";

        update_db($event_query);
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function add_item($vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!trim($vars["item_name"])) {
        $err = "The Item Name cannot be blank.";
    } elseif (strlen($vars["item_name"]) > 50) {
        $err = "The Item Name is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z0-9 -']+$/", $vars["item_name"])) {
        $err = "The Item Name contains invalid symbols.";
    } elseif (strlen($vars["item_notes"]) > 200) {
        $err = "The Item Notes is too long.  It may only be 200 characters in length.";
    } elseif (!preg_match("/^[0-9 .]+$/", $vars["item_value"])) {
        $err = "The Points must be numeric.";
    } else {
        $values  = "0,";
        $values .= "'" . clean_string($vars["item_name"]) . "',";
        $values .= "'" . clean_string($vars["item_notes"]) . "',";
        $values .= "'" . $vars["item_magelo"] . "',";
        $values .= "'" . $vars["item_value"] . "'";

        $query  = "insert into " . TABLE_PREFIX . "items (item_id, item_name, item_notes, item_magelo, item_value) ";
        $query .= "values ($values)";

        update_db($query);
    }
    return $err;
}

/**
 * @param $item_id
 * @param $vars
 * @return string
 */
function edit_item($item_id, $vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!trim($vars["item_name"])) {
        $err = "The Item Name cannot be blank.";
    } elseif (strlen($vars["item_name"]) > 50) {
        $err = "The Item Name is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z0-9 -']+$/", $vars["item_name"])) {
        $err = "The Item Name contains invalid symbols.";
    } elseif (strlen($vars["item_notes"]) > 200) {
        $err = "The Item Notes is too long.  It may only be 200 characters in length.";
    } elseif (!preg_match("/^[0-9 .]+$/", $vars["item_value"])) {
        $err = "The Points must be numeric.";
    } else {
        $item_query  = "update " . TABLE_PREFIX . "items";
        $item_query .= "   set item_name = '" . trim(clean_string($vars["item_name"])) . "', ";
        $item_query .= "       item_notes = '" . trim(clean_string($vars["item_notes"])) . "', ";
        $item_query .= "       item_magelo = '" . trim($vars["item_magelo"]) . "', ";
        $item_query .= "       item_value = '" . trim($vars["item_value"]) . "'";
        $item_query .= " where item_id = '" . $item_id . "'";

        update_db($item_query);
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function add_purchase($vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        if ($vars["ireceived_cost"] == "") {
            $query  = "select *";
            $query .= "  from " . TABLE_PREFIX . "items";
            $query .= "  where item_id = '" . $vars["item_id"] . "'";

            query_db($query, $item_info);
        }
        if ($vars["ireceived_cost"] == "") {
            $item_cost = $item_info["item_value"];
        } else {
            $item_cost = $vars["ireceived_cost"];
        }
        $values  = "0,";
        $values .= "'" . $vars["raid_id"] . "',";
        $values .= "'" . $vars["roster_id"] . "',";
        $values .= "'" . $vars["item_id"] . "',";
        $values .= "'" . $item_cost . "'";

        $query  = "insert into " . TABLE_PREFIX . "item_received (ireceived_id, raid_id, roster_id, item_id, ireceived_cost) ";
        $query .= "values ($values)";

        update_db($query);

        $dkp_query  = "update " . TABLE_PREFIX . "roster";
        $dkp_query .= "   set roster_spent = roster_spent + " . $item_cost . "";
        $dkp_query .= " where roster_id = '" . $vars["roster_id"] . "'";

        update_db($dkp_query);

        //---------------------------------------------------
        // Distribute points among attendees

        $query  = "select COUNT(raid_id) as max";
        $query .= "  from " . TABLE_PREFIX . "raid_attendance";
        $query .= " where raid_id = '" . $vars["raid_id"] . "'";

        query_db($query, $attendee);

        $query  = "select COUNT(ra.raid_id) as max, r.roster_type";
        $query .= "  from " . TABLE_PREFIX . "raid_attendance as ra";
        $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = ra.roster_id";
        $query .= " where ra.raid_id = '" . $vars["raid_id"] . "' and r.roster_type = '1'";

        query_db($query, $alt_attendees);

        $query  = "select COUNT(ra.raid_id) as max, r.roster_type";
        $query .= "  from " . TABLE_PREFIX . "raid_attendance as ra";
        $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = ra.roster_id";
        $query .= " where ra.raid_id = '" . $vars["raid_id"] . "' and r.roster_type = '0'";

        query_db($query, $main_attendees);

        $alt_value = round(($item_cost / $attendee["max"]) / 2, 2);
        $main_value = round(($item_cost - ((($item_cost / $attendee["max"]) / 2) * $alt_attendees["max"])) / $main_attendees["max"], 2);

        $query  = "select ra.*, r.roster_type";
        $query .= "  from " . TABLE_PREFIX . "raid_attendance as ra";
        $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = ra.roster_id";
        $query .= " where ra.raid_id = '" . $vars["raid_id"] . "' and r.roster_type = '0'";

        $get_main_attendees["count"] = query_db($query, $get_main_attendees, true);

        for ($i = 0; $i < $get_main_attendees["count"]; $i++) {
            $add_main_dkp_query  = "update " . TABLE_PREFIX . "roster";
            $add_main_dkp_query .= "   set roster_adjusted = roster_adjusted + " . $main_value . "";
            $add_main_dkp_query .= " where roster_id = '" . $get_main_attendees[$i]["roster_id"] . "'";

            update_db($add_main_dkp_query);
        }

        $query  = "select ra.*, r.roster_type";
        $query .= "  from " . TABLE_PREFIX . "raid_attendance as ra";
        $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = ra.roster_id";
        $query .= " where ra.raid_id = '" . $vars["raid_id"] . "' and r.roster_type = '1'";

        $get_alt_attendees["count"] = query_db($query, $get_alt_attendees, true);

        for ($j = 0; $j < $get_alt_attendees["count"]; $j++) {
            $add_alt_dkp_query  = "update " . TABLE_PREFIX . "roster";
            $add_alt_dkp_query .= "   set roster_adjusted = roster_adjusted + " . $alt_value . "";
            $add_alt_dkp_query .= " where roster_id = '" . $get_alt_attendees[$j]["roster_id"] . "'";

            update_db($add_alt_dkp_query);
        }
    }
    return $err;
}

/**
 * @param $ireceived_id
 * @param $vars
 * @return string
 */
function edit_purchase($ireceived_id, $vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        if ($vars["ireceived_cost"] == "") {
            $query  = "select *";
            $query .= "  from " . TABLE_PREFIX . "items";
            $query .= "  where item_id = '" . $vars["item_id"] . "'";

            query_db($query, $item_info);
        }
        if (($vars["ireceived_cost"] == "") || ($vars["ireceived_cost"] == '0.00')) {
            $item_cost = $item_info["item_value"];
        } else {
            $item_cost = $vars["ireceived_cost"];
        }

        $item_query  = "update " . TABLE_PREFIX . "item_received";
        $item_query .= "   set raid_id = '" . trim($vars["raid_id"]) . "', ";
        $item_query .= "       roster_id = '" . trim(clean_string($vars["roster_id"])) . "', ";
        $item_query .= "       item_id = '" . trim($vars["item_id"]) . "', ";
        $item_query .= "       ireceived_cost = '" . $item_cost . "'";
        $item_query .= " where ireceived_id = '" . $ireceived_id . "'";

        update_db($item_query);

        $minus_dkp_query  = "update " . TABLE_PREFIX . "roster";
        $minus_dkp_query .= "   set roster_spent = (roster_spent - " . $vars["old_ireceived_cost"] . ")";
        $minus_dkp_query .= " where roster_id = '" . $vars["roster_id"] . "'";

        update_db($minus_dkp_query);

        $add_dkp_query  = "update " . TABLE_PREFIX . "roster";
        $add_dkp_query .= "   set roster_spent = (roster_spent + '" . $item_cost . "')";
        $add_dkp_query .= " where roster_id = '" . $vars["roster_id"] . "'";

        update_db($add_dkp_query);

        //---------------------------------------------------
        // Distribute points among attendees

        $query  = "select COUNT(raid_id) as max";
        $query .= "  from " . TABLE_PREFIX . "raid_attendance";
        $query .= " where raid_id = '" . $vars["raid_id"] . "'";

        query_db($query, $attendee);

        $query  = "select COUNT(ra.raid_id) as max, r.roster_type";
        $query .= "  from " . TABLE_PREFIX . "raid_attendance as ra";
        $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = ra.roster_id";
        $query .= " where ra.raid_id = '" . $vars["raid_id"] . "' and r.roster_type = '1'";

        query_db($query, $alt_attendees);

        $query  = "select COUNT(ra.raid_id) as max, r.roster_type";
        $query .= "  from " . TABLE_PREFIX . "raid_attendance as ra";
        $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = ra.roster_id";
        $query .= " where ra.raid_id = '" . $vars["raid_id"] . "' and r.roster_type = '0'";

        query_db($query, $main_attendees);

        $alt_value = round(($item_cost / $attendee["max"]) / 2, 2);
        $main_value = round(($item_cost - ((($item_cost / $attendee["max"]) / 2) * $alt_attendees["max"])) / $main_attendees["max"], 2);

        $old_alt_value = round(($vars["old_ireceived_cost"] / $attendee["max"]) / 2, 2);
        $old_main_value = round(($vars["old_ireceived_cost"] - ((($vars["old_ireceived_cost"] / $attendee["max"]) / 2) * $alt_attendees["max"])) / $main_attendees["max"], 2);

        $query  = "select ra.*, r.roster_type";
        $query .= "  from " . TABLE_PREFIX . "raid_attendance as ra";
        $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = ra.roster_id";
        $query .= " where ra.raid_id = '" . $vars["raid_id"] . "' and r.roster_type = '0'";

        $get_main_attendees["count"] = query_db($query, $get_main_attendees, true);

        for ($i = 0; $i < $get_main_attendees["count"]; $i++) {
            $remove_dkp_query  = "update " . TABLE_PREFIX . "roster";
            $remove_dkp_query .= "   set roster_adjusted = roster_adjusted - " . $old_main_value . "";
            $remove_dkp_query .= " where roster_id = '" . $get_main_attendees[$i]["roster_id"] . "'";

            update_db($remove_dkp_query);

            $add_dkp_query  = "update " . TABLE_PREFIX . "roster";
            $add_dkp_query .= "   set roster_adjusted = roster_adjusted + " . $main_value . "";
            $add_dkp_query .= " where roster_id = '" . $get_main_attendees[$i]["roster_id"] . "'";

            update_db($add_dkp_query);
        }

        $query  = "select ra.*, r.roster_type";
        $query .= "  from " . TABLE_PREFIX . "raid_attendance as ra";
        $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = ra.roster_id";
        $query .= " where ra.raid_id = '" . $vars["raid_id"] . "' and r.roster_type = '1'";

        $get_alt_attendees["count"] = query_db($query, $get_alt_attendees, true);

        for ($i = 0; $i < $get_alt_attendees["count"]; $i++) {
            $remove_dkp_query  = "update " . TABLE_PREFIX . "roster";
            $remove_dkp_query .= "   set roster_adjusted = roster_adjusted - " . $old_alt_value . "";
            $remove_dkp_query .= " where roster_id = '" . $get_alt_attendees[$i]["roster_id"] . "'";

            update_db($remove_dkp_query);

            $add_dkp_query  = "update " . TABLE_PREFIX . "roster";
            $add_dkp_query .= "   set roster_adjusted = roster_adjusted + " . $alt_value . "";
            $add_dkp_query .= " where roster_id = '" . $get_alt_attendees[$i]["roster_id"] . "'";

            update_db($add_dkp_query);
        }
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function add_destination($vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!trim($vars["dest_name"])) {
        $err = "The Destination Name cannot be blank.";
    } elseif (strlen($vars["dest_name"]) > 50) {
        $err = "The Destination Name is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z0-9 -]+$/", $vars["dest_name"])) {
        $err = "The Destination Name contains invalid symbols.";
    } else {
        $values  = "0,";
        $values .= "'" . trim($vars["dest_name"]) . "',";
        $values .= "'" . trim($vars["dest_value"]) . "'";

        $query  = "insert into " . TABLE_PREFIX . "destinations (dest_id, dest_name, dest_value) ";
        $query .= "values ($values)";

        update_db($query);
    }
    return $err;
}

/**
 * @param $dest_id
 * @param $vars
 * @return string
 */
function edit_destination($dest_id, $vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!trim($vars["dest_name"])) {
        $err = "The Destination Name cannot be blank.";
    } elseif (strlen($vars["dest_name"]) > 50) {
        $err = "The Destination Name is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z0-9 -]+$/", $vars["dest_name"])) {
        $err = "The Destination Name contains invalid symbols.";
    } else {
        $dest_query  = "update " . TABLE_PREFIX . "destinations";
        $dest_query .= "   set dest_name = '" . trim($vars["dest_name"]) . "', ";
        $dest_query .= "       dest_value = '" . $vars["dest_value"] . "'";
        $dest_query .= " where dest_id = '" . $dest_id . "'";

        update_db($dest_query);
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function add_adjustment($vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (strlen($vars["adjustment_desc"]) > 200) {
        $err = "The Description is too long.  It may only be 200 characters in length.";
    } else {
        $values  = "0,";
        $values .= "'" . $vars["roster_id"] . "',";
        $values .= "'" . strtotime($vars["adjustment_date"]) . "',";
        $values .= "'" . trim($vars["adjustment_amount"]) . "',";
        $values .= "'" . trim($vars["adjustment_desc"]) . "'";

        $query  = "insert into " . TABLE_PREFIX . "adjustments (adjustment_id, roster_id, adjustment_date, adjustment_amount, adjustment_desc) ";
        $query .= "values ($values)";

        update_db($query);

        $dkp_query  = "update " . TABLE_PREFIX . "roster";
        $dkp_query .= "   set roster_adjusted = roster_adjusted + " . $vars["adjustment_amount"] . "";
        $dkp_query .= " where roster_id = '" . $vars["roster_id"] . "'";

        update_db($dkp_query);
    }
    return $err;
}

/**
 * @param $adjustment_id
 * @param $vars
 * @return string
 */
function edit_adjustment($adjustment_id, $vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (strlen($vars["adjustment_desc"]) > 200) {
        $err = "The Description is too long.  It may only be 200 characters in length.";
    } else {
        $item_query  = "update " . TABLE_PREFIX . "adjustments";
        $item_query .= "   set roster_id = '" . $vars["roster_id"] . "', ";
        $item_query .= "       adjustment_date = '" . strtotime($vars["adjustment_date"]) . "', ";
        $item_query .= "       adjustment_amount = '" . trim($vars["adjustment_amount"]) . "', ";
        $item_query .= "       adjustment_desc = '" . trim($vars["adjustment_desc"]) . "'";
        $item_query .= " where adjustment_id = '" . $adjustment_id . "'";

        update_db($item_query);

        $minus_dkp_query  = "update " . TABLE_PREFIX . "roster";
        $minus_dkp_query .= "   set roster_adjusted = (roster_adjusted - '" . $vars["old_adjustment_amount"] . "')";
        $minus_dkp_query .= " where roster_id = '" . $vars["roster_id"] . "'";

        update_db($minus_dkp_query);

        $add_dkp_query  = "update " . TABLE_PREFIX . "roster";
        $add_dkp_query .= "   set roster_adjusted = (roster_adjusted + '" . $vars["adjustment_amount"] . "')";
        $add_dkp_query .= " where roster_id = '" . $vars["roster_id"] . "'";

        update_db($add_dkp_query);
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function mass_adjust($vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (strlen($vars["adjustment_desc"]) > 200) {
        $err = "The Description is too long.  It may only be 200 characters in length.";
    } else {
        for($i = 0; $i < count($vars["roster_id"]); $i++) {
            if ($vars["adjustment_amount"][$i] != "") {
                $values  = "0,";
                $values .= "'" . $vars["roster_id"][$i] . "',";
                $values .= "'" . strtotime($vars["adjustment_date"]) . "',";
                $values .= "'" . trim($vars["adjustment_amount"][$i]) . "',";
                $values .= "'" . trim($vars["adjustment_desc"]) . "'";

                $query  = "insert into " . TABLE_PREFIX . "adjustments (adjustment_id, roster_id, adjustment_date, adjustment_amount, adjustment_desc) ";
                $query .= "values ($values)";

                update_db($query);

                $add_dkp_query  = "update " . TABLE_PREFIX . "roster";
                $add_dkp_query .= "   set roster_adjusted = (roster_adjusted + " . $vars["adjustment_amount"][$i] . ")";
                $add_dkp_query .= " where roster_id = '" . $vars["roster_id"][$i] . "'";

                update_db($add_dkp_query);
            }
        }
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function manual_raid($vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (strlen($vars["raid_desc"]) > 500) {
        $err = "The Description is too long.  It may only be 500 characters in length.";
    } else {
        $values  = "0,";
        $values .= "'" . $vars["event_id"] . "',";
        $values .= "'" . $vars["dest_id"] . "',";
        $values .= "'" . trim($vars["raid_desc"]) . "',";
        $values .= "'" . trim($vars["raid_value"]) . "'";

        $query  = "insert into " . TABLE_PREFIX . "raids (raid_id, event_id, dest_id, raid_desc, raid_value) ";
        $query .= "values ($values)";

        update_db($query);

        $query  = "select raid_id";
        $query .= "  from " . TABLE_PREFIX . "raids";
        $query .= " order by raid_id desc";
        $query .= " limit 1";

        query_db($query, $get_rid);

        foreach($vars as $key => $value) {
            if (substr($key, 17)) {
                $roster_id = substr($key, 17);

                $query  = "select roster_id, roster_type";
                $query .= "  from " . TABLE_PREFIX . "roster";
                $query .= " where roster_id = '" . $roster_id . "'";

                query_db($query, $check_type);

                if (($value == "") || ($value == '0.00')) {
                    $query  = "select *";
                    $query .= "  from " . TABLE_PREFIX . "destinations";
                    $query .= "  where dest_id = '" . $vars["dest_id"] . "'";

                    query_db($query, $dest_info);
                    if (($vars["raid_value"] == "") || ($vars["raid_value"] == '0.00')) {
                        $points = $dest_info["dest_value"];
                    } else {
                        $points = $vars["raid_value"];
                    }
                } else {
                    $points = $value;
                }
                if ($check_type["roster_type"] == 1) {
                    $points = $points / 2;
                }
                $values  = "'" . $get_rid["raid_id"] . "',";
                $values .= "'" . $roster_id . "',";
                $values .= "'" . $points . "'";

                $query  = "insert into " . TABLE_PREFIX . "raid_attendance (raid_id, roster_id, attendance_value) ";
                $query .= "values ($values)";

                update_db($query);

                $add_dkp_query  = "update " . TABLE_PREFIX . "roster";
                $add_dkp_query .= "   set roster_earned = (roster_earned + '" . $points . "')";
                $add_dkp_query .= " where roster_id = '" . $roster_id . "'";

                update_db($add_dkp_query);
            }
        }
    }
    return $err;
}

/**
 * @param $raid_id
 * @param $vars
 * @return string
 */
function edit_raid($raid_id, $vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (strlen($vars["raid_desc"]) > 500) {
        $err = "The Description is too long.  It may only be 500 characters in length.";
    } else {
        $query  = "select *";
        $query .= "  from " . TABLE_PREFIX . "raids";
        $query .= "  where raid_id = '" . $raid_id . "'";

        query_db($query, $get_atval);

        $raid_query  = "update " . TABLE_PREFIX . "raids";
        $raid_query .= "   set event_id = '" . $vars["event_id"] . "', ";
        $raid_query .= "       dest_id = '" . $vars["dest_id"] . "', ";
        $raid_query .= "       raid_desc = '" . trim($vars["raid_desc"]) . "', ";
        $raid_query .= "       raid_value = '" . trim($vars["raid_value"]) . "'";
        $raid_query .= " where raid_id = '" . $raid_id . "'";

        update_db($raid_query);

        $combined_array = array_combine ($vars["roster_id_check"], $vars["attendance_value"]);

        foreach($vars["roster_id"] as $key => $value) {
            read_raid_attendees($raid_id, $value, $attendee);
            if (array_key_exists($value, $combined_array)) {
                if (!$attendee["roster_id"]) {
                    if (($combined_array[$value] == "") || ($combined_array[$value] == '0.00')) {
                        $query  = "select *";
                        $query .= "  from " . TABLE_PREFIX . "destinations";
                        $query .= "  where dest_id = '" . $vars["dest_id"] . "'";

                        query_db($query, $dest_info);
                        if (($vars["raid_value"] == "") || ($vars["raid_value"] == '0.00')) {
                            $points = $dest_info["dest_value"];
                        } else {
                            $points = $vars["raid_value"];
                        }
                    } else {
                        $points = $combined_array[$value];
                    }
                    $values  = "'" . $raid_id . "',";
                    $values .= "'" . $value . "',";
                    $values .= "'" . $points . "'";


                    $query  = "insert into " . TABLE_PREFIX . "raid_attendance (raid_id, roster_id, attendance_value) ";
                    $query .= "values ($values)";

                    update_db($query);

                    $add_dkp_query  = "update " . TABLE_PREFIX . "roster";
                    $add_dkp_query .= "   set roster_earned = (roster_earned + '" . $points . "')";
                    $add_dkp_query .= " where roster_id = '" . $value . "'";

                    update_db($add_dkp_query);
                } else {
                    if ($combined_array[$value] != $attendee["attendance_value"]) {
                        if (($combined_array[$value] == "") || ($combined_array[$value] == '0.00')) {
                            $query  = "select *";
                            $query .= "  from " . TABLE_PREFIX . "destinations";
                            $query .= "  where dest_id = '" . $vars["dest_id"] . "'";

                            query_db($query, $dest_info);
                            if (($vars["raid_value"] == "") || ($vars["raid_value"] == '0.00')) {
                                $points = $dest_info["dest_value"];
                            } else {
                                $points = $vars["raid_value"];
                            }
                        } else {
                            $points = $combined_array[$value];
                        }
                        $minus_dkp_query  = "update " . TABLE_PREFIX . "roster";
                        $minus_dkp_query .= "   set roster_earned = (roster_earned - '" . $attendee["attendance_value"] . "')";
                        $minus_dkp_query .= " where roster_id = '" . $value . "'";

                        update_db($minus_dkp_query);

                        $update_atval_query  = "update " . TABLE_PREFIX . "raid_attendance";
                        $update_atval_query .= "   set attendance_value = '" . $points . "'";
                        $update_atval_query .= " where raid_id = '" . $raid_id . "' and roster_id = '" . $value . "'";

                        update_db($update_atval_query);

                        $add_dkp_query  = "update " . TABLE_PREFIX . "roster";
                        $add_dkp_query .= "   set roster_earned = (roster_earned + '" . $points . "')";
                        $add_dkp_query .= " where roster_id = '" . $value . "'";

                        update_db($add_dkp_query);
                    }
                }
            } else {
                if ($attendee["roster_id"]) {
                    $minus_dkp_query  = "update " . TABLE_PREFIX . "roster";
                    $minus_dkp_query .= "   set roster_earned = (roster_earned - '" . $attendee["attendance_value"] . "')";
                    $minus_dkp_query .= " where roster_id = '" . $value . "'";

                    update_db($minus_dkp_query);

                    $delete_raid_query = "delete";
                    $delete_raid_query .= "  from " . TABLE_PREFIX . "raid_attendance";
                    $delete_raid_query .= " where raid_id = '" . $raid_id . "' and roster_id = '" . $value . "'";

                    update_db($delete_raid_query);
                }
            }
        }
    }
    return $err;
}

/**
 * @param $log_file
 * @param $chars
 * @param $chars_no_id
 * @return string
 */
function import_raid($log_file, &$chars, &$chars_no_id) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!strlen(trim($log_file["name"]))) {
        $err = "There was no file uploaded.";
    } elseif ($log_file["type"] != "text/plain") {
        $err = "The log is of an invalid file type.";
    } elseif ($log_file["size"] > 1048576) {
        $err = "The log is too large.";
    } else {
        $chars_no_id = array();
        $chars = array();
        //Getting and storing the temporary file name of the uploaded file
        $fileName = $log_file['tmp_name'];
        //Throw an error message if the file could not be open
        $file = fopen($fileName,"r") or exit("Unable to open file!");
        // Reading a .txt file line by line
        while(!feof($file)) {
            preg_match("/[a-zA-Z]+/", fgets($file), $info);
            read_roster_info($info[0], $roster_info);
            if ($roster_info["roster_id"]) {
                #echo $info[0] . " - " . $roster_info["roster_id"] . "<br />";
                if ($info[0] != "") {
                    $chars[$roster_info["roster_id"]] = $info[0];
                }
            } else {
                if ($info[0] != "") {
                    $chars_no_id[] = $info[0];
                }
            }
        }
        fclose($file);
    }
    if ($err) {
        $chars_no_id = array();
        $chars = array();
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function transfer_dkp($vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        $query  = "select *";
        $query .= "  from " . TABLE_PREFIX . "roster";
        $query .= "  where roster_id = '" . $vars["roster_id_from"] . "'";

        query_db($query, $get_dkp_from);

        $transfer_dkp_query  = "update " . TABLE_PREFIX . "roster";
        $transfer_dkp_query .= "   set roster_earned = '" . $get_dkp_from["roster_earned"] . "',";
        $transfer_dkp_query .= "       roster_spent = '" . $get_dkp_from["roster_spent"] . "',";
        $transfer_dkp_query .= "       roster_adjusted = '" . $get_dkp_from["roster_adjusted"] . "'";
        $transfer_dkp_query .= " where roster_id = '" . $vars["roster_id_to"] . "'";

        update_db($transfer_dkp_query);

        $remove_dkp_query  = "update " . TABLE_PREFIX . "roster";
        $remove_dkp_query .= "   set roster_earned = '0',";
        $remove_dkp_query .= "       roster_spent = '0',";
        $remove_dkp_query .= "       roster_adjusted = '0'";
        $remove_dkp_query .= " where roster_id = '" . $vars["roster_id_from"] . "'";

        update_db($remove_dkp_query);

        //-----------------------------------------------------------
        $change_adj_query  = "update " . TABLE_PREFIX . "adjustments";
        $change_adj_query .= "   set roster_id = '99999999'";
        $change_adj_query .= " where roster_id = '" . $vars["roster_id_from"] . "'";

        update_db($change_adj_query);

        $delete_char_query = "delete";
        $delete_char_query .= "  from " . TABLE_PREFIX . "event_signups";
        $delete_char_query .= " where event_id = '" . $event_id . "' and roster_id = '" . $vars["roster_id"] . "'";

        update_db($delete_char_query);
    }
    return $err;
}

/**
 * @param $event_id
 * @param $vars
 * @return string
 */
function add_signup($event_id, $vars) {
    global $user;
    get_auth_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        $values  = "'" . $event_id . "',";
        $values .= "'" . $vars["roster_id"] . "',";
        $values .= "'" . $vars["signup_late"] . "'";

        $query  = "insert into " . TABLE_PREFIX . "event_signups (event_id, roster_id, signup_late) ";
        $query .= "values ($values)";

        update_db($query);
    }
    return $err;
}

/**
 * @param $event_id
 * @param $vars
 * @return string
 */
function delete_signup($event_id, $vars) {
    global $user;
    get_auth_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        $delete_char_query = "delete";
        $delete_char_query .= "  from " . TABLE_PREFIX . "event_signups";
        $delete_char_query .= " where event_id = '" . $event_id . "' and roster_id = '" . $vars["roster_id"] . "'";

        update_db($delete_char_query);
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function wipe_dkp($vars) {
    global $user;
    get_admin_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        if ($vars["adjustments_table"]) {
            $query = "truncate";
            $query .= " table " . TABLE_PREFIX . "adjustments";

            update_db($query);
        }
        if ($vars["destinations_table"]) {
            $query = "truncate";
            $query .= " table " . TABLE_PREFIX . "destinations";

            update_db($query);
        }
        if ($vars["events_table"]) {
            $query = "truncate";
            $query .= " table " . TABLE_PREFIX . "events";

            update_db($query);
        }
        if ($vars["event_signups_table"]) {
            $query = "truncate";
            $query .= " table " . TABLE_PREFIX . "event_signups";

            update_db($query);
        }
        if ($vars["items_table"]) {
            $query = "truncate";
            $query .= " table " . TABLE_PREFIX . "items";

            update_db($query);
        }
        if ($vars["items_received_table"]) {
            $query = "truncate";
            $query .= " table " . TABLE_PREFIX . "item_received";

            update_db($query);
        }
        if ($vars["raids_table"]) {
            $query = "truncate";
            $query .= " table " . TABLE_PREFIX . "raids";

            update_db($query);
        }
        if ($vars["raid_attendance_table"]) {
            $query = "truncate";
            $query .= " table " . TABLE_PREFIX . "raid_attendance";

            update_db($query);
        }
        if ($vars["char_dkp"]) {
            $query  = "update " . TABLE_PREFIX . "roster";
            $query .= "   set roster_earned = '0',";
            $query .= "       roster_spent = '0',";
            $query .= "       roster_adjusted = '0'";

            update_db($query);
        }
    }
    return $err;
}