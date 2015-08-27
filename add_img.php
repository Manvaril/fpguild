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
include $fpg_root_path . "includes/write_gallery.php";
include $fpg_root_path . "header.php";

if ($request->variable('add', 0)) {
    $err = add_img($request->get_super_global(\phpbb\request\request_interface::POST), $request->get_super_global(\phpbb\request\request_interface::FILES)["image_file"]);

    if (!$err) {
        header("Location: gallery.php");
        exit;
    }
}
?>
    <div id="body">
        <div class="header_title">Gallery: Add Image</div>
        <div class="body_style">
            <?php
            if ($err) {
                ?>
                <div class="error">ERROR:&nbsp;<?php echo $err; ?></div>
            <?php
            }
            ?>
            <form action="add_img.php?add=1" method="post" enctype="multipart/form-data" onsubmit="return beforeSubmit();">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%" class="text_normal">Image</td>
                        <td width="75%" class="text_normal"><input name="image_file" id="imageInput" type="file" /><br /><div id="output"></div></td>
                    </tr>
                    <tr>
                        <td class="text_normal">Image Name</td>
                        <td class="text_normal"><input type="text" name="gallery_imgname" size="30" maxlength="50" value="<?php echo safe_string($request->variable('gallery_imgname', '')); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="text_normal" valign="top">Image Comment</td>
                        <td class="text_normal"><textarea name="gallery_comment" cols="40" rows="5"><?php echo safe_string($request->variable('gallery_comment', '')); ?></textarea></td>
                    </tr>
                </table>
                <input class="form_button" type="submit" value="Upload" />
            </form>
        </div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>