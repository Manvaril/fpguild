<?php
/**
 * File              : panel_recruitment.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

include $fpg_root_path . "includes/read_recruitment.php";

$err = read_recruitment ($recruitment);
get_admin_groups($admin_ary, $grp_ids);
?>
<div class="header_title">Recruitment</div>
<div class="body_style">
    <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>&nbsp;</td>
            <td width="60%" class="text_header">Class</td>
            <td width="40%" class="text_header">Need</td>
        </tr>
        <?php
        for ($j = 0; $j < $recruitment["count"]; $j++) {
            ?>
            <tr>
                <td><img src="images/<?php echo $recruitment[$j]["class_id"]; ?>.gif" width="19" height="19" alt="<?php echo $CLASS[$recruitment[$j]["class_id"]] ?>"></td>
                <td width="60%" class="text_normal"><?php echo $CLASS[$recruitment[$j]["class_id"]] ?></td>
                <td width="40%" class="text_normal"><?php echo $RECRUITING[$recruitment[$j]["class_value"]] ?></td>
            </tr>
        <?php
        }
        if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS) && (in_array($user->data['user_id'], $admin_ary))) {
            ?>
            <tr>
                <td class="text_small" colspan="3"><input class="form_button" type="button" value="Edit Panel" onclick="window.location.href='edit_recruitment.php'; return false;" /></td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>