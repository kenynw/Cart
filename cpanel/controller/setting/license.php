<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ControllerSettingLicense extends Controller {
	private $route = 'setting/license';
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
		$rs = new ModelSettingLicense ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->addLicense ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function update() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelSettingLicense ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->editLicense ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function delete() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelSettingLicense ( $this->registry );
		if (isset ( $this->request->post ['selected'] ) && $this->validateDelete ()) {
			foreach ( $this->request->post ['selected'] as $id ) {
				$rs->deleteLicense ( $id );
			}
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getList ();
	}
	protected function getList() {
		$id = 'id';
		$sort_data = array (
				'id',
				'project_key',
				'project_version',
				'status',
				'license_type' 
		);
		$this->loadModel ( $this->route );
		$rs = new ModelSettingLicense ( $this->registry );
		$record_total = $rs->getTotalLicenses ();
		$param = $this->initList ( $this->route, $record_total, $sort_data );
		$results = $rs->getLicenses ( $param, $sort_data );
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
		$this->initTpl ( 'setting/license_list' );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	protected function getForm() {
		$this->loadModel ( $this->route );
		$rs = new ModelSettingLicense ( $this->registry );
		$this->data ['token'] = $this->session->data ['token'];
		$id = isset ( $this->request->get ['id'] ) ? $this->request->get ['id'] : '';
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
			$item = $rs->getLicense ( $id );
		} else {
			$item = $rs->getDefaultLicense ();
		}
		$this->initItem ( $item );
		$this->initNotice ();
		$this->initTpl ( 'setting/license_form' );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	protected function validateForm() {
		if (! $this->user->hasPermission ( 'modify', $this->route )) {
			$this->error ['warning'] = $this->language->get ( 'error_permission' );
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
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
}