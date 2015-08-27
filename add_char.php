<?php
/**
 * File              : add_char.php
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
include $fpg_root_path . "includes/write_roster.php";
include $fpg_root_path . "header.php";

if ($request->variable('add', 0)) {
    $err = add_char($request->get_super_global(\phpbb\request\request_interface::POST));

    if (!$err) {
        header("Location: roster.php");
        exit;
    }
}
?>
    <div id="body">
        <div class="header_title">Roster: Add Character</div>
        <div class="body_style">
            <?php
            if ($err) {
                ?>
                <div class="error">ERROR:&nbsp;<?php echo $err; ?></div>
            <?php
            }
            ?>
            <form action="add_char.php?add=1" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td colspan="2" class="text_normal red">Your character will NOT show up on the roster until it receives a rank.<br />Please limit your alts to level 46+ only, this will keep the clutter on the roster down.</td>
                    </tr>
                    <tr>
                        <td width="25%" class="text_normal">Character Name</td>
                        <td width="75%" class="text_normal"><input type="text" name="roster_charfirst" size="30" maxlength="50" value="<?php echo safe_string($request->variable('roster_charfirst', '')); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Character Surname</td>
                        <td class="text_normal"><input type="text" name="roster_charlast" size="30" maxlength="50" value="<?php echo safe_string($request->variable('roster_charlast', '')); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Class</td>
                        <td class="text_normal">
                            <select name="roster_class">
                                <?php
                                for ($i = 1; $i < 17; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>"<?php echo ($request->variable('roster_class', '') == $i ? " selected=\"selected\"" : ""); ?>><?php echo $CLASS[$i]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_normal">Level</td>
                        <td class="text_normal"><input type="text" name="roster_level" size="2" maxlength="2" value="<?php echo safe_string($request->variable('roster_level', '')); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Magelo Link</td>
                        <td class="text_normal"><input type="text" name="roster_magelo" size="50" maxlength="100" value="<?php echo safe_string($request->variable('roster_magelo', '')); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Has Epic</td>
                        <td class="text_normal">
                            <select name="roster_epic">
                                <option value="0"<?php echo ($request->variable('roster_level', 0) == 0 ? " selected=\"selected\"" : ""); ?>>No</option>
                                <option value="1"<?php echo ($request->variable('roster_level', 0) == 1 ? " selected=\"selected\"" : ""); ?>>Yes</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="hrline"></div>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="text_normal" width="50%" valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td class="text_header" colspan="2">Trade Skills</td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal" width="30%">Alchemy</td>
                                                <td class="text_normal" width="70%"><input type="text" name="tskills_alchemy" size="3" maxlength="3" value="<?php echo safe_string($request->variable('tskills_alchemy', '')); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Baking</td>
                                                <td class="text_normal"><input type="text" name="tskills_baking" size="3" maxlength="3" value="<?php echo safe_string($request->variable('tskills_baking', '')); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Blacksmithing</td>
                                                <td class="text_normal"><input type="text" name="tskills_blacksmithing" size="3" maxlength="3" value="<?php safe_string($request->variable('tskills_blacksmithing', '')); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Brewing</td>
                                                <td class="text_normal"><input type="text" name="tskills_brewing" size="3" maxlength="3" value="<?php echo safe_string($request->variable('tskills_brewing', '')); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Fishing</td>
                                                <td class="text_normal"><input type="text" name="tskills_fishing" size="3" maxlength="3" value="<?php echo safe_string($request->variable('tskills_fishing', '')); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Fletching</td>
                                                <td class="text_normal"><input type="text" name="tskills_fletching" size="3" maxlength="3" value="<?php echo safe_string($request->variable('tskills_fletching', '')); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Jewelcrafting</td>
                                                <td class="text_normal"><input type="text" name="tskills_jewelcrafting" size="3" maxlength="3" value="<?php echo safe_string($request->variable('tskills_jewelcrafting', '')); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Poison Making</td>
                                                <td class="text_normal"><input type="text" name="tskills_poisonmaking" size="3" maxlength="3" value="<?php echo safe_string($request->variable('tskills_poisonmaking', '')); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Pottery</td>
                                                <td class="text_normal"><input type="text" name="tskills_pottery" size="3" maxlength="3" value="<?php echo safe_string($request->variable('tskills_pottery', '')); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Research</td>
                                                <td class="text_normal"><input type="text" name="tskills_research" size="3" maxlength="3" value="<?php echo safe_string($request->variable('tskills_research', '')); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Tailoring</td>
                                                <td class="text_normal"><input type="text" name="tskills_tailoring" size="3" maxlength="3" value="<?php echo safe_string($request->variable('tskills_tailoring', '')); ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Tinkering</td>
                                                <td class="text_normal"><input type="text" name="tskills_tinkering" size="3" maxlength="3" value="<?php echo safe_string($request->variable('tskills_tinkering', '')); ?>" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="text_normal" width="50%" valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td class="text_header" colspan="2">Keys</td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal" width="50%">Sky Island 2: <a href="http://eq.magelo.com/item/20912/Key-of-the-Misplaced">Key of the Misplaced</a></td>
                                                <td class="text_normal" width="50%">
                                                    <select name="sky_1">
                                                        <option value="0"<?php echo ($request->variable('sky_1', 0) == 0 ? " selected=\"selected\"" : ""); ?>>No</option>
                                                        <option value="1"<?php echo ($request->variable('sky_1', 0) == 1 ? " selected=\"selected\"" : ""); ?>>Yes</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Sky Island 3: <a href="http://eq.magelo.com/item/20913/Key-of-Misfortune">Key of Misfortune</a></td>
                                                <td class="text_normal">
                                                    <select name="sky_2">
                                                        <option value="0"<?php echo ($request->variable('sky_2', 0) == 0 ? " selected=\"selected\"" : ""); ?>>No</option>
                                                        <option value="1"<?php echo ($request->variable('sky_2', 0) == 1 ? " selected=\"selected\"" : ""); ?>>Yes</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Sky Island 4: <a href="http://eq.magelo.com/item/20914/Key-of-Beasts">Key of Beasts</a></td>
                                                <td class="text_normal">
                                                    <select name="sky_3">
                                                        <option value="0"<?php echo ($request->variable('sky_3', 0) == 0 ? " selected=\"selected\"" : ""); ?>>No</option>
                                                        <option value="1"<?php echo ($request->variable('sky_3', 0) == 1 ? " selected=\"selected\"" : ""); ?>>Yes</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Sky Island 5: <a href="http://eq.magelo.com/item/20915/Avian-Key">Avian Key</a></td>
                                                <td class="text_normal">
                                                    <select name="sky_4">
                                                        <option value="0"<?php echo ($request->variable('sky_4', 0) == 0 ? " selected=\"selected\"" : ""); ?>>No</option>
                                                        <option value="1"<?php echo ($request->variable('sky_4', 0) == 1 ? " selected=\"selected\"" : ""); ?>>Yes</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Sky Island 6: <a href="http://eq.magelo.com/item/20916/Key-of-the-Swarm">Key of the Swarm</a></td>
                                                <td class="text_normal">
                                                    <select name="sky_5">
                                                        <option value="0"<?php echo ($request->variable('sky_5', 0) == 0 ? " selected=\"selected\"" : ""); ?>>No</option>
                                                        <option value="1"<?php echo ($request->variable('sky_5', 0) == 1 ? " selected=\"selected\"" : ""); ?>>Yes</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Sky Island 7: <a href="http://eq.magelo.com/item/20917/Key-of-Scale">Key of Scale</a></td>
                                                <td class="text_normal">
                                                    <select name="sky_6">
                                                        <option value="0"<?php echo ($request->variable('sky_6', 0) == 0 ? " selected=\"selected\"" : ""); ?>>No</option>
                                                        <option value="1"<?php echo ($request->variable('sky_6', 0) == 1 ? " selected=\"selected\"" : ""); ?>>Yes</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text_normal">Sky Island 8: <a href="http://eq.magelo.com/item/20918/Veeshan's-Key">Veeshan's Key</a></td>
                                                <td class="text_normal">
                                                    <select name="sky_7">
                                                        <option value="0"<?php echo ($request->variable('sky_7', 0) == 0 ? " selected=\"selected\"" : ""); ?>>No</option>
                                                        <option value="1"<?php echo ($request->variable('sky_7', 0) == 1 ? " selected=\"selected\"" : ""); ?>>Yes</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <input class="form_button" type="submit" value="Save" />
            </form>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>