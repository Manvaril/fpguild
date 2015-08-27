<?php
/**
 * File              : view_char.php
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

read_char($request->variable('char_id', ''), $char_info);
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>False Prophecy - EverQuest Ragefire Guild</title>
    <meta charset="UTF-8"/>
    <link rel="shortcut icon" href="favicon.ico"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="http://www.magelocdn.com/pack/eq/en/magelo-bar.js#7q"></script>
</head>
<body>
<div id="body">
    <div class="header_title">Roster: Viewing <?php echo $char_info["roster_charfirst"]; ?></div>
    <div class="body_style">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="text_header" colspan="2">Keys</td>
            </tr>
            <tr>
                <td class="text_normal" width="75%">Sky Island 2: <a href="http://eq.magelo.com/item/20912/Key-of-the-Misplaced">Key of the Misplaced</a></td>
                <td class="text_normal" width="25%"><?php echo ($char_info["sky_1"] == 1 ? "Yes" : "No"); ?></td>
            </tr>
            <tr>
                <td class="text_normal">Sky Island 3: <a href="http://eq.magelo.com/item/20913/Key-of-Misfortune">Key of Misfortune</a></td>
                <td class="text_normal"><?php echo ($char_info["sky_2"] == 1 ? "Yes" : "No"); ?></td>
            </tr>
            <tr>
                <td class="text_normal">Sky Island 4: <a href="http://eq.magelo.com/item/20914/Key-of-Beasts">Key of Beasts</a></td>
                <td class="text_normal"><?php echo ($char_info["sky_3"] == 1 ? "Yes" : "No"); ?></td>
            </tr>
            <tr>
                <td class="text_normal">Sky Island 5: <a href="http://eq.magelo.com/item/20915/Avian-Key">Avian Key</a></td>
                <td class="text_normal"><?php echo ($char_info["sky_4"] == 1 ? "Yes" : "No"); ?></td>
            </tr>
            <tr>
                <td class="text_normal">Sky Island 6: <a href="http://eq.magelo.com/item/20916/Key-of-the-Swarm">Key of the Swarm</a></td>
                <td class="text_normal"><?php echo ($char_info["sky_5"] == 1 ? "Yes" : "No"); ?></td>
            </tr>
            <tr>
                <td class="text_normal">Sky Island 7: <a href="http://eq.magelo.com/item/20917/Key-of-Scale">Key of Scale</a></td>
                <td class="text_normal"><?php echo ($char_info["sky_6"] == 1 ? "Yes" : "No"); ?></td>
            </tr>
            <tr>
                <td class="text_normal">Sky Island 8: <a href="http://eq.magelo.com/item/20918/Veeshan's-Key">Veeshan's Key</a></td>
                <td class="text_normal"><?php echo ($char_info["sky_7"] == 1 ? "Yes" : "No"); ?></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>