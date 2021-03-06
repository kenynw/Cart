<?php
class ControllerShippingItem extends Controller { 
	 
	private $route = 'shipping/item';
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
			$this->model_setting_setting->editSetting('item', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		
		
		

		
		
		
		
		

		
		

		

		
		$this->data['action'] = $this->url->link('shipping/item', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['item_cost'])) {
			$this->data['item_cost'] = $this->request->post['item_cost'];
		} else {
			$this->data['item_cost'] = $this->config->get('item_cost');
		}

		if (isset($this->request->post['item_tax_class_id'])) {
			$this->data['item_tax_class_id'] = $this->request->post['item_tax_class_id'];
		} else {
			$this->data['item_tax_class_id'] = $this->config->get('item_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['item_geo_zone_id'])) {
			$this->data['item_geo_zone_id'] = $this->request->post['item_geo_zone_id'];
		} else {
			$this->data['item_geo_zone_id'] = $this->config->get('item_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['item_status'])) {
			$this->data['item_status'] = $this->request->post['item_status'];
		} else {
			$this->data['item_status'] = $this->config->get('item_status');
		}

		if (isset($this->request->post['item_sort_order'])) {
			$this->data['item_sort_order'] = $this->request->post['item_sort_order'];
		} else {
			$this->data['item_sort_order'] = $this->config->get('item_sort_order');
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