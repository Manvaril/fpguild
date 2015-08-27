<?php
/**
 * File              : index.php
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
include $fpg_root_path . "header.php";

get_auth_groups($user_ary, $group_ids);
?>
    <div id="body">
        <div class="left_col">
            <?php include $fpg_root_path . "panel_recruitment.php"; ?>
            <?php include $fpg_root_path . "panel_forumrecent.php"; ?>
        </div>
        <div class="right_col">
            <div class="header_title">News</div>
            <div class="body_style">
                <?php
                $search_limit = 5;
                $forum_id = array($setting["setting_news_forum"]);
                $forum_id_where = create_where_clauses($forum_id, 'forum');

                $posts_ary = array(
                    'SELECT'    => 'p.*, t.*',

                    'FROM'      => array(
                        POSTS_TABLE     => 'p',
                    ),

                    'LEFT_JOIN' => array(
                        array(
                            'FROM'  => array(TOPICS_TABLE => 't'),
                            'ON'    => 't.topic_first_post_id = p.post_id'
                        )
                    ),

                    'WHERE'     => str_replace( array('WHERE ', 'forum_id'), array('', 't.forum_id'), $forum_id_where) . '
                        AND t.topic_status <> ' . ITEM_MOVED . '
                        AND t.topic_visibility = 1',

                    'ORDER_BY'  => 'p.post_id DESC',
                );

                $posts = $db->sql_build_query('SELECT', $posts_ary);

                $posts_result = $db->sql_query_limit($posts, $search_limit);
                $count = 0;

                while( $posts_row = $db->sql_fetchrow($posts_result) )
                {
                    $count++;
                    $topic_title       = $posts_row['topic_title'];
                    $topic_author       = get_username_string('full', $posts_row['topic_poster'], $posts_row['topic_first_poster_name'], $posts_row['topic_first_poster_colour']);
                    $topic_date       = $user->format_date($posts_row['topic_time']);
                    $topic_link       = append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'f=' . $posts_row['forum_id'] . '&amp;t=' . $posts_row['topic_id']);

                    $post_text = nl2br($posts_row['post_text']);

                    $bbcode = new bbcode(base64_encode($bbcode_bitfield));
                    $bbcode->bbcode_second_pass($post_text, $posts_row['bbcode_uid'], $posts_row['bbcode_bitfield']);

                    $post_text = smiley_text($post_text);
                    ?>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="text_header"><?php echo $topic_title; ?></td>
                        </tr>
                        <tr>
                            <td class="text_small">Posted By: <?php echo $topic_author; ?> On: <?php echo $topic_date; ?></td>
                        </tr>
                        <tr>
                            <td class="text_normal"><?php echo $post_text; ?></td>
                        </tr>
                        <?php
                        if (($user->data['is_registered']) && ($user->data["user_id"] != ANONYMOUS)) {
                            if (in_array($user->data['user_id'], $user_ary)) {
                                ?>
                                <tr>
                                    <td class="text_normal">
                                        <input class="form_button" type="button" value="Post Reply" onclick="window.location.href='<?php echo $topic_link; ?>'; return false;" />
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                    </table>
                    <?php
                    if ($count < 5) {
                        ?>
                        <div class="hrline"></div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php
include $fpg_root_path . "footer.php";
?>