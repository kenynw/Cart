<?php
class ControllerLocalisationLanguage extends Controller {
	private $route = 'localisation/language';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		$this->getList ();
	}
	public function insert() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelLocalisationLanguage ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->addLanguage ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function update() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelLocalisationLanguage ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->editLanguage ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function delete() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelLocalisationLanguage ( $this->registry );
		if (isset ( $this->request->post ['selected'] ) && $this->validateDelete ()) {
			foreach ( $this->request->post ['selected'] as $id ) {
				$rs->deleteLanguage ( $id );
			}
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getList ();
	}
	protected function getList() {
		$id = 'language_id';
		$sort_data = array (
				'name',
				'code',
				'sort_order'			
		);
		$this->loadModel ( $this->route );
		$rs = new ModelLocalisationLanguage ( $this->registry );
		$record_total = $rs->getTotalLanguages ();
		$param = $this->initList ( $this->route, $record_total, $sort_data );
		$results = $rs->getLanguages_ ( $param, $sort_data );
		$records = array ();
		foreach ( $results as $result ) {
			$action = array ();
			$action [] = array (
					'text' => $this->language->get ( 'text_edit' ),
					'href' => $this->url->link ( $this->route . '/update', 'token=' . $this->session->data ['token'] . '&id=' . $result [$id] . $param ['url'], 'SSL' )
			);
			$result ['action'] = $action;
			$result ['selected'] = isset ( $this->request->post ['selected'] ) && in_array ( $result [$id], $this->request->post ['selected'] );
			$records [] = $result;
		}
		$this->data ['list'] = $records;	
		$this->initNotice ();
		$this->initTpl ( 'localisation/language_list' );
		$this->children = array ( 'common/header', 'common/footer' );
		$this->response->setOutput ( $this->render () );
	}
	protected function getForm() {
		$this->loadModel ( $this->route );
		$rs = new ModelLocalisationLanguage ( $this->registry );
		$this->data ['token'] = $this->session->data ['token'];
		$id = isset ( $this->request->get ['id'] ) ? $this->request->get ['id'] : '';
		if (isset ( $this->error ['name'] )) {
			$this->data ['error_name'] = $this->error ['name'];
		} else {
			$this->data ['error_name'] = '';
		}
		if (isset ( $this->error ['code'] )) {
			$this->data ['error_code'] = $this->error ['code'];
		} else {
			$this->data ['error_code'] = '';
		}
		if (isset ( $this->error ['locale'] )) {
			$this->data ['error_locale'] = $this->error ['locale'];
		} else {
			$this->data ['error_locale'] = '';
		}
		if (isset ( $this->error ['image'] )) {
			$this->data ['error_image'] = $this->error ['image'];
		} else {
			$this->data ['error_image'] = '';
		}
		if (isset ( $this->error ['directory'] )) {
			$this->data ['error_directory'] = $this->error ['directory'];
		} else {
			$this->data ['error_directory'] = '';
		}
		if (isset ( $this->error ['filename'] )) {
			$this->data ['error_filename'] = $this->error ['filename'];
		} else {
			$this->data ['error_filename'] = '';
		}
		$url = $this->initUrlGet ( array (
				'sort',
				'order',
				'page'
		) );
		if ($id != '') {
			$this->data ['action'] = $this->url->link ( $this->route . '/update', 'token=' . $this->session->data ['token'] . '&id=' . $id . $url, 'SSL' );
		} else {
			$this->data ['action'] = $this->url->link ( $this->route . '/insert', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		}
		$this->data ['cancel'] = $this->url->link ( $this->route, 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		if (($id != '') && ($this->request->server ['REQUEST_METHOD'] != 'POST')) {
			$item = $rs->getLanguage_ ( $id );
		} else {
			$item = $rs->getDefaultLanguage ();
		}
		$this->initItem ( $item );		
		$this->initNotice ();
		$this->initTpl ( 'localisation/language_form' );
		$this->children = array ( 'common/header', 'common/footer' );
		$this->response->setOutput ( $this->render () );
	}
	protected function validateForm() {
		if (! $this->user->hasPermission ( 'modify', $this->route )) {
			$this->error ['warning'] = $this->language->get ( 'error_permission' );
		}
		if ((utf8_strlen ( $this->request->post ['name'] ) < 3) || (utf8_strlen ( $this->request->post ['name'] ) > 32)) {
			$this->error ['name'] = $this->language->get ( 'error_name' );
		}
		if (utf8_strlen ( $this->request->post ['code'] ) < 2) {
			$this->error ['code'] = $this->language->get ( 'error_code' );
		}
		if (! $this->request->post ['locale']) {
			$this->error ['locale'] = $this->language->get ( 'error_locale' );
		}
		if (! $this->request->post ['directory']) {
			$this->error ['directory'] = $this->language->get ( 'error_directory' );
		}
		if (! $this->request->post ['filename']) {
			$this->error ['filename'] = $this->language->get ( 'error_filename' );
		}
		if ((utf8_strlen ( $this->request->post ['image'] ) < 3) || (utf8_strlen ( $this->request->post ['image'] ) > 32)) {
			$this->error ['image'] = $this->language->get ( 'error_image' );
		}
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
	protected function validateDelete() {
		if (! $this->user->hasPermission ( 'modify', $this->route )) {
			$this->error ['warning'] = $this->language->get ( 'error_permission' );
		}
		$this->loadModel($this->route);
		$rs = new ModelLocalisationLanguage($this->registry);
		$this->loadModel('setting/store');
		$rss = new ModelSettingStore($this->registry);
		
		$this->loadModel('sale/order');
		$rso = new ModelSaleOrder($this->registry);	
		
		foreach ( $this->request->post ['selected'] as $language_id ) {
			$language_info = $rs->getLanguage_ ( $language_id );
			if ($language_info) {
				if ($this->config->get ( 'config_language' ) == $language_info ['code']) {
					$this->error ['warning'] = $this->language->get ( 'error_default' );
				}
				if ($this->config->get ( 'config_admin_language' ) == $language_info ['code']) {
					$this->error ['warning'] = $this->language->get ( 'error_admin' );
				}
				$store_total = $rss->getTotalStoresByLanguage ( $language_info ['code'] );
				if ($store_total) {
					$this->error ['warning'] = sprintf ( $this->language->get ( 'error_store' ), $store_total );
				}
			}
			$order_total = $rso->getTotalOrdersByLanguageId ( $language_id );
			if ($order_total) {
				$this->error ['warning'] = sprintf ( $this->language->get ( 'error_order' ), $order_total );
			}
		}
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>