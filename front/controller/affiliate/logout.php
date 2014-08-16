<?php 
class ControllerAffiliateLogout extends Controller {
	private $route = 'affiliate/logout';
	private function loadText($route = '') {
		if($route != ''){
			$this->loadLang ( $route );
		}else{
		$this->loadLang ( $this->route ); }
	}
	public function index() {
		$this->loadText ();
		if ($this->affiliate->isLogged()) {
			$this->affiliate->logout();

			$this->redirect($this->url->link('affiliate/logout', '', 'SSL'));
		}

		 

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),        	
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('affiliate/account', '', 'SSL'),       	
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_logout'),
			'href'      => $this->url->link('affiliate/logout', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		

		

		

		$this->data['continue'] = $this->url->link('common/home');

		$this->initTpl('common/success');

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);

		$this->response->setOutput($this->render());	
	}
}
?>