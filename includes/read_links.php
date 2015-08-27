<?php
/**
 * File              : read_link.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

/**
 * @param $links
 */
function read_links(&$links) {
    $query = "select *";
    $query .= "  from " . TABLE_PREFIX . "links";
    $query .= " order by link_name asc";

    $links["count"] = query_db($query, $links, true);
}

?>