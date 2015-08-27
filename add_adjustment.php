<?php
/**
 * File              : add_adjustment.php
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

if ($request->variable('add', 0)) {
    $err = add_adjustment($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: adjustments.php");
        exit;
    }
}

read_chars($chars);
?>
    <div id="body">
        <div class="header_title">DKP: Add Adjustment</div>
        <div class="body_style">
            <?php
            if ($err) {
                ?>
                <div class="error">ERROR:&nbsp;<?php echo $err; ?></div>
            <?php
            }
            ?>
            <form action="add_adjustment.php?add=1" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_normal">Date</td>
                        <td width="75%" class="text_normal"><input id="datetimeadjust" type="text" name="adjustment_date" size="20" maxlength="20" value="<?php echo date("m/d/Y", ($request->variable('add', 0) ? $request->variable('adjustment_date', '') : time())); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Member</td>
                        <td class="text_normal">
                            <select name="roster_id">
                                <?php
                                for ($i = 0; $i < $chars["count"]; $i++) {
                                    ?>
                                    <option value="<?php echo $chars[$i]["roster_id"];  ?>"<?php echo ($request->variable('roster_id', '') == $chars[$i]["roster_id"] ? " selected=\"selected\"" : ""); ?>><?php echo $chars[$i]["roster_charfirst"] . " (" . $chars[$i]["roster_level"] . " " . $CLASS[$chars[$i]["roster_class"]] . ")";  ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%" class="text_normal">Description</td>
                        <td width="75%" class="text_normal"><input type="text" name="adjustment_desc" size="50" maxlength="200" value="<?php echo safe_string($request->variable('adjustment_desc', '')); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Adjustment Amount</td>
                        <td class="text_normal"><input type="text" name="adjustment_amount" size="7" maxlength="7" value="<?php echo safe_string($request->variable('adjustment_amount', '')); ?>" /></td>
                    </tr>
                </table>
                <input class="form_button" type="submit" value="Save" />
            </form>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>