<?php
/**
 * File              : write_roster.php
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
function add_char($vars) {
    global $user;
    get_auth_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!trim($vars["roster_charfirst"])) {
        $err = "The Character Name cannot be blank.";
    } elseif (strlen($vars["roster_charfirst"]) > 50) {
        $err = "The Character Name is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $vars["roster_charfirst"])) {
        $err = "The Character Name contains invalid symbols.";
    } elseif (strlen($vars["roster_charlast"]) > 50) {
        $err = "The Character Surname is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $vars["roster_charlast"]) && $vars["roster_charlast"] != "") {
        $err = "The Character Surname can only be A-Z.";
    } elseif (!$vars["roster_level"]) {
        $err = "The Character Level cannot be blank.";
    } elseif (!preg_match("/^[0-9]+$/", $vars["roster_level"])) {
        $err = "The Character Level must be numeric.";
    } elseif ($vars["roster_level"] < 1) {
        $err = "The Character Level must be at least 1.";
    } elseif ($vars["roster_level"] > 50) {
        $err = "The Character Level must be 50 or less.";
    } else {
        $query  = "select roster_id";
        $query .= "  from " . TABLE_PREFIX . "roster";
        $query .= " where roster_charfirst = '" . $vars["roster_charfirst"] . "'";

        query_db($query, $char_exists);

        $query  = "select roster_id, roster_type, roster_rank";
        $query .= "  from " . TABLE_PREFIX . "roster";
        $query .= " where user_id = '" . $user->data['user_id'] . "' and roster_type = '0'";

        query_db($query, $user_exists);

        if ($char_exists["roster_id"]) {
            $err = "That character already exists in the database.";
        } else {
            if ($user_exists["roster_id"]) {
                $main_exists = 1;
                $main_rank = $user_exists["roster_rank"];
            } else {
                $main_exists = 0;
                $main_rank = $user_exists["roster_rank"];
            }
            $values  = "0,";
            $values .= $user->data['user_id'] . ",";
            $values .= "'" . $main_exists . "',";
            $values .= "'" . ucfirst($vars["roster_charfirst"]) . "',";
            $values .= "'" . ucfirst($vars["roster_charlast"]) . "',";
            $values .= "'" . $main_rank . "',";
            $values .= "'" . $vars["roster_class"] . "',";
            $values .= "'" . $vars["roster_level"] . "',";
            $values .= "'" . $vars["roster_epic"] . "',";
            $values .= "'" . $vars["roster_magelo"] . "',";
            $values .= "0,";
            $values .= "0,";
            $values .= "0";

            $query  = "insert into " . TABLE_PREFIX . "roster (roster_id, user_id, roster_type, roster_charfirst, roster_charlast, roster_rank, roster_class, roster_level, roster_epic, roster_magelo, roster_earned, roster_spent, roster_adjusted) ";
            $query .= "values ($values)";

            update_db($query);

            $query  = "select roster_id";
            $query .= "  from " . TABLE_PREFIX . "roster";
            $query .= " where user_id = '" . $user->data['user_id'] . "' and roster_charfirst = '" . ucfirst($vars["roster_charfirst"]) . "'";

            query_db($query, $get_char_id);

            $query  = "select roster_id";
            $query .= "  from " . TABLE_PREFIX . "roster";
            $query .= " where user_id = '" . $user->data['user_id'] . "'";
            $query .= " order by roster_id desc";
            $query .= " limit 1";

            query_db($query, $get_rid);

            $key_values  = "0,";
            $key_values .= $get_char_id["roster_id"] . ",";
            $key_values .= "'" . $vars["sky_1"] . "',";
            $key_values .= "'" . $vars["sky_2"] . "',";
            $key_values .= "'" . $vars["sky_3"] . "',";
            $key_values .= "'" . $vars["sky_4"] . "',";
            $key_values .= "'" . $vars["sky_5"] . "',";
            $key_values .= "'" . $vars["sky_6"] . "',";
            $key_values .= "'" . $vars["sky_7"] . "'";

            $key_query  = "insert into " . TABLE_PREFIX . "roster_keys (key_id, roster_id, sky_1, sky_2, sky_3, sky_4, sky_5, sky_6, sky_7) ";
            $key_query .= "values ($key_values)";

            update_db($key_query);

            $tskill_values  = "0,";
            $tskill_values .= $get_char_id["roster_id"] . ",";
            $tskill_values .= "'" . $vars["tskills_alchemy"] . "',";
            $tskill_values .= "'" . $vars["tskills_baking"] . "',";
            $tskill_values .= "'" . $vars["tskills_blacksmithing"] . "',";
            $tskill_values .= "'" . $vars["tskills_brewing"] . "',";
            $tskill_values .= "'" . $vars["tskills_fishing"] . "',";
            $tskill_values .= "'" . $vars["tskills_fletching"] . "',";
            $tskill_values .= "'" . $vars["tskills_jewelcrafting"] . "',";
            $tskill_values .= "'" . $vars["tskills_poisonmaking"] . "',";
            $tskill_values .= "'" . $vars["tskills_pottery"] . "',";
            $tskill_values .= "'" . $vars["tskills_research"] . "',";
            $tskill_values .= "'" . $vars["tskills_tailoring"] . "',";
            $tskill_values .= "'" . $vars["tskills_tinkering"] . "'";

            $tskill_query  = "insert into " . TABLE_PREFIX . "roster_tradeskills (tskills_id, roster_id, tskills_alchemy, tskills_baking, tskills_blacksmithing, tskills_brewing, tskills_fishing, tskills_fletching, tskills_jewelcrafting, tskills_poisonmaking, tskills_pottery, tskills_research, tskills_tailoring, tskills_tinkering) ";
            $tskill_query .= "values ($tskill_values)";

            update_db($tskill_query);
        }
    }
    return $err;
}

/**
 * @param $char_id
 * @param $vars
 * @return string
 */
function edit_char($char_id, $vars) {
    global $user;
    get_auth_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!trim($vars["roster_charfirst"])) {
        $err = "The Character Name cannot be blank.";
    } elseif (strlen($vars["roster_charfirst"]) > 50) {
        $err = "The Character Name is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $vars["roster_charfirst"])) {
        $err = "The Character Name contains invalid symbols.";
    } elseif (strlen($vars["roster_charlast"]) > 50) {
        $err = "The Character Surname is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $vars["roster_charlast"]) && $vars["roster_charlast"] != "") {
        $err = "The Character Surname can only be A-Z.";
    } elseif (!$vars["roster_level"]) {
        $err = "The Character Level cannot be blank.";
    } elseif (!preg_match("/^[0-9]+$/", $vars["roster_level"])) {
        $err = "The Character Level must be numeric.";
    } elseif ($vars["roster_level"] < 1) {
        $err = "The Character Level must be at least 1.";
    } elseif ($vars["roster_level"] > 50) {
        $err = "The Character Level must be 50 or less.";
    } else {
        $query  = "select roster_id";
        $query .= "  from " . TABLE_PREFIX . "roster";
        $query .= " where roster_charfirst = '" . $vars["roster_charfirst"] . "' and roster_id != '" . $char_id . "'";

        query_db($query, $char_exists);

        $query  = "select roster_id";
        $query .= "  from " . TABLE_PREFIX . "roster";
        $query .= " where roster_id = '" . $char_id . "' and user_id = '" . $user->data['user_id'] . "'";

        query_db($query, $user_exists);

        if ($char_exists["roster_id"]) {
            $err = "That character already exists in the database.";
        } elseif ($user_exists["roster_id"] != $char_id) {
            $err = "You do not own that character.";
        } else {
            $char_query  = "update " . TABLE_PREFIX . "roster";
            $char_query .= "   set roster_charfirst = '" . trim(ucfirst($vars["roster_charfirst"])) . "', ";
            $char_query .= "       roster_charlast = '" . trim(ucfirst($vars["roster_charlast"])) . "', ";
            $char_query .= "       roster_class = '" . $vars["roster_class"] . "', ";
            $char_query .= "       roster_level = '" . trim($vars["roster_level"]) . "', ";
            $char_query .= "       roster_epic = '" . $vars["roster_epic"] . "', ";
            $char_query .= "       roster_magelo = '" . trim($vars["roster_magelo"]) . "'";
            $char_query .= " where roster_id = $char_id";

            update_db($char_query);

            $key_query  = "update " . TABLE_PREFIX . "roster_keys";
            $key_query .= "   set sky_1 = '" . $vars["sky_1"] . "', ";
            $key_query .= "       sky_2 = '" . $vars["sky_2"] . "', ";
            $key_query .= "       sky_3 = '" . $vars["sky_3"] . "', ";
            $key_query .= "       sky_4 = '" . $vars["sky_4"] . "', ";
            $key_query .= "       sky_5 = '" . $vars["sky_5"] . "', ";
            $key_query .= "       sky_6 = '" . $vars["sky_6"] . "', ";
            $key_query .= "       sky_7 = '" . $vars["sky_7"] . "'";
            $key_query .= " where roster_id = $char_id";

            update_db($key_query);

            $tskill_query  = "update " . TABLE_PREFIX . "roster_tradeskills";
            $tskill_query .= "   set tskills_alchemy = '" . $vars["tskills_alchemy"] . "', ";
            $tskill_query .= "       tskills_baking = '" . $vars["tskills_baking"] . "', ";
            $tskill_query .= "       tskills_blacksmithing = '" . $vars["tskills_blacksmithing"] . "', ";
            $tskill_query .= "       tskills_brewing = '" . $vars["tskills_brewing"] . "', ";
            $tskill_query .= "       tskills_fishing = '" . $vars["tskills_fishing"] . "', ";
            $tskill_query .= "       tskills_fletching = '" . $vars["tskills_fletching"] . "', ";
            $tskill_query .= "       tskills_jewelcrafting = '" . $vars["tskills_jewelcrafting"] . "', ";
            $tskill_query .= "       tskills_poisonmaking = '" . $vars["tskills_poisonmaking"] . "', ";
            $tskill_query .= "       tskills_pottery = '" . $vars["tskills_pottery"] . "', ";
            $tskill_query .= "       tskills_research = '" . $vars["tskills_research"] . "', ";
            $tskill_query .= "       tskills_tailoring = '" . $vars["tskills_tailoring"] . "', ";
            $tskill_query .= "       tskills_tinkering = '" . $vars["tskills_tinkering"] . "'";
            $tskill_query .= " where roster_id = $char_id";

            update_db($tskill_query);
        }
    }
    return $err;
}

/**
 * @param $char_id
 * @return string
 */
function delete_char(&$char_id) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        $delete_char_query = "delete";
        $delete_char_query .= "  from " . TABLE_PREFIX . "roster";
        $delete_char_query .= " where roster_id = '" . $char_id . "'";

        update_db($delete_char_query);

        $delete_key_query = "delete";
        $delete_key_query .= "  from " . TABLE_PREFIX . "roster_keys";
        $delete_key_query .= " where roster_id = '" . $char_id . "'";

        update_db($delete_key_query);

        $delete_tskill_query = "delete";
        $delete_tskill_query .= "  from " . TABLE_PREFIX . "roster_tradeskills";
        $delete_tskill_query .= " where roster_id = '" . $char_id . "'";

        update_db($delete_tskill_query);
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function add_rank($vars) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!trim($vars["rank_name"])) {
        $err = "The rank name cannot be blank.";
    } elseif (strlen($vars["rank_name"]) > 50) {
        $err = "The rank name is too long.  It may only be 50 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $vars["rank_name"])) {
        $err = "The rank name contains invalid symbols.";
    } elseif (!trim($vars["rank_order"])) {
        $err = "The rank order cannot be blank.";
    } elseif (strlen($vars["rank_order"]) > 11) {
        $err = "The rank order is too long.  It may only be 11 characters in length.";
    } elseif (!preg_match("/^[0-9]+$/", $vars["rank_order"])) {
        $err = "The rank name contains invalid symbols.";
    } else {
            $values  = "0,";
            $values .= "'" . $vars["rank_name"] . "',";
            $values .= "'" . $vars["rank_order"] . "'";

            $query  = "insert into " . TABLE_PREFIX . "ranks (rank_id, rank_name, rank_order) ";
            $query .= "values ($values)";

            update_db($query);
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function edit_ranks($vars) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        for($i = 0; $i < count($vars['rank_id']); $i++) {
            if (!trim($vars["rank_name"][$i])) {
                $err = "The rank name cannot be blank.";
            } elseif (strlen($vars["rank_name"][$i]) > 50) {
                $err = "The rank name is too long.  It may only be 50 characters in length.";
            } elseif (!preg_match("/^[a-zA-Z ]+$/", $vars["rank_name"][$i])) {
                $err = "The rank name contains invalid symbols.";
            } elseif (!trim($vars["rank_order"][$i])) {
                $err = "The rank order cannot be blank.";
            } elseif (strlen($vars["rank_order"][$i]) > 11) {
                $err = "The rank order is too long.  It may only be 11 characters in length.";
            } elseif (!preg_match("/^[0-9]+$/", $vars["rank_order"][$i])) {
                $err = "The rank name contains invalid symbols.";
            }
        }
        if (!$err) {
            for($i = 0; $i < count($vars['rank_name']); $i++) {
                $char_query  = "update " . TABLE_PREFIX . "ranks";
                $char_query .= "   set rank_name = '" . trim($vars["rank_name"][$i]) . "', ";
                $char_query .= "       rank_order = '" . trim($vars["rank_order"][$i]) . "'";
                $char_query .= " where rank_id = '" . trim($vars["rank_id"][$i]) . "'";

                update_db($char_query);
            }
        }
    }
    return $err;
}

/**
 * @param $rank_id
 * @return string
 */
function delete_rank($rank_id) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        $query  = "select roster_id";
        $query .= "  from " . TABLE_PREFIX . "roster";
        $query .= " where roster_rank = '" . $rank_id . "'";

        query_db($query, $exist);
        if ($exist["roster_id"]) {
            $err = "There are still characters assigned with that rank.";
        } else {
            $delete_char_query = "delete";
            $delete_char_query .= "  from " . TABLE_PREFIX . "ranks";
            $delete_char_query .= " where rank_id = '" . $rank_id . "'";

            update_db($delete_char_query);
        }
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function edit_char_rank($vars) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        $char_query  = "update " . TABLE_PREFIX . "roster";
        $char_query .= "   set roster_rank = '" . trim($vars["roster_rank"]) . "'";
        $char_query .= " where roster_id = '" . trim($vars["roster_id"]) . "'";

        update_db($char_query);
    }
    return $err;
}

/**
 * @param $vars
 * @return string
 */
function edit_roster_type($vars) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        for($i = 0; $i < count($vars["roster_id"]); $i++) {
            $set_alt_query  = "update " . TABLE_PREFIX . "roster";
            $set_alt_query .= "   set roster_type = '1'";
            $set_alt_query .= " where roster_id = '" . $vars["roster_id"][$i] . "'";

            update_db($set_alt_query);
        }
        $set_main_query  = "update " . TABLE_PREFIX . "roster";
        $set_main_query .= "   set roster_type = '0'";
        $set_main_query .= " where roster_id = '" . trim($vars["roster_type"]) . "'";

        update_db($set_main_query);
    }
    return $err;
}