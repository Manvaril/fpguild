<?php
/**
 * File              : read_dkp.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

/**
 * @param $current
 */
function read_standings(&$current) {
    $query  = "select roster_id, roster_charfirst, roster_class, roster_earned, roster_spent, roster_adjusted, (roster_earned-roster_spent+roster_adjusted) as standings_current";
    $query .= "  from " . TABLE_PREFIX . "roster";
    $query .= " order by roster_charfirst asc, roster_earned desc, roster_spent desc, roster_adjusted desc";

    $current["count"] = query_db($query, $current, true);
}

/**
 * @param $roster_id
 * @param $char_raid_count
 * @param $raid_count
 */
function read_char_raids($roster_id, &$char_raid_count, &$raid_count) {
    /* counts all raids in DB
    $query  = "select COUNT(raid_id) as max";
    $query .= "  from " . TABLE_PREFIX . "raid_attendance";
    $query .= " where roster_id = '" . $roster_id . "'";

    query_db($query, $char_raid_count);

    $query  = "select COUNT(raid_id) as max";
    $query .= "  from " . TABLE_PREFIX . "raids";

    query_db($query, $raid_count);
*/
    $query  = "select COUNT(ra.raid_id) as max";
    $query .= "  from " . TABLE_PREFIX . "raid_attendance as ra";
    $query .= " left join " . TABLE_PREFIX . "raids as r on r.raid_id = ra.raid_id";
    $query .= " left join " . TABLE_PREFIX . "events as e on e.event_id = r.event_id";
    $query .= " where roster_id = '" . $roster_id . "' and FROM_UNIXTIME(e.event_date) >= curdate() - interval 30 day";

    query_db($query, $char_raid_count);

    $query  = "select COUNT(r.raid_id) as max";
    $query .= "  from " . TABLE_PREFIX . "raids as r";
    $query .= " left join " . TABLE_PREFIX . "events as e on e.event_id = r.event_id";
    $query .= " where FROM_UNIXTIME(e.event_date) >= curdate() - interval 30 day";

    query_db($query, $raid_count);
}

/**
 * @param $events
 */
function read_events(&$events) {
    $current_month = date("m", time());
    $next_month = date('m', strtotime('+1 month'));
    $last_month = date('m', strtotime('-1 month'));
    $current_year = date("Y", time());
    $this_month = $current_year . "-" . $current_month . "-01";
    $next_month = $current_year . "-" . $next_month . "-01";

    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "events";
    $query .= " where DATE_FORMAT(FROM_UNIXTIME(event_date), '%Y-%m-%d') BETWEEN '" . $last_month . "' AND '" . $next_month . "' + INTERVAL 1 MONTH + INTERVAL -1 SECOND";
    $query .= " order by event_date desc";

    $events["count"] = query_db($query, $events, true);
}

/**
 * @param $event_id
 * @param $event_info
 */
function read_event($event_id, &$event_info) {
    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "events";
    $query .= "  where event_id = '" . $event_id . "'";

    query_db($query, $event_info);
}

function read_events_list(&$events) {
    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "events";
    $query .= " order by event_date asc";

    $events["count"] = query_db($query, $events, true);
}

function read_items(&$items) {
    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "items";
    $query .= "  order by item_name asc";

    $items["count"] = query_db($query, $items, true);
}

function read_item($item_id, &$item_info) {
    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "items";
    $query .= "  where item_id = '" . $item_id . "'";

    query_db($query, $item_info);
}

function read_received_items(&$received_items) {
    $query  = "select ir.*, e.event_date, e.event_name, ra.roster_charfirst, i.item_name, i.item_magelo, i.item_value";
    $query .= "  from " . TABLE_PREFIX . "item_received as ir";
    $query .= " left join " . TABLE_PREFIX .  "raids as r on r.raid_id = ir.raid_id";
    $query .= " left join " . TABLE_PREFIX . "events as e on e.event_id = r.event_id";
    $query .= " left join " . TABLE_PREFIX . "roster as ra on ra.roster_id = ir.roster_id";
    $query .= " left join " . TABLE_PREFIX . "items as i on i.item_id = ir.item_id";
    $query .= " order by e.event_date asc, ra.roster_charfirst";

    $received_items["count"] = query_db($query, $received_items, true);
}

function read_chars(&$chars) {
    $query  = "select roster_id, roster_charfirst, roster_class, roster_level";
    $query .= "  from " . TABLE_PREFIX . "roster";
    $query .= " where roster_rank != '0'";
    $query .= " order by roster_charfirst asc";

    $chars["count"] = query_db($query, $chars, true);
}

function read_received_item($ireceived_id, &$ireceived_info) {
    $query  = "select ir.*, e.event_id, e.event_name, e.event_date, ra.roster_id, ra.roster_charfirst, ra.roster_class, ra.roster_level, i.item_id, i.item_name, i.item_value";
    $query .= "  from " . TABLE_PREFIX . "item_received as ir";
    $query .= " left join " . TABLE_PREFIX . "raids as r on r.raid_id = ir.raid_id";
    $query .= " left join " . TABLE_PREFIX . "events as e on e.event_id = r.event_id";
    $query .= " left join " . TABLE_PREFIX . "roster as ra on ra.roster_id = ir.roster_id";
    $query .= " left join " . TABLE_PREFIX . "items as i on i.item_id = ir.item_id";
    $query .= " where ir.ireceived_id = '" . $ireceived_id . "'";

    query_db($query, $ireceived_info);
}

function read_destinations(&$destination) {
    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "destinations";
    $query .= "  order by dest_name asc";

    $destination["count"] = query_db($query, $destination, true);
}

function read_destination($dest_id, &$destination) {
    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "destinations";
    $query .= " where dest_id = '" . $dest_id . "'";

    query_db($query, $destination);
}

function read_adjustments(&$adjustment) {
    $query  = "select a.*, ro.roster_id, ro.roster_charfirst";
    $query .= "  from " . TABLE_PREFIX . "adjustments as a";
    $query .= " left join " . TABLE_PREFIX . "roster as ro on ro.roster_id = a.roster_id";
    $query .= "  order by a.adjustment_date desc, ro.roster_charfirst asc";

    $adjustment["count"] = query_db($query, $adjustment, true);
}

function read_adjustment($adjust_id, &$adjustment) {
    $query  = "select a.*, ro.roster_id, ro.roster_charfirst";
    $query .= "  from " . TABLE_PREFIX . "adjustments as a";
    $query .= " left join " . TABLE_PREFIX . "roster as ro on ro.roster_id = a.roster_id";
    $query .= " where a.adjustment_id = '" . $adjust_id . "'";

    query_db($query, $adjustment);
}

function read_transfer_chars(&$chars) {
    $query  = "select roster_id, user_id, roster_charfirst, roster_class, roster_level, roster_type";
    $query .= "  from " . TABLE_PREFIX . "roster";
    $query .= " where roster_rank != '0'";
    $query .= " order by roster_charfirst asc";

    $chars["count"] = query_db($query, $chars, true);
}

function read_raids(&$raid) {
    $query  = "select r.*, e.event_id, e.event_name, e.event_date, d.dest_id, d.dest_name, d.dest_value";
    $query .= "  from " . TABLE_PREFIX . "raids as r";
    $query .= " left join " . TABLE_PREFIX . "events as e on e.event_id = r.event_id";
    $query .= " left join " . TABLE_PREFIX . "destinations as d on d.dest_id = r.dest_id";
    $query .= " order by e.event_date asc";

    $raid["count"] = query_db($query, $raid, true);
}

function count_attendees($raid_id, &$attendee) {
    $query  = "select COUNT(raid_id) as max";
    $query .= "  from " . TABLE_PREFIX . "raid_attendance";
    $query .= " where raid_id = '" . $raid_id . "'";

    query_db($query, $attendee);
}

function read_raid($raid_id, &$raid) {
    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "raids";
    $query .= " where raid_id = '" . $raid_id . "'";

    query_db($query, $raid);
}

function read_view_raid($raid_id, &$raid) {
    $query  = "select r.*, e.event_id, e.event_name, e.event_date, d.dest_id, d.dest_name, d.dest_value";
    $query .= "  from " . TABLE_PREFIX . "raids as r";
    $query .= " left join " . TABLE_PREFIX . "events as e on e.event_id = r.event_id";
    $query .= " left join " . TABLE_PREFIX . "destinations as d on d.dest_id = r.dest_id";
    $query .= " where raid_id = '" . $raid_id . "'";

    query_db($query, $raid);
}

function read_raid_attendees($raid_id, $roster_id, &$attendee) {
    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "raid_attendance";
    $query .= " where raid_id = '" . $raid_id . "' and roster_id = '" . $roster_id . "'";

    query_db($query, $attendee);
}

function read_roster_info($roster_charfirst, &$roster_info) {
    $query  = "select roster_id, roster_charfirst";
    $query .= "  from " . TABLE_PREFIX . "roster";
    $query .= " where roster_charfirst = '" . $roster_charfirst . "'";

    query_db($query, $roster_info);
}

function read_char_info($char_id, &$char_info) {
    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "roster";
    $query .= " where roster_id = '" . $char_id . "'";

    query_db($query, $char_info);
}

function read_attendees($raid_id, &$attendees) {
    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "raid_attendance";
    $query .= " where raid_id = '" . $raid_id . "'";

    $attendees["count"] = query_db($query, $attendees, true);
}

function read_signups($event_id, &$signups) {
    $query  = "select es.*, r.*";
    $query .= "  from " . TABLE_PREFIX . "event_signups as es";
    $query .= " left join " . TABLE_PREFIX . "roster as r on r.roster_id = es.roster_id";
    $query .= " where es.event_id = '" . $event_id . "'";

    $signups["count"] = query_db($query, $signups, true);
}

function read_signedup_chars($user_id, $event_id, &$user_chars) {
    $query = "select *";
    $query .= "  from " . TABLE_PREFIX . "roster";
    $query .= " where user_id = '" . $user_id . "' and roster_id not in (select roster_id from " . TABLE_PREFIX . "event_signups where event_id = '" . $event_id . "')";
    $query .= " order by roster_charfirst asc";

    $user_chars["count"] = query_db($query, $user_chars, true);
}

function read_chars_signedup($user_id, $event_id, &$signedup_chars) {
    $query = "select ro.*, es.*";
    $query .= "  from " . TABLE_PREFIX . "roster as ro";
    $query .= " left join " . TABLE_PREFIX . "event_signups as es on es.roster_id = ro.roster_id";
    $query .= " where ro.user_id = '" . $user_id . "' and es.event_id = '" . $event_id . "'";
    $query .= " order by ro.roster_charfirst asc";

    $signedup_chars["count"] = query_db($query, $signedup_chars, true);
}

function read_days($date, &$multi_event) {
    $query  = "select *";
    $query .= "  from " . TABLE_PREFIX . "events";
    $query .= "  where DATE_FORMAT(FROM_UNIXTIME(event_date), '%m%d%Y') = '" . $date . "'";

    $multi_event["count"] = query_db($query, $multi_event, true);
}