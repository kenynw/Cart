<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
class ControllerCommonLogout extends Controller {
	private $route = 'common/logout';
	public function index() {
		$this->user->logout ();
		unset ( $this->session->data ['token'] );
		$this->cache->delete('cpanel_menu');
		$this->redirect ( $this->url->link ( 'common/login' ) );
	}
}