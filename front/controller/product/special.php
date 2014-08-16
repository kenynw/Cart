<?php
class ControllerProductSpecial extends Controller {
	private $route = 'product/special';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		$this->loadModel('catalog/product');
		$rsp = new ModelCatalogProduct($this->registry);
		$this->loadModel('tool/image');
		$rsi = new ModelToolImage($this->registry);

		if (isset ( $this->request->get ['sort'] )) {
			$sort = $this->request->get ['sort'];
		} else {
			$sort = 'p.sort_order';
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
		if (isset ( $this->request->get ['limit'] )) {
			$limit = $this->request->get ['limit'];
		} else {
			$limit = $this->config->get ( 'config_catalog_limit' );
		}
		$this->document->addScript ( 'catalog/view/javascript/jquery/jquery.total-storage.min.js' );
		$this->data ['breadcrumbs'] = array ();
		$this->data ['breadcrumbs'] [] = array ( 'text' => $this->language->get ( 'text_home' ), 'href' => $this->url->link ( 'common/home' ), 'separator' => false );
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
		if (isset ( $this->request->get ['limit'] )) {
			$url .= '&limit=' . $this->request->get ['limit'];
		}
		$this->data ['breadcrumbs'] [] = array ( 'text' => $this->language->get ( 'heading_title' ), 'href' => $this->url->link ( 'product/special', $url ), 'separator' => $this->language->get ( 'text_separator' ) );
		$this->data ['text_compare'] = sprintf ( $this->language->get ( 'text_compare' ), (isset ( $this->session->data ['compare'] ) ? count ( $this->session->data ['compare'] ) : 0) );
		$this->data ['compare'] = $this->url->link ( 'product/compare' );
		$this->data ['products'] = array ();
		$data = array ( 'sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $limit, 'limit' => $limit );
		$product_total = $rsp->getTotalProductSpecials ( $data );
		$results = $rsp->getProductSpecials ( $data );
		foreach ( $results as $result ) {
			if ($result ['image']) {
				$image = $rsi->resize ( $result ['image'], $this->config->get ( 'config_image_product_width' ), $this->config->get ( 'config_image_product_height' ) );
			} else {
				$image = false;
			}
			if (($this->config->get ( 'config_customer_price' ) && $this->customer->isLogged ()) || ! $this->config->get ( 'config_customer_price' )) {
				$price = $this->currency->format ( $this->tax->calculate ( $result ['price'], $result ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
			} else {
				$price = false;
			}
			if (( float ) $result ['special']) {
				$special = $this->currency->format ( $this->tax->calculate ( $result ['special'], $result ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
			} else {
				$special = false;
			}
			if ($this->config->get ( 'config_tax' )) {
				$tax = $this->currency->format ( ( float ) $result ['special'] ? $result ['special'] : $result ['price'] );
			} else {
				$tax = false;
			}
			if ($this->config->get ( 'config_review_status' )) {
				$rating = ( int ) $result ['rating'];
			} else {
				$rating = false;
			}
			$this->data ['products'] [] = array ( 'product_id' => $result ['product_id'], 'thumb' => $image, 'name' => $result ['name'], 'description' => utf8_substr ( strip_tags ( html_entity_decode ( $result ['description'], ENT_QUOTES, 'UTF-8' ) ), 0, 100 ) . '..', 'price' => $price, 'special' => $special, 'tax' => $tax, 'rating' => $result ['rating'], 'reviews' => sprintf ( $this->language->get ( 'text_reviews' ), ( int ) $result ['reviews'] ), 'href' => $this->url->link ( 'product/product', 'product_id=' . $result ['product_id'] . $url ) );
		}
		$url = '';
		if (isset ( $this->request->get ['limit'] )) {
			$url .= '&limit=' . $this->request->get ['limit'];
		}
		$this->data ['sorts'] = array ();
		$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_default' ), 'value' => 'p.sort_order-ASC', 'href' => $this->url->link ( 'product/special', 'sort=p.sort_order&order=ASC' . $url ) );
		$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_name_asc' ), 'value' => 'pd.name-ASC', 'href' => $this->url->link ( 'product/special', 'sort=pd.name&order=ASC' . $url ) );
		$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_name_desc' ), 'value' => 'pd.name-DESC', 'href' => $this->url->link ( 'product/special', 'sort=pd.name&order=DESC' . $url ) );
		$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_price_asc' ), 'value' => 'ps.price-ASC', 'href' => $this->url->link ( 'product/special', 'sort=ps.price&order=ASC' . $url ) );
		$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_price_desc' ), 'value' => 'ps.price-DESC', 'href' => $this->url->link ( 'product/special', 'sort=ps.price&order=DESC' . $url ) );
		if ($this->config->get ( 'config_review_status' )) {
			$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_rating_desc' ), 'value' => 'rating-DESC', 'href' => $this->url->link ( 'product/special', 'sort=rating&order=DESC' . $url ) );
			$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_rating_asc' ), 'value' => 'rating-ASC', 'href' => $this->url->link ( 'product/special', 'sort=rating&order=ASC' . $url ) );
		}
		$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_model_asc' ), 'value' => 'p.model-ASC', 'href' => $this->url->link ( 'product/special', 'sort=p.model&order=ASC' . $url ) );
		$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_model_desc' ), 'value' => 'p.model-DESC', 'href' => $this->url->link ( 'product/special', 'sort=p.model&order=DESC' . $url ) );
		$url = '';
		if (isset ( $this->request->get ['sort'] )) {
			$url .= '&sort=' . $this->request->get ['sort'];
		}
		if (isset ( $this->request->get ['order'] )) {
			$url .= '&order=' . $this->request->get ['order'];
		}
		$this->data ['limits'] = array ();
		$limits = array_unique ( array ( $this->config->get ( 'config_catalog_limit' ), 25, 50, 75, 100 ) );
		sort ( $limits );
		foreach ( $limits as $value ) {
			$this->data ['limits'] [] = array ( 'text' => $value, 'value' => $value, 'href' => $this->url->link ( 'product/special', $url . '&limit=' . $value ) );
		}
		$url = '';
		if (isset ( $this->request->get ['sort'] )) {
			$url .= '&sort=' . $this->request->get ['sort'];
		}
		if (isset ( $this->request->get ['order'] )) {
			$url .= '&order=' . $this->request->get ['order'];
		}
		if (isset ( $this->request->get ['limit'] )) {
			$url .= '&limit=' . $this->request->get ['limit'];
		}
		$pagination = new Pagination ();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get ( 'text_pagination' );
		$pagination->url = $this->url->link ( 'product/special', $url . '&page={page}' );
		$this->data ['pagination'] = $pagination->render ();
		$this->data ['sort'] = $sort;
		$this->data ['order'] = $order;
		$this->data ['limit'] = $limit;
		$this->initTpl ( $this->route );
		$this->children = array ( 'common/column_left', 'common/column_right', 'common/content_top', 'common/content_bottom', 'common/footer', 'common/header' );
		$this->response->setOutput ( $this->render () );
	}
}
?>