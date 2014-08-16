<?php
class ControllerModuleAffiliate extends Controller {
	private $route = 'module/affiliate';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index() {
		$this->loadText ();
		
		$this->data ['logged'] = $this->affiliate->isLogged ();
		$this->data ['register'] = $this->url->link ( 'affiliate/register', '', 'SSL' );
		$this->data ['login'] = $this->url->link ( 'affiliate/login', '', 'SSL' );
		$this->data ['logout'] = $this->url->link ( 'affiliate/logout', '', 'SSL' );
		$this->data ['forgotten'] = $this->url->link ( 'affiliate/forgotten', '', 'SSL' );
		$this->data ['account'] = $this->url->link ( 'affiliate/account', '', 'SSL' );
		$this->data ['edit'] = $this->url->link ( 'affiliate/edit', '', 'SSL' );
		$this->data ['password'] = $this->url->link ( 'affiliate/password', '', 'SSL' );
		$this->data ['payment'] = $this->url->link ( 'affiliate/payment', '', 'SSL' );
		$this->data ['tracking'] = $this->url->link ( 'affiliate/tracking', '', 'SSL' );
		$this->data ['transaction'] = $this->url->link ( 'affiliate/transaction', '', 'SSL' );
		
		$this->initTpl ( $this->route );
		
		$this->render ();
	}
}
?>