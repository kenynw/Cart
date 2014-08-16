<?php
class ControllerModuleGoogleTalk extends Controller {
	 
	private $route = 'module/google_talk';
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
			$this->model_setting_setting->editSetting('google_talk', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		

		
		
		
				
		
		

		
		
		
		
		

		
		
		
		

		

		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}

		
		$this->data['action'] = $this->url->link('module/google_talk', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['google_talk_code'])) {
			$this->data['google_talk_code'] = $this->request->post['google_talk_code'];
		} else {
			$this->data['google_talk_code'] = $this->config->get('google_talk_code');
		}	

		$this->data['modules'] = array();

		if (isset($this->request->post['google_talk_module'])) {
			$this->data['modules'] = $this->request->post['google_talk_module'];
		} elseif ($this->config->get('google_talk_module')) { 
			$this->data['modules'] = $this->config->get('google_talk_module');
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

		if (!$this->request->post['google_talk_code']) {
			$this->error['code'] = $this->language->get('error_code');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>