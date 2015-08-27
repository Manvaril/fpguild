<?php
/**
 * File              : user_chars.php
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

read_user_chars($user->data['user_id'], $user_chars);
get_auth_groups($user_ary, $group_ids);
get_admin_groups($admin_ary, $grp_ids);
?>
    <script type="text/javascript">
        function openCharacter(rid) {
            var left = (screen.width/2)-(400/2);
            var top = (screen.height/2)-(300/2);
            window.open("view_char.php?char_id=" + rid,"",'width=400,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left='+left+',top='+top);
        }
    </script>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">Roster: Your Characters</div>
            <div class="body_style">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="text_normal" colspan="2">
                            <?php
                            if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS)) {
                                if (in_array($user->data['user_id'], $user_ary)) {
                                    ?>
                                    <input class="form_button" type="button" value="Add Character" onclick="window.location.href='add_char.php'; return false;" />
                                    <input class="form_button" type="button" value="Edit Characters" onclick="window.location.href='user_chars.php'; return false;" />
                                    <div class="hrline"></div>
                                <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="40%" class="text_header">Character Name</td>
                        <td width="20%" class="text_header">Type</td>
                        <td width="20%" class="text_header">Class</td>
                        <td width="10%" class="text_header">Level</td>
                        <td width="10%" class="text_header">Action</td>
                    </tr>
                    <?php
                    for ($i = 0; $i < $user_chars["count"]; $i++) {
                        ?>
                        <tr>
                            <td class="text_normal">
                                <?php
                                echo "<a href=\"javascript:openCharacter('" . $user_chars[$i]["roster_id"] . "')\">";
                                echo $user_chars[$i]["roster_charfirst"];
                                echo ($user_chars[$i]["roster_charlast"] == "" ? "" : "&nbsp;" . $user_chars[$i]["roster_charlast"]);
                                echo "</a>";
                                echo ($user_chars[$i]["roster_magelo"] != '' ? "&nbsp;<a href=\"javascript:openProfile('" . $user_chars[$i]["roster_magelo"] . "')\"><img src=\"images/magelo.gif\" alt=\"Player Has Magelo\" /></a>" : "");
                                echo ($user_chars[$i]["roster_epic"] == 1 ? "&nbsp;<img src=\"images/epic.gif\" alt=\"Player Has Epic\" />" : "");
                                ?>
                            </td>
                            <td class="text_normal"><?php echo $CHAR_TYPE[$user_chars[$i]["roster_type"]]; ?></td>
                            <td class="text_normal"><?php echo $CLASS[$user_chars[$i]["roster_class"]]; ?></td>
                            <td class="text_normal"><?php echo $user_chars[$i]["roster_level"]; ?></td>
                            <td class="text_normal"><input class="form_button" type="button" value="Edit" onclick="window.location.href='edit_char.php?char_id=<?php echo $user_chars[$i]["roster_id"]; ?>'; return false;" /></td>
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