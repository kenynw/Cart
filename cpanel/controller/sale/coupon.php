<?php  
class ControllerSaleCoupon extends Controller {
	
	private $route = 'sale/coupon';
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
			$this->model_sale_coupon->addCoupon($this->request->post);

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

			$this->redirect($this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->loadText ();
		

		

		$this->load->model($this->route);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_coupon->editCoupon($this->request->get['coupon_id'], $this->request->post);

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

			$this->redirect($this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->loadText ();
		

		

		$this->load->model($this->route);

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $coupon_id) {
				$this->model_sale_coupon->deleteCoupon($coupon_id);
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

			$this->redirect($this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
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

		

		$this->data['insert'] = $this->url->link('sale/coupon/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/coupon/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['coupons'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$coupon_total = $this->model_sale_coupon->getTotalCoupons();

		$results = $this->model_sale_coupon->getCoupons($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/coupon/update', 'token=' . $this->session->data['token'] . '&coupon_id=' . $result['coupon_id'] . $url, 'SSL')
			);

			$this->data['coupons'][] = array(
				'coupon_id'  => $result['coupon_id'],
				'name'       => $result['name'],
				'code'       => $result['code'],
				'discount'   => $result['discount'],
				'date_start' => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
				'date_end'   => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['coupon_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}

		

		

		
		
		
		
		
		
				

		
		

		

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

		$this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=name' . $url;
		$this->data['sort_code'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=code' . $url;
		$this->data['sort_discount'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=discount' . $url;
		$this->data['sort_date_start'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=date_start' . $url;
		$this->data['sort_date_end'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=date_end' . $url;
		$this->data['sort_status'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=status' . $url;

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $coupon_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . $url . '&page={page}';

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->initNotice();
		$this->initTpl('sale/coupon_list');
		$this->children = array(
			'common/header',	
			'common/footer'	
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		

		
		
		
		
		
		

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		
		

		
		

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['coupon_id'])) {
			$this->data['coupon_id'] = $this->request->get['coupon_id'];
		} else {
			$this->data['coupon_id'] = 0;
		}

		

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}		

		if (isset($this->error['date_start'])) {
			$this->data['error_date_start'] = $this->error['date_start'];
		} else {
			$this->data['error_date_start'] = '';
		}	

		if (isset($this->error['date_end'])) {
			$this->data['error_date_end'] = $this->error['date_end'];
		} else {
			$this->data['error_date_end'] = '';
		}	

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		
		if (!isset($this->request->get['coupon_id'])) {
			$this->data['action'] = $this->url->link('sale/coupon/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/coupon/update', 'token=' . $this->session->data['token'] . '&coupon_id=' . $this->request->get['coupon_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['coupon_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
			$coupon_info = $this->model_sale_coupon->getCoupon($this->request->get['coupon_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($coupon_info)) {
			$this->data['name'] = $coupon_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['code'])) {
			$this->data['code'] = $this->request->post['code'];
		} elseif (!empty($coupon_info)) {
			$this->data['code'] = $coupon_info['code'];
		} else {
			$this->data['code'] = '';
		}

		if (isset($this->request->post['type'])) {
			$this->data['type'] = $this->request->post['type'];
		} elseif (!empty($coupon_info)) {
			$this->data['type'] = $coupon_info['type'];
		} else {
			$this->data['type'] = '';
		}

		if (isset($this->request->post['discount'])) {
			$this->data['discount'] = $this->request->post['discount'];
		} elseif (!empty($coupon_info)) {
			$this->data['discount'] = $coupon_info['discount'];
		} else {
			$this->data['discount'] = '';
		}

		if (isset($this->request->post['logged'])) {
			$this->data['logged'] = $this->request->post['logged'];
		} elseif (!empty($coupon_info)) {
			$this->data['logged'] = $coupon_info['logged'];
		} else {
			$this->data['logged'] = '';
		}

		if (isset($this->request->post['shipping'])) {
			$this->data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($coupon_info)) {
			$this->data['shipping'] = $coupon_info['shipping'];
		} else {
			$this->data['shipping'] = '';
		}

		if (isset($this->request->post['total'])) {
			$this->data['total'] = $this->request->post['total'];
		} elseif (!empty($coupon_info)) {
			$this->data['total'] = $coupon_info['total'];
		} else {
			$this->data['total'] = '';
		}

		if (isset($this->request->post['coupon_product'])) {
			$products = $this->request->post['coupon_product'];
		} elseif (isset($this->request->get['coupon_id'])) {		
			$products = $this->model_sale_coupon->getCouponProducts($this->request->get['coupon_id']);
		} else {
			$products = array();
		}

		$this->load->model('catalog/product');

		$this->data['coupon_product'] = array();

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct_($product_id);

			if ($product_info) {
				$this->data['coupon_product'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}

		if (isset($this->request->post['coupon_category'])) {
			$categories = $this->request->post['coupon_category'];
		} elseif (isset($this->request->get['coupon_id'])) {		
			$categories = $this->model_sale_coupon->getCouponCategories($this->request->get['coupon_id']);
		} else {
			$categories = array();
		}

		$this->load->model('catalog/category');

		$this->data['coupon_category'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory_($category_id);

			if ($category_info) {
				$this->data['coupon_category'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']
				);
			}
		}

		if (isset($this->request->post['date_start'])) {
			$this->data['date_start'] = $this->request->post['date_start'];
		} elseif (!empty($coupon_info)) {
			$this->data['date_start'] = date('Y-m-d', strtotime($coupon_info['date_start']));
		} else {
			$this->data['date_start'] = date('Y-m-d', time());
		}

		if (isset($this->request->post['date_end'])) {
			$this->data['date_end'] = $this->request->post['date_end'];
		} elseif (!empty($coupon_info)) {
			$this->data['date_end'] = date('Y-m-d', strtotime($coupon_info['date_end']));
		} else {
			$this->data['date_end'] = date('Y-m-d', time());
		}

		if (isset($this->request->post['uses_total'])) {
			$this->data['uses_total'] = $this->request->post['uses_total'];
		} elseif (!empty($coupon_info)) {
			$this->data['uses_total'] = $coupon_info['uses_total'];
		} else {
			$this->data['uses_total'] = 1;
		}

		if (isset($this->request->post['uses_customer'])) {
			$this->data['uses_customer'] = $this->request->post['uses_customer'];
		} elseif (!empty($coupon_info)) {
			$this->data['uses_customer'] = $coupon_info['uses_customer'];
		} else {
			$this->data['uses_customer'] = 1;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($coupon_info)) {
			$this->data['status'] = $coupon_info['status'];
		} else {
			$this->data['status'] = 1;
		}
		$this->initNotice();
		$this->initTpl('sale/coupon_form');
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

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['code']) < 3) || (utf8_strlen($this->request->post['code']) > 10)) {
			$this->error['code'] = $this->language->get('error_code');
		}

		$coupon_info = $this->model_sale_coupon->getCouponByCode($this->request->post['code']);

		if ($coupon_info) {
			if (!isset($this->request->get['coupon_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			} elseif ($coupon_info['coupon_id'] != $this->request->get['coupon_id'])  {
				$this->error['warning'] = $this->language->get('error_exists');
			}
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

		$results = $this->model_sale_coupon->getCouponHistories($this->request->get['coupon_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$this->data['histories'][] = array(
				'order_id'   => $result['order_id'],
				'customer'   => $result['customer'],
				'amount'     => $result['amount'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$history_total = $this->model_sale_coupon->getTotalCouponHistories($this->request->get['coupon_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->url = $this->url->link('sale/coupon/history', 'token=' . $this->session->data['token'] . '&coupon_id=' . $this->request->get['coupon_id'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->initTpl('sale/coupon_history');		

		$this->response->setOutput($this->render());
	}
}
?>