<?php  
class ControllerSaleVoucher extends Controller {
	
	private $route = 'sale/voucher';
	private function loadText($route = '') {
		if($route != ''){
			$this->loadLang ( $route );
		}else{
		$this->loadLang ( $this->route ); }
	}
	public function index() {
		$this->loadText ();
		 

		$this->load->model($this->route);

		$this->getList();
	}

	public function insert() {
		$this->loadText ();
		

		

		$this->load->model($this->route);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_voucher->addVoucher($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->loadText ();
		

		

		$this->load->model($this->route);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_voucher->editVoucher($this->request->get['voucher_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->loadText ();
		

		

		$this->load->model($this->route);

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $voucher_id) {
				$this->model_sale_voucher->deleteVoucher($voucher_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'v.date_added';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		

		$this->data['insert'] = $this->url->link('sale/voucher/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/voucher/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['vouchers'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$voucher_total = $this->model_sale_voucher->getTotalVouchers();

		$results = $this->model_sale_voucher->getVouchers($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/voucher/update', 'token=' . $this->session->data['token'] . '&voucher_id=' . $result['voucher_id'] . $url, 'SSL')
			);

			$this->data['vouchers'][] = array(
				'voucher_id' => $result['voucher_id'],
				'code'       => $result['code'],
				'from'       => $result['from_name'],
				'to'         => $result['to_name'],
				'theme'      => $result['theme'],
				'amount'     => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['voucher_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}

		

		
		
		

		
		
		
		
		
		
		
				

		
		

		$this->data['token'] = $this->session->data['token'];

		

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_code'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.code' . $url, 'SSL');
		$this->data['sort_from'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.from_name' . $url, 'SSL');
		$this->data['sort_to'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.to_name' . $url, 'SSL');
		$this->data['sort_theme'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=theme' . $url, 'SSL');
		$this->data['sort_amount'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.amount' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.date_end' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $voucher_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->initNotice();
		$this->initTpl('sale/voucher_list');
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		

		
		

		
		
		
		
		
		
		
		
		

		
		

		
		

		if (isset($this->request->get['voucher_id'])) {
			$this->data['voucher_id'] = $this->request->get['voucher_id'];
		} else {
			$this->data['voucher_id'] = 0;
		}

		

		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}		

		if (isset($this->error['from_name'])) {
			$this->data['error_from_name'] = $this->error['from_name'];
		} else {
			$this->data['error_from_name'] = '';
		}	

		if (isset($this->error['from_email'])) {
			$this->data['error_from_email'] = $this->error['from_email'];
		} else {
			$this->data['error_from_email'] = '';
		}	

		if (isset($this->error['to_name'])) {
			$this->data['error_to_name'] = $this->error['to_name'];
		} else {
			$this->data['error_to_name'] = '';
		}	

		if (isset($this->error['to_email'])) {
			$this->data['error_to_email'] = $this->error['to_email'];
		} else {
			$this->data['error_to_email'] = '';
		}	

		if (isset($this->error['amount'])) {
			$this->data['error_amount'] = $this->error['amount'];
		} else {
			$this->data['error_amount'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		
		if (!isset($this->request->get['voucher_id'])) {
			$this->data['action'] = $this->url->link('sale/voucher/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/voucher/update', 'token=' . $this->session->data['token'] . '&voucher_id=' . $this->request->get['voucher_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['voucher_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
			$voucher_info = $this->model_sale_voucher->getVoucher($this->request->get['voucher_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['code'])) {
			$this->data['code'] = $this->request->post['code'];
		} elseif (!empty($voucher_info)) {
			$this->data['code'] = $voucher_info['code'];
		} else {
			$this->data['code'] = '';
		}

		if (isset($this->request->post['from_name'])) {
			$this->data['from_name'] = $this->request->post['from_name'];
		} elseif (!empty($voucher_info)) {
			$this->data['from_name'] = $voucher_info['from_name'];
		} else {
			$this->data['from_name'] = '';
		}

		if (isset($this->request->post['from_email'])) {
			$this->data['from_email'] = $this->request->post['from_email'];
		} elseif (!empty($voucher_info)) {
			$this->data['from_email'] = $voucher_info['from_email'];
		} else {
			$this->data['from_email'] = '';
		}

		if (isset($this->request->post['to_name'])) {
			$this->data['to_name'] = $this->request->post['to_name'];
		} elseif (!empty($voucher_info)) {
			$this->data['to_name'] = $voucher_info['to_name'];
		} else {
			$this->data['to_name'] = '';
		}

		if (isset($this->request->post['to_email'])) {
			$this->data['to_email'] = $this->request->post['to_email'];
		} elseif (!empty($voucher_info)) {
			$this->data['to_email'] = $voucher_info['to_email'];
		} else {
			$this->data['to_email'] = '';
		}

		$this->load->model('sale/voucher_theme');

		$this->data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

		if (isset($this->request->post['voucher_theme_id'])) {
			$this->data['voucher_theme_id'] = $this->request->post['voucher_theme_id'];
		} elseif (!empty($voucher_info)) {
			$this->data['voucher_theme_id'] = $voucher_info['voucher_theme_id'];
		} else {
			$this->data['voucher_theme_id'] = '';
		}

		if (isset($this->request->post['message'])) {
			$this->data['message'] = $this->request->post['message'];
		} elseif (!empty($voucher_info)) {
			$this->data['message'] = $voucher_info['message'];
		} else {
			$this->data['message'] = '';
		}

		if (isset($this->request->post['amount'])) {
			$this->data['amount'] = $this->request->post['amount'];
		} elseif (!empty($voucher_info)) {
			$this->data['amount'] = $voucher_info['amount'];
		} else {
			$this->data['amount'] = '';
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($voucher_info)) {
			$this->data['status'] = $voucher_info['status'];
		} else {
			$this->data['status'] = 1;
		}
		$this->initNotice();
		$this->initTpl('sale/voucher_form');
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());		
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', $this->route)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['code']) < 3) || (utf8_strlen($this->request->post['code']) > 10)) {
			$this->error['code'] = $this->language->get('error_code');
		}

		$voucher_info = $this->model_sale_voucher->getVoucherByCode($this->request->post['code']);

		if ($voucher_info) {
			if (!isset($this->request->get['voucher_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			} elseif ($voucher_info['voucher_id'] != $this->request->get['voucher_id'])  {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}

		if ((utf8_strlen($this->request->post['to_name']) < 1) || (utf8_strlen($this->request->post['to_name']) > 64)) {
			$this->error['to_name'] = $this->language->get('error_to_name');
		}

		if ((utf8_strlen($this->request->post['to_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['to_email'])) {
			$this->error['to_email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['from_name']) < 1) || (utf8_strlen($this->request->post['from_name']) > 64)) {
			$this->error['from_name'] = $this->language->get('error_from_name');
		}

		if ((utf8_strlen($this->request->post['from_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['from_email'])) {
			$this->error['from_email'] = $this->language->get('error_email');
		}

		if ($this->request->post['amount'] < 1) {
			$this->error['amount'] = $this->language->get('error_amount');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', $this->route)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('sale/order');

		foreach ($this->request->post['selected'] as $voucher_id) {
			$order_voucher_info = $this->model_sale_order->getOrderVoucherByVoucherId($voucher_id);

			if ($order_voucher_info) {
				$this->error['warning'] = sprintf($this->language->get('error_order'), $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $order_voucher_info['order_id'], 'SSL')); 

				break;       
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function history() {
		$this->loadText ();

		$this->load->model($this->route);

		

		
		
		
		

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  

		$this->data['histories'] = array();

		$results = $this->model_sale_voucher->getVoucherHistories($this->request->get['voucher_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$this->data['histories'][] = array(
				'order_id'   => $result['order_id'],
				'customer'   => $result['customer'],
				'amount'     => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$history_total = $this->model_sale_voucher->getTotalVoucherHistories($this->request->get['voucher_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->url = $this->url->link('sale/voucher/history', 'token=' . $this->session->data['token'] . '&voucher_id=' . $this->request->get['voucher_id'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->initTpl('sale/voucher_history');		

		$this->response->setOutput($this->render());
	}

	public function send() {
		$this->loadText ();

		$json = array();

		if (!$this->user->hasPermission('modify', $this->route)) {
			$json['error'] = $this->language->get('error_permission');
		} elseif (isset($this->request->get['voucher_id'])) {
			$this->load->model($this->route);

			$this->model_sale_voucher->sendVoucher($this->request->get['voucher_id']);

			$json['success'] = $this->language->get('text_sent');
		}	

		$this->response->setOutput(json_encode($json));			
	}
}
?>