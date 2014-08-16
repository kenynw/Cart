<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ControllerUserUserPermission extends Controller {
	private $route = 'user/user_permission';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( 'user/user_group' );
		}
	}
	public function index() {
		$this->loadText ();
		$this->getList ();
	}
	public function insert() {
		$this->loadText ();
		$this->loadModel ( 'user/user_group' );
		$rs = new ModelUserUserGroup ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->addUserGroup ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function update() {
		$this->loadText ();
		$this->loadModel ( 'user/user_group' );
		$rs = new ModelUserUserGroup ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->editUserGroup ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function delete() {
		$this->loadText ();
		$this->loadModel ( 'user/user_group' );
		$rs = new ModelUserUserGroup ( $this->registry );
		if (isset ( $this->request->post ['selected'] ) && $this->validateDelete ()) {
			foreach ( $this->request->post ['selected'] as $id ) {
				$rs->deleteUserGroup ( $id );
			}
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getList ();
	}
	protected function getList() {
		$id = 'user_group_id';
		$sort_data = array (
				'name' 
		);
		$this->loadModel ( 'user/user_group' );
		$rs = new ModelUserUserGroup ( $this->registry );
		$record_total = $rs->getTotalUserGroups ();
		$param = $this->initList ( $this->route, $record_total, $sort_data );
		$results = $rs->getUserGroups ( $param, $sort_data );
		$records = array ();
		foreach ( $results as $result ) {
			$action = array ();
			$action [] = array (
					'text' => $this->language->get ( 'text_edit' ),
					'href' => $this->url->link ( 'user/user_permission/update', 'token=' . $this->session->data ['token'] . '&id=' . $result [$id] . $param ['url'], 'SSL' ) 
			);
			$result ['action'] = $action;
			$result ['selected'] = isset ( $this->request->post ['selected'] ) && in_array ( $result [$id], $this->request->post ['selected'] );
			$records [] = $result;
		}
		$this->data ['list'] = $records;
		$this->initNotice ();
		$this->initTpl ( 'user/user_group_list' );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	protected function getForm() {
		$this->loadModel ( 'user/user_group' );
		$rs = new ModelUserUserGroup ( $this->registry );
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
			$item = $rs->getUserGroup ( $id );
		} else {
			$item = $rs->getDefaultUserGroup ();
		}
		$this->initItem ( $item );
		$ignore = array (
				'common/home',
				'common/startup',
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/reset',
				'error/not_found',
				'error/permission',
				'common/footer',
				'common/header' 
		);
		$this->data ['permissions'] = array ();
		$arr = array ();
		if (strtoupper ( PROJECT ) == 'WEB') {
			$this->loadModel ( 'info/category' );
			$rs = new ModelInfoCategory ( $this->registry );
			$param = array (
					'sort' => 'sort_order',
					'order' => 'ASC',
					'start' => 0,
					'limit' => PHP_INT_MAX,
					'id' => 0 
			);
			$results = $rs->getListFilter ( $param );
			foreach ( $results as $result ) {
				$param = array (
						'sort' => 'sort_order',
						'order' => 'ASC',
						'start' => 0,
						'limit' => PHP_INT_MAX,
						'id' => $result ['category_id'] 
				);
				$tmpList = $rs->getListFilter ( $param );
				if ($tmpList != null) {
					foreach ( $tmpList as $item ) {
						$arr [] = 'info/info&cid=' . $item ['category_id'];
					}
				} else {
					$arr [] = 'info/info&cid=' . $result ['category_id'];
				}
			}
		} elseif (strtoupper ( PROJECT ) == 'CART' || strtoupper ( PROJECT ) == 'SEO' || strtoupper ( PROJECT ) == 'B2B' || strtoupper ( PROJECT ) == 'SOP') {
			$this->loadModel ( 'user/user_page' );
			$rs = new ModelUserUserPage ( $this->registry );
			$results = $rs->getUserPageListCpanel ( PROJECT );
			$ignore = array (
					'error',
					'' 
			);
			foreach ( $results as $result ) {
				if ($result ['project_name'] == strtolower ( PROJECT ) && ! in_array ( $result ['menu_key'], $ignore )) {
					$arr [] = $result ['route'];
				}
			}
		} else {
			$files = glob ( DIR_APPLICATION . 'controller/*/*.php' );
			foreach ( $files as $file ) {
				$data = explode ( '/', dirname ( $file ) );
				$permission = end ( $data ) . '/' . basename ( $file, '.php' );
				if (! in_array ( $permission, $ignore )) {
					$arr [] = $permission;
				}
			}
		}
		$this->data ['permissions'] = $arr;
		if (isset ( $this->request->post ['permission'] ['access'] )) {
			$this->data ['access'] = $this->request->post ['permission'] ['access'];
		} elseif (isset ( $item ['permission'] ['access'] )) {
			$this->data ['access'] = $item ['permission'] ['access'];
		} else {
			$this->data ['access'] = array ();
		}
		if (isset ( $this->request->post ['permission'] ['modify'] )) {
			$this->data ['modify'] = $this->request->post ['permission'] ['modify'];
		} elseif (isset ( $item ['permission'] ['modify'] )) {
			$this->data ['modify'] = $item ['permission'] ['modify'];
		} else {
			$this->data ['modify'] = array ();
		}
		$this->initNotice ();
		$this->initTpl ( 'user/user_group_form' );
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
		$this->loadModel ( 'user/user' );
		$rs = new ModelUserUser ( $this->registry );
		foreach ( $this->request->post ['selected'] as $user_group_id ) {
			$user_total = $rs->getTotalUsersByGroupId ( $user_group_id );
			if ($user_total) {
				$this->error ['warning'] = sprintf ( $this->language->get ( 'error_user' ), $user_total );
			}
		}
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
}