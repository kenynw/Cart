<?php
class ControllerModuleEbaydisplay extends Controller {
	
	private $route = 'module/ebaydisplay';
	private function loadText($route = '') {
		if($route != ''){
			$this->loadLang ( $route );
		}else{
		$this->loadLang ( $this->route ); }
	}
	public function index() {
		$this->loadText ();
		 
		$this->document->addScript('view/javascript/openbay/faq.js');
		$this->document->addStyle('view/stylesheet/openbay.css');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ebaydisplay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->cache->delete('ebaydisplay');

			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		
		
		
		
		

		
		
		
		
		
		
		

		
		
		
		

		

		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}

		

		$this->data['action'] = $this->url->link('module/ebaydisplay', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['token'] = $this->session->data['token'];


		$this->data['modules'] = array();

		if (isset($this->request->post['ebaydisplay_module'])) {
			$this->data['modules'] = $this->request->post['ebaydisplay_module'];
		} elseif ($this->config->get('ebaydisplay_module')) {
			$this->data['modules'] = $this->config->get('ebaydisplay_module');
		}else{
			$this->data['modules'] = array();
		}
		if (isset($this->request->post['ebaydisplay_module_username'])) {
			$this->data['ebaydisplay_module_username'] = $this->request->post['ebaydisplay_module_username'];
		} elseif ($this->config->get('ebaydisplay_module_username')) {
			$this->data['ebaydisplay_module_username'] = $this->config->get('ebaydisplay_module_username');
		}else{
			$this->data['ebaydisplay_module_username'] = '';
		}
		if (isset($this->request->post['ebaydisplay_module_keywords'])) {
			$this->data['ebaydisplay_module_keywords'] = $this->request->post['ebaydisplay_module_keywords'];
		} elseif ($this->config->get('ebaydisplay_module_keywords')) {
			$this->data['ebaydisplay_module_keywords'] = $this->config->get('ebaydisplay_module_keywords');
		}else{
			$this->data['ebaydisplay_module_keywords'] = '';
		}
		if (isset($this->request->post['ebaydisplay_module_description'])) {
			$this->data['ebaydisplay_module_description'] = $this->request->post['ebaydisplay_module_description'];
		} elseif ($this->config->get('ebaydisplay_module_description')) {
			$this->data['ebaydisplay_module_description'] = $this->config->get('ebaydisplay_module_description');
		}else{
			$this->data['ebaydisplay_module_description'] = 0;
		}
		if (isset($this->request->post['ebaydisplay_module_limit'])) {
			$this->data['ebaydisplay_module_limit'] = $this->request->post['ebaydisplay_module_limit'];
		} elseif ($this->config->get('ebaydisplay_module_limit')) {
			$this->data['ebaydisplay_module_limit'] = $this->config->get('ebaydisplay_module_limit');
		}else{
			$this->data['ebaydisplay_module_limit'] = 10;
		}
		if (isset($this->request->post['ebaydisplay_module_sort'])) {
			$this->data['ebaydisplay_module_sort'] = $this->request->post['ebaydisplay_module_sort'];
		} elseif ($this->config->get('ebaydisplay_module_sort')) {
			$this->data['ebaydisplay_module_sort'] = $this->config->get('ebaydisplay_module_sort');
		}else{
			$this->data['ebaydisplay_module_sort'] = 'StartTimeNewest';
		}
		if (isset($this->request->post['ebaydisplay_module_site'])) {
			$this->data['ebaydisplay_module_site'] = $this->request->post['ebaydisplay_module_site'];
		} elseif ($this->config->get('ebaydisplay_module_sort')) {
			$this->data['ebaydisplay_module_site'] = $this->config->get('ebaydisplay_module_site');
		}else{
			$this->data['ebaydisplay_module_site'] = 3;
		}

		$this->data['ebay_sites'] = array(
			0 => 'USA',
			3 => 'UK',
			15 => 'Australia',
			2 => 'Canada (English)',
			71 => 'France',
			77 => 'Germany',
			101 => 'Italy',
			186 => 'Spain',
			205 => 'Ireland',
			16 => 'Austria',
			146 => 'Netherlands',
			23 => 'Belgium (French)',
			123 => 'Belgium (Dutch)',
		);

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

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>