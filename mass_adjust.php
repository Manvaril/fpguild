<?php
/**
 * File              : mass_adjust.php
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

if ($request->variable('add', 0)) {
    $err = mass_adjust($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: adjustments.php");
        exit;
    }
    #echo "<pre>";
    #print_r($request->get_super_global(\phpbb\request\request_interface::POST));
    #echo "</pre>";
}

read_standings($current);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="header_title">DKP: Mass Adjustment</div>
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
            <form action="mass_adjust.php?add=1" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_normal">Effective Date</td>
                        <td width="75%" class="text_normal"><input id="datetimeadjust" type="text" name="adjustment_date" size="20" maxlength="20" value="<?php echo date("m/d/Y", ($request->variable('add', 0) ? $request->variable('adjustment_date', '') : time())); ?>" /></td>
                    </tr>
                    <tr>
                        <td width="25%" class="text_normal">Description</td>
                        <td width="75%" class="text_normal"><input type="text" name="adjustment_desc" size="50" maxlength="200" value="<?php echo safe_string($request->variable('adjustment_desc', '')); ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text_normal">
                            <div class="hrline"></div>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="25%" class="text_header">Character Name</td>
                                    <td width="20%" class="text_header">Class</td>
                                    <td width="10%" class="text_header">Earned</td>
                                    <td width="10%" class="text_header">Spent</td>
                                    <td width="10%" class="text_header">Adj</td>
                                    <td width="10%" class="text_header">Current</td>
                                    <td width="15%" class="text_header">Adjustment Amount<br /><span class="text_small">Leave blank to ignore</span></td>
                                </tr>
                                <?php
                                for ($i = 0; $i < $current["count"]; $i++) {
                                    ?>
                                    <tr>
                                        <td class="text_normal"><?php echo $current[$i]["roster_charfirst"]; ?></td>
                                        <td class="text_normal"><?php echo $CLASS[$current[$i]["roster_class"]]; ?></td>
                                        <td class="text_normal green"><?php echo $current[$i]["roster_earned"]; ?></td>
                                        <td class="text_normal red"><?php echo $current[$i]["roster_spent"]; ?></td>
                                        <td class="text_normal<?php if ($current[$i]["roster_adjusted"] < 0) { echo " red"; } elseif ($current[$i]["roster_adjusted"] > 0) { echo " green"; } ?>"><?php echo $current[$i]["roster_adjusted"]; ?></td>
                                        <td class="text_normal<?php if ($current[$i]["standings_current"] < 0) { echo " red"; } elseif ($current[$i]["standings_current"] > 0) { echo " green"; } ?>"><?php echo $current[$i]["standings_current"]; ?></td>
                                        <td class="text_normal"><input type="hidden" name="roster_id[]" value="<?php echo ($request->get_super_global(\phpbb\request\request_interface::POST)["roster_id"][$i] ? $request->get_super_global(\phpbb\request\request_interface::POST)["roster_id"][$i] : $current[$i]["roster_id"]); ?>" /><input type="text" name="adjustment_amount[]" size="7" maxlength="7" value="<?php echo safe_string(($request->get_super_global(\phpbb\request\request_interface::POST)["adjustment_amount"][$i] ? $request->get_super_global(\phpbb\request\request_interface::POST)["adjustment_amount"][$i] : "")); ?>" /></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>
                <input class="form_button" type="submit" value="Save" />
            </form>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>