<?php
/**
 * File              : read_gallery.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

/**
 * @param $gallery
 * @param $img_cnt
 * @param $page
 */
function read_gallery(&$gallery, &$img_cnt, $page) {
    $query = "select *";
    $query .= "  from " . TABLE_PREFIX . "gallery";
    $query .= " order by gallery_date desc";
    $query .= " limit " . ($page - 1) * 12 . ", " . 12;

    $gallery["count"] = query_db($query, $gallery, true);

    $query  = "select count(gallery_id) as cnt";
    $query .= "  from " . TABLE_PREFIX . "gallery";

    query_db($query, $img_cnt);
}

/**
 * @param $user_id
 * @param $user_data
 */
function get_user_info($user_id, &$user_data) {
    $query = "select user_id, username, user_colour";
    $query .= "  from " . PHPBB_TABLE_PREFIX . "users";
    $query .= " where user_id = '" . $user_id . "'";

    phpbb_query_db($query, $user_data);
}

/**
 * @param $img_id
 * @param $image
 */
function read_image($img_id, &$image) {
    $query = "select *";
    $query .= "  from " . TABLE_PREFIX . "gallery";
    $query .= " order by gallery_date asc";

    $images["count"] = query_db($query, $images, true);

    $found = false;
    for ($i = 0; $i < $images["count"]; $i++) {
        get_user_info($images[$i]["user_id"], $user_data);
        if ($images[$i]["gallery_id"] == $img_id) {
            $found = true;

            if ($i == 0) {
                $image["previous"] = 0;
            } else {
                $image["previous"] = $images[$i - 1]["gallery_id"];
            }

            if (!$images[$i + 1]["gallery_id"]) {
                $image["next"] = 0;
            } else {
                $image["next"] = $images[$i + 1]["gallery_id"];
            }

            $image["gallery_id"]       = $images[$i]["gallery_id"];
            $image["gallery_name"]     = $images[$i]["gallery_name"];
            $image["gallery_date"]     = $images[$i]["gallery_date"];
            $image["user_id"]          = $user_data["user_id"];
            $image["username"]         = $user_data["username"];
            $image["user_colour"]      = $user_data["user_colour"];
            $image["gallery_comment"]  = $images[$i]["gallery_comment"];
            $image["gallery_filename"] = $images[$i]["gallery_filename"];

            break;
        }
    }
}

?>