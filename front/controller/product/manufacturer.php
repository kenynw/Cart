<?php
class ControllerProductManufacturer extends Controller {
	private $route = 'product/manufacturer';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		$this->loadModel ( 'catalog/manufacturer' );
		$rsm = new ModelCatalogManufacturer ( $this->registry );
		$this->loadModel ( 'tool/image' );
		$rsi = new ModelToolImage ( $this->registry );		
		$this->data ['breadcrumbs'] = array ();
		$this->data ['breadcrumbs'] [] = array ( 'text' => $this->language->get ( 'text_home' ), 'href' => $this->url->link ( 'common/home' ), 'separator' => false );
		$this->data ['breadcrumbs'] [] = array ( 'text' => $this->language->get ( 'text_brand' ), 'href' => $this->url->link ( 'product/manufacturer' ), 'separator' => $this->language->get ( 'text_separator' ) );
		$this->data ['categories'] = array ();
		$results = $rsm->getManufacturers ();
		foreach ( $results as $result ) {
			if (is_numeric ( utf8_substr ( $result ['name'], 0, 1 ) )) {
				$key = '0 - 9';
			} else {
				$key = utf8_substr ( utf8_strtoupper ( $result ['name'] ), 0, 1 );
			}
			if (! isset ( $this->data ['manufacturers'] [$key] )) {
				$this->data ['categories'] [$key] ['name'] = $key;
			}
			$this->data ['categories'] [$key] ['manufacturer'] [] = array ( 'name' => $result ['name'], 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $result ['manufacturer_id'] ) );
		}
		$this->data ['continue'] = $this->url->link ( 'common/home' );
		$this->initTpl ( 'product/manufacturer_list' );
		$this->children = array ( 'common/column_left', 'common/column_right', 'common/content_top', 'common/content_bottom', 'common/footer', 'common/header' );
		$this->response->setOutput ( $this->render () );
	}
	public function info() {
		$this->loadText ();
		$this->loadModel ( 'catalog/manufacturer' );
		$rsm = new ModelCatalogManufacturer ( $this->registry );
		$this->loadModel ( 'catalog/product' );
		$rsp = new ModelCatalogProduct ( $this->registry );
		$this->loadModel ( 'tool/image' );
		$rsi = new ModelToolImage ( $this->registry );	
		if (isset ( $this->request->get ['manufacturer_id'] )) {
			$manufacturer_id = ( int ) $this->request->get ['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		}
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
		$this->data ['breadcrumbs'] = array ();
		$this->data ['breadcrumbs'] [] = array ( 'text' => $this->language->get ( 'text_home' ), 'href' => $this->url->link ( 'common/home' ), 'separator' => false );
		$this->data ['breadcrumbs'] [] = array ( 'text' => $this->language->get ( 'text_brand' ), 'href' => $this->url->link ( 'product/manufacturer' ), 'separator' => $this->language->get ( 'text_separator' ) );
		$manufacturer_info = $rsm->getManufacturer ( $manufacturer_id );
		if ($manufacturer_info) {
			$this->document->setTitle ( $manufacturer_info ['name'] );
			$this->document->addScript ( 'catalog/view/javascript/jquery/jquery.total-storage.min.js' );
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
			$this->data ['breadcrumbs'] [] = array ( 'text' => $manufacturer_info ['name'], 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . $url ), 'separator' => $this->language->get ( 'text_separator' ) );
			$this->data ['heading_title'] = $manufacturer_info ['name'];
			$this->data ['text_compare'] = sprintf ( $this->language->get ( 'text_compare' ), (isset ( $this->session->data ['compare'] ) ? count ( $this->session->data ['compare'] ) : 0) );
			$this->data ['compare'] = $this->url->link ( 'product/compare' );
			$this->data ['products'] = array ();
			$data = array ( 'filter_manufacturer_id' => $manufacturer_id, 'sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $limit, 'limit' => $limit );
			$product_total = $rsp->getTotalProducts ( $data );
			$results = $rsp->getProducts ( $data );
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
				$this->data ['products'] [] = array ( 'product_id' => $result ['product_id'], 'thumb' => $image, 'name' => $result ['name'], 'description' => utf8_substr ( strip_tags ( html_entity_decode ( $result ['description'], ENT_QUOTES, 'UTF-8' ) ), 0, 100 ) . '..', 'price' => $price, 'special' => $special, 'tax' => $tax, 'rating' => $result ['rating'], 'reviews' => sprintf ( $this->language->get ( 'text_reviews' ), ( int ) $result ['reviews'] ), 'href' => $this->url->link ( 'product/product', '&manufacturer_id=' . $result ['manufacturer_id'] . '&product_id=' . $result ['product_id'] . $url ) );
			}
			$url = '';
			if (isset ( $this->request->get ['limit'] )) {
				$url .= '&limit=' . $this->request->get ['limit'];
			}
			$this->data ['sorts'] = array ();
			$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_default' ), 'value' => 'p.sort_order-ASC', 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . '&sort=p.sort_order&order=ASC' . $url ) );
			$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_name_asc' ), 'value' => 'pd.name-ASC', 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . '&sort=pd.name&order=ASC' . $url ) );
			$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_name_desc' ), 'value' => 'pd.name-DESC', 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . '&sort=pd.name&order=DESC' . $url ) );
			$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_price_asc' ), 'value' => 'p.price-ASC', 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . '&sort=p.price&order=ASC' . $url ) );
			$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_price_desc' ), 'value' => 'p.price-DESC', 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . '&sort=p.price&order=DESC' . $url ) );
			if ($this->config->get ( 'config_review_status' )) {
				$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_rating_desc' ), 'value' => 'rating-DESC', 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . '&sort=rating&order=DESC' . $url ) );
				$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_rating_asc' ), 'value' => 'rating-ASC', 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . '&sort=rating&order=ASC' . $url ) );
			}
			$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_model_asc' ), 'value' => 'p.model-ASC', 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . '&sort=p.model&order=ASC' . $url ) );
			$this->data ['sorts'] [] = array ( 'text' => $this->language->get ( 'text_model_desc' ), 'value' => 'p.model-DESC', 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . '&sort=p.model&order=DESC' . $url ) );
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
				$this->data ['limits'] [] = array ( 'text' => $value, 'value' => $value, 'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . $url . '&limit=' . $value ) );
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
			$pagination->url = $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . $url . '&page={page}' );
			$this->data ['pagination'] = $pagination->render ();
			$this->data ['sort'] = $sort;
			$this->data ['order'] = $order;
			$this->data ['limit'] = $limit;
			$this->data ['continue'] = $this->url->link ( 'common/home' );
			$this->initTpl ( 'product/manufacturer_info' );
			$this->children = array ( 'common/column_left', 'common/column_right', 'common/content_top', 'common/content_bottom', 'common/footer', 'common/header' );
			$this->response->setOutput ( $this->render () );
		} else {
			$url = '';
			if (isset ( $this->request->get ['manufacturer_id'] )) {
				$url .= '&manufacturer_id=' . $this->request->get ['manufacturer_id'];
			}
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
			$this->data ['breadcrumbs'] [] = array ( 'text' => $this->language->get ( 'text_error' ), 'href' => $this->url->link ( 'product/category', $url ), 'separator' => $this->language->get ( 'text_separator' ) );
			$this->document->setTitle ( $this->language->get ( 'text_error' ) );
			$this->data ['continue'] = $this->url->link ( 'common/home' );
			$this->response->addHeader ( $this->request->server ['SERVER_PROTOCOL'] . '/1.1 404 Not Found' );
			$this->initTpl ( 'error/not_found' );
			$this->children = array ( 'common/column_left', 'common/column_right', 'common/content_top', 'common/content_bottom', 'common/footer', 'common/header' );
			$this->response->setOutput ( $this->render () );
		}
	}
}
?>