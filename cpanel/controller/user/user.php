<?php
class ControllerUserUser extends Controller {
	private $route = 'user/user';
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
		$rs = new ModelUserUser ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->addUser ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function update() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelUserUser ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->editUser ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function delete() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelUserUser ( $this->registry );
		if (isset ( $this->request->post ['selected'] ) && $this->validateDelete ()) {
			foreach ( $this->request->post ['selected'] as $id ) {
				$rs->deleteUser ( $id );
			}
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getList ();
	}
	protected function getList() {
		$id = 'user_id';
		$sort_data = array (
				'username',
				'email',
				'user_group_id',
				'status',
				'date_added' 
		);
		$this->loadModel ( $this->route );
		$rs = new ModelUserUser ( $this->registry );
		$record_total = $rs->getTotalUsers ();
		$param = $this->initList ( $this->route, $record_total, $sort_data );
		$results = $rs->getUsers ( $param, $sort_data );
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
		$this->initNotice ();
		$this->data ['list'] = $records;
		$this->initTpl ( 'user/user_list' );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	protected function getForm() {
		$this->loadModel ( $this->route );
		$rs = new ModelUserUser ( $this->registry );
		$this->data ['token'] = $this->session->data ['token'];
		$id = isset ( $this->request->get ['id'] ) ? $this->request->get ['id'] : '';
		if (isset ( $this->error ['username'] )) {
			$this->data ['error_username'] = $this->error ['username'];
		} else {
			$this->data ['error_username'] = '';
		}
		if (isset ( $this->error ['password'] )) {
			$this->data ['error_password'] = $this->error ['password'];
		} else {
			$this->data ['error_password'] = '';
		}
		if (isset ( $this->error ['confirm'] )) {
			$this->data ['error_confirm'] = $this->error ['confirm'];
		} else {
			$this->data ['error_confirm'] = '';
		}
		if (isset ( $this->error ['firstname'] )) {
			$this->data ['error_firstname'] = $this->error ['firstname'];
		} else {
			$this->data ['error_firstname'] = '';
		}
		if (isset ( $this->error ['lastname'] )) {
			$this->data ['error_lastname'] = $this->error ['lastname'];
		} else {
			$this->data ['error_lastname'] = '';
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
			$item = $rs->getUser ( $id );
		} else {
			$item = $rs->getDefaultUser ();
		}
		$this->initItem ( $item );
		if (isset ( $this->request->post ['confirm'] )) {
			$this->data ['confirm'] = $this->request->post ['confirm'];
		} else {
			$this->data ['confirm'] = '';
		}
		if (isset ( $this->request->post ['status'] )) {
			$this->data ['status'] = $this->request->post ['status'];
		} elseif (! empty ( $item )) {
			$this->data ['status'] = $item ['status'];
		} else {
			$this->data ['status'] = 0;
		}
		$this->loadModel ( 'user/user_group' );
		$rsg = new ModelUserUserGroup ( $this->registry );
		$this->data ['user_groups'] = $rsg->getUserGroups ();
		$this->initNotice ();
		$this->initTpl ( 'user/user_form' );
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
		if ((utf8_strlen ( $this->request->post ['username'] ) < 3) || (utf8_strlen ( $this->request->post ['username'] ) > 20)) {
			$this->error ['username'] = $this->language->get ( 'error_username' );
		}
		$this->loadModel ( $this->route );
		$rs = new ModelUserUser ( $this->registry );
		$user_info = $rs->getUserByUsername ( $this->request->post ['username'] );
		if ($this->request->post ['user_id'] != '' ) {
			if ($user_info && ($this->request->post ['user_id'] != $user_info ['user_id'])) {
				$this->error ['warning'] = $this->language->get ( 'error_exists' );
			}
		} else {
			if ($user_info) {
				$this->error ['warning'] = $this->language->get ( 'error_exists' );
			}
		}
		if ((utf8_strlen ( $this->request->post ['firstname'] ) < 1) || (utf8_strlen ( $this->request->post ['firstname'] ) > 32)) {
			$this->error ['firstname'] = $this->language->get ( 'error_firstname' );
		}
		if ((utf8_strlen ( $this->request->post ['lastname'] ) < 1) || (utf8_strlen ( $this->request->post ['lastname'] ) > 32)) {
			$this->error ['lastname'] = $this->language->get ( 'error_lastname' );
		}
		if ($this->request->post ['password'] || (! isset ( $this->request->get ['user_id'] ))) {
			if (($this->request->post ['password'] != '') && ((utf8_strlen ( $this->request->post ['password'] ) < 4) || (utf8_strlen ( $this->request->post ['password'] ) > 20))) {
				$this->error ['password'] = $this->language->get ( 'error_password' );
			}
			if ($this->request->post ['password'] != $this->request->post ['confirm']) {
				$this->error ['confirm'] = $this->language->get ( 'error_confirm' );
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
		foreach ( $this->request->post ['selected'] as $user_id ) {
			if ($this->user->getId () == $user_id) {
				$this->error ['warning'] = $this->language->get ( 'error_account' );
			}
		}
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
}