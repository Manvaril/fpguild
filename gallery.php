<?php
/**
 * File              : gallery.php
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
include $fpg_root_path . "includes/read_gallery.php";
include $fpg_root_path . "header.php";

if (!$request->variable('page', '')) {
    $page = 1;
} else {
    $page = $request->variable('page', '');
}

read_gallery($gallery, $img_cnt, $page);
get_auth_groups($user_ary, $group_ids);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">Gallery</div>
            <div class="body_style">
                <?php
                if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS)) {
                    if (in_array($user->data['user_id'], $user_ary)) {
                        ?>
                        <input class="form_button" type="button" value="Add Image" onclick="window.location.href='add_img.php'; return false;" />
                        <?php
                        echo "<div class=\"hrline\"></div>";
                    }
                }
                if ($gallery["count"] > 0) {
                    for ($i = 0; $i < $gallery["count"]; $i++) {
                        get_user_info($gallery[$i]["user_id"], $user_data);
                        ?>
                        <div class="img_box">
                            <a href="view_img.php?img_id=<?php echo $gallery[$i]["gallery_id"]; ?>"><img src="<?php echo HTTP_PATH . "gallery/" . GAL_THUMB_PREFIX . $gallery[$i]["gallery_filename"]; ?>" alt="<?php echo $gallery[$i]["gallery_name"]; ?>" /></a><br />
                            Posted By: <?php echo get_username_string('full', $user_data["user_id"], $user_data["username"], $user_data["user_colour"]); ?>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="center_txt">No images in database yet.</div>
                <?php
                }
                ?>
                <div class="clear"></div>
                <?php
                $pages  = ceil($img_cnt["cnt"] / 12);

                for ($j = 1; $j <= $pages; $j++) {
                    if ($j == $page) {
                        $page_str .= $j . " | ";
                    } else {
                        $page_str .= "<a href=\"gallery.php?page=$j\">$j</a> | ";
                    }
                }
                echo "Page: " . substr($page_str, 0, -3);
                ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>