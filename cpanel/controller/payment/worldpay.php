<?php 
class ControllerPaymentWorldPay extends Controller {
	 
	private $route = 'payment/worldpay';
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
			$this->model_setting_setting->editSetting('worldpay', $this->request->post);				

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		
		
		
		
		
		
		

		
		
		
		
			
				
		
		
		

		
		

		

		if (isset($this->error['merchant'])) {
			$this->data['error_merchant'] = $this->error['merchant'];
		} else {
			$this->data['error_merchant'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		
		$this->data['action'] = $this->url->link('payment/worldpay', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['worldpay_merchant'])) {
			$this->data['worldpay_merchant'] = $this->request->post['worldpay_merchant'];
		} else {
			$this->data['worldpay_merchant'] = $this->config->get('worldpay_merchant');
		}

		if (isset($this->request->post['worldpay_password'])) {
			$this->data['worldpay_password'] = $this->request->post['worldpay_password'];
		} else {
			$this->data['worldpay_password'] = $this->config->get('worldpay_password');
		}

		$this->data['callback'] = HTTP_CATALOG . 'index.php?route=payment/worldpay/callback';

		if (isset($this->request->post['worldpay_test'])) {
			$this->data['worldpay_test'] = $this->request->post['worldpay_test'];
		} else {
			$this->data['worldpay_test'] = $this->config->get('worldpay_test');
		}

		if (isset($this->request->post['worldpay_total'])) {
			$this->data['worldpay_total'] = $this->request->post['worldpay_total'];
		} else {
			$this->data['worldpay_total'] = $this->config->get('worldpay_total'); 
		} 

		if (isset($this->request->post['worldpay_order_status_id'])) {
			$this->data['worldpay_order_status_id'] = $this->request->post['worldpay_order_status_id'];
		} else {
			$this->data['worldpay_order_status_id'] = $this->config->get('worldpay_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['worldpay_geo_zone_id'])) {
			$this->data['worldpay_geo_zone_id'] = $this->request->post['worldpay_geo_zone_id'];
		} else {
			$this->data['worldpay_geo_zone_id'] = $this->config->get('worldpay_geo_zone_id'); 
		} 

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['worldpay_status'])) {
			$this->data['worldpay_status'] = $this->request->post['worldpay_status'];
		} else {
			$this->data['worldpay_status'] = $this->config->get('worldpay_status');
		}

		if (isset($this->request->post['worldpay_sort_order'])) {
			$this->data['worldpay_sort_order'] = $this->request->post['worldpay_sort_order'];
		} else {
			$this->data['worldpay_sort_order'] = $this->config->get('worldpay_sort_order');
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

		if (!$this->request->post['worldpay_merchant']) {
			$this->error['merchant'] = $this->language->get('error_merchant');
		}

		if (!$this->request->post['worldpay_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>