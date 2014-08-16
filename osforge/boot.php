<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
// Error Reporting
error_reporting ( E_ALL );
// Check Version
if (version_compare ( phpversion (), '5.2.0', '<' ) == true) {
	exit ( 'PHP5.2+ Required' );
}
// Register Globals
if (ini_get ( 'register_globals' )) {
	ini_set ( 'session.use_cookies', 'On' );
	ini_set ( 'session.use_trans_sid', 'Off' );
	session_set_cookie_params ( 0, '/' );
	session_start ();
	$globals = array (
			$_REQUEST,
			$_SESSION,
			$_SERVER,
			$_FILES 
	);
	foreach ( $globals as $global ) {
		foreach ( array_keys ( $global ) as $key ) {
			unset ( ${$key} );
		}
	}
}
// Magic Quotes Fix
if (ini_get ( 'magic_quotes_gpc' )) {
	function clean($data) {
		if (is_array ( $data )) {
			foreach ( $data as $key => $value ) {
				$data [clean ( $key )] = clean ( $value );
			}
		} else {
			$data = stripslashes ( $data );
		}
		return $data;
	}
	$_GET = clean ( $_GET );
	$_POST = clean ( $_POST );
	$_REQUEST = clean ( $_REQUEST );
	$_COOKIE = clean ( $_COOKIE );
}
if (! ini_get ( 'date.timezone' )) {
	date_default_timezone_set ( 'UTC' );
}
// Windows IIS Compatibility
if (! isset ( $_SERVER ['DOCUMENT_ROOT'] )) {
	if (isset ( $_SERVER ['SCRIPT_FILENAME'] )) {
		$_SERVER ['DOCUMENT_ROOT'] = str_replace ( '\\', '/', substr ( $_SERVER ['SCRIPT_FILENAME'], 0, 0 - strlen ( $_SERVER ['PHP_SELF'] ) ) );
	}
}
if (! isset ( $_SERVER ['DOCUMENT_ROOT'] )) {
	if (isset ( $_SERVER ['PATH_TRANSLATED'] )) {
		$_SERVER ['DOCUMENT_ROOT'] = str_replace ( '\\', '/', substr ( str_replace ( '\\\\', '\\', $_SERVER ['PATH_TRANSLATED'] ), 0, 0 - strlen ( $_SERVER ['PHP_SELF'] ) ) );
	}
}
if (! isset ( $_SERVER ['REQUEST_URI'] )) {
	$_SERVER ['REQUEST_URI'] = substr ( $_SERVER ['PHP_SELF'], 1 );
	if (isset ( $_SERVER ['QUERY_STRING'] )) {
		$_SERVER ['REQUEST_URI'] .= '?' . $_SERVER ['QUERY_STRING'];
	}
}
if (! isset ( $_SERVER ['HTTP_HOST'] )) {
	$_SERVER ['HTTP_HOST'] = getenv ( 'HTTP_HOST' );
}
// Helper
require_once (DIR_SYSTEM . 'helper/helper.php');
require_once (DIR_SYSTEM . 'helper/json.php');
require_once (DIR_SYSTEM . 'helper/utf8.php');
// Engine
require_once (DIR_SYSTEM . 'engine/action.php');
require_once (DIR_SYSTEM . 'engine/controller.php');
require_once (DIR_SYSTEM . 'engine/front.php');
require_once (DIR_SYSTEM . 'engine/loader.php');
require_once (DIR_SYSTEM . 'engine/model.php');
require_once (DIR_SYSTEM . 'engine/registry.php');
// Common
require_once (DIR_SYSTEM . 'library/cache.php');
require_once (DIR_SYSTEM . 'library/url.php');
require_once (DIR_SYSTEM . 'library/config.php');
require_once (DIR_SYSTEM . 'library/db.php');
require_once (DIR_SYSTEM . 'library/document.php');
require_once (DIR_SYSTEM . 'library/encryption.php');
require_once (DIR_SYSTEM . 'library/image.php');
require_once (DIR_SYSTEM . 'library/language.php');
require_once (DIR_SYSTEM . 'library/log.php');
require_once (DIR_SYSTEM . 'library/pagination.php');
require_once (DIR_SYSTEM . 'library/request.php');
require_once (DIR_SYSTEM . 'library/response.php');
require_once (DIR_SYSTEM . 'library/session.php');
require_once (DIR_SYSTEM . 'library/template.php');
require_once (DIR_SYSTEM . 'library/user.php');
$registry = new Registry ();
$loader = new Loader ( $registry );
$registry->set ( 'load', $loader );
$config = new Config ();
$registry->set ( 'config', $config );
$db = new DB ( DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE );
$registry->set ( 'db', $db );
if (isset ( $_SERVER ['HTTPS'] ) && (($_SERVER ['HTTPS'] == 'on') || ($_SERVER ['HTTPS'] == '1'))) {
	$store_query = $db->query ( "SELECT * FROM " . DB_PREFIX . "store WHERE REPLACE(`ssl`, 'www.', '') = '" . $db->escape ( 'https://' . str_replace ( 'www.', '', $_SERVER ['HTTP_HOST'] ) . rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/.\\' ) . '/' ) . "'" );
} else {
	$store_query = $db->query ( "SELECT * FROM " . DB_PREFIX . "store WHERE REPLACE(`url`, 'www.', '') = '" . $db->escape ( 'http://' . str_replace ( 'www.', '', $_SERVER ['HTTP_HOST'] ) . rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/.\\' ) . '/' ) . "'" );
}
if ($store_query->num_rows) {
	$config->set ( 'config_store_id', $store_query->row ['store_id'] );
} else {
	$config->set ( 'config_store_id', 0 );
}
$query = $db->query ( "SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '0' OR store_id = '" . ( int ) $config->get ( 'config_store_id' ) . "' ORDER BY store_id ASC" );
foreach ( $query->rows as $setting ) {
	if (! $setting ['serialized']) {
		$config->set ( $setting ['key'], $setting ['value'] );
	} else {
		$config->set ( $setting ['key'], unserialize ( $setting ['value'] ) );
	}
}
if (! $store_query->num_rows) {
	$config->set ( 'config_url', HTTP_SERVER );
	$config->set ( 'config_ssl', HTTPS_SERVER );
}
$url = new Url ( $config->get ( 'config_url' ), $config->get ( 'config_secure' ) ? $config->get ( 'config_ssl' ) : $config->get ( 'config_url' ) );
$registry->set ( 'url', $url );
$request = new Request ();
$registry->set ( 'request', $request );
$response = new Response ();
$response->addHeader ( 'Content-Type: text/html; charset=utf-8' );
$response->setCompression ( $config->get ( 'config_compression' ) );
$registry->set ( 'response', $response );
$cache = new Cache ();
$registry->set ( 'cache', $cache );
$session = new Session ();
$registry->set ( 'session', $session );
$registry->set ( 'document', new Document () );
if (strtoupper ( PROJECT ) == 'CART') {
	require_once (DIR_SYSTEM . 'library/mail.php');
	require_once (DIR_SYSTEM . 'library/iexcel.php');
	require_once (DIR_SYSTEM . 'library/openbay.php');
	require_once (DIR_SYSTEM . 'library/ebay.php');
	require_once (DIR_SYSTEM . 'library/amazon.php');
	require_once (DIR_SYSTEM . 'library/amazonus.php');
	require_once (DIR_SYSTEM . 'library/currency.php');
	require_once (DIR_SYSTEM . 'library/weight.php');
	require_once (DIR_SYSTEM . 'library/length.php');
	require_once (DIR_SYSTEM . 'library/customer.php');
	require_once (DIR_SYSTEM . 'library/affiliate.php');
	require_once (DIR_SYSTEM . 'library/tax.php');
	require_once (DIR_SYSTEM . 'library/cart.php');
	if (PATH_ROOT != '') {
		// Language Detection
		$languages = array ();
		$query = $db->query ( "SELECT * FROM `" . DB_PREFIX . "language` WHERE status = '1'" );
		foreach ( $query->rows as $result ) {
			$languages [$result ['code']] = $result;
		}
		$detect = '';
		if (isset ( $request->server ['HTTP_ACCEPT_LANGUAGE'] ) && $request->server ['HTTP_ACCEPT_LANGUAGE']) {
			$browser_languages = explode ( ',', $request->server ['HTTP_ACCEPT_LANGUAGE'] );
			foreach ( $browser_languages as $browser_language ) {
				foreach ( $languages as $key => $value ) {
					if ($value ['status']) {
						$locale = explode ( ',', $value ['locale'] );
						if (in_array ( $browser_language, $locale )) {
							$detect = $key;
						}
					}
				}
			}
		}
		if (isset ( $session->data ['language'] ) && array_key_exists ( $session->data ['language'], $languages ) && $languages [$session->data ['language']] ['status']) {
			$code = $session->data ['language'];
		} elseif (isset ( $request->cookie ['language'] ) && array_key_exists ( $request->cookie ['language'], $languages ) && $languages [$request->cookie ['language']] ['status']) {
			$code = $request->cookie ['language'];
		} elseif ($detect) {
			$code = $detect;
		} else {
			$code = $config->get ( 'config_language' );
		}
		if (! isset ( $session->data ['language'] ) || $session->data ['language'] != $code) {
			$session->data ['language'] = $code;
		}
		if (! isset ( $request->cookie ['language'] ) || $request->cookie ['language'] != $code) {
			setcookie ( 'language', $code, time () + 60 * 60 * 24 * 30, '/', $request->server ['HTTP_HOST'] );
		}
		$config->set ( 'config_language_id', $languages [$code] ['language_id'] );
		$config->set ( 'config_language', $languages [$code] ['code'] );
		// Language
		$language = new Language ( $languages [$code] ['directory'] );
		$language->load ( $languages [$code] ['filename'] );
		$registry->set ( 'language', $language );
		// Customer
		$registry->set ( 'customer', new Customer ( $registry ) );
		// Affiliate
		$registry->set ( 'affiliate', new Affiliate ( $registry ) );
		if (isset ( $request->get ['tracking'] )) {
			setcookie ( 'tracking', $request->get ['tracking'], time () + 3600 * 24 * 1000, '/' );
		}
		// Currency
		$registry->set ( 'currency', new Currency ( $registry ) );
		// Tax
		$registry->set ( 'tax', new Tax ( $registry ) );
		// Weight
		$registry->set ( 'weight', new Weight ( $registry ) );
		// Length
		$registry->set ( 'length', new Length ( $registry ) );
		// Cart
		$registry->set ( 'cart', new Cart ( $registry ) );
		// OpenBay Pro
		$registry->set ( 'openbay', new Openbay ( $registry ) );
		// Encryption
		$registry->set ( 'encryption', new Encryption ( $config->get ( 'config_encryption' ) ) );
	} else {
		// Language
		$languages = array ();
		$query = $db->query ( "SELECT * FROM `" . DB_PREFIX . "language`" );
		foreach ( $query->rows as $result ) {
			$languages [$result ['code']] = $result;
		}
		$config->set ( 'config_language_id', $languages [$config->get ( 'config_admin_language' )] ['language_id'] );
		// Language
		$language = new Language ( $languages [$config->get ( 'config_admin_language' )] ['directory'] );
		$language->load ( $languages [$config->get ( 'config_admin_language' )] ['filename'] );
		$registry->set ( 'language', $language );
		// Currency
		$registry->set ( 'currency', new Currency ( $registry ) );
		// Customer
		$registry->set ( 'customer', new Customer ( $registry ) );
		// Weight
		$registry->set ( 'weight', new Weight ( $registry ) );
		// Length
		$registry->set ( 'length', new Length ( $registry ) );
		// User
		$registry->set ( 'user', new User ( $registry ) );
		// OpenBay Pro
		$registry->set ( 'openbay', new Openbay ( $registry ) );
	}
} elseif (strtoupper ( PROJECT ) == 'WEB') {
	require_once (DIR_SYSTEM . 'library/mail.php');
	require_once (DIR_SYSTEM . 'library/iexcel.php');
	require_once (DIR_SYSTEM . 'library/customer.php');
	if (PATH_ROOT != '') {
		// Language Detection
		$languages = array ();
		$query = $db->query ( "SELECT * FROM `" . DB_PREFIX . "language` WHERE status = '1'" );
		foreach ( $query->rows as $result ) {
			$languages [$result ['code']] = $result;
		}
		$detect = '';
		if (isset ( $request->server ['HTTP_ACCEPT_LANGUAGE'] ) && $request->server ['HTTP_ACCEPT_LANGUAGE']) {
			$browser_languages = explode ( ',', $request->server ['HTTP_ACCEPT_LANGUAGE'] );
			foreach ( $browser_languages as $browser_language ) {
				foreach ( $languages as $key => $value ) {
					if ($value ['status']) {
						$locale = explode ( ',', $value ['locale'] );
						if (in_array ( $browser_language, $locale )) {
							$detect = $key;
						}
					}
				}
			}
		}
		if (isset ( $session->data ['language'] ) && array_key_exists ( $session->data ['language'], $languages ) && $languages [$session->data ['language']] ['status']) {
			$code = $session->data ['language'];
		} elseif (isset ( $request->cookie ['language'] ) && array_key_exists ( $request->cookie ['language'], $languages ) && $languages [$request->cookie ['language']] ['status']) {
			$code = $request->cookie ['language'];
		} elseif ($detect) {
			$code = $detect;
		} else {
			$code = $config->get ( 'config_language' );
		}
		if (! isset ( $session->data ['language'] ) || $session->data ['language'] != $code) {
			$session->data ['language'] = $code;
		}
		if (! isset ( $request->cookie ['language'] ) || $request->cookie ['language'] != $code) {
			setcookie ( 'language', $code, time () + 60 * 60 * 24 * 30, '/', $request->server ['HTTP_HOST'] );
		}
		$config->set ( 'config_language_id', $languages [$code] ['language_id'] );
		$config->set ( 'config_language', $languages [$code] ['code'] );
		// Language
		$language = new Language ( $languages [$code] ['directory'] );
		$language->load ( $languages [$code] ['filename'] );
		$registry->set ( 'language', $language );
		// Customer
		$registry->set ( 'customer', new Customer ( $registry ) );
		// Encryption
		$registry->set ( 'encryption', new Encryption ( $config->get ( 'config_encryption' ) ) );
	} else {
		// Language
		$languages = array ();
		$query = $db->query ( "SELECT * FROM `" . DB_PREFIX . "language`" );
		foreach ( $query->rows as $result ) {
			$languages [$result ['code']] = $result;
		}
		$config->set ( 'config_language_id', $languages [$config->get ( 'config_admin_language' )] ['language_id'] );
		// Language
		$language = new Language ( $languages [$config->get ( 'config_admin_language' )] ['directory'] );
		$language->load ( $languages [$config->get ( 'config_admin_language' )] ['filename'] );
		$registry->set ( 'language', $language );
		// User
		$registry->set ( 'user', new User ( $registry ) );
	}
} elseif (strtoupper ( PROJECT ) == 'SEO') {
	require_once(DIR_SYSTEM . 'library/mail.php');
	require_once (DIR_SYSTEM . 'library/iexcel.php');
	require_once (DIR_SYSTEM . 'library/izip.php');
	// Language
	$languages = array ();
	$query = $db->query ( "SELECT * FROM `" . DB_PREFIX . "language`" );
	foreach ( $query->rows as $result ) {
		$languages [$result ['code']] = $result;
	}
	$config->set ( 'config_language_id', $languages [$config->get ( 'config_admin_language' )] ['language_id'] );
	// Language
	$language = new Language ( $languages [$config->get ( 'config_admin_language' )] ['directory'] );
	$language->load ( $languages [$config->get ( 'config_admin_language' )] ['filename'] );
	$registry->set ( 'language', $language );
	// User
	$registry->set ( 'user', new User ( $registry ) );
} elseif (strtoupper ( PROJECT ) == 'B2B') {
	// Language
	$languages = array ();
	$query = $db->query ( "SELECT * FROM `" . DB_PREFIX . "language`" );
	foreach ( $query->rows as $result ) {
		$languages [$result ['code']] = $result;
	}
	$config->set ( 'config_language_id', $languages [$config->get ( 'config_admin_language' )] ['language_id'] );
	// Language
	$language = new Language ( $languages [$config->get ( 'config_admin_language' )] ['directory'] );
	$language->load ( $languages [$config->get ( 'config_admin_language' )] ['filename'] );
	$registry->set ( 'language', $language );
	// User
	$registry->set ( 'user', new User ( $registry ) );
} elseif (strtoupper ( PROJECT ) == 'SOP') {
	// Language
	$languages = array ();
	$query = $db->query ( "SELECT * FROM `" . DB_PREFIX . "language`" );
	foreach ( $query->rows as $result ) {
		$languages [$result ['code']] = $result;
	}
	$config->set ( 'config_language_id', $languages [$config->get ( 'config_admin_language' )] ['language_id'] );
	// Language
	$language = new Language ( $languages [$config->get ( 'config_admin_language' )] ['directory'] );
	$language->load ( $languages [$config->get ( 'config_admin_language' )] ['filename'] );
	$registry->set ( 'language', $language );
	// User
	$registry->set ( 'user', new User ( $registry ) );
}
// Log
$log = new Log ( $config->get ( 'config_error_filename' ) );
$registry->set ( 'log', $log );
function error_handler($errno, $errstr, $errfile, $errline) {
	global $log, $config;
	switch ($errno) {
		case E_NOTICE :
		case E_USER_NOTICE :
			$error = 'Notice';
			break;
		case E_WARNING :
		case E_USER_WARNING :
			$error = 'Warning';
			break;
		case E_ERROR :
		case E_USER_ERROR :
			$error = 'Fatal Error';
			break;
		default :
			$error = 'Unknown';
			break;
	}
	if ($config->get ( 'config_error_display' )) {
		echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}
	if ($config->get ( 'config_error_log' )) {
		$log->write ( 'PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline );
	}
	return true;
}
// Error Handler
set_error_handler ( 'error_handler' );