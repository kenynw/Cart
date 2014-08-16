<?php
class ControllerModuleFeatured extends Controller {
	 
	private $route = 'module/featured';
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
			$this->model_setting_setting->editSetting('featured', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		
		
				
		
		

		
		
		
		
		
		
		

		
		
		
		

		

		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}

		
		$this->data['action'] = $this->url->link('module/featured', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['featured_product'])) {
			$this->data['featured_product'] = $this->request->post['featured_product'];
		} else {
			$this->data['featured_product'] = $this->config->get('featured_product');
		}	

		$this->load->model('catalog/product');

		if (isset($this->request->post['featured_product'])) {
			$products = explode(',', $this->request->post['featured_product']);
		} else {		
			$products = explode(',', $this->config->get('featured_product'));
		}

		$this->data['products'] = array();

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct_($product_id);

			if ($product_info) {
				$this->data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}	

		$this->data['modules'] = array();

		if (isset($this->request->post['featured_module'])) {
			$this->data['modules'] = $this->request->post['featured_module'];
		} elseif ($this->config->get('featured_module')) { 
			$this->data['modules'] = $this->config->get('featured_module');
		}		

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();
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

		if (isset($this->request->post['featured_module'])) {
			foreach ($this->request->post['featured_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>