<?php
/**
 * File              : events.php
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

read_events($events);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="header_title">DKP: Events</div>
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
                        <?php
                        if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS) && (in_array($user->data['user_id'], $admin_ary))) {
                            ?>
                            <input class="form_button" type="button" value="Add Event" onclick="window.location.href='add_event.php'; return false;" />
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="text_normal" colspan="2"><div class="hrline"></div></td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="22%" class="text_header">Event Date</td>
                    <td width="56%" class="text_header">Event Name</td>
                    <td width="12%" class="text_header">Max Signups</td>
                    <td width="10%" class="text_header">Action</td>
                </tr>
                <?php
                for ($i = 0; $i < $events["count"]; $i++) {
                    ?>
                    <tr>
                        <td class="text_normal"><?php echo date("D M d, Y g:i a", $events[$i]["event_date"]); ?></td>
                        <td class="text_normal"><?php echo $events[$i]["event_name"]; ?></td>
                        <td class="text_normal"><?php echo ($events[$i]["event_max_signup"] != 0 ? $events[$i]["event_max_signup"] : "Unlimited"); ?></td>
                        <td class="text_normal"><input class="form_button" type="button" value="Edit" onclick="window.location.href='edit_event.php?event_id=<?php echo $events[$i]["event_id"]; ?>'; return false;" /></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>