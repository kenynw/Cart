<?php
class ControllerModuleOpenbaypro extends Controller {
	
	private $route = 'module/openbaypro';
	private function loadText($route = '') {
		if($route != ''){
			$this->loadLang ( $route );
		}else{
		$this->loadLang ( $this->route ); }
	}
	public function index() {
		$this->loadText ();
		 

		

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		
		
		

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

	public function install() {
		$this->load->model('setting/setting');

		$settings = $this->model_setting_setting->getSetting('openbaymanager');
		$settings['openbaymanager_show_menu'] = 1;
		$this->model_setting_setting->editSetting('openbaymanager', $settings);
	}

	public function uninstall() {
		$this->load->model('setting/setting');

		$settings = $this->model_setting_setting->getSetting('openbaymanager');
		$settings['openbaymanager_show_menu'] = 0;
		$this->model_setting_setting->editSetting('openbaymanager', $settings);
	}
}
?>