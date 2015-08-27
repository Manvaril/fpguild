<?php
/**
 * File              : read_recruitment.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

/**
 * @param $recruitment
 */
function read_recruitment (&$recruitment) {
    $query = "select *";
    $query .= "  from " . TABLE_PREFIX . "recruitment";

    $recruitment["count"] = query_db($query, $recruitment, true);
}