<?php
/**
 * File              : roster_keys.php
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

read_roster_keys($roster_keys)
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">Roster: Character Keys</div>
            <div class="body_style">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="30%" class="text_header">Character Name</td>
                        <td width="10%" class="text_header">Sky 2</td>
                        <td width="10%" class="text_header">Sky 3</td>
                        <td width="10%" class="text_header">Sky 4</td>
                        <td width="10%" class="text_header">Sky 5</td>
                        <td width="10%" class="text_header">Sky 6</td>
                        <td width="10%" class="text_header">Sky 7</td>
                        <td width="10%" class="text_header">Sky 8</td>
                    </tr>
                    <?php
                    for ($i = 0; $i < $roster_keys["count"]; $i++) {
                        ?>
                        <tr>
                            <td class="text_normal">
                                <?php
                                echo $roster_keys[$i]["roster_charfirst"];
                                echo ($roster_keys[$i]["roster_charlast"] == "" ? "" : "&nbsp;" . $roster_keys[$i]["roster_charlast"]);
                                ?>
                            </td>
                            <td class="text_normal"><?php echo ($roster_keys[$i]["sky_1"] == 1 ? "Yes" : "No"); ?></td>
                            <td class="text_normal"><?php echo ($roster_keys[$i]["sky_2"] == 1 ? "Yes" : "No"); ?></td>
                            <td class="text_normal"><?php echo ($roster_keys[$i]["sky_3"] == 1 ? "Yes" : "No"); ?></td>
                            <td class="text_normal"><?php echo ($roster_keys[$i]["sky_4"] == 1 ? "Yes" : "No"); ?></td>
                            <td class="text_normal"><?php echo ($roster_keys[$i]["sky_5"] == 1 ? "Yes" : "No"); ?></td>
                            <td class="text_normal"><?php echo ($roster_keys[$i]["sky_6"] == 1 ? "Yes" : "No"); ?></td>
                            <td class="text_normal"><?php echo ($roster_keys[$i]["sky_7"] == 1 ? "Yes" : "No"); ?></td>
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