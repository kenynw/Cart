<?php 
class ControllerTotalHandling extends Controller { 
	 
	private $route = 'total/handling';
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
			$this->model_setting_setting->editSetting('handling', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		
		

		
		
		
		
		

		
		

		

		
		$this->data['action'] = $this->url->link('total/handling', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['handling_total'])) {
			$this->data['handling_total'] = $this->request->post['handling_total'];
		} else {
			$this->data['handling_total'] = $this->config->get('handling_total');
		}

		if (isset($this->request->post['handling_fee'])) {
			$this->data['handling_fee'] = $this->request->post['handling_fee'];
		} else {
			$this->data['handling_fee'] = $this->config->get('handling_fee');
		}

		if (isset($this->request->post['handling_tax_class_id'])) {
			$this->data['handling_tax_class_id'] = $this->request->post['handling_tax_class_id'];
		} else {
			$this->data['handling_tax_class_id'] = $this->config->get('handling_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['handling_status'])) {
			$this->data['handling_status'] = $this->request->post['handling_status'];
		} else {
			$this->data['handling_status'] = $this->config->get('handling_status');
		}

		if (isset($this->request->post['handling_sort_order'])) {
			$this->data['handling_sort_order'] = $this->request->post['handling_sort_order'];
		} else {
			$this->data['handling_sort_order'] = $this->config->get('handling_sort_order');
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