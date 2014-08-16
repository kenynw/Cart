<?php
class ControllerPaymentAmazonCheckout extends Controller {
	private $errors = array();
	private $route = 'payment/amazon_checkout';
	private function loadText($route = '') {
		if($route != ''){
			$this->loadLang ( $route );
		}else{
		$this->loadLang ( $this->route ); }
	}
	public function index() {
		$this->loadText ();
		$this->load->model('setting/setting');
		$this->load->model('localisation/geo_zone');
		$this->load->model('localisation/order_status');
		$this->load->model($this->route);
		 
		$this->load->library('cba');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->request->post['amazon_checkout_access_key'] = trim($this->request->post['amazon_checkout_access_key']);
			$this->request->post['amazon_checkout_access_secret'] = trim($this->request->post['amazon_checkout_access_secret']);
			$this->request->post['amazon_checkout_merchant_id'] = trim($this->request->post['amazon_checkout_merchant_id']);

			if (!isset($this->request->post['amazon_checkout_allowed_ips'])) {
				$this->request->post['amazon_checkout_allowed_ips'] = array();
			}

			$this->model_setting_setting->editSetting('amazon_checkout', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$access_key = $this->request->post['amazon_checkout_access_key'];
			$access_secret = $this->request->post['amazon_checkout_access_secret'];
			$merchant_id = $this->request->post['amazon_checkout_merchant_id'];
			$mode = $this->request->post['amazon_checkout_mode'];

			$cba = new CBA($merchant_id, $access_key, $access_secret);
			$cba->setMode($mode);

			$cba->scheduleReports();

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (isset($this->request->post['amazon_checkout_status'])) {
			$this->data['amazon_checkout_status'] = $this->request->post['amazon_checkout_status'];
		} elseif ($this->config->get('amazon_checkout_status')) {
			$this->data['amazon_checkout_status'] = $this->config->get('amazon_checkout_status');
		} else {
			$this->data['amazon_checkout_status'] = '0';
		}

		if (isset($this->request->post['amazon_checkout_mode'])) {
			$this->data['amazon_checkout_mode'] = $this->request->post['amazon_checkout_mode'];
		} elseif ($this->config->get('amazon_checkout_mode')) {
			$this->data['amazon_checkout_mode'] = $this->config->get('amazon_checkout_mode');
		} else {
			$this->data['amazon_checkout_mode'] = 'sandbox';
		}

		if (isset($this->request->post['amazon_checkout_sort_order'])) {
			$this->data['amazon_checkout_sort_order'] = $this->request->post['amazon_checkout_sort_order'];
		} elseif ($this->config->get('amazon_checkout_sort_order')) {
			$this->data['amazon_checkout_sort_order'] = $this->config->get('amazon_checkout_sort_order');
		} else {
			$this->data['amazon_checkout_sort_order'] = '0';
		}

		if (isset($this->request->post['amazon_checkout_geo_zone'])) {
			$this->data['amazon_checkout_geo_zone'] = $this->request->post['amazon_checkout_geo_zone'];
		} elseif ($this->config->get('amazon_checkout_geo_zone')) {
			$this->data['amazon_checkout_geo_zone'] = $this->config->get('amazon_checkout_geo_zone');
		} else {
			$this->data['amazon_checkout_geo_zone'] = '0';
		}

		if (isset($this->request->post['amazon_checkout_minimum_total'])) {
			$this->data['amazon_checkout_minimum_total'] = $this->request->post['amazon_checkout_minimum_total'];
		} elseif ($this->config->get('amazon_checkout_minimum_total')) {
			$this->data['amazon_checkout_minimum_total'] = $this->config->get('amazon_checkout_minimum_total');
		} else {
			$this->data['amazon_checkout_minimum_total'] = '0.00';
		}

		if (isset($this->request->post['amazon_checkout_access_key'])) {
			$this->data['amazon_checkout_access_key'] = $this->request->post['amazon_checkout_access_key'];
		} elseif ($this->config->get('amazon_checkout_access_key')) {
			$this->data['amazon_checkout_access_key'] = $this->config->get('amazon_checkout_access_key');
		} else {
			$this->data['amazon_checkout_access_key'] = '';
		}

		if (isset($this->request->post['amazon_checkout_access_secret'])) {
			$this->data['amazon_checkout_access_secret'] = $this->request->post['amazon_checkout_access_secret'];
		} elseif ($this->config->get('amazon_checkout_access_secret')) {
			$this->data['amazon_checkout_access_secret'] = $this->config->get('amazon_checkout_access_secret');
		} else {
			$this->data['amazon_checkout_access_secret'] = '';
		}

		if (isset($this->request->post['amazon_checkout_merchant_id'])) {
			$this->data['amazon_checkout_merchant_id'] = $this->request->post['amazon_checkout_merchant_id'];
		} elseif ($this->config->get('amazon_checkout_merchant_id')) {
			$this->data['amazon_checkout_merchant_id'] = $this->config->get('amazon_checkout_merchant_id');
		} else {
			$this->data['amazon_checkout_merchant_id'] = '';
		}

		if (isset($this->request->post['amazon_checkout_marketplace'])) {
			$this->data['amazon_checkout_marketplace'] = $this->request->post['amazon_checkout_marketplace'];
		} elseif ($this->config->get('amazon_checkout_marketplace')) {
			$this->data['amazon_checkout_marketplace'] = $this->config->get('amazon_checkout_marketplace');
		} else {
			$this->data['amazon_checkout_marketplace'] = 'uk';
		}

		if (isset($this->request->post['amazon_checkout_order_default_status'])) {
			$this->data['amazon_checkout_order_default_status'] = $this->request->post['amazon_checkout_order_default_status'];
		} elseif ($this->config->get('amazon_checkout_order_default_status')) {
			$this->data['amazon_checkout_order_default_status'] = $this->config->get('amazon_checkout_order_default_status');
		} else {
			$this->data['amazon_checkout_order_default_status'] = '0';
		}

		if (isset($this->request->post['amazon_checkout_order_ready_status'])) {
			$this->data['amazon_checkout_order_ready_status'] = $this->request->post['amazon_checkout_order_ready_status'];
		} elseif ($this->config->get('amazon_checkout_order_ready_status')) {
			$this->data['amazon_checkout_order_ready_status'] = $this->config->get('amazon_checkout_order_ready_status');
		} else {
			$this->data['amazon_checkout_order_ready_status'] = '0';
		}

		if (isset($this->request->post['amazon_checkout_order_canceled_status'])) {
			$this->data['amazon_checkout_order_canceled_status'] = $this->request->post['amazon_checkout_order_canceled_status'];
		} elseif ($this->config->get('amazon_checkout_order_canceled_status')) {
			$this->data['amazon_checkout_order_canceled_status'] = $this->config->get('amazon_checkout_order_canceled_status');
		} else {
			$this->data['amazon_checkout_order_canceled_status'] = 'amazon_checkout_order_canceled_status';
		}

		if (isset($this->request->post['amazon_checkout_order_shipped_status'])) {
			$this->data['amazon_checkout_order_shipped_status'] = $this->request->post['amazon_checkout_order_shipped_status'];
		} elseif ($this->config->get('amazon_checkout_order_shipped_status')) {
			$this->data['amazon_checkout_order_shipped_status'] = $this->config->get('amazon_checkout_order_shipped_status');
		} else {
			$this->data['amazon_checkout_order_shipped_status'] = '0';
		}

		if (isset($this->request->post['amazon_checkout_allowed_ips'])) {
			$this->data['amazon_checkout_allowed_ips'] = $this->request->post['amazon_checkout_allowed_ips'];
		} elseif ($this->config->get('amazon_checkout_allowed_ips')) {
			$this->data['amazon_checkout_allowed_ips'] = $this->config->get('amazon_checkout_allowed_ips');
		} else {
			$this->data['amazon_checkout_allowed_ips'] = array();
		}

		if (isset($this->request->post['amazon_checkout_button_colour'])) {
			$this->data['amazon_checkout_button_colour'] = $this->request->post['amazon_checkout_button_colour'];
		} elseif ($this->config->get('amazon_checkout_button_colour')) {
			$this->data['amazon_checkout_button_colour'] = $this->config->get('amazon_checkout_button_colour');
		} else {
			$this->data['amazon_checkout_button_colour'] = 'orange';
		}

		if (isset($this->request->post['amazon_checkout_button_size'])) {
			$this->data['amazon_checkout_button_size'] = $this->request->post['amazon_checkout_button_size'];
		} elseif ($this->config->get('amazon_checkout_button_size')) {
			$this->data['amazon_checkout_button_size'] = $this->config->get('amazon_checkout_button_size');
		} else {
			$this->data['amazon_checkout_button_size'] = 'large';
		}

		if (isset($this->request->post['amazon_checkout_button_background'])) {
			$this->data['amazon_checkout_button_background'] = $this->request->post['amazon_checkout_button_background'];
		} elseif ($this->config->get('amazon_checkout_button_background')) {
			$this->data['amazon_checkout_button_background'] = $this->config->get('amazon_checkout_button_background');
		} else {
			$this->data['amazon_checkout_button_background'] = '';
		}

		if (isset($this->request->post['amazon_checkout_cron_job_token'])) {
			$this->data['amazon_checkout_cron_job_token'] = $this->request->post['amazon_checkout_cron_job_token'];
		} elseif ($this->config->get('amazon_checkout_cron_job_token')) {
			$this->data['amazon_checkout_cron_job_token'] = $this->config->get('amazon_checkout_cron_job_token');
		} else {
			$this->data['amazon_checkout_cron_job_token'] = sha1(uniqid(mt_rand(), 1));
		}

		$this->data['cron_job_url'] = HTTPS_CATALOG . 'index.php?route=payment/amazon_checkout/cron&token=' . $this->data['amazon_checkout_cron_job_token'];

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		
		

		
		
		
		
		
		
		
		
		
		
		
		

		

		$this->data['last_cron_job_run'] = $this->config->get('amazon_checkout_last_cron_job_run');

		

		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->data['errors'] = $this->errors;
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token']);

		$this->data['button_colours'] = array(
			'orange' => $this->language->get('text_orange'),
			'tan' => $this->language->get('text_tan')
		);

		$this->data['button_backgrounds'] = array(
			'white' => $this->language->get('text_white'),
			'light' => $this->language->get('text_light'),
			'dark' => $this->language->get('text_dark'),
		);

		$this->data['button_sizes'] = array(
			'medium' => $this->language->get('text_medium'),
			'large' => $this->language->get('text_large'),
			'x-large' => $this->language->get('text_x_large'),
		);

		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->initTpl($this->route);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->load->model($this->route);
		$this->load->model('setting/setting');
		$this->model_payment_amazon_checkout->install();
		$this->model_setting_setting->editSetting('amazon_checkout', $this->settings);
	}

	public function uninstall() {
		$this->load->model($this->route);
		$this->model_payment_amazon_checkout->uninstall();
	}

	public function template() {
		$file = DIR_SYSTEM . 'AmazonOrderAdjustmentTemplate.xls';

		header('Content-Type: application/octet-stream');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename=AmazonOrderAdjustmentTemplate.xls');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));

		readfile($file, 'rb');
	}

	public function uploadOrderAdjustment() {
		$this->loadText ($this->route);
		

		$json = array();

		if (!empty($this->request->files['file']['name'])) {
			$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload');
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		if (!isset($json['error'])) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$flat = str_replace(",", "\t", file_get_contents($this->request->files['file']['tmp_name']));

				$this->load->library('cba');

				$cba = new CBA($this->config->get('amazon_checkout_merchant_id'), $this->config->get('amazon_checkout_access_key'),
						$this->config->get('amazon_checkout_access_secret'));

				$response = $cba->orderAdjustment($flat);

				$response_xml = simplexml_load_string($response);
				$submission_id = (string)$response_xml->SubmitFeedResult->FeedSubmissionInfo->FeedSubmissionId;

				if (!empty($submission_id)) {
					$json['success'] = $this->language->get('text_upload_success');
					$json['submission_id'] = $submission_id;
				}
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function addSubmission() {
		$this->load->model($this->route);

		$order_id = $this->request->get['order_id'];
		$feed_submission_id = $this->request->get['submission_id'];

		$this->model_payment_amazon_checkout->addReportSubmission($order_id, $feed_submission_id);
	}

	public function orderAction() {
		$this->load->model('sale/order');
		$this->load->model($this->route);
		$this->loadText ('sale/order');
		$this->loadText ();
		

		$this->document->addScript('view/javascript/jquery/ajaxupload.js');

		$order_id = $this->request->get['order_id'];
		$amazon_order_info = $this->model_payment_amazon_checkout->getOrder($order_id);

		if ($amazon_order_info) {
			$order_products = $this->model_sale_order->getOrderProducts($order_id);
			$order_info = $this->model_sale_order->getOrder($order_id);

			$this->data['products'] = array();

			foreach ($order_products as $product) {
				$product_options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

				$order_item_code = '';

				if (isset($amazon_order_info['products'][$product['order_product_id']])) {
					$order_item_code = $amazon_order_info['products'][$product['order_product_id']]['amazon_order_item_code'];
				}

				$this->data['products'][] = array(
					'amazon_order_item_code' => $order_item_code,
					'order_product_id' => $product['order_product_id'],
					'product_id' => $product['product_id'],
					'name' => $product['name'],
					'model' => $product['model'],
					'option' => $product_options,
					'quantity' => $product['quantity'],
					'price' => $this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value']),
					'total' => $this->currency->format($product['total'], $order_info['currency_code'], $order_info['currency_value']),
					'href' => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], 'SSL')
				);
			}

			$this->data['report_submissions'] = $this->model_payment_amazon_checkout->getReportSubmissions($order_id);

			
			
			
			
			

			
			
			
			
			
			
			
			
			

			
			$this->data['text_download'] = sprintf($this->language->get('text_download'), $this->url->link('payment/amazon_checkout/template', 'token=' . $this->session->data['token'], 'SSL'));

			$this->data['amazon_order_id'] = $amazon_order_info['amazon_order_id'];

			$this->data['token'] = $this->session->data['token'];
			$this->data['order_id'] = $order_id;

		$this->initTpl('payment/amazon_checkout_order');
			$this->response->setOutput($this->render());
		}
	}

	protected function validate() {
		$this->load->model('localisation/currency');

		if (!$this->user->hasPermission('modify', $this->route)) {
			$this->errors[] = $this->language->get('error_permission');
		}

		if (empty($this->request->post['amazon_checkout_merchant_id'])) {
			$this->errors[] = $this->language->get('error_empty_merchant_id');
		}

		if (empty($this->request->post['amazon_checkout_access_key'])) {
			$this->errors[] = $this->language->get('error_empty_access_key');
		}

		if (empty($this->request->post['amazon_checkout_access_secret'])) {
			$this->errors[] = $this->language->get('error_empty_access_secret');
		}

		switch ($this->request->post['amazon_checkout_marketplace']) {
			case 'uk':
				$currency_code = 'GBP';
				break;

			case 'de':
				$currency_code = 'EUR';
				break;
		}

		$currency = $this->model_localisation_currency->getCurrency($this->currency->getId($currency_code));

		if (empty($currency) || $currency['status'] != '1') {
			$this->errors[] = sprintf($this->language->get('error_curreny'), $currency_code);
		}

		return empty($this->errors);
	}
}
?>