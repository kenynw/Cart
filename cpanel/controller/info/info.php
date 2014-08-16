<?php
class ControllerInfoInfo extends Controller {
	private $route = 'info/info';
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
		$rs = new ModelInfoInfo ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->addInfo ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function update() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelInfoInfo ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->editInfo ( $this->request->get ['id'], $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function delete() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelInfoInfo ( $this->registry );
		if (isset ( $this->request->post ['selected'] ) && $this->validateDelete ()) {
			foreach ( $this->request->post ['selected'] as $id ) {
				$rs->deleteInfo ( $id );
			}
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getList ();
	}
	protected function getList() {
		$this->loadModel ( $this->route );
		$rs = new ModelInfoInfo ( $this->registry );
		$id = 'information_id';
		$sort_data = array (
				'i.sort_order',
				'id.title' 
		);
		$category_id = 0;
		if (isset ( $this->request->get ['cid'] ) && ($this->request->get ['cid'] != '')) {
			$category_id = ( int ) $this->request->get ['cid'];
		}
		$record_total = $rs->getTotalInfos ( $category_id );
		$param = $this->initList ( $this->route, $record_total, $sort_data );
		$param ['userId'] = $this->user->getId ();
		$param ['category_id'] = $category_id;
		$results = $rs->getInfos_ ( $param, $sort_data );
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
		$this->initTpl ( 'info/info_list' );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	protected function getForm() {
		$this->loadModel ( $this->route );
		$rs = new ModelInfoInfo ( $this->registry );
		$this->data ['token'] = $this->session->data ['token'];
		$id = isset ( $this->request->get ['id'] ) ? $this->request->get ['id'] : '';
		if (isset ( $this->error ['title'] )) {
			$this->data ['error_title'] = $this->error ['title'];
		} else {
			$this->data ['error_title'] = array ();
		}
		if (isset ( $this->error ['description'] )) {
			$this->data ['error_description'] = $this->error ['description'];
		} else {
			$this->data ['error_description'] = array ();
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
			$item = $rs->getInfo ( $id );
		} else {
			$item = $rs->getDefaultInfo ();
			$this->data ['userId'] = $this->user->getId ();
		}
		$this->initItem ( $item );
		$this->loadModel ( 'localisation/language' );
		$rll = new ModelLocalisationLanguage ( $this->registry );
		$this->data ['languages'] = $rll->getLanguages ();
		if (isset ( $this->request->post ['information_description'] )) {
			$this->data ['information_description'] = $this->request->post ['information_description'];
		} elseif (isset ( $this->request->get ['id'] )) {
			$this->data ['information_description'] = $rs->getInfoDescriptions ( $this->request->get ['id'] );
		} else {
			$this->data ['information_description'] = array ();
		}
		if (isset ( $this->request->post ['category_id'] )) {
			$this->data ['category_id'] = $this->request->post ['category_id'];
		} elseif (isset ( $item ['category_id'] )) {
			$this->data ['category_id'] = $item ['category_id'];
		} else {
			$this->data ['category_id'] = '';
		}
		$this->loadModel ( 'setting/store' );
		$rss = new ModelSettingStore ( $this->registry );
		$this->data ['stores'] = $rss->getStores ();
		if (isset ( $this->request->post ['information_store'] )) {
			$this->data ['information_store'] = $this->request->post ['information_store'];
		} elseif (isset ( $this->request->get ['id'] )) {
			$this->data ['information_store'] = $rs->getInfoStores ( $this->request->get ['id'] );
		} else {
			$this->data ['information_store'] = array (
					0 
			);
		}
		if (isset ( $this->request->post ['path'] )) {
			$this->data ['path'] = $this->request->post ['path'];
		} elseif (! empty ( $item )) {
			$tmpItem = $rs->getInfoCategory ( $item ['information_id'] );
			$this->data ['path'] = isset ( $tmpItem ['name'] ) ? $tmpItem ['name'] : '';
		} else {
			$this->data ['path'] = '';
		}
		if (isset ( $this->request->post ['keyword'] )) {
			$this->data ['keyword'] = $this->request->post ['keyword'];
		} elseif (! empty ( $item ) && isset ( $item ['keyword'] )) {
			$this->data ['keyword'] = $item ['keyword'];
		} else {
			$this->data ['keyword'] = '';
		}
		if (isset ( $this->request->post ['information_layout'] )) {
			$this->data ['information_layout'] = $this->request->post ['information_layout'];
		} elseif (isset ( $this->request->get ['id'] )) {
			$this->data ['information_layout'] = $rs->getInfoLayouts ( $this->request->get ['id'] );
		} else {
			$this->data ['information_layout'] = array ();
		}
		$this->load->model ( 'design/layout' );
		$this->data ['layouts'] = $this->model_design_layout->getLayouts ();
		$this->initNotice ();
		$this->initTpl ( 'info/info_form' );
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
		foreach ( $this->request->post ['information_description'] as $language_id => $value ) {
			if ((utf8_strlen ( $value ['title'] ) < 3) || (utf8_strlen ( $value ['title'] ) > 64)) {
				$this->error ['title'] [$language_id] = $this->language->get ( 'error_title' );
			}
			if (utf8_strlen ( $value ['description'] ) < 3) {
				$this->error ['description'] [$language_id] = $this->language->get ( 'error_description' );
			}
		}
		if ((utf8_strlen ( $this->request->post ['path'] ) < 3) || (utf8_strlen ( $this->request->post ['path'] ) > 32)) {
			$this->error ['path'] = $this->language->get ( 'error_path' );
		}
		if ($this->error && ! isset ( $this->error ['warning'] )) {
			$this->error ['warning'] = $this->language->get ( 'error_warning' );
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
			$this->load->model ( 'info/category' );
			$data = array (
					'filter_name' => $this->request->get ['filter_name'],
					'start' => 0,
					'limit' => 20 
			);
			$results = $this->model_info_category->getCategories_ ( $data );
			foreach ( $results as $result ) {
				$json [] = array (
						'category_id' => $result ['category_id'],
						'name' => strip_tags ( html_entity_decode ( $result ['name'], ENT_QUOTES, 'UTF-8' ) ) 
				);
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