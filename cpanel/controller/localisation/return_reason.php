<?php
class ControllerLocalisationReturnReason extends Controller {
	private $route = 'localisation/return_reason';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		$this->load->model ( $this->route );
		$this->getList ();
	}
	public function insert() {
		$this->loadText ();
		$this->load->model ( $this->route );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$this->model_localisation_return_reason->addReturnReason ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
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
			$this->redirect ( $this->url->link ( 'localisation/return_reason', 'token=' . $this->session->data ['token'] . $url, 'SSL' ) );
		}
		$this->getForm ();
	}
	public function update() {
		$this->loadText ();
		$this->load->model ( $this->route );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$this->model_localisation_return_reason->editReturnReason ( $this->request->get ['return_reason_id'], $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
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
			$this->redirect ( $this->url->link ( 'localisation/return_reason', 'token=' . $this->session->data ['token'] . $url, 'SSL' ) );
		}
		$this->getForm ();
	}
	public function delete() {
		$this->loadText ();
		$this->load->model ( $this->route );
		if (isset ( $this->request->post ['selected'] ) && $this->validateDelete ()) {
			foreach ( $this->request->post ['selected'] as $return_reason_id ) {
				$this->model_localisation_return_reason->deleteReturnReason ( $return_reason_id );
			}
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
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
			$this->redirect ( $this->url->link ( 'localisation/return_reason', 'token=' . $this->session->data ['token'] . $url, 'SSL' ) );
		}
		$this->getList ();
	}
	protected function getList() {
		if (isset ( $this->request->get ['sort'] )) {
			$sort = $this->request->get ['sort'];
		} else {
			$sort = 'name';
		}
		if (isset ( $this->request->get ['order'] )) {
			$order = $this->request->get ['order'];
		} else {
			$order = 'ASC';
		}
		if (isset ( $this->request->get ['page'] )) {
			$page = $this->request->get ['page'];
		} else {
			$page = 1;
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
		$this->data ['insert'] = $this->url->link ( 'localisation/return_reason/insert', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		$this->data ['delete'] = $this->url->link ( 'localisation/return_reason/delete', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		$this->data ['return_reasons'] = array ();
		$data = array (
				'sort' => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->config->get ( 'config_admin_limit' ),
				'limit' => $this->config->get ( 'config_admin_limit' ) 
		);
		$return_reason_total = $this->model_localisation_return_reason->getTotalReturnReasons_ ();
		$results = $this->model_localisation_return_reason->getReturnReasons_ ( $data );
		foreach ( $results as $result ) {
			$action = array ();
			$action [] = array (
					'text' => $this->language->get ( 'text_edit' ),
					'href' => $this->url->link ( 'localisation/return_reason/update', 'token=' . $this->session->data ['token'] . '&return_reason_id=' . $result ['return_reason_id'] . $url, 'SSL' ) 
			);
			$this->data ['return_reasons'] [] = array (
					'return_reason_id' => $result ['return_reason_id'],
					'name' => $result ['name'],
					'selected' => isset ( $this->request->post ['selected'] ) && in_array ( $result ['return_reason_id'], $this->request->post ['selected'] ),
					'action' => $action 
			);
		}
		if (isset ( $this->session->data ['success'] )) {
			$this->data ['success'] = $this->session->data ['success'];
			unset ( $this->session->data ['success'] );
		} else {
			$this->data ['success'] = '';
		}
		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset ( $this->request->get ['page'] )) {
			$url .= '&page=' . $this->request->get ['page'];
		}
		$this->data ['sort_name'] = $this->url->link ( 'localisation/return_reason', 'token=' . $this->session->data ['token'] . '&sort=name' . $url, 'SSL' );
		$url = '';
		if (isset ( $this->request->get ['sort'] )) {
			$url .= '&sort=' . $this->request->get ['sort'];
		}
		if (isset ( $this->request->get ['order'] )) {
			$url .= '&order=' . $this->request->get ['order'];
		}
		$pagination = new Pagination ();
		$pagination->total = $return_reason_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get ( 'config_admin_limit' );
		$pagination->text = $this->language->get ( 'text_pagination' );
		$pagination->url = $this->url->link ( 'localisation/return_reason', 'token=' . $this->session->data ['token'] . $url . '&page={page}', 'SSL' );
		$this->data ['pagination'] = $pagination->render ();
		$this->data ['sort'] = $sort;
		$this->data ['order'] = $order;
		$this->initNotice ();
		$this->initTpl ( 'localisation/return_reason_list' );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	protected function getForm() {
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
		if (! isset ( $this->request->get ['return_reason_id'] )) {
			$this->data ['action'] = $this->url->link ( 'localisation/return_reason/insert', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		} else {
			$this->data ['action'] = $this->url->link ( 'localisation/return_reason/update', 'token=' . $this->session->data ['token'] . '&return_reason_id=' . $this->request->get ['return_reason_id'] . $url, 'SSL' );
		}
		$this->data ['cancel'] = $this->url->link ( 'localisation/return_reason', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		$this->load->model ( 'localisation/language' );
		$this->data ['languages'] = $this->model_localisation_language->getLanguages ();
		if (isset ( $this->request->post ['return_reason'] )) {
			$this->data ['return_reason'] = $this->request->post ['return_reason'];
		} elseif (isset ( $this->request->get ['return_reason_id'] )) {
			$this->data ['return_reason'] = $this->model_localisation_return_reason->getReturnReasonDescriptions ( $this->request->get ['return_reason_id'] );
			$this->data ['return_reason_id'] = $this->request->get ['return_reason_id'];
		} else {
			$this->data ['return_reason'] = array ();
			$this->data ['return_reason_id'] = '';
		}		
		$this->initNotice ();
		$this->initTpl ( 'localisation/return_reason_form' );
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
		foreach ( $this->request->post ['return_reason'] as $language_id => $value ) {
			if ((utf8_strlen ( $value ['name'] ) < 3) || (utf8_strlen ( $value ['name'] ) > 32)) {
				$this->error ['name'] [$language_id] = $this->language->get ( 'error_name' );
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
		$this->load->model ( 'sale/return' );
		foreach ( $this->request->post ['selected'] as $return_reason_id ) {
			$return_total = $this->model_sale_return->getTotalReturnsByReturnReasonId ( $return_reason_id );
			if ($return_total) {
				$this->error ['warning'] = sprintf ( $this->language->get ( 'error_return' ), $return_total );
			}
		}
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
}