<?php
/**
 * File              : roster.php
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

if (!$request->get_super_global(\phpbb\request\request_interface::REQUEST)["sort1"] || !$request->get_super_global(\phpbb\request\request_interface::REQUEST)["sort2"] || !$request->get_super_global(\phpbb\request\request_interface::REQUEST)["sort3"]) {
    $sort1 = "ra.rank_order";
    $sort2 = "ro.roster_class";
    $sort3 = "ro.roster_charfirst";
} else {
    $sort1 = $request->variable('sort1', '');
    $sort2 = $request->variable('sort2', '');
    $sort3 = $request->variable('sort3', '');
}

read_roster($roster, $sort1, $sort2, $sort3, $request->variable('view_alts', ''));
check_char($exist);
check_chars_waiting($waiting_chars);
get_auth_groups($user_ary, $group_ids);
get_admin_groups($admin_ary, $grp_ids);
?>
    <script type="text/javascript">
        function openProfile(path) {
            window.open(path,"",'width=800, height=600, location=yes, scrollbars=no, resizable=no');
        }
    </script>
    <script type="text/javascript">
        function openCharacter(rid) {
            var left = (screen.width/2)-(400/2);
            var top = (screen.height/2)-(300/2);
            window.open("view_char.php?char_id=" + rid,"",'width=400,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left='+left+',top='+top);
        }
    </script>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">Roster</div>
            <div class="body_style">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="text_normal" colspan="2">
                            <?php
                            if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS) && (in_array($user->data['user_id'], $admin_ary))) {
                                ?>
                                <input class="form_button" type="button" value="Edit Ranks" onclick="window.location.href='edit_ranks.php'; return false;" />
                                <input class="form_button" type="button" value="Assign Ranks" onclick="window.location.href='assign_ranks.php'; return false;" />
                                <input class="form_button" type="button" value="View Character Keys" onclick="window.location.href='roster_keys.php'; return false;" />
                                <input class="form_button" type="button" value="Set User Mains" onclick="window.location.href='set_mains.php'; return false;" />
                                <?php
                                if ($waiting_chars["count"] > 0) {
                                    ?>
                                    <span class="text_normal red"><?php echo $waiting_chars["count"]; ?> Characters Awaiting Rank Assignment</span>
                                <?php
                                }
                                echo "<div class=\"hrline\"></div>";
                            }
                            if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS)) {
                                if (in_array($user->data['user_id'], $user_ary)) {
                                    ?>
                                    <input class="form_button" type="button" value="Add Character" onclick="window.location.href='add_char.php'; return false;" />
                                    <input class="form_button" type="button" value="Edit Characters" onclick="window.location.href='user_chars.php'; return false;" />
                                    <div class="hrline"></div>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_normal">
                            <?php
                            if ($request->variable('view_alts', '') == 1) {
                                echo "<span class=\"text_italic\">Viewing Alternate Characters Only</span>";
                            } elseif ($request->variable('view_alts', '') == 2) {
                                echo "<span class=\"text_italic\">Viewing Main and Alternate Characters</span>";
                            } else {
                                echo "<span class=\"text_italic\">Viewing Main Characters Only</span>";
                            }
                            echo "<br />[<a href=\"roster.php\">View Mains</a>]&nbsp;[<a href=\"roster.php?view_alts=1\">View Alts</a>]&nbsp;[<a href=\"roster.php?view_alts=2\">View Both</a>]";
                            ?>
                        </td>
                        <?php
                        if ($request->variable('view_alts', 0) == 1) {
                            echo "<form action=\"roster.php?view_alts=1\" method=\"post\">";
                        } elseif ($request->variable('view_alts', 0) == 2) {
                            echo "<form action=\"roster.php?view_alts=2\" method=\"post\">";
                        } else {
                            echo "<form action=\"roster.php\" method=\"post\">";
                        }
                        ?>
                            <td class="text_normal" style="text-align: right;">Sort By:&nbsp;
                                <select name="sort1" class="form_button">
                                    <option value="ro.roster_charfirst"<?php echo ($sort1 == "ro.roster_charfirst" ? " selected" : ""); ?>>Name</option>
                                    <option value="ra.roster_rank"<?php echo ($sort1 == "ra.roster_rank" ? " selected" : ""); ?>>Status</option>
                                    <option value="ro.roster_class"<?php echo ($sort1 == "ro.roster_class" ? " selected" : ""); ?>>Class</option>
                                    <option value="ro.roster_level"<?php echo ($sort1 == "ro.roster_level" ? " selected" : ""); ?>>Level</option>
                                </select>

                                <select name="sort2" class="form_button">
                                    <option value="ro.roster_charfirst"<?php echo ($sort2 == "ro.roster_charfirst" ? " selected" : ""); ?>>Name</option>
                                    <option value="ra.roster_rank"<?php echo ($sort2 == "ra.roster_rank" ? " selected" : ""); ?>>Status</option>
                                    <option value="ro.roster_class"<?php echo ($sort2 == "ro.roster_class" ? " selected" : ""); ?>>Class</option>
                                    <option value="ro.roster_level"<?php echo ($sort2 == "ro.roster_level" ? " selected" : ""); ?>>Level</option>
                                </select>

                                <select name="sort3" class="form_button">
                                    <option value="ro.roster_charfirst"<?php echo ($sort3 == "ro.roster_charfirst" ? " selected" : ""); ?>>Name</option>
                                    <option value="ra.roster_rank"<?php echo ($sort3 == "ra.roster_rank" ? " selected" : ""); ?>>Status</option>
                                    <option value="ro.roster_class"<?php echo ($sort3 == "ro.roster_class" ? " selected" : ""); ?>>Class</option>
                                    <option value="ro.roster_level"<?php echo ($sort3 == "ro.roster_level" ? " selected" : ""); ?>>Level</option>
                                </select>&nbsp;<input class="form_button" type="submit" value="Sort">
                            </td>
                        </form>
                    </tr>
                    <tr>
                        <td class="text_normal" colspan="2"><div class="hrline"></div></td>
                    </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="40%" class="text_header">Character Name</td>
                        <td width="30%" class="text_header">Guild Status</td>
                        <td width="20%" class="text_header">Class</td>
                        <td width="10%" class="text_header">Level</td>
                    </tr>
                    <?php
                    for ($i = 0; $i < $roster["count"]; $i++) {
                        ?>
                        <tr>
                            <td class="text_normal">
                                <?php
                                echo "<a href=\"javascript:openCharacter('" . $roster[$i]["roster_id"] . "')\">";
                                echo $roster[$i]["roster_charfirst"];
                                echo ($roster[$i]["roster_charlast"] == "" ? "" : "&nbsp;" . $roster[$i]["roster_charlast"]);
                                echo "</a>";
                                echo ($roster[$i]["roster_magelo"] != '' ? "&nbsp;<a href=\"javascript:openProfile('" . $roster[$i]["roster_magelo"] . "')\"><img src=\"images/magelo.gif\" alt=\"Player Has Magelo\" /></a>" : "");
                                echo ($roster[$i]["roster_epic"] == 1 ? "&nbsp;<img src=\"images/epic.gif\" alt=\"Player Has Epic\" />" : "");
                                ?>
                            </td>
                            <td class="text_normal"><?php echo $roster[$i]["rank_name"]; ?></td>
                            <td class="text_normal"><?php echo $CLASS[$roster[$i]["roster_class"]]; ?></td>
                            <td class="text_normal"><?php echo $roster[$i]["roster_level"]; ?></td>
                        </tr>
                    <?php
                    }
                    if ($request->variable('view_alts', '') == 1) {
                        $wording =  "Alternate Characters";
                    } elseif ($request->variable('view_alts', '') == 2) {
                        $wording =  "Main and Alternate Characters";
                    } else {
                        $wording =  "Main Characters";
                    }
                    ?>
                    <tr>
                        <td colspan="4" class="text_normal" style="text-align: right;"><?php echo $roster["count"]; ?> Total <?php echo $wording; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>