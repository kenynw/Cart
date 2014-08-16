<?php 
class ControllerTotalTax extends Controller { 
	
	private $route = 'total/tax';
	private function loadText($route = '') {
		if($route != ''){
			$this->loadLang ( $route );
		}else{
		$this->loadLang ( $this->route ); }
	}
	public function index() {
		$this->loadText (); 
		 

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('tax', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		

		
		

		
		

		

		
		$this->data['action'] = $this->url->link('total/tax', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['tax_status'])) {
			$this->data['tax_status'] = $this->request->post['tax_status'];
		} else {
			$this->data['tax_status'] = $this->config->get('tax_status');
		}

		if (isset($this->request->post['tax_sort_order'])) {
			$this->data['tax_sort_order'] = $this->request->post['tax_sort_order'];
		} else {
			$this->data['tax_sort_order'] = $this->config->get('tax_sort_order');
		}
		$this->initNotice();
		$this->initTpl($this->route);
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', $this->route)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>