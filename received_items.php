<?php
/**
 * File              : recieved_items.php
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

read_received_items($received_items);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="header_title">DKP: Items Recieved</div>
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
                            <input class="form_button" type="button" value="Add Item Purchase" onclick="window.location.href='add_purchase.php'; return false;" />
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
                    <td width="30%" class="text_header">Date/Event</td>
                    <td width="20%" class="text_header">Character Name</td>
                    <td width="30%" class="text_header">Item</td>
                    <td width="10%" class="text_header">Cost</td>
                    <td width="10%" class="text_header">Action</td>
                </tr>
                <?php
                for ($i = 0; $i < $received_items["count"]; $i++) {
                    ?>
                    <tr>
                        <td class="text_normal"><?php echo date("m/d/Y", $received_items[$i]["event_date"]) . " - " . $received_items[$i]["event_name"]; ?></td>
                        <td class="text_normal"><?php echo $received_items[$i]["roster_charfirst"]; ?></td>
                        <td class="text_normal"><a href="<?php echo $received_items[$i]["item_magelo"]; ?>"><?php echo $received_items[$i]["item_name"]; ?></a></td>
                        <td class="text_normal"><?php echo ($received_items[$i]["ireceived_cost"] == 0 ? $received_items[$i]["item_value"] : $received_items[$i]["ireceived_cost"]); ?></td>
                        <td class="text_normal"><input class="form_button" type="button" value="Edit" onclick="window.location.href='edit_purchase.php?ireceived_id=<?php echo $received_items[$i]["ireceived_id"]; ?>'; return false;" /></td>
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