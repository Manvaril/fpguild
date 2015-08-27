<?php
/**
 * File              : write_gallery.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

/**
 * @param $vars
 * @param $img
 * @return string
 */
function add_img($vars, $img) {
    global $user;
    get_auth_groups($user_ary, $group_ids);

    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $user_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } elseif (!strlen(trim($img["name"]))) {
        $err = "There was no image uploaded.";
    } elseif ($img["type"] != "image/gif" && $img["type"] != "image/jpg" && $img["type"] != "image/jpeg" && $img["type"] != "image/pjpeg") {
        $err = "The image is of an invalid file type.";
    } elseif ($img["size"] > 1048576) {
        $err = "The uploaded image is too large. The max upload size is 1MB.";
    } elseif (!trim($vars["gallery_imgname"])) {
        $err = "The Image Name cannot be blank.";
    } elseif (strlen($vars["gallery_imgname"]) > 150) {
        $err = "The Image Name is too long.  It may only be 150 characters in length.";
    } elseif (!preg_match("/^[a-zA-Z0-9 ]+$/", $vars["gallery_imgname"])) {
        $err = "The Image Name contains invalid symbols.";
    } elseif (!trim($vars["gallery_comment"])) {
        $err = "The Image Comment cannot be blank.";
    } elseif (strlen($vars["gallery_comment"]) > 4096) {
        $err = "The Image Comment is too long.  It may only be 4096 characters in length.";
    } else {
        $query  = "select gallery_id";
        $query .= "  from " . TABLE_PREFIX . "gallery";
        $query .= " where gallery_name = '" . $vars["gallery_name"] . "' and user_id != '" . $user->data['user_id'] . "'";

        query_db($query, $img_exists);

        if ($img_exists["gallery_id"]) {
            $err = "That image already exists in the database.";
        } else {
            $thumb_square_size 		= GAL_THUMB_SIZE; //Thumbnails will be cropped to 200x200 pixels
            $max_image_size 		= GAL_PAGE_SIZE; //Maximum image size (height and width)
            $thumb_prefix			= GAL_THUMB_PREFIX; //Normal thumb Prefix
            $page_prefix            = GAL_PAGE_PREFIX;
            $destination_folder		= DIR_PATH . "gallery/"; //upload directory ends with / (slash)
            $jpeg_quality 			= GAL_JPEG_QUALITY; //jpeg quality

            //uploaded file info we need to proceed
            $image_name = $img['name']; //file name
            $image_size = $img['size']; //file size
            $image_temp = $img['tmp_name']; //file temp

            $image_size_info 	= getimagesize($image_temp); //get image size

            $image_width 		= $image_size_info[0]; //image width
            $image_height 		= $image_size_info[1]; //image height
            $image_type 		= $image_size_info['mime']; //image type

            //switch statement below checks allowed image type
            //as well as creates new image from given file
            switch($image_type){
                case 'image/png':
                    $image_res =  imagecreatefrompng($image_temp); break;
                case 'image/gif':
                    $image_res =  imagecreatefromgif($image_temp); break;
                case 'image/jpeg': case 'image/pjpeg':
                $image_res = imagecreatefromjpeg($image_temp); break;
                default:
                    $image_res = false;
            }

            if ($image_res) {
                //Get file extension and name to construct new file name
                $image_info = pathinfo($image_name);
                $image_extension = strtolower($image_info["extension"]); //image extension
                $image_name_only = strtolower($image_info["filename"]); //file name only, no extension

                //create a random name for new image (Eg: fileName_293749.jpg) ;
                $new_file_name = $image_name_only. '_' .  rand(0, 9999999999) . '.' . $image_extension;

                //folder path to save resized images and thumbnails
                $thumb_save_folder 	= $destination_folder . $thumb_prefix . $new_file_name;
                $page_save_folder   = $destination_folder . $page_prefix . $new_file_name;
                $image_save_folder 	= $destination_folder . $new_file_name;

                //call normal_resize_image() function to proportionally resize image
                if (normal_resize_image($image_res, $page_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality)) {
                    //call crop_image_square() function to create square thumbnails
                    if (!normal_resize_image($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality)) {
                        $err = "Problem creating thumbnail.";
                    }
                }
                save_image($image_res, $image_save_folder, $image_type, $jpeg_quality);

                imagedestroy($image_res); //freeup memory
            }

            $values  = "0,";
            $values .= $user->data['user_id'] . ",";
            $values .= "'" . $new_file_name . "',";
            $values .= "'" . $vars["gallery_imgname"] . "',";
            $values .= "'" . $vars["gallery_comment"] . "',";
            $values .= "'" . time() . "'";

            $query  = "insert into " . TABLE_PREFIX . "gallery (gallery_id, user_id, gallery_filename, gallery_name, gallery_comment, gallery_date) ";
            $query .= "values ($values)";

            update_db($query);
        }
    }
    return $err;
}

/**
 * @param $img_id
 */
function delete_img($img_id) {
    global $user;

    get_admin_groups($admin_ary, $grp_ids);
    if ($user->data["user_id"] == ANONYMOUS) {
        $err = "You must be logged in to use this feature.";
    } elseif (!in_array($user->data['user_id'], $admin_ary)) {
        $err = "Your User Group does not have enough access to use this feature.";
    } else {
        $query  = "select gallery_id, gallery_filename";
        $query .= "  from " . TABLE_PREFIX . "gallery";
        $query .= " where gallery_id = '" . $img_id . "'";

        query_db($query, $get_filename);

        @unlink(DIR_PATH . "gallery/" . GAL_THUMB_PREFIX . $get_filename["gallery_filename"]);
        @unlink(DIR_PATH . "gallery/" . GAL_PAGE_PREFIX . $get_filename["gallery_filename"]);
        @unlink(DIR_PATH . "gallery/" . $get_filename["gallery_filename"]);

        $delete_img_query = "delete";
        $delete_img_query .= "  from " . TABLE_PREFIX . "gallery";
        $delete_img_query .= " where gallery_id = '" . $img_id . "'";

        update_db($delete_img_query);
    }
    return $err;
}