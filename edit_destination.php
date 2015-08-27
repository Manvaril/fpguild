<?php
/**
 * File              : edit_destination.php
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
include $fpg_root_path . "includes/read_dkp.php";
include $fpg_root_path . "header.php";

if ($request->variable('edit', 0)) {
    $err = edit_destination($request->variable('dest_id', ''), $request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: destinations.php");
        exit;
    }
}

read_destination($request->variable('dest_id', ''), $destination);
?>
    <div id="body">
        <div class="header_title">DKP: Edit Destination/Boss</div>
        <div class="body_style">
            <?php
            if ($err) {
                ?>
                <div class="error">ERROR:&nbsp;<?php echo $err; ?></div>
            <?php
            }
            ?>
            <form action="edit_destination.php?dest_id=<?php echo $request->variable('dest_id', ''); ?>&edit=1" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_normal">Item Name</td>
                        <td width="75%" class="text_normal"><input type="text" name="dest_name" size="30" maxlength="150" value="<?php echo ($request->variable('edit', 0) ? $request->variable('dest_name', '') : $destination["dest_name"]); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Points</td>
                        <td class="text_normal"><input type="text" name="dest_value" size="7" maxlength="7" value="<?php echo ($request->variable('edit', 0) ? $request->variable('dest_value', '') : $destination["dest_value"]); ?>" /></td>
                    </tr>
                </table>
                <input class="form_button" type="submit" value="Save" />
            </form>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>