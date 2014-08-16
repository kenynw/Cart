<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ControllerCommonMain extends Controller {
	private $route = 'common/main';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		$this->data ['token'] = $this->session->data ['token'];
		$this->data ['project_name'] = PROJECT;
		$this->session->data ['project_name'] = PROJECT;
		if (! $this->user->isLogged ()) {
			return $this->forward ( 'common/login' );
		} else {
			$this->data ['menus'] = $this->getCpanelMenu ( 1 );
			$this->data ['home'] = $this->url->link ( 'common/home&token=' . $this->session->data ['token'] );
			$this->data ['logout'] = $this->url->link ( 'common/logout&token=' . $this->session->data ['token'] );
			$this->data ['logged'] = sprintf ( $this->language->get ( 'text_logged' ), $this->user->getUserName () );
		}
		$this->initNotice ();
		$this->initTpl ( $this->route );
		$this->response->setOutput ( $this->render () );
	}
}