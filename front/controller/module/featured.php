<?php
class ControllerModuleFeatured extends Controller {
	private $route = 'module/featured';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index($setting) {
		$this->loadText ();
		
		$this->load->model ( 'catalog/product' );
		
		$this->load->model ( 'tool/image' );
		
		$this->data ['products'] = array ();
		
		$products = explode ( ',', $this->config->get ( 'featured_product' ) );
		
		if (empty ( $setting ['limit'] )) {
			$setting ['limit'] = 5;
		}
		
		$products = array_slice ( $products, 0, ( int ) $setting ['limit'] );
		
		foreach ( $products as $product_id ) {
			$product_info = $this->model_catalog_product->getProduct ( $product_id );
			
			if ($product_info) {
				if ($product_info ['image']) {
					$image = $this->model_tool_image->resize ( $product_info ['image'], $setting ['image_width'], $setting ['image_height'] );
				} else {
					$image = false;
				}
				
				if (($this->config->get ( 'config_customer_price' ) && $this->customer->isLogged ()) || ! $this->config->get ( 'config_customer_price' )) {
					$price = $this->currency->format ( $this->tax->calculate ( $product_info ['price'], $product_info ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
				} else {
					$price = false;
				}
				
				if (( float ) $product_info ['special']) {
					$special = $this->currency->format ( $this->tax->calculate ( $product_info ['special'], $product_info ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
				} else {
					$special = false;
				}
				
				if ($this->config->get ( 'config_review_status' )) {
					$rating = $product_info ['rating'];
				} else {
					$rating = false;
				}
				
				$this->data ['products'] [] = array (
						'product_id' => $product_info ['product_id'],
						'thumb' => $image,
						'name' => $product_info ['name'],
						'price' => $price,
						'special' => $special,
						'rating' => $rating,
						'reviews' => ( int ) $product_info ['reviews'],
						'href' => $this->url->link ( 'product/product', 'product_id=' . $product_info ['product_id'] ) 
				);
			}
		}
		
		$this->initTpl ( $this->route );
		
		$this->render ();
	}
}
?>