<?php
/**
 * File              : edit_links.php
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
include $fpg_root_path . "includes/write_links.php";
include $fpg_root_path . "header.php";

if ($request->variable('edit', 0)) {
    $edit_err = edit_link($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$edit_err) {
        header("Location: edit_links.php?updated=1");
        exit;
    }
} elseif ($request->variable('add', 0)) {
    $add_err = add_link($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$add_err) {
        header("Location: edit_links.php?added=1");
        exit;
    }
} elseif ($request->variable('del_link', 0)) {
    $add_err = delete_link($request->variable('link_id', ''));

    if (!$add_err) {
        header("Location: edit_links.php?deleted=1");
        exit;
    }
}

read_links($links);

?>
    <div id="body">
        <div class="header_title">Links: Edit Links</div>
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
                <div class="updated">Link Updated</div>
            <?php
            }
            ?>
            <?php
            if ($request->variable('deleted', 0)) {
                ?>
                <div class="updated">Link Deleted</div>
            <?php
            }
            ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="25%" class="text_header">Link Name</td>
                    <td width="45%" class="text_header">Link URL</td>
                    <td width="30%" class="text_header">Action</td>
                </tr>
                <?php
                for ($i = 0; $i < $links["count"]; $i++) {
                    ?>
                    <form action="edit_links.php?edit=1" method="post">
                        <tr>
                            <td class="text_normal"><input type="text" name="link_name" size="30" maxlength="50" value="<?php echo $links[$i]["link_name"]; ?>" /><input name="link_id" type="hidden" value="<?php echo $links[$i]["link_id"]; ?>"></td>
                            <td class="text_normal"><input type="text" name="link_url" size="60" maxlength="150" value="<?php echo $links[$i]["link_url"]; ?>" /></td>
                            <td class="text_normal"><input class="form_button" type="submit" value="Update" /><input class="form_button" type="button" value="Delete" onclick="window.location.href='edit_links.php?del_link=1&link_id=<?php echo $links[$i]["link_id"]; ?>'; return false;" /></td>
                        </tr>
                    </form>
                <?php
                }
                ?>
            </table>
        </div>
        <div class="header_title">Links: Add Link</div>
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
                <div class="updated">Link Added</div>
            <?php
            }
            ?>
            <form action="edit_links.php?add=1" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_header">Link Name</td>
                        <td width="75%" class="text_header">Link URL</td>
                    </tr>
                    <tr>
                        <td class="text_normal"><input type="text" name="link_name" size="30" maxlength="50" value="<?php echo safe_string($request->variable('link_name', '')); ?>" /></td>
                        <td class="text_normal"><input type="text" name="link_url" size="60" maxlength="150" value="<?php echo safe_string($request->variable('link_url', '')); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_small" colspan="3"><input class="form_button" type="submit" value="Add" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>