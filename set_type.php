<?php
/**
 * File              : set_type.php
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

if ($request->variable('update', 0)) {
    $err = edit_roster_type($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: set_mains.php");
        exit;
    }
}

read_user_chars($request->variable('user_id', ''), $user_chars);
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">Roster: Set Main Character</div>
            <div class="body_style">
                <?php
                if ($err) {
                    ?>
                    <div class="error">ERROR:&nbsp;<?php echo $err; ?></div>
                <?php
                }
                ?>
                <form action="set_type.php?update=1" method="post">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="25%" class="text_header">Character Name</td>
                            <td width="75%" class="text_header">Select Main</td>
                        </tr>
                        <?php
                        for ($i = 0; $i < $user_chars["count"]; $i++) {
                            ?>
                            <tr>
                                <td class="text_normal">
                                    <?php
                                    echo $user_chars[$i]["roster_charfirst"];
                                    ?>
                                </td>
                                <td class="text_normal"><input type="hidden" name="roster_id[]" value="<?php echo ($request->variable('roster_id', '') ? $request->variable('roster_id[]', '') : $user_chars[$i]["roster_id"]); ?>" /><input type="radio" name="roster_type" value="<?php echo $user_chars[$i]["roster_id"]; ?>"<?php echo (($user_chars[$i]["roster_type"] == 0) ? " checked=\"checked\"" : ""); ?> /></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                    <input class="form_button" type="submit" value="Set Main" />
                </form>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>