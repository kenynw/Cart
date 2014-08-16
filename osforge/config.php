<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
define ( 'VERSION', '1.4.2' );
define ( 'PROJECT', 'CART' );
// HTTP
define ( 'HTTP_SERVER', 'http://' . $_SERVER ['HTTP_HOST'] . rtrim ( dirname ( $_SERVER ['SCRIPT_NAME'] ), '/.\\' ) . '/' );
define ( 'HTTPS_SERVER', 'https://' . $_SERVER ['HTTP_HOST'] . rtrim ( dirname ( $_SERVER ['SCRIPT_NAME'] ), '/.\\' ) . '/' );
define ( 'HTTP_CATALOG', 'http://' . $_SERVER ['HTTP_HOST'] . '/' );
define ( 'HTTPS_CATALOG', 'https://' . $_SERVER ['HTTP_HOST'] . '/' );
// DIR
define ( 'DIR_SYSTEM', DIR_ROOT . 'osforge/' );
define ( 'DIR_TEMPLATE', DIR_APPLICATION . 'view/' );
define ( 'DIR_LANGUAGE', DIR_SYSTEM . 'language/' );
define ( 'DIR_DATABASE', DIR_SYSTEM . 'database/' );
define ( 'DIR_CONFIG', DIR_SYSTEM . 'config/' );
define ( 'DIR_CACHE', DIR_SYSTEM . 'cache/' );
define ( 'DIR_LOGS', DIR_SYSTEM . 'logs/' );
define ( 'DIR_IMAGE', DIR_ROOT . 'image/' );
define ( 'DIR_DOWNLOAD', DIR_ROOT . 'image/' );
// DB
if (file_exists ( DIR_CONFIG . strtolower(PROJECT) . '.php' )) {
	require_once (DIR_CONFIG . strtolower(PROJECT) . '.php');
} else {
	require_once (DIR_CONFIG . 'default.php');
}