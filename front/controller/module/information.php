<?php
class ControllerModuleInformation extends Controller {
	private $route = 'module/information';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index() {
		$this->loadText ();
		
		$this->load->model ( 'catalog/information' );
		
		$this->data ['informations'] = array ();
		
		foreach ( $this->model_catalog_information->getInformations () as $result ) {
			$this->data ['informations'] [] = array (
					'title' => $result ['title'],
					'href' => $this->url->link ( 'information/information', 'information_id=' . $result ['information_id'] ) 
			);
		}
		
		$this->data ['contact'] = $this->url->link ( 'information/contact' );
		$this->data ['sitemap'] = $this->url->link ( 'information/sitemap' );
		
		$this->initTpl ( $this->route );
		
		$this->render ();
	}
}
?>