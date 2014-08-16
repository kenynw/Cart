<?php
class ControllerModuleGoogleTalk extends Controller {
	private $route = 'module/google_talk';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index() {
		$this->loadText ();
		
		if (isset ( $this->request->server ['HTTPS'] ) && (($this->request->server ['HTTPS'] == 'on') || ($this->request->server ['HTTPS'] == '1'))) {
			$this->data ['code'] = str_replace ( 'http', 'https', html_entity_decode ( $this->config->get ( 'google_talk_code' ) ) );
		} else {
			$this->data ['code'] = html_entity_decode ( $this->config->get ( 'google_talk_code' ) );
		}
		
		$this->initTpl ( $this->route );
		
		$this->render ();
	}
}
?>