<?php
/**
 * File              : panel_forumrecent.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */
$search_limit = 10;
$posts_ary = array(
    'SELECT'    => 'p.*, t.*, u.username, u.user_colour',

    'FROM'      => array(
        POSTS_TABLE     => 'p',
    ),

    'LEFT_JOIN' => array(
        array(
            'FROM'  => array(USERS_TABLE => 'u'),
            'ON'    => 'u.user_id = p.poster_id'
        ),
        array(
            'FROM'  => array(TOPICS_TABLE => 't'),
            'ON'    => 'p.topic_id = t.topic_id'
        ),
    ),

    'WHERE'     => $db->sql_in_set('t.forum_id', array_keys($auth->acl_getf('f_read', true))) . '
                        AND t.topic_status <> ' . ITEM_MOVED . '
                         AND t.topic_visibility = 1',

    'ORDER_BY'  => 'p.post_id DESC',
);

$posts = $db->sql_build_query('SELECT', $posts_ary);

$posts_result = $db->sql_query_limit($posts, $search_limit);
?>
    <div class="header_title">Latest Posts</div>
    <div class="body_style">
        <table border="0" cellspacing="0" cellpadding="0">
            <?php
            while( $posts_row = $db->sql_fetchrow($posts_result) )
            {
                $topic_title = $posts_row['topic_title'];
                $post_author = get_username_string('full', $posts_row['poster_id'], $posts_row['username'], $posts_row['user_colour']);
                $post_date   = $user->format_date($posts_row['post_time']);
                $post_link   = append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'f=' . $posts_row['forum_id'] . '&amp;t=' . $posts_row['topic_id'] . '&amp;p=' . $posts_row['post_id']) . '#p' . $posts_row['post_id'];
                ?>
                <tr>
                    <td class="text_normal"><a href="<?php echo $post_link; ?>"><?php echo $topic_title; ?></a> by: <?php echo $post_author; ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
