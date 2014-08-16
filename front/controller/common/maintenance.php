<?php
class ControllerCommonMaintenance extends Controller {
	private $route = 'common/maintenance';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		if ($this->config->get ( 'config_maintenance' )) {
			$route = '';
			if (isset ( $this->request->get ['route'] )) {
				$part = explode ( '/', $this->request->get ['route'] );
				if (isset ( $part [0] )) {
					$route .= $part [0];
				}
			}
			// Show site if logged in as admin
			$this->load->library ( 'user' );
			$this->user = new User ( $this->registry );
			if (($route != 'payment') && ! $this->user->isLogged ()) {
				return $this->forward ( 'common/maintenance/info' );
			}
		}
	}
	public function info() {
		$this->loadText ();
		$this->data ['message'] = $this->language->get ( 'text_message' );
		
		$this->children = array (
				'common/footer',
				'common/header' 
		);
		$this->initTpl ( $this->route );
		$this->response->setOutput ( $this->render () );
	}
}