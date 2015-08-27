<?php
/**
 * File              : dkp_wipe.php
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
include $fpg_root_path . "header.php";

get_auth_groups($user_ary, $group_ids);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_calendar.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">DKP: Wipe</div>
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
                </table>
                <?php
                if ($err) {
                    ?>
                    <div class="error">ERROR:&nbsp;<?php echo $err; ?></div>
                <?php
                }
                ?>
                <form action="dkp_wipe.php?delete=1" method="post">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="25%" class="text_normal">Adjustments</td>
                            <td width="75%" class="text_normal"><input type="checkbox" name="adjustments_table" value="1" /></td>
                        </tr>
                        <tr>
                            <td width="25%" class="text_normal">Destination/Bosses</td>
                            <td width="75%" class="text_normal"><input type="checkbox" name="destinations_table" value="1" /></td>
                        </tr>
                        <tr>
                            <td width="25%" class="text_normal">Events</td>
                            <td width="75%" class="text_normal"><input type="checkbox" name="events_table" value="1" /></td>
                        </tr>
                        <tr>
                            <td width="25%" class="text_normal">Events Signups</td>
                            <td width="75%" class="text_normal"><input type="checkbox" name="event_signups_table" value="1" /></td>
                        </tr>
                        <tr>
                            <td width="25%" class="text_normal">Items</td>
                            <td width="75%" class="text_normal"><input type="checkbox" name="items_table" value="1" /></td>
                        </tr>
                        <tr>
                            <td width="25%" class="text_normal">Items Received</td>
                            <td width="75%" class="text_normal"><input type="checkbox" name="items_received_table" value="1" /></td>
                        </tr>
                        <tr>
                            <td width="25%" class="text_normal">Raids</td>
                            <td width="75%" class="text_normal"><input type="checkbox" name="raids_table" value="1" /></td>
                        </tr>
                        <tr>
                            <td width="25%" class="text_normal">Raid Attendance</td>
                            <td width="75%" class="text_normal"><input type="checkbox" name="raid_attendance_table" value="1" /></td>
                        </tr>
                        <tr>
                            <td width="25%" class="text_normal">Character DKP</td>
                            <td width="75%" class="text_normal"><input type="checkbox" name="char_dkp" value="1" /></td>
                        </tr>
                    </table>
                    <input class="form_button" type="submit" value="Wipe" />
                </form>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>