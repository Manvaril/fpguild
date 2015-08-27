<?php
/**
 * File              : footer.php
 * Copyright         : (C) 2015 BlackBlade Software. All Rights Reserved.
 *
 * Last Modified By  : $Author$
 * Last Modified Date: $Date$
 * File Version:     : $Revision$
 *
 * $Id$
 */
?>
    <div id="footer">Copyright &copy; 2015 False Prophecy. All Rights Reserved.<br />Design by: Manvaril<br /><a href="forums/viewtopic.php?f=23&t=95">Website Changelog</a></div>
    </div>
    </body>
    </html>
<?php
######################################################################################################
#        DO NOT REMOVE THE CODE BELOW... THIS CLEANS UP THE GZIP COMPRESSION
######################################################################################################

if (($setting["setting_enable_gzip"] == 1) && ($ext_zlib_loaded == true) && ($ini_zlib_output_compression < 1)) {
    if ( (PHP_VERSION < '4.0.4') && (PHP_VERSION >= '4') ) {
        gzip_output($setting["setting_gzip_level"]);
    }
}
?>