<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
define ( 'PATH_ROOT', '' );
define ( 'DIR_ROOT', str_replace ( '\'', '/', realpath ( dirname ( __FILE__ ) . '/../' ) ) . '/' );
define ( 'DIR_APPLICATION', str_replace ( '\'', '/', realpath ( dirname ( __FILE__ ) ) ) . '/' );
if (file_exists ( DIR_ROOT . 'osforge/config.php' )) {
	require_once (DIR_ROOT . 'osforge/config.php');
}
require_once (DIR_SYSTEM . 'boot.php');
global $registry, $response;
$controller = new Front ( $registry );
$controller->addPreAction ( new Action ( 'common/home/login' ) );
$controller->addPreAction ( new Action ( 'common/home/permission' ) );
if (isset ( $request->get ['route'] )) {
	$action = new Action ( $request->get ['route'] );
} else {
	$action = new Action ( 'common/home' );
}
$controller->dispatch ( $action, new Action ( 'error/not_found' ) );
$response->output ();