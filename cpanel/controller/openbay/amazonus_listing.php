<?php
class ControllerOpenbayAmazonusListing extends Controller{
	private $route = 'openbay/amazonus_listing';
	public function create() {
		$this->load->language($this->route);
		$this->load->model($this->route);
		$this->load->model('openbay/amazonus');
		$this->load->model('catalog/product');
		$this->load->model('localisation/country');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_price_to'])) {
			$url .= '&filter_price_to=' . $this->request->get['filter_price_to'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_quantity_to'])) {
			$url .= '&filter_quantity_to=' . $this->request->get['filter_quantity_to'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . $this->request->get['filter_sku'];
		}

		if (isset($this->request->get['filter_desc'])) {
			$url .= '&filter_desc=' . $this->request->get['filter_desc'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if ($this->request->post) {
			$product = $this->request->post;
			if (isset($product['option_variant'])) {
				$variant = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_relation` WHERE `var` = '" . $this->db->escape((string)$product['option_variant']) . "' AND `product_id` = '".(int)$product['product_id']."' LIMIT 1")->row;
				$product['var'] = $product['option_variant'];
				$product['quantity'] = $variant['stock'];
			} else {
				$product_info = $this->model_catalog_product->getProduct_($product['product_id']);
				$product['var'] = '';
				$product['quantity'] = $product_info['quantity'];
			}

			$result = $this->model_openbay_amazonus_listing->simpleListing($product);

			if($result['status'] === 1) {
				$this->session->data['success'] = $this->language->get('text_product_sent');
				$this->redirect($this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			} else {
				$this->session->data['error'] = sprintf($this->language->get('text_product_not_sent'), $result['message']);
				$this->redirect($this->url->link('openbay/amazonus_listing/create', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->post['product_id'] . $url, 'SSL'));
			}
		}

		if (isset($this->request->get['product_id'])) {
			$product_info = $this->model_catalog_product->getProduct_($this->request->get['product_id']);

			if(empty($product_info)) {
				$this->redirect($this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}

			if($this->openbay->addonLoad('openstock') == true) {
				$this->load->model('openstock/openstock');
				$this->load->model('tool/image');
				$this->data['options'] = $this->model_openstock_openstock->getProductOptionStocks($this->request->get['product_id']);
			} else {
				$this->data['options'] = array();
			}

			$listing_status = $this->model_openbay_amazonus->getProductStatus($this->request->get['product_id']);

			if($listing_status === 'processing' || $listing_status === 'ok') {
				$this->redirect($this->url->link('openbay/amazonus_listing/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, 'SSL'));
			} else if ($listing_status === 'error_advanced' || $listing_status === 'saved' || $listing_status === 'error_few') {
				$this->redirect($this->url->link('openbay/amazonus_product', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, 'SSL'));
			}
		} else {
			$this->redirect($this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->document->setTitle($this->language->get('lang_title'));
		$this->document->addStyle('view/stylesheet/openbay.css');
		$this->document->addScript('view/javascript/openbay/faq.js');

		$this->initTpl($this->route);

		$this->children = array(
			'common/header',
			'common/footer'
		);

		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}

		$this->data['url_return']  = $this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['url_search']  = $this->url->link('openbay/amazonus_listing/search', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_advanced']  = $this->url->link('openbay/amazonus_product', 'token=' . $this->session->data['token'] . '&product_id='.$this->request->get['product_id'] . $url, 'SSL');
		$this->data['form_action'] = $this->url->link('openbay/amazonus_listing/create', 'token=' . $this->session->data['token'], 'SSL');

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		$this->data['sku'] = trim($product_info['sku']);

		if ($this->config->get('openbay_amazonus_listing_tax_added')) {
				$this->data['price'] = $product_info['price'] * (1 + $this->config->get('openbay_amazonus_listing_tax_added') / 100);
			} else {
				$this->data['price'] = $product_info['price'];
			}

		$this->data['listing_errors'] = array();

		if ($listing_status == 'error_quick') {
			$this->data['listing_errors'] = $this->model_openbay_amazonus->getProductErrors($product_info['product_id'], 3);
		}

		$this->data['price'] = number_format($this->data['price'], 2);
		$this->data['quantity'] = $product_info['quantity'];
		$this->data['product_id'] = $product_info['product_id'];

		$this->data['conditions'] = array(
			'New' => $this->language->get('text_new'),
			'UsedLikeNew' => $this->language->get('text_used_like_new'),
			'UsedVeryGood' => $this->language->get('text_used_very_good'),
			'UsedGood' => $this->language->get('text_used_good'),
			'UsedAcceptable' => $this->language->get('text_used_acceptable'),
			'CollectibleLikeNew' => $this->language->get('text_collectible_like_new'),
			'CollectibleVeryGood' => $this->language->get('text_collectible_very_good'),
			'CollectibleGood' => $this->language->get('text_collectible_good'),
			'CollectibleAcceptable' => $this->language->get('text_collectible_acceptable'),
			'Refurbished' => $this->language->get('text_refurbished'),
		);

		$this->data['default_condition'] = $this->config->get('openbay_amazonus_listing_default_condition');

		$this->data['token'] = $this->session->data['token'];

		

		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	public function edit() {
		$this->load->model($this->route);
		$this->load->model('openbay/amazonus');
		$this->load->language($this->route);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_price_to'])) {
			$url .= '&filter_price_to=' . $this->request->get['filter_price_to'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_quantity_to'])) {
			$url .= '&filter_quantity_to=' . $this->request->get['filter_quantity_to'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . $this->request->get['filter_sku'];
		}

		if (isset($this->request->get['filter_desc'])) {
			$url .= '&filter_desc=' . $this->request->get['filter_desc'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$this->redirect($this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$status = $this->model_openbay_amazonus->getProductStatus($product_id);

		//If product was not submited/saved for Amazonus
		if($status === false) {
			$this->redirect($this->url->link('openbay/amazonus_listing/create', 'token=' . $this->session->data['token'] . '&product_id=' . $product_id . $url, 'SSL'));
			return;
		}

		$this->data['product_links'] = $this->model_openbay_amazonus->getProductLinks($product_id);
		$this->data['url_return']  = $this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'] . $url, 'SSL');
		if($status == 'ok' || $status == 'linked') {
			$this->data['url_create_new']  = $this->url->link('openbay/amazonus_listing/createNew', 'token=' . $this->session->data['token'] . '&product_id=' . $product_id . $url, 'SSL');
			$this->data['url_delete_links']  = $this->url->link('openbay/amazonus_listing/deleteLinks', 'token=' . $this->session->data['token'] . '&product_id=' . $product_id . $url, 'SSL');
		}

		if($status == 'saved') {
			$this->data['has_saved_listings'] = true;
		} else {
			$this->data['has_saved_listings'] = false;
		}

		$this->data['url_saved_listings']  = $this->url->link('openbay/amazonus/savedListings', 'token=' . $this->session->data['token'] . '&product_id=' . $product_id, 'SSL');


		$this->data['token'] = $this->session->data['token'];

		
		
		

		

		
		
		
		

		
		
		
		
		
		
		

		$this->initTpl('openbay/amazonus_listing_edit');
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render());
	}

	public function createNew() {
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_price_to'])) {
			$url .= '&filter_price_to=' . $this->request->get['filter_price_to'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_quantity_to'])) {
			$url .= '&filter_quantity_to=' . $this->request->get['filter_quantity_to'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . $this->request->get['filter_sku'];
		}

		if (isset($this->request->get['filter_desc'])) {
			$url .= '&filter_desc=' . $this->request->get['filter_desc'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$this->redirect($this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->load->model('openbay/amazonus');
		$this->model_openbay_amazonus->deleteProduct($product_id);
		$this->redirect($this->url->link('openbay/amazonus_listing/create', 'token=' . $this->session->data['token'] . '&product_id=' . $product_id . $url, 'SSL'));
	}

	public function deleteLinks() {
		$this->load->language($this->route);
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_price_to'])) {
			$url .= '&filter_price_to=' . $this->request->get['filter_price_to'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_quantity_to'])) {
			$url .= '&filter_quantity_to=' . $this->request->get['filter_quantity_to'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . $this->request->get['filter_sku'];
		}

		if (isset($this->request->get['filter_desc'])) {
			$url .= '&filter_desc=' . $this->request->get['filter_desc'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$this->redirect($this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->load->model('openbay/amazonus');

		$links = $this->model_openbay_amazonus->getProductLinks($product_id);
		foreach ($links as $link) {
			$this->model_openbay_amazonus->removeProductLink($link['amazonus_sku']);
		}
		$this->model_openbay_amazonus->deleteProduct($product_id);
		$this->session->data['success'] = $this->language->get('text_links_removed');

		$this->redirect($this->url->link('extension/openbay/itemList', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}

	public function search() {


		$this->load->model($this->route);
		$this->load->language($this->route);

		$error = '';

		if (empty($this->request->post['search_string'])) {
			$error = $this->language->get('error_text_missing');
		}

		if ($error) {
			$response = array(
				'data' => '',
				'error' => $error,
			);
		} else {
			$response = array(
				'data' => $this->model_openbay_amazonus_listing->search($this->request->post['search_string']),
				'error' => '',
			);
		}

		$this->response->setOutput(json_encode($response));
	}

	public function bestPrice() {


		$this->load->model($this->route);
		$this->load->language($this->route);

		$error = '';

		if (empty($this->request->post['asin'])) {
			$error = $this->language->get('error_missing_asin');
		}

		if (empty($this->request->post['condition'])) {
			$error = $this->language->get('error_condition_missing');
		}

		if ($error) {
			$response = array(
				'data' => '',
				'error' => $error,
			);
		} else {
			$bestPrice = $this->model_openbay_amazonus_listing->getBestPrice($this->request->post['asin'], $this->request->post['condition']);

			if ($bestPrice) {
				$response = array(
					'data' => $bestPrice,
					'error' => '',
				);
			} else {
				$response = array(
					'data' => '',
					'error' => $this->language->get('error_amazonus_price'),
				);
			}
		}

		$this->response->setOutput(json_encode($response));
	}

	public function getProductByAsin() {


		$this->load->model($this->route);

		$data = $this->model_openbay_amazonus_listing->getProductByAsin($this->request->post['asin']);

		$response = array(
			'title' => (string)$data['ItemAttributes']['Title'],
			'img' => (!isset($data['ItemAttributes']['SmallImage']['URL']) ? '' : $data['ItemAttributes']['SmallImage']['URL'])
		);

		$this->response->setOutput(json_encode($response));
	}

	public function getBrowseNodes() {
		$this->load->model($this->route);

		$data = array(
			'node' => (isset($this->request->post['node']) ? $this->request->post['node'] : ''),
		);

		$response = $this->model_openbay_amazonus_listing->getBrowseNodes($data);

		$this->response->setOutput($response);
	}
}
?>