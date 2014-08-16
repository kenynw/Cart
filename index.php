<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
define ( 'PATH_ROOT', 'front' );
if (file_exists ( PATH_ROOT . '/index.php' )) {
	require_once (PATH_ROOT . '/index.php');
} else {
	echo "System Error. Please contact administrator.";
	exit ( 0 );
}
