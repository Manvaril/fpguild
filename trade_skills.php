<?php
/**
 * File              : trade_skills.php
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

read_trade_skills($alchemy, $baking, $blacksmithing, $brewing, $fishing, $fletching, $jewelcrafting, $poisonmaking, $pottery, $research, $tailoring, $tinkering);
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
        <div class="header_title_alt">Trade Skills</div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%" class="right_buffer">
                        <div class="header_title">Alchemy</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($alchemy["count"] > 0) {
                                    for ($i = 0; $i < $alchemy["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $alchemy[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $alchemy[$i]["tskills_alchemy"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="header_title">Blacksmithing</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($blacksmithing["count"] > 0) {
                                    for ($i = 0; $i < $blacksmithing["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $blacksmithing[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $blacksmithing[$i]["tskills_blacksmithing"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="header_title">Fishing</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($fishing["count"] > 0) {
                                    for ($i = 0; $i < $fishing["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $fishing[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $fishing[$i]["tskills_fishing"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="header_title">Jewelcrafting</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($jewelcrafting["count"] > 0) {
                                    for ($i = 0; $i < $jewelcrafting["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $jewelcrafting[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $jewelcrafting[$i]["tskills_jewelcrafting"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="header_title">Pottery</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($pottery["count"] > 0) {
                                    for ($i = 0; $i < $pottery["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $pottery[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $pottery[$i]["tskills_pottery"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="header_title">Tailoring</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($tailoring["count"] > 0) {
                                    for ($i = 0; $i < $tailoring["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $tailoring[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $tailoring[$i]["tskills_tailoring"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </td>
                    <td width="50%" class="left_buffer">
                        <div class="header_title">Baking</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($baking["count"] > 0) {
                                    for ($i = 0; $i < $baking["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $baking[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $baking[$i]["tskills_baking"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="header_title">Brewing</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($brewing["count"] > 0) {
                                    for ($i = 0; $i < $brewing["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $brewing[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $brewing[$i]["tskills_brewing"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="header_title">Fletching</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($fletching["count"] > 0) {
                                    for ($i = 0; $i < $fletching["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $fletching[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $fletching[$i]["tskills_fletching"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="header_title">Poison Making</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($poisonmaking["count"] > 0) {
                                    for ($i = 0; $i < $poisonmaking["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $poisonmaking[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $poisonmaking[$i]["tskills_poisonmaking"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="header_title">Research</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($research["count"] > 0) {
                                    for ($i = 0; $i < $research["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $research[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $research[$i]["tskills_research"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="header_title">Tinkering</div>
                        <div class="body_style">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" class="text_header">Character Name</td>
                                    <td width="50%" class="text_header">Skill</td>
                                </tr>
                                <?php
                                if ($tinkering["count"] > 0) {
                                    for ($i = 0; $i < $tinkering["count"]; $i++) {
                                        ?>
                                        <tr>
                                            <td class="text_normal"><?php echo $tinkering[$i]["roster_charfirst"]; ?></td>
                                            <td class="text_normal"><?php echo $tinkering[$i]["tskills_tinkering"]; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text_normal">No characters with this trade skill.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>