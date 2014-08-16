<?php
class ControllerShippingAusPost extends Controller {
	 
	private $route = 'shipping/auspost';
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
			$this->model_setting_setting->editSetting('auspost', $this->request->post);             

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		
		
		

		
		
		
		
		
		
		         
		
		

		
		

		

		if (isset($this->error['postcode'])) {
			$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
		}

		
		$this->data['action'] = $this->url->link('shipping/auspost', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['auspost_postcode'])) {
			$this->data['auspost_postcode'] = $this->request->post['auspost_postcode'];
		} else {
			$this->data['auspost_postcode'] = $this->config->get('auspost_postcode');
		}

		if (isset($this->request->post['auspost_standard'])) {
			$this->data['auspost_standard'] = $this->request->post['auspost_standard'];
		} else {
			$this->data['auspost_standard'] = $this->config->get('auspost_standard');
		}

		if (isset($this->request->post['auspost_express'])) {
			$this->data['auspost_express'] = $this->request->post['auspost_express'];
		} else {
			$this->data['auspost_express'] = $this->config->get('auspost_express');
		}

		if (isset($this->request->post['auspost_display_time'])) {
			$this->data['auspost_display_time'] = $this->request->post['auspost_display_time'];
		} else {
			$this->data['auspost_display_time'] = $this->config->get('auspost_display_time');
		}

		if (isset($this->request->post['auspost_weight_class_id'])) {
			$this->data['auspost_weight_class_id'] = $this->request->post['auspost_weight_class_id'];
		} else {
			$this->data['auspost_weight_class_id'] = $this->config->get('auspost_weight_class_id');
		}

		$this->load->model('localisation/weight_class');

		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['auspost_tax_class_id'])) {
			$this->data['auspost_tax_class_id'] = $this->request->post['auspost_tax_class_id'];
		} else {
			$this->data['auspost_tax_class_id'] = $this->config->get('auspost_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['auspost_geo_zone_id'])) {
			$this->data['auspost_geo_zone_id'] = $this->request->post['auspost_geo_zone_id'];
		} else {
			$this->data['auspost_geo_zone_id'] = $this->config->get('auspost_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['auspost_status'])) {
			$this->data['auspost_status'] = $this->request->post['auspost_status'];
		} else {
			$this->data['auspost_status'] = $this->config->get('auspost_status');
		}

		if (isset($this->request->post['auspost_sort_order'])) {
			$this->data['auspost_sort_order'] = $this->request->post['auspost_sort_order'];
		} else {
			$this->data['auspost_sort_order'] = $this->config->get('auspost_sort_order');
		}                               
		$this->initNotice();
		$this->initTpl($this->route);
		$this->children = array(
			'common/header',        
			'common/footer' 
		);

		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', $this->route)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!preg_match('/^[0-9]{4}$/', $this->request->post['auspost_postcode'])){
			$this->error['postcode'] = $this->language->get('error_postcode');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}       
	}
}
?>