<?php
/**
 * File              : panel_calendar.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

include $fpg_root_path . "includes/calendar.php";

#$err = read_recruitment ($recruitment);
get_admin_groups($admin_ary, $grp_ids);
?>
<div class="header_title">Calendar</div>
<div class="body_style">
    <?php
    $calendar = new Calendar();
    echo $calendar->show();
    ?>
</div>