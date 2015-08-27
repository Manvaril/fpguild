<?php
/**
 * File              : view_event.php
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
include $fpg_root_path . "includes/write_dkp.php";
include $fpg_root_path . "includes/read_roster.php";
include $fpg_root_path . "header.php";

if ($request->variable('add', 0)) {
    $err = add_signup($request->variable('event_id', ''), $request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: view_event.php?event_id=" . $request->variable('event_id', ''));
        exit;
    }
} elseif ($request->variable('delete', 0)) {
    $err = delete_signup($request->variable('event_id', ''), $request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: view_event.php?event_id=" . $request->variable('event_id', ''));
        exit;
    }
}

read_event($request->variable('event_id', ''), $event_info);
read_signups($request->variable('event_id', ''), $signups);
read_signedup_chars($user->data['user_id'], $request->variable('event_id', ''), $user_chars);
read_chars_signedup($user->data['user_id'], $request->variable('event_id', ''), $signedup_chars);
get_auth_groups($user_ary, $group_ids);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_calendar.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">View Event</div>
            <div class="body_style">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_normal">Event Name</td>
                        <td width="75%" class="text_normal"><?php echo $event_info["event_name"]; ?></td>
                    </tr>
                    <tr>
                        <td width="25%" class="text_normal">Event Date/Time</td>
                        <td width="75%" class="text_normal"><?php echo date("m/d/Y g:i a", $event_info["event_date"]); ?></td>
                    </tr>
                    <?php
                    if ($event_info["event_no_signup"] == 1) {
                        if ($event_info["event_signup_start"] != 0) {
                            ?>
                            <tr>
                                <td width="25%" class="text_normal">Signups Begin</td>
                                <td width="75%" class="text_normal"><?php echo date("m/d/Y g:i a", $event_info["event_signup_start"]); ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td width="25%" class="text_normal">Signups Close</td>
                            <td width="75%" class="text_normal"><?php echo ($event_info["event_signup_end"] != 0 ? date("m/d/Y g:i a", $event_info["event_signup_end"]) : "Signups close when event starts"); ?></td>
                        </tr>
                        <tr>
                            <td class="text_normal" valign="top">Participants Wanted</td>
                            <td class="text_normal"><?php echo ($event_info["event_max_signup"] != 0 ? $event_info["event_max_signup"] : "Unlimited"); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td class="text_normal" valign="top">Description</td>
                        <td class="text_normal"><?php echo $event_info["event_desc"]; ?></td>
                    </tr>
                    <?php
                    if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS)) {
                        if (in_array($user->data['user_id'], $user_ary)) {
                            ?>
                            <tr>
                                <td colspan="2" class="text_normal">
                                    <div class="hrline"></div>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="text_header">Character Signup</td>
                                        </tr>
                                        <?php
                                        if ($event_info["event_signup_end"] == 0) {
                                            $end_time = $event_info["event_date"];
                                        } else {
                                            $end_time = $event_info["event_signup_end"];
                                        }
                                        if ($event_info["event_no_signup"] == 1) {
                                            if ((time() < $end_time) && (time() > $event_info["event_signup_start"])) {
                                                if (($event_info["event_max_signup"] <= $signups["count"]) || $event_info["event_max_signup"] == 0) {
                                                    if ($user_chars["count"] != 0) {
                                                        ?>
                                                        <tr>
                                                            <td width="75%" class="text_normal">
                                                                <form action="view_event.php?event_id=<?php echo $request->variable('event_id', ''); ?>&add=1" method="post">
                                                                    <select name="roster_id">
                                                                        <?php
                                                                        for ($i = 0; $i < $user_chars["count"]; $i++) {
                                                                            ?>
                                                                            <option value="<?php echo $user_chars[$i]["roster_id"]; ?>"><?php echo $user_chars[$i]["roster_charfirst"] . " (" . $CHAR_TYPE[$user_chars[$i]["roster_type"]] . " " . $user_chars[$i]["roster_level"] . " " . $CLASS[$user_chars[$i]["roster_class"]] . ")"; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    Late?
                                                                    <input type="checkbox" name="signup_late" value="1" />
                                                                    <input class="form_button" type="submit" value="Signup" />
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td class="text_normal">This event has enough people signed up.</td>
                                                    </tr>
                                                    <?php
                                                }
                                                if ($signedup_chars["count"] != 0) {
                                                    ?>
                                                    <tr>
                                                        <td width="75%" class="text_normal">
                                                            <form action="view_event.php?event_id=<?php echo $request->variable('event_id', ''); ?>&delete=1" method="post">
                                                                <select name="roster_id">
                                                                    <?php
                                                                    for ($i = 0; $i < $signedup_chars["count"]; $i++) {
                                                                        ?>
                                                                        <option value="<?php echo $signedup_chars[$i]["roster_id"]; ?>"<?php echo($request->variable('roster_id', '') == $user_chars[$i]["roster_id"] ? " selected=\"selected\"" : ""); ?>><?php echo $signedup_chars[$i]["roster_charfirst"] . " (" . $CHAR_TYPE[$signedup_chars[$i]["roster_type"]] . " " . $signedup_chars[$i]["roster_level"] . " " . $CLASS[$signedup_chars[$i]["roster_class"]] . ")"; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <input class="form_button" type="submit" value="Remove" />
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td class="text_normal">Signups have ended and/or the event has started.</td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td class="text_normal">Signups Disabled</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </td>
                            </tr>
                        <?php
                        }
                    }
                    if ($event_info["event_no_signup"] == 1) {
                        ?>
                        <tr>
                            <td colspan="2" class="text_normal">
                                <div class="hrline"></div>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="4" class="text_header">Signups</td>
                                    </tr>
                                    <tr>
                                        <td width="20%" class="text_header">Character Name</td>
                                        <td width="10%" class="text_header">Main</td>
                                        <td width="10%" class="text_header">Level</td>
                                        <td width="20%" class="text_header">Class</td>
                                        <td width="7%" class="text_header">Late?</td>
                                    </tr>
                                    <?php
                                    if ($signups["count"] != 0) {
                                        for ($i = 0; $i < $signups["count"]; $i++) {
                                            ?>
                                            <tr>
                                                <td class="text_normal"><?php echo $signups[$i]["roster_charfirst"]; ?></td>
                                                <td class="text_normal"><?php echo $CHAR_TYPE[$signups[$i]["roster_type"]]; ?></td>
                                                <td class="text_normal"><?php echo $signups[$i]["roster_level"]; ?></td>
                                                <td class="text_normal"><?php echo $CLASS[$signups[$i]["roster_class"]]; ?></td>
                                                <td class="text_normal"><?php echo(($signups[$i]["signup_late"] == 1) ? "Yes" : "No"); ?></td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="4" class="text_normal">No characters signed up yet.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </td>
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