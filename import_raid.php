<?php
/**
 * File              : import_raid.php
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

if ($request->variable('upload', 0)) {
    $err = import_raid($request->get_super_global(\phpbb\request\request_interface::FILES)["raid_log"], $chars, $chars_no_id);

    #if (!$err) {
    #    header("Location: import_raid.php?view=1");
    #    exit;
    #}
} elseif ($request->variable('add', 0)) {
    $err = manual_raid($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: raids.php");
        exit;
    }
    #echo "<pre>";
    #print_r($request->get_super_global(\phpbb\request\request_interface::POST));
    #echo "</pre>";
}
read_events_list($events);
read_destinations($destination);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="header_title">DKP: Import Raid</div>
        <div class="body_style">
            <?php
            if ($err) {
                ?>
                <div class="error">ERROR:&nbsp;<?php echo $err; ?></div>
            <?php
            }
            ?>
            <?php
            if ($request->variable('upload', 0)) {
                if (!$err) {
                    ?>
                    <form action="import_raid.php?add=1" method="post">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="2" class="text_normal red">*** Make sure you add FRPS to the raid ***</td>
                            </tr>
                            <tr>
                                <td width="25%" class="text_normal">Event</td>
                                <td width="75%" class="text_normal">
                                    <select name="event_id">
                                        <?php
                                        for ($i = 0; $i < $events["count"]; $i++) {
                                            ?>
                                            <option value="<?php echo $events[$i]["event_id"]; ?>"<?php echo($request->variable('event_id', '') == $events[$i]["event_id"] ? " selected=\"selected\"" : ""); ?>><?php echo date("m/d/Y", $events[$i]["event_date"]) . " - " . $events[$i]["event_name"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="25%" class="text_normal">Destination</td>
                                <td width="75%" class="text_normal">
                                    <select name="dest_id">
                                        <?php
                                        for ($i = 0; $i < $destination["count"]; $i++) {
                                            ?>
                                            <option value="<?php echo $destination[$i]["dest_id"]; ?>"<?php echo($request->variable('dest_id', '') == $destination[$i]["dest_id"] ? " selected=\"selected\"" : ""); ?>><?php echo $destination[$i]["dest_name"] . " (" . $destination[$i]["dest_value"] . " DKP)"; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="text_normal" valign="top">Description<br /><span class="text_small">(Optional)</span>
                                </td>
                                <td class="text_normal">
                                    <textarea name="raid_desc" cols="35" rows="5"><?php echo safe_string($request->variable('raid_desc', '')); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="text_normal">Points</td>
                                <td class="text_normal">
                                    <input type="text" name="raid_value" size="7" maxlength="7" value="<?php echo safe_string($request->variable('raid_value', '')); ?>" /><br /><span class="text_small">Leave this box empty to use default</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text_normal">
                                    <div class="hrline"></div>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="8%" class="text_header">Present</td>
                                            <td width="15%" class="text_header">Point Override<br /><span class="text_small">Leave blank to ignore</span>
                                            </td>
                                            <td width="20%" class="text_header">Character Name</td>
                                            <td width="10%" class="text_header">Main</td>
                                            <td width="10%" class="text_header">Level</td>
                                            <td width="37%" class="text_header">Class</td>
                                        </tr>
                                        <?php
                                        asort($chars);
                                        foreach ($chars as $key => $value) {
                                            read_char_info($key, $char_info);
                                            $rid = "roster_id_" . $char_info["roster_id"];
                                            $cleanrid = substr($rid, 10);
                                            $atval = "attendance_value_" . $char_info["roster_id"];
                                            $cleanatval = substr($atval, 17);
                                            ?>
                                            <tr>
                                                <td class="text_normal">
                                                    <input type="checkbox" name="roster_id_<?php echo $char_info["roster_id"]; ?>" class="present" value="<?php echo $char_info["roster_id"]; ?>"<?php echo (($char_info["roster_id"]) || ($char_info["roster_id"] == $request->variable($rid, "")) ? " checked=\"checked\"" : ""); ?> />
                                                </td>
                                                <td class="text_normal">
                                                    <input type="text" name="attendance_value_<?php echo $char_info["roster_id"]; ?>" class="present_rid_<?php echo $char_info["roster_id"]; ?>" size="7" maxlength="7" value="<?php echo ($request->variable('add', 0) ? $request->variable($atval, "") : ""); ?>"<?php echo (($char_info["roster_id"]) || ($char_info["roster_id"] == $request->variable($rid, "")) ? "" : " disabled=\"disabled\""); ?> />
                                                </td>
                                                <td class="text_normal"><?php echo $char_info["roster_charfirst"]; ?></td>
                                                <td class="text_normal"><?php echo $CHAR_TYPE[$char_info["roster_type"]]; ?></td>
                                                <td class="text_normal"><?php echo $char_info["roster_level"]; ?></td>
                                                <td class="text_normal"><?php echo $CLASS[$char_info["roster_class"]]; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                    <?php
                                    if ($chars_no_id) {
                                        ?>
                                        <div class="hrline"></div>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="100%" class="text_header">Character not on the roster that will be ignored</td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal red">
                                                    <?php
                                                    asort($chars_no_id);
                                                    foreach ($chars_no_id as $key => $value) {
                                                        ?>
                                                        <div class="div_width text_normal red"><?php echo $value; ?></div>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <input class="form_button" type="submit" value="Save" />
                    </form>
                <?php
                }
            } else {
                ?>
                <form action="import_raid.php?upload=1" method="post" enctype="multipart/form-data">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="25%" class="text_normal">Raid Dump File</td>
                            <td width="75%" class="text_normal"><input type="file" name="raid_log" /></td>
                        </tr>
                    </table>
                    <input class="form_button" type="submit" value="Import" />
                </form>
            <?php
            }
            ?>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>