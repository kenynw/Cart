<?php 
class ControllerPaymentSagepay extends Controller {
	 
	private $route = 'payment/sagepay';
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
			$this->model_setting_setting->editSetting('sagepay', $this->request->post);				

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		
		
		
		
		
		
		
		

		
		
		
		
			
				
		
		
		

		
		

		

		if (isset($this->error['vendor'])) {
			$this->data['error_vendor'] = $this->error['vendor'];
		} else {
			$this->data['error_vendor'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		

		$this->data['action'] = $this->url->link('payment/sagepay', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['sagepay_vendor'])) {
			$this->data['sagepay_vendor'] = $this->request->post['sagepay_vendor'];
		} else {
			$this->data['sagepay_vendor'] = $this->config->get('sagepay_vendor');
		}

		if (isset($this->request->post['sagepay_password'])) {
			$this->data['sagepay_password'] = $this->request->post['sagepay_password'];
		} else {
			$this->data['sagepay_password'] = $this->config->get('sagepay_password');
		}

		if (isset($this->request->post['sagepay_test'])) {
			$this->data['sagepay_test'] = $this->request->post['sagepay_test'];
		} else {
			$this->data['sagepay_test'] = $this->config->get('sagepay_test');
		}

		if (isset($this->request->post['sagepay_transaction'])) {
			$this->data['sagepay_transaction'] = $this->request->post['sagepay_transaction'];
		} else {
			$this->data['sagepay_transaction'] = $this->config->get('sagepay_transaction');
		}

		if (isset($this->request->post['sagepay_total'])) {
			$this->data['sagepay_total'] = $this->request->post['sagepay_total'];
		} else {
			$this->data['sagepay_total'] = $this->config->get('sagepay_total'); 
		} 

		if (isset($this->request->post['sagepay_order_status_id'])) {
			$this->data['sagepay_order_status_id'] = $this->request->post['sagepay_order_status_id'];
		} else {
			$this->data['sagepay_order_status_id'] = $this->config->get('sagepay_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['sagepay_geo_zone_id'])) {
			$this->data['sagepay_geo_zone_id'] = $this->request->post['sagepay_geo_zone_id'];
		} else {
			$this->data['sagepay_geo_zone_id'] = $this->config->get('sagepay_geo_zone_id'); 
		} 

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['sagepay_status'])) {
			$this->data['sagepay_status'] = $this->request->post['sagepay_status'];
		} else {
			$this->data['sagepay_status'] = $this->config->get('sagepay_status');
		}

		if (isset($this->request->post['sagepay_sort_order'])) {
			$this->data['sagepay_sort_order'] = $this->request->post['sagepay_sort_order'];
		} else {
			$this->data['sagepay_sort_order'] = $this->config->get('sagepay_sort_order');
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

		if (!$this->request->post['sagepay_vendor']) {
			$this->error['vendor'] = $this->language->get('error_vendor');
		}

		if (!$this->request->post['sagepay_password']) {
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