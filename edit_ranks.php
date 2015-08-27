<?php
/**
 * File              : edit_ranks.php
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
    $edit_err = edit_ranks($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$edit_err) {
        header("Location: edit_ranks.php?updated=1");
        exit;
    }
} elseif ($request->variable('add', 0)) {
    $add_err = add_rank($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$add_err) {
        header("Location: edit_ranks.php?added=1");
        exit;
    }
} elseif ($request->variable('del_rank', 0)) {
    $edit_err = delete_rank($request->variable('rank_id', ''));

    if (!$edit_err) {
        header("Location: edit_ranks.php?deleted=1");
        exit;
    }
}

read_ranks($ranks);

?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">Roster: Edit Ranks</div>
            <div class="body_style">
                <?php
                if ($edit_err) {
                    ?>
                    <div class="error">ERROR:&nbsp;<?php echo $edit_err; ?></div>
                <?php
                }
                ?>
                <?php
                if ($request->variable('updated', 0)) {
                    ?>
                    <div class="updated">Ranks Updated</div>
                <?php
                }
                ?>
                <?php
                if ($request->variable('deleted', 0)) {
                    ?>
                    <div class="updated">Rank Deleted</div>
                <?php
                }
                ?>
                <form action="edit_ranks.php?edit=1" method="post">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="25%" class="text_header">Rank Name</td>
                            <td width="5%" class="text_header">Order</td>
                            <td width="70%" class="text_header">Action</td>
                        </tr>
                        <?php
                        for ($i = 0; $i < $ranks["count"]; $i++) {
                            ?>
                            <tr>
                                <td class="text_normal"><input type="text" name="rank_name[]" size="30" maxlength="50" value="<?php echo ($request->variable('edit', 0) ? $request->get_super_global(\phpbb\request\request_interface::POST)["rank_name"][$i] : $ranks[$i]["rank_name"]); ?>" /><input name="rank_id[]" type="hidden" value="<?php echo ($request->variable('edit', 0) ? $request->get_super_global(\phpbb\request\request_interface::POST)["rank_id"][$i] : $ranks[$i]["rank_id"]); ?>"></td>
                                <td class="text_normal"><input type="text" name="rank_order[]" size="2" maxlength="2" value="<?php echo ($request->variable('edit', 0) ? $request->get_super_global(\phpbb\request\request_interface::POST)["rank_order"][$i] : $ranks[$i]["rank_order"]); ?>" /></td>
                                <td class="text_normal">
                                    <?php
                                    check_rank($ranks[$i]["rank_id"], $exist);
                                    if (!$exist["roster_id"]) {
                                        ?>
                                        <input class="form_button" type="button" value="Delete" onclick="window.location.href='edit_ranks.php?del_rank=1&rank_id=<?php echo ($request->variable('edit', 0) ? $request->get_super_global(\phpbb\request\request_interface::POST)["rank_id"][$i] : $ranks[$i]["rank_id"]); ?>'; return false;" />
                                    <?php
                                    } else {
                                        ?>
                                        <input class="form_button" type="button" value="Delete" disabled="disabled" />
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td class="text_small" colspan="3"><input class="form_button" type="submit" value="Save" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="header_title">Roster: Add Rank</div>
            <div class="body_style">
                <?php
                if ($add_err) {
                    ?>
                    <div class="error">ERROR:&nbsp;<?php echo $add_err; ?></div>
                <?php
                }
                ?>
                <?php
                if ($request->variable('added', 0)) {
                    ?>
                    <div class="updated">New Rank Added</div>
                <?php
                }
                ?>
                <form action="edit_ranks.php?add=1" method="post">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="25%" class="text_header">Rank Name</td>
                            <td width="75%" class="text_header">Rank Order</td>
                        </tr>
                        <tr>
                            <td class="text_normal"><input type="text" name="rank_name" size="30" maxlength="50" value="<?php echo safe_string($request->variable('rank_name', '')); ?>" /></td>
                            <td class="text_normal"><input type="text" name="rank_order" size="2" maxlength="2" value="<?php echo safe_string($request->variable('rank_order', '')); ?>" /></td>
                        </tr>
                        <tr>
                            <td class="text_small" colspan="3"><input class="form_button" type="submit" value="Add" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>