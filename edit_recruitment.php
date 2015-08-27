<?php
/**
 * File              : edit_recruitment.php
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
include $fpg_root_path . "includes/read_recruitment.php";
include $fpg_root_path . "includes/write_recruitment.php";
include $fpg_root_path . "header.php";

if ($request->variable('update', 0)) {
    $err = write_recruitment($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: edit_recruitment.php?updated=1");
        exit;
    }
}

$read_err = read_recruitment ($recruitment);
?>
    <div id="body">
        <div class="header_title">Editing Recruitment</div>
        <div class="body_style">
            <?php
            if ($err || $read_err) {
                ?>
                <div class="error">ERROR:&nbsp;<?php echo $err; echo $read_err; ?></div>
            <?php
            }
            ?>
            <?php
            if ($request->variable('updated', 0)) {
                ?>
                <div class="updated">Class Recruitment Table Updated</div>
            <?php
            }
            ?>
            <form action="edit_recruitment.php?update=1" method="post">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>&nbsp;</td>
                    <td width="30%" class="text_header">Class</td>
                    <td width="70%" class="text_header">Need</td>
                </tr>
                <?php
                for ($j = 0; $j < $recruitment["count"]; $j++) {
                    ?>
                    <tr>
                        <td><img src="images/<?php echo $recruitment[$j]["class_id"]; ?>.gif" width="19" height="19" alt="<?php echo $CLASS[$recruitment[$j]["class_id"]] ?>"></td>
                        <td class="text_normal"><?php echo $CLASS[$recruitment[$j]["class_id"]] ?></td>
                        <td class="text_normal">
                            <select name="need_<?php echo $recruitment[$j]["class_id"]; ?>">
                                <?php
                                for ($i = 1; $i < 5; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>"<?php echo ($recruitment[$j]["class_value"] == $i ? " selected=\"selected\"" : ""); ?>><?php echo $RECRUITING[$i]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td class="text_small" colspan="3"><input class="form_button" type="submit" value="Save" /></td>
                </tr>
            </table>
          </form>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>