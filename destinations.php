<?php
/**
 * File              : destinations.php
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

read_destinations($destination);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="header_title">DKP: Destination/Bosses</div>
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
                            <input class="form_button" type="button" value="Add Destination" onclick="window.location.href='add_destination.php'; return false;" />
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
                    <td width="50%" class="text_header">Destination/Boss</td>
                    <td width="40%" class="text_header">Points</td>
                    <td width="10%" class="text_header">Action</td>
                </tr>
                <?php
                for ($i = 0; $i < $destination["count"]; $i++) {
                    ?>
                    <tr>
                        <td class="text_normal"><?php echo $destination[$i]["dest_name"]; ?></td>
                        <td class="text_normal"><?php echo $destination[$i]["dest_value"]; ?></td>
                        <td class="text_normal"><input class="form_button" type="button" value="Edit" onclick="window.location.href='edit_destination.php?dest_id=<?php echo $destination[$i]["dest_id"]; ?>'; return false;" /></td>
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