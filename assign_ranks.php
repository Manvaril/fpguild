<?php
/**
 * File              : assign_ranks.php
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
include $fpg_root_path . "includes/read_roster.php";
include $fpg_root_path . "includes/write_roster.php";
include $fpg_root_path . "header.php";

if ($request->variable('edit', 0)) {
    $edit_err = edit_char_rank($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$edit_err) {
        header("Location: assign_ranks.php?updated=1");
        exit;
    }
} elseif ($request->variable('del_char', 0)) {
    $del_err = delete_char($request->variable('roster_id', ''));

    if (!$err) {
        header("Location: assign_ranks.php?deleted=1");
        exit;
    }
}

read_assign_roster($roster);
check_chars_waiting($waiting_chars);
read_ranks($ranks);
?>
    <script language="JavaScript" type="text/javascript">
        function del_char(roster_id, roster_charfirst) {
            var conf = confirm("Are you sure you want to delete " + roster_charfirst + "?");
            if (conf == true) {
                window.location = 'assign_ranks.php?del_char=1&roster_id=' + roster_id + '';
            }
        }
    </script>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">Roster: Assign Ranks</div>
            <div class="body_style">
                <?php
                if ($edit_err || $del_err) {
                    ?>
                    <div class="error">ERROR:&nbsp;<?php echo $edit_err; echo $del_err; ?></div>
                <?php
                }
                ?>
                <?php
                if ($request->variable('updated', 0)) {
                    ?>
                    <div class="updated">Character Rank Updated</div>
                <?php
                }
                ?>
                <?php
                if ($request->variable('deleted', 0)) {
                    ?>
                    <div class="updated">Character Deleted</div>
                <?php
                }
                ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_header">Character Name</td>
                        <td width="20%" class="text_header">Guild Status</td>
                        <td width="55%" class="text_header">Action</td>
                    </tr>
                    <?php
                    for ($i = 0; $i < $roster["count"]; $i++) {
                        ?>
                        <form action="assign_ranks.php?edit=1" method="post">
                            <tr>
                                <td class="text_normal">
                                    <?php
                                    echo $roster[$i]["roster_charfirst"];
                                    echo ($roster[$i]["roster_charlast"] == "" ? "" : "&nbsp;" . $roster[$i]["roster_charlast"]);
                                    ?>
                                </td><input name="roster_id" type="hidden" value="<?php echo ($request->variable('roster_id', 0) ? $request->variable('roster_id', '') : $roster[$i]["roster_id"]); ?>">
                                <td class="text_normal">
                                    <select name="roster_rank">
                                        <option value="0"<?php echo ($roster[$i]["roster_rank"] == 0 ? " selected=\"selected\"" : ""); ?>>Select a Rank</option>
                                        <?php
                                        for ($j = 0; $j < $ranks["count"]; $j++) {
                                            ?>
                                            <option value="<?php echo $ranks[$j]["rank_id"]; ?>"<?php echo ($roster[$i]["roster_rank"] == $ranks[$j]["rank_id"] ? " selected=\"selected\"" : ""); ?>><?php echo $ranks[$j]["rank_name"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input class="form_button" type="submit" value="Update" />
                                    <input class="form_button" type="submit" onclick="javascript:del_char(<?php echo $roster[$i]["roster_id"]; ?>, '<?php echo safe_string($roster[$i]["roster_charfirst"]); ?>'); return false;" value="Delete Char" />
                                </td>
                            </tr>
                        </form>
                    <?php
                    }
                    ?>
                </table>
            </div>
            <?php
            if ($waiting_chars["count"] > 0) {
                ?>
                <div class="header_title">Roster: Awaiting Rank Assignment</div>
                <div class="body_style">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="25%" class="text_header">Character Name</td>
                            <td width="20%" class="text_header">Guild Status</td>
                            <td width="55%" class="text_header">Action</td>
                        </tr>
                        <?php
                        for ($i = 0; $i < $waiting_chars["count"]; $i++) {
                            ?>
                            <form action="assign_ranks.php?edit=1" method="post">
                                <tr>
                                    <td class="text_normal">
                                        <?php
                                        echo $waiting_chars[$i]["roster_charfirst"];
                                        echo ($waiting_chars[$i]["roster_charlast"] == "" ? "" : "&nbsp;" . $waiting_chars[$i]["roster_charlast"]);
                                        ?>
                                    </td><input name="roster_id" type="hidden" value="<?php echo ($request->variable('roster_id', 0) ? $request->variable('roster_id', '') : $waiting_chars[$i]["roster_id"]); ?>">
                                    <td class="text_normal">
                                        <select name="roster_rank">
                                            <option value="0"<?php echo ($waiting_chars[$i]["roster_rank"] == 0 ? " selected=\"selected\"" : ""); ?>>Select a Rank</option>
                                            <?php
                                            for ($j = 0; $j < $ranks["count"]; $j++) {
                                                ?>
                                                <option value="<?php echo $ranks[$j]["rank_id"]; ?>"<?php echo ($waiting_chars[$i]["roster_rank"] == $ranks[$j]["rank_id"] ? " selected=\"selected\"" : ""); ?>><?php echo $ranks[$j]["rank_name"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td><input class="form_button" type="submit" value="Update" /><input class="form_button" type="submit" onclick="javascript:del_char(<?php echo $waiting_chars[$i]["roster_id"]; ?>, '<?php echo safe_string($waiting_chars[$i]["roster_charfirst"]); ?>'); return false;" value="Delete Char" /></td>
                                </tr>
                            </form>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="clear"></div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>