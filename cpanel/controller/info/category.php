<?php
class ControllerInfoCategory extends Controller {
	private $route = 'info/category';
	private $model = 'model_info_category';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$this->getList ();
	}
	public function insert() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelInfoCategory ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->addCategory ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function update() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelInfoCategory ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->editCategory ( $this->request->get ['id'], $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function delete() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelInfoCategory ( $this->registry );
		if (isset ( $this->request->post ['selected'] ) && $this->validateDelete ()) {
			foreach ( $this->request->post ['selected'] as $id ) {
				$rs->deleteCategory ( $id );
			}
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getList ();
	}
	public function repair() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelInfoCategory ( $this->registry );
		if ($this->validateRepair ()) {
			$rs->repairCategory ();
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getList ();
	}
	protected function getList() {
		$rs = new ModelInfoCategory ( $this->registry );
		$id = 'category_id';
		$sort_data = array (
				'category_id',
				'sort_order' 
		);
		$record_total = $rs->getTotalCategories ();
		$param = $this->initList ( $this->route, $record_total, $sort_data );
		$param ['userId'] = $this->user->getId ();
		$this->data ['repair'] = $this->url->link ( $this->route . '/repair', 'token=' . $this->session->data ['token'] . $param ['url'], 'SSL' );
		$results = $rs->getCategories_ ( $param );
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
		$this->initTpl ( 'info/category_list' );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	protected function getForm() {
		$rs = new ModelInfoCategory ( $this->registry );
		$this->data ['token'] = $this->session->data ['token'];
		$id = isset ( $this->request->get ['id'] ) ? $this->request->get ['id'] : '';
		if (isset ( $this->error ['name'] )) {
			$this->data ['error_name'] = $this->error ['name'];
		} else {
			$this->data ['error_name'] = array ();
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
			$item = $rs->getCategory_ ( $id );
		} else {
			$item = $rs->getDefaultCategory ();
			$this->data ['userId'] = $this->user->getId ();
		}
		$this->initItem ( $item );
		$this->loadModel ( 'localisation/language' );
		$rll = new ModelLocalisationLanguage ( $this->registry );
		$this->data ['languages'] = $rll->getLanguages ();
		if (isset ( $this->request->post ['category_description'] )) {
			$this->data ['category_description'] = $this->request->post ['category_description'];
		} elseif ($id != '') {
			$this->data ['category_description'] = $rs->getCategoryDescriptions ( $id );
		} else {
			$this->data ['category_description'] = array ();
		}
		if (isset ( $this->request->post ['path'] )) {
			$this->data ['path'] = $this->request->post ['path'];
		} elseif (! empty ( $item ) && isset ( $item ['path'] )) {
			$this->data ['path'] = $item ['path'];
		} else {
			$this->data ['path'] = '';
		}
		if (isset ( $this->request->post ['parent_id'] )) {
			$this->data ['parent_id'] = $this->request->post ['parent_id'];
		} elseif (! empty ( $category_info )) {
			$this->data ['parent_id'] = $category_info ['parent_id'];
		} else {
			$this->data ['parent_id'] = 0;
		}
		$this->load->model ( 'info/filter' );
		if (isset ( $this->request->post ['category_filter'] )) {
			$filters = $this->request->post ['category_filter'];
		} elseif ($id != '') {
			$filters = $rs->getCategoryFilters_ ( $id );
		} else {
			$filters = array ();
		}
		$this->data ['category_filters'] = array ();
		foreach ( $filters as $filter_id ) {
			$filter_info = $this->model_info_filter->getFilter ( $filter_id );
			if ($filter_info) {
				$this->data ['category_filters'] [] = array (
						'filter_id' => $filter_info ['filter_id'],
						'name' => $filter_info ['group'] . ' &gt; ' . $filter_info ['name'] 
				);
			}
		}
		$this->load->model ( 'setting/store' );
		$this->data ['stores'] = $this->model_setting_store->getStores ();
		if (isset ( $this->request->post ['category_store'] )) {
			$this->data ['category_store'] = $this->request->post ['category_store'];
		} elseif ($id != '') {
			$this->data ['category_store'] = $rs->getCategoryStores ( $id );
		} else {
			$this->data ['category_store'] = array (
					0 
			);
		}
		if (isset ( $this->request->post ['keyword'] )) {
			$this->data ['keyword'] = $this->request->post ['keyword'];
		} elseif (! empty ( $item ) && isset ( $item ['keyword'] )) {
			$this->data ['keyword'] = $item ['keyword'];
		} else {
			$this->data ['keyword'] = '';
		}
		$this->load->model ( 'tool/image' );
		if (isset ( $this->request->post ['image'] ) && file_exists ( DIR_IMAGE . $this->request->post ['image'] )) {
			$this->data ['thumb'] = $this->model_tool_image->resize ( $this->request->post ['image'], 100, 100 );
		} elseif (! empty ( $item ) && $item ['image'] && file_exists ( DIR_IMAGE . $item ['image'] )) {
			$this->data ['thumb'] = $this->model_tool_image->resize ( $item ['image'], 100, 100 );
		} else {
			$this->data ['thumb'] = $this->model_tool_image->resize ( 'no_image.jpg', 100, 100 );
		}
		$this->data ['no_image'] = $this->model_tool_image->resize ( 'no_image.jpg', 100, 100 );
		if (isset ( $this->request->post ['top'] )) {
			$this->data ['top'] = $this->request->post ['top'];
		} elseif (! empty ( $item )) {
			$this->data ['top'] = $item ['top'];
		} else {
			$this->data ['top'] = 0;
		}
		if (isset ( $this->request->post ['column'] )) {
			$this->data ['column'] = $this->request->post ['column'];
		} elseif (! empty ( $item )) {
			$this->data ['column'] = $item ['column'];
		} else {
			$this->data ['column'] = 1;
		}
		if (isset ( $this->request->post ['category_layout'] )) {
			$this->data ['category_layout'] = $this->request->post ['category_layout'];
		} elseif ($id != '') {
			$this->data ['category_layout'] = $rs->getCategoryLayouts ( $id );
		} else {
			$this->data ['category_layout'] = array ();
		}
		$this->load->model ( 'design/layout' );
		$this->data ['layouts'] = $this->model_design_layout->getLayouts ();
		$this->initNotice ();
		$this->initTpl ( 'info/category_form' );
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
		foreach ( $this->request->post ['category_description'] as $language_id => $value ) {
			if ((utf8_strlen ( $value ['name'] ) < 2) || (utf8_strlen ( $value ['name'] ) > 255)) {
				$this->error ['name'] [$language_id] = $this->language->get ( 'error_name' );
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
	protected function validateRepair() {
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
		$rs = new ModelInfoCategory ( $this->registry );
		$json = array ();
		if (isset ( $this->request->get ['filter_name'] )) {
			$this->load->model ( $this->route );
			$data = array (
					'filter_name' => $this->request->get ['filter_name'],
					'start' => 0,
					'limit' => 20 
			);
			$results = $this->$rs->getList ( $data );
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