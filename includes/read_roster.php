<?php
/**
 * File              : read_roster.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

/**
 * @param $roster
 * @param $sort1
 * @param $sort2
 * @param $sort3
 * @param $view_alts
 */
function read_roster(&$roster, $sort1, $sort2, $sort3, $view_alts) {
    $query = "select ro.*, ra.*";
    $query .= "  from " . TABLE_PREFIX . "roster as ro";
    $query .= " left join " . TABLE_PREFIX . "ranks as ra on ra.rank_id = ro.roster_rank";
    $query .= " where ro.roster_rank != '0'";
    if ($view_alts == 0) {
        $query .= " and ro.roster_type = '0'";
    } elseif ($view_alts == 1) {
        $query .= " and ro.roster_type = '1'";
    }
    $query .= " order by $sort1 " . ($sort1 == "ro.roster_charfirst" ? "asc" : ($sort1 == "ra.rank_order" ? "asc" : ($sort1 == "ro.roster_level" ? "desc" : "asc")));
    $query .= " , $sort2 " . ($sort2 == "ro.roster_charfirst" ? "asc" : ($sort2 == "ra.rank_order" ? "asc" : ($sort2 == "ro.roster_level" ? "desc" : "asc")));
    $query .= " , $sort3 " . ($sort3 == "ro.roster_charfirst" ? "asc" : ($sort3 == "ra.rank_order" ? "asc" : ($sort3 == "ro.roster_level" ? "desc" : "asc")));
    #$query .= " order by ra.rank_order asc , ro.roster_charfirst asc";

    $roster["count"] = query_db($query, $roster, true);
}

/**
 * @param $user_id
 * @param $user_chars
 */
function read_user_chars($user_id, &$user_chars) {
    $query = "select ro.*, ra.*";
    $query .= "  from " . TABLE_PREFIX . "roster as ro";
    $query .= " left join " . TABLE_PREFIX . "ranks as ra on ra.rank_id = ro.roster_rank";
    $query .= " where ro.user_id = '" . $user_id . "'";
    $query .= " order by ra.rank_order asc , ro.roster_charfirst asc";

    $user_chars["count"] = query_db($query, $user_chars, true);
}

/**
 * @param $roster
 */
function read_assign_roster(&$roster) {
    $query = "select ro.*, ra.*";
    $query .= "  from " . TABLE_PREFIX . "roster as ro";
    $query .= " left join " . TABLE_PREFIX . "ranks as ra on ra.rank_id = ro.roster_rank";
    $query .= " where roster_rank != '0'";
    $query .= " order by ra.rank_order asc , ro.roster_charfirst asc";

    $roster["count"] = query_db($query, $roster, true);
}

/**
 * @param $waiting_chars
 */
function check_chars_waiting(&$waiting_chars) {
    $query = "select roster_id, roster_charfirst, roster_charlast";
    $query .= "  from " . TABLE_PREFIX . "roster";
    $query .= " where roster_rank = '0'";

    $waiting_chars["count"] = query_db($query, $waiting_chars, true);
}

/**
 * @param $ranks
 */
function read_ranks(&$ranks) {
    $query = "select *";
    $query .= "  from " . TABLE_PREFIX . "ranks";
    $query .= " order by rank_order asc";

    $ranks["count"] = query_db($query, $ranks, true);
}

/**
 * @param $exist
 */
function check_char(&$exist) {
    global $user;
    $query  = "select roster_id";
    $query .= "  from " . TABLE_PREFIX . "roster";
    $query .= " where user_id = '" . $user->data['user_id'] . "'";

    query_db($query, $exist);
}

/**
 * @param $char_id
 * @param $char_info
 */
function read_char($char_id, &$char_info) {
    $query  = "select r.*, rk.*, ts.*";
    $query .= "  from " . TABLE_PREFIX . "roster as r";
    $query .= " left join " . TABLE_PREFIX . "roster_keys as rk on rk.roster_id = r.roster_id";
    $query .= " left join " . TABLE_PREFIX . "roster_tradeskills as ts on ts.roster_id = r.roster_id";
    $query .= " where r.roster_id = '" . $char_id . "'";

    query_db($query, $char_info);
}

/**
 * @param $rank_id
 * @param $exist
 */
function check_rank($rank_id, &$exist) {
    $query  = "select roster_id";
    $query .= "  from " . TABLE_PREFIX . "roster";
    $query .= " where roster_rank = '" . $rank_id . "'";

    query_db($query, $exist);
}

/**
 * @param $roster_keys
 */
function read_roster_keys(&$roster_keys) {
    $query = "select ro.*, rk.*";
    $query .= "  from " . TABLE_PREFIX . "roster as ro";
    $query .= " left join " . TABLE_PREFIX . "roster_keys as rk on rk.roster_id = ro.roster_id";
    $query .= " where roster_rank != '0'";
    $query .= " order by roster_charfirst asc";

    $roster_keys["count"] = query_db($query, $roster_keys, true);
}

/**
 * @param $alchemy
 * @param $baking
 * @param $blacksmithing
 * @param $brewing
 * @param $fishing
 * @param $fletching
 * @param $jewelcrafting
 * @param $poisonmaking
 * @param $pottery
 * @param $research
 * @param $tailoring
 * @param $tinkering
 */
function read_trade_skills(&$alchemy, &$baking, &$blacksmithing, &$brewing, &$fishing, &$fletching, &$jewelcrafting, &$poisonmaking, &$pottery, &$research, &$tailoring, &$tinkering) {
    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_alchemy";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_alchemy <= '300' and rt.tskills_alchemy >= '50'";
    $query .= "  order by rt.tskills_alchemy desc";

    $alchemy["count"] = query_db($query, $alchemy, true);

    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_baking";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_baking <= '300' and rt.tskills_baking >= '50'";
    $query .= "  order by rt.tskills_baking desc";

    $baking["count"] = query_db($query, $baking, true);

    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_blacksmithing";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_blacksmithing <= '300' and rt.tskills_blacksmithing >= '50'";
    $query .= "  order by rt.tskills_blacksmithing desc";

    $blacksmithing["count"] = query_db($query, $blacksmithing, true);

    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_brewing";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_brewing <= '300' and rt.tskills_brewing >= '50'";
    $query .= "  order by rt.tskills_brewing desc";

    $brewing["count"] = query_db($query, $brewing, true);

    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_fishing";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_fishing <= '300' and rt.tskills_fishing >= '50'";
    $query .= "  order by rt.tskills_fishing desc";

    $fishing["count"] = query_db($query, $fishing, true);

    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_fletching";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_fletching <= '300' and rt.tskills_fletching >= '50'";
    $query .= "  order by rt.tskills_fletching desc";

    $fletching["count"] = query_db($query, $fletching, true);

    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_jewelcrafting";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_jewelcrafting <= '300' and rt.tskills_jewelcrafting >= '50'";
    $query .= "  order by rt.tskills_jewelcrafting desc";

    $jewelcrafting["count"] = query_db($query, $jewelcrafting, true);

    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_poisonmaking";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_poisonmaking <= '300' and rt.tskills_poisonmaking >= '50'";
    $query .= "  order by rt.tskills_poisonmaking desc";

    $poisonmaking["count"] = query_db($query, $poisonmaking, true);

    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_pottery";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_pottery <= '300' and rt.tskills_pottery >= '50'";
    $query .= "  order by rt.tskills_pottery desc";

    $pottery["count"] = query_db($query, $pottery, true);

    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_research";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_research <= '300' and rt.tskills_research >= '50'";
    $query .= "  order by rt.tskills_research desc";

    $research["count"] = query_db($query, $research, true);

    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_tailoring";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_tailoring <= '300' and rt.tskills_tailoring >= '50'";
    $query .= "  order by rt.tskills_tailoring desc";

    $tailoring["count"] = query_db($query, $tailoring, true);

    $query  = "select r.roster_id, r.roster_charfirst, rt.tskills_tinkering";
    $query .= "  from " . TABLE_PREFIX . "roster_tradeskills as rt";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = rt.roster_id";
    $query .= " where rt.tskills_tinkering <= '300' and rt.tskills_tinkering >= '50'";
    $query .= "  order by rt.tskills_tinkering desc";

    $tinkering["count"] = query_db($query, $tinkering, true);
}

/**
 * @param $users
 */
function read_users(&$users) {
    $query = "select user_id, roster_charfirst";
    $query .= "  from " . TABLE_PREFIX . "roster";
    $query .= " group by user_id";
    $query .= " order by roster_charfirst asc";

    $users["count"] = query_db($query, $users, true);
}

/**
 * @param $user_id
 * @param $user_info
 */
function read_user_info($user_id, &$user_info) {
    $query  = "select *";
    $query .= "  from " . PHPBB_TABLE_PREFIX . "users";
    $query .= " where user_id = '" . $user_id . "'";

    phpbb_query_db($query, $user_info);
}


?>