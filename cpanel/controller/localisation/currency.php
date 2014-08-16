<?php
class ControllerLocalisationCurrency extends Controller {
	private $route = 'localisation/currency';
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
			$this->model_localisation_currency->addCurrency ( $this->request->post );
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
			$this->redirect ( $this->url->link ( 'localisation/currency', 'token=' . $this->session->data ['token'] . $url, 'SSL' ) );
		}
		$this->getForm ();
	}
	public function update() {
		$this->loadText ();
		$this->load->model ( $this->route );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$this->model_localisation_currency->editCurrency ( $this->request->get ['currency_id'], $this->request->post );
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
			$this->redirect ( $this->url->link ( 'localisation/currency', 'token=' . $this->session->data ['token'] . $url, 'SSL' ) );
		}
		$this->getForm ();
	}
	public function delete() {
		$this->loadText ();
		$this->load->model ( $this->route );
		if (isset ( $this->request->post ['selected'] ) && $this->validateDelete ()) {
			foreach ( $this->request->post ['selected'] as $currency_id ) {
				$this->model_localisation_currency->deleteCurrency ( $currency_id );
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
			$this->redirect ( $this->url->link ( 'localisation/currency', 'token=' . $this->session->data ['token'] . $url, 'SSL' ) );
		}
		$this->getList ();
	}
	protected function getList() {
		if (isset ( $this->request->get ['sort'] )) {
			$sort = $this->request->get ['sort'];
		} else {
			$sort = 'title';
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
		$this->data ['insert'] = $this->url->link ( 'localisation/currency/insert', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		$this->data ['delete'] = $this->url->link ( 'localisation/currency/delete', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		$this->data ['currencies'] = array ();
		$data = array (
				'sort' => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->config->get ( 'config_admin_limit' ),
				'limit' => $this->config->get ( 'config_admin_limit' ) 
		);
		$currency_total = $this->model_localisation_currency->getTotalCurrencies ();
		$results = $this->model_localisation_currency->getCurrencies_ ( $data );
		foreach ( $results as $result ) {
			$action = array ();
			$action [] = array (
					'text' => $this->language->get ( 'text_edit' ),
					'href' => $this->url->link ( 'localisation/currency/update', 'token=' . $this->session->data ['token'] . '&currency_id=' . $result ['currency_id'] . $url, 'SSL' ) 
			);
			$this->data ['currencies'] [] = array (
					'currency_id' => $result ['currency_id'],
					'title' => $result ['title'] . (($result ['code'] == $this->config->get ( 'config_currency' )) ? $this->language->get ( 'text_default' ) : null),
					'code' => $result ['code'],
					'value' => $result ['value'],
					'date_modified' => date ( $this->language->get ( 'date_format_short' ), strtotime ( $result ['date_modified'] ) ),
					'selected' => isset ( $this->request->post ['selected'] ) && in_array ( $result ['currency_id'], $this->request->post ['selected'] ),
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
		$this->data ['sort_title'] = $this->url->link ( 'localisation/currency', 'token=' . $this->session->data ['token'] . '&sort=title' . $url, 'SSL' );
		$this->data ['sort_code'] = $this->url->link ( 'localisation/currency', 'token=' . $this->session->data ['token'] . '&sort=code' . $url, 'SSL' );
		$this->data ['sort_value'] = $this->url->link ( 'localisation/currency', 'token=' . $this->session->data ['token'] . '&sort=value' . $url, 'SSL' );
		$this->data ['sort_date_modified'] = $this->url->link ( 'localisation/currency', 'token=' . $this->session->data ['token'] . '&sort=date_modified' . $url, 'SSL' );
		$url = '';
		if (isset ( $this->request->get ['sort'] )) {
			$url .= '&sort=' . $this->request->get ['sort'];
		}
		if (isset ( $this->request->get ['order'] )) {
			$url .= '&order=' . $this->request->get ['order'];
		}
		$pagination = new Pagination ();
		$pagination->total = $currency_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get ( 'config_admin_limit' );
		$pagination->text = $this->language->get ( 'text_pagination' );
		$pagination->url = $this->url->link ( 'localisation/currency', 'token=' . $this->session->data ['token'] . $url . '&page={page}', 'SSL' );
		$this->data ['pagination'] = $pagination->render ();
		$this->data ['sort'] = $sort;
		$this->data ['order'] = $order;
		$this->initNotice ();
		$this->initTpl ( 'localisation/currency_list' );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	protected function getForm() {
		if (isset ( $this->error ['title'] )) {
			$this->data ['error_title'] = $this->error ['title'];
		} else {
			$this->data ['error_title'] = '';
		}
		if (isset ( $this->error ['code'] )) {
			$this->data ['error_code'] = $this->error ['code'];
		} else {
			$this->data ['error_code'] = '';
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
		if (! isset ( $this->request->get ['currency_id'] )) {
			$this->data ['action'] = $this->url->link ( 'localisation/currency/insert', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		} else {
			$this->data ['action'] = $this->url->link ( 'localisation/currency/update', 'token=' . $this->session->data ['token'] . '&currency_id=' . $this->request->get ['currency_id'] . $url, 'SSL' );
		}
		$this->data ['cancel'] = $this->url->link ( 'localisation/currency', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		if (isset ( $this->request->get ['currency_id'] ) && ($this->request->server ['REQUEST_METHOD'] != 'POST')) {
			$currency_info = $this->model_localisation_currency->getCurrency ( $this->request->get ['currency_id'] );
		}
		if (isset ( $this->request->post ['title'] )) {
			$this->data ['title'] = $this->request->post ['title'];
		} elseif (! empty ( $currency_info )) {
			$this->data ['title'] = $currency_info ['title'];
		} else {
			$this->data ['title'] = '';
		}
		if (isset ( $this->request->post ['code'] )) {
			$this->data ['code'] = $this->request->post ['code'];
		} elseif (! empty ( $currency_info )) {
			$this->data ['code'] = $currency_info ['code'];
		} else {
			$this->data ['code'] = '';
		}
		if (isset ( $this->request->post ['symbol_left'] )) {
			$this->data ['symbol_left'] = $this->request->post ['symbol_left'];
		} elseif (! empty ( $currency_info )) {
			$this->data ['symbol_left'] = $currency_info ['symbol_left'];
		} else {
			$this->data ['symbol_left'] = '';
		}
		if (isset ( $this->request->post ['symbol_right'] )) {
			$this->data ['symbol_right'] = $this->request->post ['symbol_right'];
		} elseif (! empty ( $currency_info )) {
			$this->data ['symbol_right'] = $currency_info ['symbol_right'];
		} else {
			$this->data ['symbol_right'] = '';
		}
		if (isset ( $this->request->post ['decimal_place'] )) {
			$this->data ['decimal_place'] = $this->request->post ['decimal_place'];
		} elseif (! empty ( $currency_info )) {
			$this->data ['decimal_place'] = $currency_info ['decimal_place'];
		} else {
			$this->data ['decimal_place'] = '';
		}
		if (isset ( $this->request->post ['value'] )) {
			$this->data ['value'] = $this->request->post ['value'];
		} elseif (! empty ( $currency_info )) {
			$this->data ['value'] = $currency_info ['value'];
		} else {
			$this->data ['value'] = '';
		}
		if (isset ( $this->request->post ['status'] )) {
			$this->data ['status'] = $this->request->post ['status'];
		} elseif (! empty ( $currency_info )) {
			$this->data ['status'] = $currency_info ['status'];
		} else {
			$this->data ['status'] = '';
		}
		if (isset ( $this->request->post ['currency_id'] )) {
			$this->data ['currency_id'] = $this->request->post ['currency_id'];
		} elseif (! empty ( $currency_info )) {
			$this->data ['currency_id'] = $currency_info ['currency_id'];
		} else {
			$this->data ['currency_id'] = '';
		}
		$this->initNotice ();
		$this->initTpl ( 'localisation/currency_form' );
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
		if ((utf8_strlen ( $this->request->post ['title'] ) < 3) || (utf8_strlen ( $this->request->post ['title'] ) > 32)) {
			$this->error ['title'] = $this->language->get ( 'error_title' );
		}
		if (utf8_strlen ( $this->request->post ['code'] ) != 3) {
			$this->error ['code'] = $this->language->get ( 'error_code' );
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
		$this->load->model ( 'setting/store' );
		$this->load->model ( 'sale/order' );
		foreach ( $this->request->post ['selected'] as $currency_id ) {
			$currency_info = $this->model_localisation_currency->getCurrency ( $currency_id );
			if ($currency_info) {
				if ($this->config->get ( 'config_currency' ) == $currency_info ['code']) {
					$this->error ['warning'] = $this->language->get ( 'error_default' );
				}
				$store_total = $this->model_setting_store->getTotalStoresByCurrency ( $currency_info ['code'] );
				if ($store_total) {
					$this->error ['warning'] = sprintf ( $this->language->get ( 'error_store' ), $store_total );
				}
			}
			$order_total = $this->model_sale_order->getTotalOrdersByCurrencyId ( $currency_id );
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