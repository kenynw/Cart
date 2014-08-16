<?php 
class ControllerPaymentPPProPF extends Controller {
	 
	private $route = 'payment/pp_pro_pf';
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
			$this->model_setting_setting->editSetting('pp_pro_pf', $this->request->post);				

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		
		
		
		
		
		

		
		
		
		
		
		
			
				
		
		
		

		
		

		

		if (isset($this->error['vendor'])) {
			$this->data['error_vendor'] = $this->error['vendor'];
		} else {
			$this->data['error_vendor'] = '';
		}

		if (isset($this->error['user'])) {
			$this->data['error_user'] = $this->error['user'];
		} else {
			$this->data['error_user'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['partner'])) {
			$this->data['error_partner'] = $this->error['partner'];
		} else {
			$this->data['error_partner'] = '';
		}

		

		$this->data['action'] = $this->url->link('payment/pp_pro_pf', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['pp_pro_pf_vendor'])) {
			$this->data['pp_pro_pf_vendor'] = $this->request->post['pp_pro_pf_vendor'];
		} else {
			$this->data['pp_pro_pf_vendor'] = $this->config->get('pp_pro_pf_vendor');
		}

		if (isset($this->request->post['pp_pro_pf_user'])) {
			$this->data['pp_pro_pf_user'] = $this->request->post['pp_pro_pf_user'];
		} else {
			$this->data['pp_pro_pf_user'] = $this->config->get('pp_pro_pf_user');
		}

		if (isset($this->request->post['pp_pro_pf_password'])) {
			$this->data['pp_pro_pf_password'] = $this->request->post['pp_pro_pf_password'];
		} else {
			$this->data['pp_pro_pf_password'] = $this->config->get('pp_pro_pf_password');
		}

		if (isset($this->request->post['pp_pro_pf_partner'])) {
			$this->data['pp_pro_pf_partner'] = $this->request->post['pp_pro_pf_partner'];
		} elseif ($this->config->has('pp_pro_pf_partner')) {
			$this->data['pp_pro_pf_partner'] = $this->config->get('pp_pro_pf_partner');
		} else {
			$this->data['pp_pro_pf_partner'] = 'PayPal';
		}

		if (isset($this->request->post['pp_pro_pf_test'])) {
			$this->data['pp_pro_pf_test'] = $this->request->post['pp_pro_pf_test'];
		} else {
			$this->data['pp_pro_pf_test'] = $this->config->get('pp_pro_pf_test');
		}

		if (isset($this->request->post['pp_pro_pf_method'])) {
			$this->data['pp_pro_pf_transaction'] = $this->request->post['pp_pro_pf_transaction'];
		} else {
			$this->data['pp_pro_pf_transaction'] = $this->config->get('pp_pro_pf_transaction');
		}

		if (isset($this->request->post['pp_pro_pf_total'])) {
			$this->data['pp_pro_pf_total'] = $this->request->post['pp_pro_pf_total'];
		} else {
			$this->data['pp_pro_pf_total'] = $this->config->get('pp_pro_pf_total'); 
		} 

		if (isset($this->request->post['pp_pro_pf_order_status_id'])) {
			$this->data['pp_pro_pf_order_status_id'] = $this->request->post['pp_pro_pf_order_status_id'];
		} else {
			$this->data['pp_pro_pf_order_status_id'] = $this->config->get('pp_pro_pf_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['pp_pro_pf_geo_zone_id'])) {
			$this->data['pp_pro_pf_geo_zone_id'] = $this->request->post['pp_pro_pf_geo_zone_id'];
		} else {
			$this->data['pp_pro_pf_geo_zone_id'] = $this->config->get('pp_pro_pf_geo_zone_id'); 
		} 

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['pp_pro_pf_status'])) {
			$this->data['pp_pro_pf_status'] = $this->request->post['pp_pro_pf_status'];
		} else {
			$this->data['pp_pro_pf_status'] = $this->config->get('pp_pro_pf_status');
		}

		if (isset($this->request->post['pp_pro_pf_sort_order'])) {
			$this->data['pp_pro_pf_sort_order'] = $this->request->post['pp_pro_pf_sort_order'];
		} else {
			$this->data['pp_pro_pf_sort_order'] = $this->config->get('pp_pro_pf_sort_order');
		}
		$this->initNotice();
		$this->initTpl($this->route);
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', $this->route)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['pp_pro_pf_vendor']) {
			$this->error['vendor'] = $this->language->get('error_vendor');
		}

		if (!$this->request->post['pp_pro_pf_user']) {
			$this->error['user'] = $this->language->get('error_user');
		}

		if (!$this->request->post['pp_pro_pf_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!$this->request->post['pp_pro_pf_partner']) {
			$this->error['partner'] = $this->language->get('error_partner');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>