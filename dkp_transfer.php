<?php
/**
 * File              : dkp_transfer.php
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
include $fpg_root_path . "includes/write_dkp.php";
include $fpg_root_path . "includes/read_dkp.php";
include $fpg_root_path . "header.php";

if ($request->variable('transfer', 0)) {
    $err = mass_adjust($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: dkp_transfer.php?done=1");
        exit;
    }
}

read_transfer_chars($chars);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="header_title">DKP: DKP Transfer</div>
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
            } elseif ($request->variable('done', '') == 1) {
                ?>
                <div class="updated">Transfer Complete</div>
            <?php
            }
            ?>
            <!--<form action="dkp_transfer.php?transfer=1" method="post">-->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_normal">Transfer ALL DKP FROM who</td>
                        <td width="75%" class="text_normal">
                            <select name="roster_id_from">
                                <?php
                                for ($i = 0; $i < $chars["count"]; $i++) {
                                    ?>
                                    <option value="<?php echo $chars[$i]["roster_id"];  ?>"<?php echo ($request->variable('roster_id', '') == $chars[$i]["roster_id"] ? " selected=\"selected\"" : ""); ?>><?php echo $chars[$i]["roster_charfirst"];  ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%" class="text_normal">Transfer ALL DKP TO who</td>
                        <td width="75%" class="text_normal">
                            <select name="roster_id_to">
                                <?php
                                for ($i = 0; $i < $chars["count"]; $i++) {
                                    ?>
                                    <option value="<?php echo $chars[$i]["roster_id"];  ?>"<?php echo ($request->variable('roster_id', '') == $chars[$i]["roster_id"] ? " selected=\"selected\"" : ""); ?>><?php echo $chars[$i]["roster_charfirst"];  ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
            Disabled till a later date.
                <!--<input class="form_button" type="submit" value="Transfer" />
            </form>-->
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>