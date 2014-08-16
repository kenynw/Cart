<?php
class ControllerFeedGoogleSitemap extends Controller {
	private $route = 'feed/google_sitemap';
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
			$this->model_setting_setting->editSetting ( 'google_sitemap', $this->request->post );
			
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			
			$this->redirect ( $this->url->link ( 'extension/feed', 'token=' . $this->session->data ['token'], 'SSL' ) );
		}
		
		
		
		$this->data ['action'] = $this->url->link ( 'feed/google_sitemap', 'token=' . $this->session->data ['token'], 'SSL' );
		
		$this->data ['cancel'] = $this->url->link ( 'extension/feed', 'token=' . $this->session->data ['token'], 'SSL' );
		
		if (isset ( $this->request->post ['google_sitemap_status'] )) {
			$this->data ['google_sitemap_status'] = $this->request->post ['google_sitemap_status'];
		} else {
			$this->data ['google_sitemap_status'] = $this->config->get ( 'google_sitemap_status' );
		}
		
		$this->data ['data_feed'] = HTTP_CATALOG . 'index.php?route=feed/google_sitemap';
		$this->initNotice();
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