<?php
/**
 * File              : charter.php
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
include $fpg_root_path . "header.php";

get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">Charter</div>
            <div class="body_style">
                <?php
                if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS) && (in_array($user->data['user_id'], $admin_ary))) {
                    ?>
                        <input class="form_button" type="button" value="Edit Page" onclick="window.location.href='edit_charter.php'; return false;" /><br />
                <?php
                    echo "<div class=\"hrline\"></div>";
                }
                ?>
                <?php

                $charter_text = $setting["setting_charter"];
                $uid = $bitfield = $flags = '';
                $allow_bbcode = $allow_urls = $allow_smilies = true;
                generate_text_for_storage($charter_text, $uid, $bitfield, $flags, $allow_bbcode, $allow_urls, $allow_smilies);
                $charter_text = generate_text_for_display($charter_text, $uid, $bitfield, $flags);

                echo $charter_text;
                ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>