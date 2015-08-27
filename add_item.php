<?php
/**
 * File              : add_item.php
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
include $fpg_root_path . "includes/write_dkp.php";
include $fpg_root_path . "header.php";

if ($request->variable('add', 0)) {
    $err = add_item($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: items.php");
        exit;
    }
}
?>
    <div id="body">
        <div class="header_title">DKP: Add Item</div>
        <div class="body_style">
            <?php
            if ($err) {
                ?>
                <div class="error">ERROR:&nbsp;<?php echo $err; ?></div>
            <?php
            }
            ?>
            <form action="add_item.php?add=1" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_normal">Item Name</td>
                        <td width="75%" class="text_normal"><input type="text" name="item_name" size="30" maxlength="50" value="<?php echo safe_string($request->variable('item_name', '')); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Item Notes</td>
                        <td class="text_normal"><input type="text" name="item_notes" size="50" maxlength="200" value="<?php echo safe_string($request->variable('item_notes', '')); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Item Magelo</td>
                        <td class="text_normal"><input type="text" name="item_magelo" size="50" maxlength="100" value="<?php echo safe_string($request->variable('item_magelo', '')); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Points</td>
                        <td class="text_normal"><input type="text" name="item_value" size="7" maxlength="7" value="<?php echo safe_string($request->variable('item_value', '')); ?>" /></td>
                    </tr>
                </table>
                <input class="form_button" type="submit" value="Save" />
            </form>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>