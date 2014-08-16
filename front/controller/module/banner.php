<?php
class ControllerModuleBanner extends Controller {
	private $route = 'module/banner';
	protected function index($setting) {
		static $module = 0;
		
		$this->load->model ( 'design/banner' );
		$this->load->model ( 'tool/image' );
		
		$this->document->addScript ( 'catalog/view/javascript/jquery/jquery.cycle.js' );
		
		$this->data ['banners'] = array ();
		
		$results = $this->model_design_banner->getBanner ( $setting ['banner_id'] );
		
		foreach ( $results as $result ) {
			if (file_exists ( DIR_IMAGE . $result ['image'] )) {
				$this->data ['banners'] [] = array (
						'title' => $result ['title'],
						'link' => $result ['link'],
						'image' => $this->model_tool_image->resize ( $result ['image'], $setting ['width'], $setting ['height'] ) 
				);
			}
		}
		
		$this->data ['module'] = $module ++;
		
		$this->initTpl ( $this->route );
		
		$this->render ();
	}
}
?>