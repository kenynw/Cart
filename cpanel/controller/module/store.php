<?php
class ControllerModuleStore extends Controller {
	private $route = 'module/store';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		$this->load->model ( 'setting/setting' );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validate ()) {
			$this->model_setting_setting->editSetting ( 'store', $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->redirect ( $this->url->link ( 'extension/module', 'token=' . $this->session->data ['token'], 'SSL' ) );
		}
		$this->data ['action'] = $this->url->link ( 'module/store', 'token=' . $this->session->data ['token'], 'SSL' );
		$this->data ['cancel'] = $this->url->link ( 'extension/module', 'token=' . $this->session->data ['token'], 'SSL' );
		if (isset ( $this->request->post ['store_admin'] )) {
			$this->data ['store_admin'] = $this->request->post ['store_admin'];
		} else {
			$this->data ['store_admin'] = $this->config->get ( 'store_admin' );
		}
		$this->data ['modules'] = array ();
		if (isset ( $this->request->post ['store_module'] )) {
			$this->data ['modules'] = $this->request->post ['store_module'];
		} elseif ($this->config->get ( 'store_module' )) {
			$this->data ['modules'] = $this->config->get ( 'store_module' );
		}
		$this->load->model ( 'design/layout' );
		$this->data ['layouts'] = $this->model_design_layout->getLayouts ();
		$this->initNotice ();
		$this->initTpl ( $this->route );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	protected function validate() {
		if (! $this->user->hasPermission ( 'modify', $this->route )) {
			$this->error ['warning'] = $this->language->get ( 'error_permission' );
		}
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>