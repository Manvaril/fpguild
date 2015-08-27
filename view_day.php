<?php
/**
 * File              : view_day.php
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

read_days($request->variable('date', ''), $multi_event);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_calendar.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">Events</div>
            <div class="body_style">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="30%" class="text_header">Event Date</td>
                        <td width="45%" class="text_header">Event Name</td>
                        <td width="15%" class="text_header">Max Signups</td>
                        <td width="10%" class="text_header">Action</td>
                    </tr>
                    <?php
                    for ($i = 0; $i < $multi_event["count"]; $i++) {
                        ?>
                        <tr>
                            <td class="text_normal"><?php echo date("D M d, Y g:i a", $multi_event[$i]["event_date"]); ?></td>
                            <td class="text_normal"><?php echo $multi_event[$i]["event_name"]; ?></td>
                            <td class="text_normal"><?php echo ($multi_event[$i]["event_max_signup"] != 0 ? $multi_event[$i]["event_max_signup"] : "Unlimited"); ?></td>
                            <td class="text_normal"><input class="form_button" type="button" value="View" onclick="window.location.href='view_event.php?event_id=<?php echo $multi_event[$i]["event_id"]; ?>'; return false;" /></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>