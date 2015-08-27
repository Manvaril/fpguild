<?php
/**
 * File              : view_img.php
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
include $fpg_root_path . "includes/write_gallery.php";
include $fpg_root_path . "header.php";

if ($request->variable('del', 0)) {
    $del_err = delete_img($request->variable('img_id', ''));

    if (!$err) {
        header("Location: gallery.php");
        exit;
    }
}

read_image($request->variable('img_id', 0), $image);
get_admin_groups($admin_ary, $grp_ids);
?>
    <div id="body">
        <div class="header_title">Gallery: View Image </div>
        <div class="body_style">
            <?php
            if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS) && (in_array($user->data['user_id'], $admin_ary))) {
                ?>
                <input class="form_button" type="button" value="Delete Image" onclick="window.location.href='view_img.php?del=1&img_id=<?php echo $request->variable('img_id', 0); ?>'; return false;" /><br />
                <div class="hrline"></div>
            <?php
            }
            ?>
            <div class="text_header center_txt"><?php echo $image["gallery_name"]; ?></div>
            <a href="<?php echo HTTP_PATH . "gallery/" . $image["gallery_filename"]; ?>"><img class="center_img" src="<?php echo HTTP_PATH . "gallery/" . GAL_PAGE_PREFIX . $image["gallery_filename"]; ?>" alt="<?php echo $image["gallery_name"]; ?>" /></a><br />
            <div class="comment_box">Posted By: <?php echo get_username_string('full', $image["user_id"], $image["username"], $image["user_colour"]); ?><br />
            <?php echo nl2br($image["gallery_comment"]); ?></div><br />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="15%" class="text_normal center_txt"><?php echo ($image["next"] ? "<a href=\"view_img.php?img_id=" . $image["next"] . "\"><< Previous</a>" : "<< Previous"); ?></td>
                    <td width="70%" class="text_normal center_txt"><a href="gallery.php">Back to Gallery list</a></td>
                    <td width="15%" class="text_normal center_txt"><?php echo ($image["previous"] ? "<a href=\"view_img.php?img_id=" . $image["previous"] . "\">Next >></a>" : "Next >>"); ?></td>
                </tr>
            </table>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>