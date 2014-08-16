<?php
class ControllerModuleSpecial extends Controller {
	private $route = 'module/special';
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
		
		$data = array (
				'sort' => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $setting ['limit'] 
		);
		
		$results = $this->model_catalog_product->getProductSpecials ( $data );
		
		foreach ( $results as $result ) {
			if ($result ['image']) {
				$image = $this->model_tool_image->resize ( $result ['image'], $setting ['image_width'], $setting ['image_height'] );
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
			
			if ($this->config->get ( 'config_review_status' )) {
				$rating = $result ['rating'];
			} else {
				$rating = false;
			}
			
			$this->data ['products'] [] = array (
					'product_id' => $result ['product_id'],
					'thumb' => $image,
					'name' => $result ['name'],
					'price' => $price,
					'special' => $special,
					'rating' => $rating,
					'reviews' => ( int ) $result ['reviews'] ,
					'href' => $this->url->link ( 'product/product', 'product_id=' . $result ['product_id'] ) 
			);
		}
		
		$this->initTpl ( '/module/special' );
		
		$this->render ();
	}
}
?>