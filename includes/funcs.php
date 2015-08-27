<?php
/**
 * File              : funcs.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

session_start();
if (!isset($fpg_root_path)) {
    $fpg_root_path = "./";
}
include $fpg_root_path . "includes/defines.php";

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './forums/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/bbcode.' . $phpEx);
include($phpbb_root_path . 'includes/functions_display.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

/** User Group ID Check
 * Pulls user ids from the forums database and
 * puts them in an array for when they are called
 * Only pulls the user ids that are in the specified group ids
 * @param $user_ary
 * @param $group_ids
 */
function get_auth_groups(&$user_ary, &$group_ids) {
    global $db;
    $group_ids = array(5, 4, 8, 9, 10, 11, 12,);
    $user_ary = array();
    $sql = 'SELECT user_id
        FROM ' . USER_GROUP_TABLE . '
        WHERE ' . $db->sql_in_set('group_id', $group_ids);
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result)) {
        $user_ary[$row['user_id']] = $row['user_id'];
    }
    $db->sql_freeresult($result);
}

/** Admin Group ID Check
 * Pulls user id's from the forums database and
 * puts them in an array for when they are called
 * Only pulls the user ids that are in the specified group ids
 * @param $user_ary
 * @param $group_ids
 */
function get_admin_groups(&$user_ary, &$group_ids) {
    global $db;
    $group_ids = array(5, 4, 8, 9,);
    $user_ary = array();
    $sql = 'SELECT user_id
        FROM ' . USER_GROUP_TABLE . '
        WHERE ' . $db->sql_in_set('group_id', $group_ids);
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result)) {
        $user_ary[$row['user_id']] = $row['user_id'];
    }
    $db->sql_freeresult($result);
}

/** Checks to see if GZip is turned on
 * @return bool|string
 */
function check_gzip() {
    if (headers_sent() || connection_aborted()) {
        return false;
    }
    if (strpos($_SERVER["HTTP_ACCEPT_ENCODING"], 'x-gzip') !== false)
        return 'x-gzip';
    if (strpos($_SERVER["HTTP_ACCEPT_ENCODING"], 'gzip') !== false)
        return 'gzip';

    return false;
}

/** Compresses the output of the page for faster load times
 * @param $level
 */
function gzip_output($level) {
    if ($encoding = check_gzip()) {
        $contents = ob_get_contents();
        ob_end_clean();

        header('Content-Encoding: ' . $encoding);

        $size = strlen($contents);
        $crc = crc32($contents);

        $contents = gzcompress($contents, $level);
        $contents = substr($contents, 0, strlen($contents) - 4);

        echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
        echo $contents;
        echo pack('V', $crc);
        echo pack('V', $size);
    } else {
        ob_end_flush();
    }
}

/** Cleans a string from the database
 * @param $string
 * @return string
 */
function safe_string($string) {
    $string = trim($string);
    $string = stripslashes($string);
    #$string = htmlspecialchars($string);

    return $string;
}

/** Cleans a string going into the database
 * @param $string
 * @return string
 */
function clean_string($string) {
    $string = addslashes($string);

    return $string;
}

/** Format's system errors
 * @param $error_txt
 */
function draw_system_error($error_txt) {
    echo "<table>\n";
    echo "<tr>\n";
    echo "<td width=\"30%\" valign=\"top\"><strong>ERROR:&nbsp;</strong></td>\n";
    echo "<td width=\"70%\">" . $error_txt . "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
}

/** Where constructor for the querying of the forums database.
 * @param $gen_id
 * @param $type
 * @return string
 */
function create_where_clauses($gen_id, $type) {
    global $db, $auth;

    $size_gen_id = sizeof($gen_id);

    switch($type) {
        case 'forum':
            $type = 'forum_id';
            break;
        case 'topic':
            $type = 'topic_id';
            break;
        default:
            trigger_error('No type defined');
    }

    // Set $out_where to nothing, this will be used of the gen_id
    // size is empty, in other words "grab from anywhere" with
    // no restrictions
    $out_where = '';

    if ( $size_gen_id > 0 ) {
        // Get a list of all forums the user has permissions to read
        $auth_f_read = array_keys($auth->acl_getf('f_read', true));

        if ( $type == 'topic_id' ) {
            $sql     = 'SELECT topic_id FROM ' . TOPICS_TABLE . '
                        WHERE ' .  $db->sql_in_set('topic_id', $gen_id) . '
                        AND ' .  $db->sql_in_set('forum_id', $auth_f_read);

            $result     = $db->sql_query($sql);

            while( $row = $db->sql_fetchrow($result) ) {
                // Create an array with all acceptable topic ids
                $topic_id_list[] = $row['topic_id'];
            }

            unset($gen_id);

            $gen_id = $topic_id_list;
            $size_gen_id = sizeof($gen_id);
        }

        $j = 0;

        for ( $i = 0; $i < $size_gen_id; $i++ ) {
            $id_check = (int) $gen_id[$i];

            // If the type is topic, all checks have been made and the query can start to be built
            if ( $type == 'topic_id' ) {
                $out_where .= ($j == 0) ? 'WHERE ' . $type . ' = ' . $id_check . ' ' : 'OR ' . $type . ' = ' . $id_check . ' ';
            }

            // If the type is forum, do the check to make sure the user has read permissions
            else if ( $type == 'forum_id' && $auth->acl_get('f_read', $id_check) ) {
                $out_where .= ($j == 0) ? 'WHERE ' . $type . ' = ' . $id_check . ' ' : 'OR ' . $type . ' = ' . $id_check . ' ';
            }
            $j++;
        }
    }

    if( $out_where == '' && $size_gen_id > 0 ) {
        trigger_error('A list of topics/forums has not been created');
    }

    return $out_where;
}

/** Proportionally resizes an image
 * @param $source
 * @param $destination
 * @param $image_type
 * @param $max_size
 * @param $image_width
 * @param $image_height
 * @param $quality
 * @return bool
 */
function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality){

    if ($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize

    //do not resize if image is smaller than max size
    if ($image_width <= $max_size && $image_height <= $max_size){
        if(save_image($source, $destination, $image_type, $quality)){
            return true;
        }
    }

    //Construct a proportional size of new image
    $image_scale	= min($max_size/$image_width, $max_size/$image_height);
    $new_width		= ceil($image_scale * $image_width);
    $new_height		= ceil($image_scale * $image_height);

    $new_canvas		= imagecreatetruecolor( $new_width, $new_height ); //Create a new true color image

    //Copy and resize part of an image with resampling
    if (imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)) {
        save_image($new_canvas, $destination, $image_type, $quality); //save resized image
    }

    return true;
}

/** Saves an image resource to a file
 * @param $source
 * @param $destination
 * @param $image_type
 * @param $quality
 * @return bool
 */
function save_image($source, $destination, $image_type, $quality) {
    switch(strtolower($image_type)) {//determine mime type
        case 'image/png':
            imagepng($source, $destination); return true; //save png file
            break;
        case 'image/gif':
            imagegif($source, $destination); return true; //save gif file
            break;
        case 'image/jpeg': case 'image/pjpeg':
        imagejpeg($source, $destination, $quality); return true; //save jpeg file
        break;
        default: return false;
    }
}

?>