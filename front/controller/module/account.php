<?php
class ControllerModuleAccount extends Controller {
	private $route = 'module/account';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index() {
		$this->loadText ();
		
		$this->data ['logged'] = $this->customer->isLogged ();
		$this->data ['register'] = $this->url->link ( 'account/register', '', 'SSL' );
		$this->data ['login'] = $this->url->link ( 'account/login', '', 'SSL' );
		$this->data ['logout'] = $this->url->link ( 'account/logout', '', 'SSL' );
		$this->data ['forgotten'] = $this->url->link ( 'account/forgotten', '', 'SSL' );
		$this->data ['account'] = $this->url->link ( 'account/account', '', 'SSL' );
		$this->data ['edit'] = $this->url->link ( 'account/edit', '', 'SSL' );
		$this->data ['password'] = $this->url->link ( 'account/password', '', 'SSL' );
		$this->data ['address'] = $this->url->link ( 'account/address', '', 'SSL' );
		$this->data ['wishlist'] = $this->url->link ( 'account/wishlist' );
		$this->data ['order'] = $this->url->link ( 'account/order', '', 'SSL' );
		$this->data ['download'] = $this->url->link ( 'account/download', '', 'SSL' );
		$this->data ['return'] = $this->url->link ( 'account/return', '', 'SSL' );
		$this->data ['transaction'] = $this->url->link ( 'account/transaction', '', 'SSL' );
		$this->data ['newsletter'] = $this->url->link ( 'account/newsletter', '', 'SSL' );
		$this->data ['recurring'] = $this->url->link ( 'account/recurring', '', 'SSL' );
		
		$this->initTpl ( $this->route );
		
		$this->render ();
	}
}
?>