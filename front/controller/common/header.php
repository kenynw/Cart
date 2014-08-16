<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ControllerCommonHeader extends Controller {
	private $route = 'common/header';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index() {
		$this->loadText ();
		$this->data ['lang'] = $this->language->get ( 'code' );
		$this->data ['direction'] = $this->language->get ( 'direction' );
		$this->initMeta ();
		// robot detector
		$status = true;
		if (isset ( $this->request->server ['HTTP_USER_AGENT'] )) {
			$robots = explode ( "\n", trim ( $this->config->get ( 'config_robots' ) ) );
			foreach ( $robots as $robot ) {
				if ($robot && strpos ( $this->request->server ['HTTP_USER_AGENT'], trim ( $robot ) ) !== false) {
					$status = false;
					break;
				}
			}
		}
		// mulit store
		$this->loadModel ( 'setting/store' );
		$this->data ['stores'] = array ();
		if ($this->config->get ( 'config_shared' ) && $status) {
			$this->data ['stores'] [] = '/front/view/default/javascript/crossdomain.php?session_id=' . $this->session->getId ();
			$rs = new ModelSettingStore ( $this->registry );
			$stores = $rs->getStores();
			foreach ( $stores as $store ) {
				$this->data ['stores'] [] = $store ['url'] . '/front/view/default/javascript/crossdomain.php?session_id=' . $this->session->getId ();
			}
		}
		// logo
		if ($this->config->get ( 'config_logo' ) && file_exists ( DIR_IMAGE . $this->config->get ( 'config_logo' ) )) {
			$this->data ['logo'] = '/image/' . $this->config->get ( 'config_logo' );
		} else {
			$this->data ['logo'] = '';
		}
		// search
		if (isset ( $this->request->get ['search'] )) {
			$this->data ['search'] = $this->request->get ['search'];
		} else {
			$this->data ['search'] = '';
		}
		// language
		if (isset ( $this->request->post ['language_code'] )) {
			$this->session->data ['language'] = $this->request->post ['language_code'];
			if (isset ( $this->request->post ['redirect'] )) {
				$this->redirect ( $this->request->post ['redirect'] );
			} else {
				$this->redirect ( $this->url->link ( 'common/home' ) );
			}
		}
		$this->loadModel ( 'localisation/language' );
		$rs = new ModelLocalisationLanguage ( $this->registry );
		$this->data ['languages'] = $rs->getLanguages ();
		$this->data ['language_code'] = $this->session->data ['language'];
		if (strtoupper ( PROJECT ) == 'CART') {
			// cart
			$this->data ['cart_num'] = ( int ) $this->cart->countProducts ();
			// currency
			if (isset ( $this->request->post ['currency_code'] )) {
				$this->currency->set ( $this->request->post ['currency_code'] );
				unset ( $this->session->data ['shipping_method'] );
				unset ( $this->session->data ['shipping_methods'] );
				if (isset ( $this->request->post ['redirect'] )) {
					$this->redirect ( $this->request->post ['redirect'] );
				} else {
					$this->redirect ( $this->url->link ( 'common/home' ) );
				}
			}
			$this->loadModel ( 'localisation/currency' );
			$rs = new ModelLocalisationCurrency ( $this->registry );
			$this->data ['currencies'] = $rs->getCurrencies ();
			$this->data ['currency_code'] = $this->currency->getCode ();
			$this->data ['categories'] = $this->getCategoryMenu ();
		}
		if (strtoupper ( PROJECT ) == 'CART' || strtoupper ( PROJECT ) == 'WEB') {
			// InfoMenu
			$this->loadModel ( 'info/category' );
			$rs = new ModelInfoCategory ( $this->registry );
			$list = $rs->getCategories(0);
			$this->data ['menu_list'] = array ();
			foreach ( $list as $item ) {
				if ($item ['top'] > 0) {
					$this->data ['menu_list'] [] = array (
							'name' => $item ['name'],
							'href' => $this->url->link ( 'info/category', 'category_id=' . $item ['category_id'] ) 
					);
				}
			}
			$this->data ['logged'] = $this->customer->isLogged ();
			$this->data ['login'] = $this->url->link ( 'account/login', '', 'SSL' );
			$this->data ['register'] = $this->url->link ( 'account/register', '', 'SSL' );
			$this->data ['logout'] = $this->url->link ( 'account/logout', '', 'SSL' );
			$this->data ['account'] = $this->url->link ( 'account/account', '', 'SSL' );
			$this->data ['text_welcome'] = sprintf ( $this->language->get ( 'text_welcome' ), $this->customer->getFirstName () . ' ' . $this->customer->getLastName () );
			$this->data ['shopping_cart'] = $this->url->link ( 'checkout/cart' );
			$this->data ['checkout'] = $this->url->link ( 'checkout/checkout', '', 'SSL' );
			$this->data ['wishlist'] = $this->url->link ( 'account/wishlist', '', 'SSL' );
			$this->data ['text_wishlist'] = sprintf ( $this->language->get ( 'text_wishlist' ), (isset ( $this->session->data ['wishlist'] ) ? count ( $this->session->data ['wishlist'] ) : 0) );
		}
		if (! isset ( $this->request->get ['route'] )) {
			$this->data ['redirect'] = $this->url->link ( 'common/home' );
		} else {
			$data = $this->request->get;
			unset ( $data ['_route_'] );
			$route = $data ['route'];
			unset ( $data ['route'] );
			$url = '';
			if ($data) {
				$url = '&' . urldecode ( http_build_query ( $data, '', '&' ) );
			}
			$this->data ['redirect'] = $this->url->link ( $route, $url, 'SSL' );
		}
		// others
		$this->data ['action'] = $this->url->link ( 'common/header', '', 'SSL' );
		$this->data ['home'] = $this->url->link ( 'common/home' );
		$this->data ['name'] = $this->config->get ( 'config_name' );
		$this->data ['title'] = $this->config->get ( 'config_title' );
		$this->initNotice ();
		$this->children = array(
		    'module/language',
		    'module/currency',
		    'module/cart'
		);
		$this->initTpl ( $this->route );
		$this->render ();
	}
	private function getCategoryMenu() {
		$this->loadModel ( 'catalog/category' );
		$rsc = new ModelCatalogCategory ( $this->registry );
		$this->loadModel ( 'catalog/product' );
		$rsp = new ModelCatalogProduct ( $this->registry );
		$list = array ();
		$list_1 = $rsc->getCategories ( 0 );
		foreach ( $list_1 as $item_1 ) {
			if ($item_1 ['top']) {
				// Level 2
				$list_2_data = array ();
				if ($this->config->get ( 'config_category_level' ) > '1') {
					$list_2 = $rsc->getCategories ( $item_1 ['category_id'] );
					foreach ( $list_2 as $item_2 ) {
						// Level 3
						$list_3_data = array ();
						if ($this->config->get ( 'config_category_level' ) > '2') {
							$list_3 = $rsc->getCategories ( $item_2 ['category_id'] );
							foreach ( $list_3 as $item_3 ) {
								if ($this->config->get ( 'config_product_count' )) {
									$param = array (
											'filter_category_id' => $item_3 ['category_id'],
											'filter_sub_category' => true 
									);
									$name = $item_3 ['name'] . '( ' . $rsp->getTotalProducts ( $param ) . ' )';
								} else {
									$name = $item_3 ['name'];
								}
								$list_3_data [] = array (
										'category_id' => $item_3 ['category_id'],
										'column' => $item_3 ['column'] ? $item_3 ['column'] : 1,
										'name' => $name,
										'href' => $this->url->link ( 'product/category', 'path=' . $item_1 ['category_id'] . '_' . $item_2 ['category_id'] . '_' . $item_3 ['category_id'] ) 
								);
							}
						}
						if ($this->config->get ( 'config_product_count' )) {
							$param = array (
									'filter_category_id' => $item_2 ['category_id'],
									'filter_sub_category' => true 
							);
							$name = $item_2 ['name'] . '( ' . $rsp->getTotalProducts ( $param ) . ' )';
						} else {
							$name = $item_2 ['name'];
						}
						$list_2_data [] = array (
								'category_id' => $item_2 ['category_id'],
								'column' => $item_2 ['column'] ? $item_2 ['column'] : 1,
								'name' => $name,
								'href' => $this->url->link ( 'product/category', 'path=' . $item_1 ['category_id'] . '_' . $item_2 ['category_id'] ),
								'item' => $list_3_data 
						);
					}
				}
				// Level 1
				if ($this->config->get ( 'config_product_count' )) {
					$param = array (
							'filter_category_id' => $item_1 ['category_id'],
							'filter_sub_category' => true 
					);
					$name = $item_1 ['name'] . '( ' . $rsp->getTotalProducts ( $param ) . ' )';
				} else {
					$name = $item_1 ['name'];
				}
				$list [] = array (
						'category_id' => $item_1 ['category_id'],
						'name' => $name,
						'column' => $item_1 ['column'] ? $item_1 ['column'] : 1,
						'href' => $this->url->link ( 'product/category', 'path=' . $item_1 ['category_id'] ),
						'item' => $list_2_data 
				);
			}
		}
		return $list;
	}
}