<?php
class ControllerModuleEbaydisplay extends Controller {
	private $route = 'module/ebaydisplay';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index($setting) {
		$this->loadText ();
		$this->load->model ( 'tool/image' );
		$this->load->model ( 'openbay/ebay_product' );
		
		$this->data ['products'] = array ();
		
		$products = $this->cache->get ( 'ebaydisplay.' . md5 ( serialize ( $setting ) ) );
		
		if (! $products) {
			$products = $this->model_openbay_ebay_product->getDisplayProducts ();
			$this->cache->set ( 'ebaydisplay.' . md5 ( serialize ( $setting ) ), $products );
		}
		
		foreach ( $products ['products'] as $product ) {
			
			if (isset ( $product ['pictures'] [0] )) {
				$image = $this->model_openbay_ebay_product->resize ( $product ['pictures'] [0], $setting ['image_width'], $setting ['image_height'] );
			} else {
				$image = '';
			}
			
			$this->data ['products'] [] = array (
					'thumb' => $image,
					'name' => base64_decode ( $product ['Title'] ),
					'price' => $this->currency->format ( $product ['priceGross'] ),
					'href' => ( string ) $product ['link'] 
			);
		}
		
		$this->data ['tracking_pixel'] = $products ['tracking_pixel'];
		
		$this->initTpl ( $this->route );
		
		$this->render ();
	}
}
?>