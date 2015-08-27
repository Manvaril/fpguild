<?php
/**
 * File              : add_purchase.php
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
include $fpg_root_path . "includes/read_roster.php";
include $fpg_root_path . "includes/write_dkp.php";
include $fpg_root_path . "header.php";

if ($request->variable('add', 0)) {
    $err = add_purchase($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: received_items.php");
        exit;
    }
}

read_events_list($events);
read_raids($raid);
read_chars($chars);
read_items($items);
?>
    <div id="body">
        <div class="header_title">DKP: Add Item Purchase</div>
        <div class="body_style">
            <?php
            if ($err) {
                ?>
                <div class="error">ERROR:&nbsp;<?php echo $err; ?></div>
            <?php
            }
            ?>
            <form action="add_purchase.php?add=1" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_normal">Raid</td>
                        <td width="75%" class="text_normal">
                            <select name="raid_id">
                                <?php
                                for ($i = 0; $i < $raid["count"]; $i++) {
                                    ?>
                                    <option value="<?php echo $raid[$i]["raid_id"];  ?>"<?php echo ($request->variable('raid_id', '') == $raid[$i]["raid_id"] ? " selected=\"selected\"" : ""); ?>><?php echo date("m/d/Y", $raid[$i]["event_date"]) . " - " . $raid[$i]["event_name"] . " - " . $raid[$i]["dest_name"];  ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_normal">Member</td>
                        <td class="text_normal">
                            <select name="roster_id">
                                <?php
                                for ($i = 0; $i < $chars["count"]; $i++) {
                                    ?>
                                    <option value="<?php echo $chars[$i]["roster_id"];  ?>"<?php echo ($request->variable('roster_id', '') == $chars[$i]["roster_id"] ? " selected=\"selected\"" : ""); ?>><?php echo $chars[$i]["roster_charfirst"] . " (" . $chars[$i]["roster_level"] . " " . $CLASS[$chars[$i]["roster_class"]] . ")";  ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_normal">Item</td>
                        <td class="text_normal">
                            <select name="item_id">
                                <?php
                                for ($i = 0; $i < $items["count"]; $i++) {
                                    ?>
                                    <option value="<?php echo $items[$i]["item_id"];  ?>"<?php echo ($request->variable('item_id', '') == $items[$i]["item_id"] ? " selected=\"selected\"" : ""); ?>><?php echo $items[$i]["item_name"] . " (" . $items[$i]["item_value"] . " DKP)";  ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_normal">Points</td>
                        <td class="text_normal"><input type="text" name="ireceived_cost" size="7" maxlength="7" value="<?php echo safe_string($request->variable('ireceived_cost', '')); ?>" /><br /><span class="text_small">If left empty, points will default to the items points</span></td>
                    </tr>
                </table>
                <input class="form_button" type="submit" value="Save" />
            </form>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>