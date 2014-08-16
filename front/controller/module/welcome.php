<?php
class ControllerModuleWelcome extends Controller {
	private $route = 'module/welcome';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index($setting) {
		$this->loadText ();
		
		$this->data ['heading_title'] = sprintf ( $this->language->get ( 'heading_title' ), $this->config->get ( 'config_name' ) );
		
		$this->data ['message'] = html_entity_decode ( $setting ['description'] [$this->config->get ( 'config_language_id' )], ENT_QUOTES, 'UTF-8' );
		
		$this->initTpl ( $this->route );
		
		$this->render ();
	}
}
?>