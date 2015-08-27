<?php
/**
 * File              : database.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */

/**
 * @param $query
 * @param $result
 * @param bool $multiple
 * @return int
 */
function query_db($query, &$result, $multiple = false) {
    $db = mysqli_connect(HOSTNAME, LOGIN, PASSWORD);

    if (!$db) {
        draw_system_error("Error: Failed to connect to the database.");
        exit;
    } else {
        mysqli_select_db($db, DATABASE);
        $res = mysqli_query($db, $query);
        $err = mysqli_error($db);

        if ($err) {
            mysqli_close($db);
            draw_system_error("$err<br />Query: $query");
            exit;
        } else {
            if ($res) {
                if ($multiple) {
                    $i = 0;

                    while ($result[$i] = mysqli_fetch_array($res)) {
                        $i++;
                    }

                    return $i;
                } else {
                    $result = mysqli_fetch_array($res);

                    if ($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            }
            mysqli_close($db);
        }
    }
}

/**
 * @param $query
 */
function update_db($query) {
    $db = mysqli_connect(HOSTNAME, LOGIN, PASSWORD);

    if (!$db) {
        draw_system_error("Failed to connect to the database.");
        exit;
    } else {
        mysqli_select_db($db, DATABASE);
        $res = mysqli_query($db, $query);
        $err = mysqli_error($db);
        mysqli_close($db);

        if ($err) {
            draw_system_error("$err<br />Query: $query");
            exit;
        }
    }
}

?>