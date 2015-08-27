<?php
/**
 * File              : edit_raid.php
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

if ($request->variable('edit', 0)) {
    $err = edit_raid($request->variable('raid_id', ''), $request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: raids.php");
        exit;
    }
    #echo "<pre>";
    #print_r($request->get_super_global(\phpbb\request\request_interface::POST));
    #echo "</pre>";
}

read_raid($request->variable('raid_id', ''), $raid);
read_events_list($events);
read_destinations($destination);
read_transfer_chars($chars);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="header_title">DKP: Edit Raid</div>
        <div class="body_style">
            <?php
            if ($err) {
                ?>
                <div class="error">ERROR:&nbsp;<?php echo $err; ?></div>
            <?php
            }
            ?>
            <form action="edit_raid.php?raid_id=<?php echo $request->variable('raid_id', ''); ?>&edit=1" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_normal">Event</td>
                        <td width="75%" class="text_normal">
                            <select name="event_id">
                                <?php
                                for ($i = 0; $i < $events["count"]; $i++) {
                                    ?>
                                    <option value="<?php echo $events[$i]["event_id"];  ?>"<?php echo (($request->variable('edit', '') ? $request->variable('event_id', '') == $events[$i]["event_id"] : $raid["event_id"] == $events[$i]["event_id"]) ? " selected" : ""); ?>><?php echo date("m/d/Y", $events[$i]["event_date"]) . " - " . $events[$i]["event_name"];  ?></option>
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
                                    <option value="<?php echo $destination[$i]["dest_id"];  ?>"<?php echo (($request->variable('edit', '') ? $request->variable('dest_id', '') == $destination[$i]["dest_id"] : $raid["dest_id"] == $destination[$i]["dest_id"]) ? " selected" : ""); ?>><?php echo $destination[$i]["dest_name"] . " (" . $destination[$i]["dest_value"] . " DKP)";  ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_normal" valign="top">Description<br /><span class="text_small">(Optional)</span></td>
                        <td class="text_normal"><textarea name="raid_desc" cols="35" rows="5"><?php echo safe_string(($request->variable('edit', 0) ? $request->variable('raid_desc', '') : $raid["raid_desc"])); ?></textarea></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Points</td>
                        <td class="text_normal"><input type="hidden" name="old_raid_value" value="<?php echo ($request->variable('edit', 0) ? $request->variable('old_raid_value', '') : $raid["raid_value"]); ?>" /><input type="text" name="raid_value" size="7" maxlength="7" value="<?php echo safe_string(($request->variable('edit', 0) ? $request->variable('raid_value', '') : $raid["raid_value"])); ?>" /><br /><span class="text_small">Leave this box empty to use default</span></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text_normal">
                            <div class="hrline"></div>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="8%" class="text_header">Present</td>
                                    <td width="14%" class="text_header">Point Override<br /><span class="text_small">Leave blank to ignore</span></td>
                                    <td width="15%" class="text_header">Character Name</td>
                                    <td width="7%" class="text_header">Main</td>
                                    <td width="7%" class="text_header">Hour 1</td>
                                    <td width="7%" class="text_header">Hour 2</td>
                                    <td width="7%" class="text_header">Hour 3</td>
                                    <td width="7%" class="text_header">Hour 4</td>
                                    <td width="7%" class="text_header">Hour 5</td>
                                    <td width="7%" class="text_header">Hour 6</td>
                                    <td width="7%" class="text_header">Hour 7</td>
                                    <td width="7%" class="text_header">Hour 8</td>
                                </tr>
                                <?php
                                for ($i = 0; $i < $chars["count"]; $i++) {
                                    read_raid_attendees($request->variable('raid_id', ''), $chars[$i]["roster_id"], $attendee);
                                    $rid = "roster_id_" . $chars[$i]["roster_id"];
                                    $atval = "attendance_value_" . $chars[$i]["roster_id"];
                                    $cleanrid = substr($rid, 10);
                                    $cleanatval = substr($atval, 17);
                                    ?>
                                    <tr>
                                        <td class="text_normal">
                                            <input type="hidden" name="roster_id[]" value="<?php echo($request->variable('roster_id', '') ? $request->variable($rid, '') : $chars[$i]["roster_id"]); ?>" /><input type="checkbox" name="roster_id_check[]" class="present" value="<?php echo($request->variable('roster_id', '') ? $request->variable($rid, '') : $chars[$i]["roster_id"]); ?>"<?php echo (($chars[$i]["roster_id"] == $attendee["roster_id"]) || ($cleanrid == $request->variable($rid, "")) ? " checked=\"checked\"" : ""); ?> /></td>
                                        <td class="text_normal">
                                            <input type="text" name="attendance_value[]" class="present_rid_<?php echo $chars[$i]["roster_id"]; ?>" size="7" maxlength="7" value="<?php echo ($request->variable('edit', 0) ? $request->variable($atval, "") : $attendee["attendance_value"]); ?>"<?php echo (($chars[$i]["roster_id"] == $attendee["roster_id"]) || ($cleanrid == $request->variable($rid, "")) ? "" : " disabled=\"disabled\""); ?> />
                                        </td>
                                        <td class="text_normal"><?php echo $chars[$i]["roster_charfirst"]; ?></td>
                                        <td class="text_normal"><?php echo $CHAR_TYPE[$chars[$i]["roster_type"]]; ?></td>
                                        <td class="text_normal"><?php echo (($attendee["attendance_hour_1"] == 1) ? "Yes" : "No"); ?></td>
                                        <td class="text_normal"><?php echo (($attendee["attendance_hour_2"] == 1) ? "Yes" : "No"); ?></td>
                                        <td class="text_normal"><?php echo (($attendee["attendance_hour_3"] == 1) ? "Yes" : "No"); ?></td>
                                        <td class="text_normal"><?php echo (($attendee["attendance_hour_4"] == 1) ? "Yes" : "No"); ?></td>
                                        <td class="text_normal"><?php echo (($attendee["attendance_hour_5"] == 1) ? "Yes" : "No"); ?></td>
                                        <td class="text_normal"><?php echo (($attendee["attendance_hour_6"] == 1) ? "Yes" : "No"); ?></td>
                                        <td class="text_normal"><?php echo (($attendee["attendance_hour_7"] == 1) ? "Yes" : "No"); ?></td>
                                        <td class="text_normal"><?php echo (($attendee["attendance_hour_8"] == 1) ? "Yes" : "No"); ?></td>
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