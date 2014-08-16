<?php
class ControllerModuleCurrency extends Controller {
	private $route = 'module/currency';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index() {
		if (isset ( $this->request->post ['currency_code'] )) {
			$this->currency->set ( $this->request->post ['currency_code'] );
			
			unset ( $this->session->data ['shipping_method'] );
			unset ( $this->session->data ['shipping_methods'] );
			
			if (isset ( $this->request->post ['redirect'] )) {
				$this->redirect ( $this->request->post ['redirect'] );
			} else {
				$this->redirect ( $this->url->link ( 'common/home' ) );
			}
		}
		
		$this->loadText ();
		
		if (isset ( $this->request->server ['HTTPS'] ) && (($this->request->server ['HTTPS'] == 'on') || ($this->request->server ['HTTPS'] == '1'))) {
			$connection = 'SSL';
		} else {
			$connection = 'NONSSL';
		}
		
		$this->data ['action'] = $this->url->link ( 'module/currency', '', $connection );
		
		$this->data ['currency_code'] = $this->currency->getCode ();
		
		$this->load->model ( 'localisation/currency' );
		
		$this->data ['currencies'] = array ();
		
		$results = $this->model_localisation_currency->getCurrencies ();
		
		foreach ( $results as $result ) {
			if ($result ['status']) {
				$this->data ['currencies'] [] = array (
						'title' => $result ['title'],
						'code' => $result ['code'],
						'symbol_left' => $result ['symbol_left'],
						'symbol_right' => $result ['symbol_right'] 
				);
			}
		}
		
		if (! isset ( $this->request->get ['route'] )) {
			$this->data ['redirect'] = $this->url->link ( 'common/home' );
		} else {
			$data = $this->request->get;
			
			unset ( $data ['_route_'] );
			
			$route = $data ['route'];
			
			unset ( $data ['route'] );
			
			$url = '';
			
			if ($data) {
				$url = '&' . urldecode ( http_build_query ( $data, '', '&' ) );
			}
			
			$this->data ['redirect'] = $this->url->link ( $route, $url, $connection );
		}
		
		$this->initTpl ( $this->route );
		
		$this->render ();
	}
}
?>