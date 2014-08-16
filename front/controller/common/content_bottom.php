<?php
class ControllerCommonContentBottom extends Controller {
	private $route = 'common/content_bottom';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index() {
		$this->loadModel ( 'design/layout' );
		$rsl = new ModelDesignLayout ( $this->registry );
		$this->loadModel ( 'catalog/category' );
		$rsc = new ModelCatalogCategory ( $this->registry );
		$this->loadModel ( 'catalog/product' );
		$rsp = new ModelCatalogProduct ( $this->registry );
		$this->loadModel ( 'info/category' );
		$rsic = new ModelInfoCategory ( $this->registry );
		$this->loadModel ( 'info/info' );
		$rsi = new ModelInfoInfo ( $this->registry );
		$this->loadModel ( 'setting/extension' );
		$rsm = new ModelSettingExtension ( $this->registry );
		
		if (isset ( $this->request->get ['route'] )) {
			$route = ( string ) $this->request->get ['route'];
		} else {
			$route = 'common/home';
		}
		
		$layout_id = 0;
		if ($route == 'product/category' && isset ( $this->request->get ['path'] )) {
			$path = explode ( '_', ( string ) $this->request->get ['path'] );
			$layout_id = $rsc->getCategoryLayoutId ( end ( $path ) );
		}
		
		if ($route == 'product/product' && isset ( $this->request->get ['product_id'] )) {
			$layout_id = $rsp->getProductLayoutId ( $this->request->get ['product_id'] );
		}
		
		if ($route == 'info/category' && isset ( $this->request->get ['path'] )) {
			$path = explode ( '_', ( string ) $this->request->get ['path'] );
			$layout_id = $rsic->getCategoryLayoutId ( end ( $path ) );
		}
		
		if ($route == 'info/info' && isset ( $this->request->get ['information_id'] )) {
			$layout_id = $rsi->getInfoLayoutId ( $this->request->get ['information_id'] );
		}
		
		if (! $layout_id) {
			$layout_id = $rsl->getLayout ( $route );
		}
		
		if (! $layout_id) {
			$layout_id = $this->config->get ( 'config_layout_id' );
		}
		
		$module_data = array ();
		$extensions = $rsm->getExtensions ( 'module' );
		foreach ( $extensions as $extension ) {
			$modules = $this->config->get ( $extension ['code'] . '_module' );
			if ($modules) {
				foreach ( $modules as $module ) {
					if ($module ['layout_id'] == $layout_id && $module ['position'] == 'content_bottom' && $module ['status']) {
						$module_data [] = array (
								'code' => $extension ['code'],
								'setting' => $module,
								'sort_order' => $module ['sort_order'] 
						);
					}
				}
			}
		}
		$sort_order = array ();
		foreach ( $module_data as $key => $value ) {
			$sort_order [$key] = $value ['sort_order'];
		}
		array_multisort ( $sort_order, SORT_ASC, $module_data );
		$this->data ['modules'] = array ();
		foreach ( $module_data as $module ) {
			$module = $this->getChild ( 'module/' . $module ['code'], $module ['setting'] );
			if ($module) {
				$this->data ['modules'] [] = $module;
			}
		}
		$this->initTpl ( $this->route );
		$this->render ();
	}
}