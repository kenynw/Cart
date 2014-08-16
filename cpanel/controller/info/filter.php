<?php
class ControllerInfoFilter extends Controller {
	private $route = 'info/filter';
	private function loadText($route = '') {
		if($route != ''){
			$this->loadLang ( $route );
		}else{
			$this->loadLang ( $this->route );
		}
	}
	 
	public function index() {
		$this->loadText ();
		$this->getList ();
	}
	public function insert() {
		$this->loadText ();
		$this->loadModel($this->route);
		$rs = new ModelInfoFilter($this->registry);
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->addFilter ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function update() {
		$this->loadText ();
		$this->loadModel($this->route);
		$rs = new ModelInfoFilter($this->registry);
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->editFilter ( $this->request->get ['id'], $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function delete() {
		$this->loadText ();
		$this->loadModel($this->route);
		$rs = new ModelInfoFilter($this->registry);
		if (isset ( $this->request->post ['selected'] ) && $this->validateDelete ()) {
			foreach ( $this->request->post ['selected'] as $id ) {
				$rs->deleteFilter ( $id );
			}
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getList ();
	}
	protected function getList() {
		$id = 'filter_group_id';
		$sort_data = array ( 'filter_id', 'filter_group_id' );
		$this->loadModel($this->route);
		$rs = new ModelInfoFilter($this->registry);
		$record_total = $rs->getTotalFilterGroups ();
		$param = $this->initList ( $this->route, $record_total, $sort_data );
		$results = $rs->getFilterGroups( $param, $sort_data );
		$records = array ();
		foreach ( $results as $result ) {
			$action = array ();
			$action [] = array ( 'text' => $this->language->get ( 'text_edit' ), 'href' => $this->url->link ( $this->route . '/update', 'token=' . $this->session->data ['token'] . '&id=' . $result [$id] . $param ['url'], 'SSL' ) );
			$result ['action'] = $action;
			$result ['selected'] = isset ( $this->request->post ['selected'] ) && in_array ( $result [$id], $this->request->post ['selected'] );
			$records [] = $result;
		}
		
		$this->data ['list'] = $records;
		$this->initNotice ();
		$this->initTpl('catalog/filter_list');
		$this->children = array ( 'common/header', 'common/footer' );
		$this->response->setOutput ( $this->render () );
	}
	protected function getForm() {
		$this->data ['token'] = $this->session->data ['token'];
		$id = isset ( $this->request->get ['id'] ) ? $this->request->get ['id'] : '';
		$this->loadModel($this->route);
		$rs = new ModelInfoFilter($this->registry);
		if (isset ( $this->error ['group'] )) {
			$this->data ['error_group'] = $this->error ['group'];
		} else {
			$this->data ['error_group'] = array ();
		}
		if (isset ( $this->error ['filter'] )) {
			$this->data ['error_filter'] = $this->error ['filter'];
		} else {
			$this->data ['error_filter'] = array ();
		}
		$url = '';
		if (isset ( $this->request->get ['sort'] )) {
			$url .= '&sort=' . $this->request->get ['sort'];
		}
		if (isset ( $this->request->get ['order'] )) {
			$url .= '&order=' . $this->request->get ['order'];
		}
		if (isset ( $this->request->get ['page'] )) {
			$url .= '&page=' . $this->request->get ['page'];
		}
		if ($id != '') {
			$this->data ['action'] = $this->url->link ( $this->route . '/update', 'token=' . $this->session->data ['token'] . '&id=' . $id . $url, 'SSL' );
		} else {
			$this->data ['action'] = $this->url->link ( $this->route . '/insert', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		}
		$this->data ['cancel'] = $this->url->link ( $this->route, 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		if (($id != '') && ($this->request->server ['REQUEST_METHOD'] != 'POST')) {
			$item = $rs->getFilter ( $id );
		} else {
			$item = $rs->getDefaultFilter ();
		}
		$this->initItem ( $item );
		if (isset ( $this->request->post ['filter_group_description'] )) {
			$this->data ['filter_group_description'] = $this->request->post ['filter_group_description'];
		} elseif (isset ( $this->request->get ['id'] )) {
			$this->data ['filter_group_description'] = $rs->getFilterDescriptions ( $id );
		} else {
			$this->data ['filter_group_description'] = array ();
		}
		if (isset ( $this->request->post ['filters'] )) {
			$this->data ['filters'] = $this->request->post ['filter'];
		} elseif (isset ( $this->request->get ['id'] )) {
			$this->data ['filters'] = $rs->getFilterDescriptions ( $id );
		} else {
			$this->data ['filters'] = array ();
		}
		$this->load->model ( 'localisation/language' );
		$this->data ['languages'] = $this->model_localisation_language->getList ();
		$this->initNotice ();
		$this->initTpl('catalog/filter_form');
		$this->children = array ( 'common/header', 'common/footer' );
		$this->response->setOutput ( $this->render () );
	}
	protected function validateForm() {
		if (! $this->user->hasPermission ( 'modify', $this->route )) {
			$this->error ['warning'] = $this->language->get ( 'error_permission' );
		}
		foreach ( $this->request->post ['filter_group_description'] as $language_id => $value ) {
			if ((utf8_strlen ( $value ['name'] ) < 1) || (utf8_strlen ( $value ['name'] ) > 64)) {
				$this->error ['group'] [$language_id] = $this->language->get ( 'error_group' );
			}
		}
		if (isset ( $this->request->post ['filter'] )) {
			foreach ( $this->request->post ['filter'] as $filter_id => $filter ) {
				foreach ( $filter ['filter_description'] as $language_id => $filter_description ) {
					if ((utf8_strlen ( $filter_description ['name'] ) < 1) || (utf8_strlen ( $filter_description ['name'] ) > 64)) {
						$this->error ['filter'] [$filter_id] [$language_id] = $this->language->get ( 'error_name' );
					}
				}
			}
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
	public function autocomplete() {
		$json = array ();
		if (isset ( $this->request->get ['filter_name'] )) {
			$this->loadModel($this->route);
		$rs = new ModelInfoFilter($this->registry);
			$data = array ( 'filter_name' => $this->request->get ['filter_name'], 'start' => 0, 'limit' => 20 );
			$filters = $rs->getFilters ( $data );
			foreach ( $filters as $filter ) {
				$json [] = array ( 'filter_id' => $filter ['filter_id'], 'name' => strip_tags ( html_entity_decode ( $filter ['group'] . ' &gt; ' . $filter ['name'], ENT_QUOTES, 'UTF-8' ) ) );
			}
		}
		$sort_order = array ();
		foreach ( $json as $key => $value ) {
			$sort_order [$key] = $value ['name'];
		}
		array_multisort ( $sort_order, SORT_ASC, $json );
		$this->response->setOutput ( json_encode ( $json ) );
	}
}