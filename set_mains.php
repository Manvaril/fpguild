<?php
/**
 * File              : set_mains.php
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
include $fpg_root_path . "header.php";

read_users($users);
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">Roster: Set User Mains</div>
            <div class="body_style">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_header">Forum User</td>
                        <td width="35%" class="text_header">Characters/Type</td>
                        <td width="40%" class="text_header">Action</td>
                    </tr>
                    <?php
                    for ($i = 0; $i < $users["count"]; $i++) {
                        read_user_info($users[$i]["user_id"], $user_info);
                        read_user_chars($users[$i]['user_id'], $user_chars);
                        ?>
                        <tr>
                            <td class="text_normal" valign="top">
                                <?php
                                echo $user_info["username"];
                                ?>
                            </td>
                            <td class="text_normal">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <?php
                                    for ($j = 0; $j < $user_chars["count"]; $j++) {
                                        ?>
                                        <tr>
                                            <td width="60%" class="text_normal"><?php echo $user_chars[$j]["roster_charfirst"]; ?></td>
                                            <td width="30%" class="text_normal"><?php echo $CHAR_TYPE[$user_chars[$j]["roster_type"]]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </td>
                            <?php
                            if ($user_chars["count"] > 1) {
                                ?>
                                <td class="text_normal" valign="top">
                                    <input class="form_button" type="button" value="Set Main" onclick="window.location.href='set_type.php?user_id=<?php echo $users[$i]["user_id"]; ?>'; return false;" />
                                </td>
                            <?php
                            } else {
                                ?>
                                <td class="text_normal" valign="top">&nbsp;</td>
                            <?php
                            }
                            ?>
                        </tr>
                        <tr>
                            <td colspan="3" class="text_normal"><div class="hrline"></div></td>
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