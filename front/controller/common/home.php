<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ControllerCommonHome extends Controller {
	private $route = 'common/header';
	public function index() {
		$this->initTpl ( 'common/home' );
		$this->children = array (
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header' 
		);		
		$this->response->setOutput ( $this->render () );
	}
}