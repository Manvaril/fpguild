<?php
/**
 * File              : links.php
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
include $fpg_root_path . "includes/read_links.php";
include $fpg_root_path . "header.php";

read_links($links);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">Links</div>
            <div class="body_style">
                <?php
                if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS) && (in_array($user->data['user_id'], $admin_ary))) {
                    ?>
                    <input class="form_button" type="button" value="Edit Links" onclick="window.location.href='edit_links.php'; return false;" />
                <?php
                    echo "<div class=\"hrline\"></div>";
                }
                ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php
                    for ($i = 0; $i < $links["count"]; $i++) {
                        ?>
                        <tr>
                            <td class="text_header"><a href="<?php echo $links[$i]["link_url"]; ?>" target="_blank"><?php echo $links[$i]["link_name"]; ?></a></td>
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