<?php
/**
 * File              : view_raid.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

$fpg_root_path = "./";
include $fpg_root_path . "includes/funcs.php";
include $fpg_root_path . "includes/read_dkp.php";
include $fpg_root_path . "header.php";

read_view_raid($request->variable('raid_id', ''), $raid);
read_attendees($request->variable('raid_id', ''), $attendees);
get_auth_groups($user_ary, $group_ids);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_calendar.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">DKP: View Raid</div>
            <div class="body_style">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="text_normal" colspan="2">
                            <?php
                            if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS) && (in_array($user->data['user_id'], $admin_ary))) {
                                ?>
                                <input class="form_button" type="button" value="Events" onclick="window.location.href='events.php'; return false;" />
                                <input class="form_button" type="button" value="Items" onclick="window.location.href='items.php'; return false;" />
                                <input class="form_button" type="button" value="Items Received" onclick="window.location.href='received_items.php'; return false;" />
                                <input class="form_button" type="button" value="Destinations/Bosses" onclick="window.location.href='destinations.php'; return false;" />
                                <input class="form_button" type="button" value="Adjustments" onclick="window.location.href='adjustments.php'; return false;" />
                                <input class="form_button" type="button" value="Mass Adjustments" onclick="window.location.href='mass_adjust.php'; return false;" />
                                <input class="form_button" type="button" value="DKP Transfer" onclick="window.location.href='dkp_transfer.php'; return false;" />
                                <input class="form_button" type="button" value="Raids" onclick="window.location.href='raids.php'; return false;" />
                                <input class="form_button" type="button" value="Import Raid" onclick="window.location.href='import_raid.php'; return false;" />
                                <div class="hrline"></div>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_normal">
                            <input class="form_button" type="button" value="Current Standings" onclick="window.location.href='dkp.php'; return false;" />
                            <input class="form_button" type="button" value="Items Received" onclick="window.location.href='items_received.php'; return false;" />
                            <input class="form_button" type="button" value="Past Raids" onclick="window.location.href='past_raids.php'; return false;" />
                            <input class="form_button" type="button" value="Item Prices" onclick="window.location.href='item_prices.php'; return false;" />
                        </td>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_normal" colspan="2"><div class="hrline"></div></td>
                    </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_normal">Event</td>
                        <td width="75%" class="text_normal"><?php echo date("m/d/Y", $raid["event_date"]) . " - " . $raid["event_name"]; ?></td>
                    </tr>
                    <tr>
                        <td width="25%" class="text_normal">Destination</td>
                        <td width="75%" class="text_normal"><?php echo $raid["dest_name"]; ?></td>
                    </tr>
                    <tr>
                        <td class="text_normal" valign="top">Description<br /></td>
                        <td class="text_normal"><?php echo $raid["raid_desc"]; ?></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Points</td>
                        <td class="text_normal"><?php echo ($raid["raid_value"] == 0 ? $raid["dest_value"] : $raid["raid_value"]); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text_normal">
                            <div class="hrline"></div>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="20%" class="text_header">Character Name</td>
                                    <td width="10%" class="text_header">Main</td>
                                    <td width="10%" class="text_header">Level</td>
                                    <td width="37%" class="text_header">Class</td>
                                </tr>
                                <?php
                                for ($i = 0; $i < $attendees["count"]; $i++) {
                                    #read_raid_attendees($request->variable('raid_id', ''), $chars[$i]["roster_id"], $attendee);
                                    read_char_info($attendees[$i]["roster_id"], $char_info);
                                    ?>
                                    <tr>
                                        <td class="text_normal"><?php echo $char_info["roster_charfirst"]; ?></td>
                                        <td class="text_normal"><?php echo $CHAR_TYPE[$char_info["roster_type"]]; ?></td>
                                        <td class="text_normal"><?php echo $char_info["roster_level"]; ?></td>
                                        <td class="text_normal"><?php echo $CLASS[$char_info["roster_class"]]; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>