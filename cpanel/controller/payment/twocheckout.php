<?php 
class ControllerPaymentTwoCheckout extends Controller {
	 
	private $route = 'payment/twocheckout';
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
			$this->model_setting_setting->editSetting('twocheckout', $this->request->post);				

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		
		
		
		

		
		
		
			
				
		
		
		

		
		

		

		if (isset($this->error['account'])) {
			$this->data['error_account'] = $this->error['account'];
		} else {
			$this->data['error_account'] = '';
		}	

		if (isset($this->error['secret'])) {
			$this->data['error_secret'] = $this->error['secret'];
		} else {
			$this->data['error_secret'] = '';
		}	

		
		$this->data['action'] = $this->url->link('payment/twocheckout', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['twocheckout_account'])) {
			$this->data['twocheckout_account'] = $this->request->post['twocheckout_account'];
		} else {
			$this->data['twocheckout_account'] = $this->config->get('twocheckout_account');
		}

		if (isset($this->request->post['twocheckout_secret'])) {
			$this->data['twocheckout_secret'] = $this->request->post['twocheckout_secret'];
		} else {
			$this->data['twocheckout_secret'] = $this->config->get('twocheckout_secret');
		}

		if (isset($this->request->post['twocheckout_test'])) {
			$this->data['twocheckout_test'] = $this->request->post['twocheckout_test'];
		} else {
			$this->data['twocheckout_test'] = $this->config->get('twocheckout_test');
		}

		if (isset($this->request->post['twocheckout_total'])) {
			$this->data['twocheckout_total'] = $this->request->post['twocheckout_total'];
		} else {
			$this->data['twocheckout_total'] = $this->config->get('twocheckout_total'); 
		} 

		if (isset($this->request->post['twocheckout_order_status_id'])) {
			$this->data['twocheckout_order_status_id'] = $this->request->post['twocheckout_order_status_id'];
		} else {
			$this->data['twocheckout_order_status_id'] = $this->config->get('twocheckout_order_status_id'); 
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['twocheckout_geo_zone_id'])) {
			$this->data['twocheckout_geo_zone_id'] = $this->request->post['twocheckout_geo_zone_id'];
		} else {
			$this->data['twocheckout_geo_zone_id'] = $this->config->get('twocheckout_geo_zone_id'); 
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['twocheckout_status'])) {
			$this->data['twocheckout_status'] = $this->request->post['twocheckout_status'];
		} else {
			$this->data['twocheckout_status'] = $this->config->get('twocheckout_status');
		}

		if (isset($this->request->post['twocheckout_sort_order'])) {
			$this->data['twocheckout_sort_order'] = $this->request->post['twocheckout_sort_order'];
		} else {
			$this->data['twocheckout_sort_order'] = $this->config->get('twocheckout_sort_order');
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

		if (!$this->request->post['twocheckout_account']) {
			$this->error['account'] = $this->language->get('error_account');
		}

		if (!$this->request->post['twocheckout_secret']) {
			$this->error['secret'] = $this->language->get('error_secret');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>