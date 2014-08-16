<?php
class ControllerShippingFlat extends Controller {
	 
	private $route = 'shipping/flat';
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
			$this->model_setting_setting->editSetting('flat', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		
		
		

		
		
		
		
		

		
		

		

		

		$this->data['action'] = $this->url->link('shipping/flat', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['flat_cost'])) {
			$this->data['flat_cost'] = $this->request->post['flat_cost'];
		} else {
			$this->data['flat_cost'] = $this->config->get('flat_cost');
		}

		if (isset($this->request->post['flat_tax_class_id'])) {
			$this->data['flat_tax_class_id'] = $this->request->post['flat_tax_class_id'];
		} else {
			$this->data['flat_tax_class_id'] = $this->config->get('flat_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['flat_geo_zone_id'])) {
			$this->data['flat_geo_zone_id'] = $this->request->post['flat_geo_zone_id'];
		} else {
			$this->data['flat_geo_zone_id'] = $this->config->get('flat_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['flat_status'])) {
			$this->data['flat_status'] = $this->request->post['flat_status'];
		} else {
			$this->data['flat_status'] = $this->config->get('flat_status');
		}

		if (isset($this->request->post['flat_sort_order'])) {
			$this->data['flat_sort_order'] = $this->request->post['flat_sort_order'];
		} else {
			$this->data['flat_sort_order'] = $this->config->get('flat_sort_order');
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