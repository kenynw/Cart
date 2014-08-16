<?php
class ControllerCommonFooter extends Controller {
	private $route = 'common/footer';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index() {
		$this->loadText ();
		
		$this->loadModel ( 'info/category' );
		$this->loadModel ( 'info/info' );
		$rsc = new ModelInfoCategory ( $this->registry );
		$rsi = new ModelInfoInfo ( $this->registry );
		$list = array ();
		
		$list_1 = $rsc->getCategories ( 0 );
		foreach ( $list_1 as $item_1 ) {
			if ($item_1 ['column'] > 0) {
				// Level 2
				$list_2_data = array ();
				$list_2 = $rsi->getInfos($item_1 ['category_id']);
				foreach ( $list_2 as $item_2 ) {
					$list_2_data [] = array (
							'name' => $item_2 ['title'],
							'href' => $this->url->link ( 'info/info', 'information_id=' . $item_2 ['information_id'] ) 
					);
				}
				// Level 1
				$list [] = array (
						'category_id' => $item_1 ['category_id'],
						'name' => $item_1 ['name'],
						'href' => $this->url->link ( 'info/category', 'category_id=' . $item_1 ['category_id'] ),
						'item' => $list_2_data 
				);
			}
		}
		$this->data ['menu_list'] = $list;
		
		$this->data ['mail'] = $this->config->get ( 'config_email' );
		$this->data ['phone'] = $this->config->get ( 'config_telephone' );
		$this->data ['company'] = $this->config->get ( 'config_name' );
		$this->data ['copyright'] = 'CopyRight @ 2014 ' . $this->config->get ( 'config_name' ) . ' All Right Reserved.';
		$this->data ['about_us_url'] = $this->url->link ( 'info/info', 'information_id=1' );
		$this->data ['contact_us_url'] = $this->url->link ( 'info/info', 'information_id=1' );
		$this->data ['information'] = $this->data ['menu_list'];
		
		$this->initTpl ( $this->route );
		$this->render ();
	}
}