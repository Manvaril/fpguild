<?php
/**
 * File              : edit_charter.php
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
include $fpg_root_path . "includes/write_charter.php";
include $fpg_root_path . "header.php";

if ($request->variable('update', 0)) {
    $err = write_charter($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: edit_charter.php?updated=1");
        exit;
    }
}
?>
    <div id="body">
        <div class="header_title">Editing Charter</div>
        <div class="body_style">
            <?php
            if ($err) {
                ?>
                <div class="error">ERROR:&nbsp;<?php echo $err; ?></div>
            <?php
            }
            ?>
            <?php
            if ($request->variable('updated', 0)) {
                ?>
                <div class="updated">Charter Page Updated</div>
            <?php
            }
            ?>
            <form action="edit_charter.php?update=1" method="post">
                <textarea name="charter" cols="125" rows="40"><?php echo $setting["setting_charter"]; ?></textarea><br/>
                <input class="form_button" type="submit" value="Save" />
            </form>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>