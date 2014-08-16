<?php
class ControllerCommonHome extends Controller {
	private $route = 'common/home';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		$this->data ['project_name'] = $this->session->data ['project_name'];
		$project_name = $this->session->data ['project_name'];
		$this->data ['token'] = $this->session->data ['token'];
		if ($project_name == 'CART') {
			$this->loadModel ( 'sale/customer' );
			$rs = new ModelSaleCustomer ( $this->registry );
			$this->data ['total_customer'] = $rs->getTotalCustomers ();
			$this->data ['total_customer_approval'] = $rs->getTotalCustomersAwaitingApproval ();
			$this->loadModel ( 'catalog/review' );
			$rs = new ModelCatalogReview ( $this->registry );
			$this->data ['total_review'] = $rs->getTotalReviews ();
			$this->data ['total_review_approval'] = $rs->getTotalReviewsAwaitingApproval ();
			$this->loadModel ( 'sale/affiliate' );
			$rs = new ModelSaleAffiliate ( $this->registry );
			$this->data ['total_affiliate'] = $rs->getTotalAffiliates ();
			$this->data ['total_affiliate_approval'] = $rs->getTotalAffiliatesAwaitingApproval ();
			$this->data ['orders'] = array ();
			$data = array (
					'sort' => 'o.date_added',
					'order' => 'DESC',
					'start' => 0,
					'limit' => 10 
			);
			$this->loadModel ( 'sale/order' );
			$rs = new ModelSaleOrder ( $this->registry );
			$this->data ['total_sale'] = $this->currency->format ( $rs->getTotalSales (), $this->config->get ( 'config_currency' ) );
			$this->data ['total_sale_year'] = $this->currency->format ( $rs->getTotalSalesByYear ( date ( 'Y' ) ), $this->config->get ( 'config_currency' ) );
			$this->data ['total_order'] = $rs->getTotalOrders ();
			$results = $rs->getOrders ( $data );
			foreach ( $results as $result ) {
				$action = array ();
				$action [] = array (
						'text' => $this->language->get ( 'text_view' ),
						'href' => $this->url->link ( 'sale/order/info', 'token=' . $this->session->data ['token'] . '&order_id=' . $result ['order_id'], 'SSL' ) 
				);
				$this->data ['orders'] [] = array (
						'order_id' => $result ['order_id'],
						'customer' => $result ['customer'],
						'status' => $result ['status'],
						'date_added' => date ( $this->language->get ( 'date_format_short' ), strtotime ( $result ['date_added'] ) ),
						'total' => $this->currency->format ( $result ['total'], $result ['currency_code'], $result ['currency_value'] ),
						'action' => $action 
				);
			}
			if ($this->config->get ( 'config_currency_auto' )) {
				$this->loadModel ( 'localisation/currency' );
				$rs = new ModelLocalisationCurrency ( $this->registry );
				$rs->updateCurrencies ();
			}
		} elseif ($project_name == 'SEO') {
		} elseif ($project_name == 'B2B') {
			$this->data ['pro_collection'] = $this->url->link ( 'b2b/pro_collection', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['keywords_analysis'] = $this->url->link ( 'b2b/keywords_analysis', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['keywords_mine'] = $this->url->link ( 'b2b/keywords_mine', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['keywords_store'] = $this->url->link ( 'b2b/keywords_store', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['keywords_trade'] = $this->url->link ( 'b2b/keywords_trade', 'token=' . $this->session->data ['token'], 'SSL' );
		} elseif ($project_name == 'SOP') {
		} elseif ($project_name == 'WEB') {
		} else {
		}
		$this->initTpl ( $this->route );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	public function chart() {
		$this->loadText ();
		$data = array ();
		$data ['order'] = array ();
		$data ['customer'] = array ();
		$data ['xaxis'] = array ();
		$data ['order'] ['label'] = $this->language->get ( 'text_order' );
		$data ['customer'] ['label'] = $this->language->get ( 'text_customer' );
		if (isset ( $this->request->get ['range'] )) {
			$range = $this->request->get ['range'];
		} else {
			$range = 'month';
		}
		switch ($range) {
			case 'day' :
				for($i = 0; $i < 24; $i ++) {
					$query = $this->db->query ( "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '" . ( int ) $this->config->get ( 'config_complete_status_id' ) . "' AND (DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . ( int ) $i . "') GROUP BY HOUR(date_added) ORDER BY date_added ASC" );
					if ($query->num_rows) {
						$data ['order'] ['data'] [] = array (
								$i,
								( int ) $query->row ['total'] 
						);
					} else {
						$data ['order'] ['data'] [] = array (
								$i,
								0 
						);
					}
					$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . ( int ) $i . "' GROUP BY HOUR(date_added) ORDER BY date_added ASC" );
					if ($query->num_rows) {
						$data ['customer'] ['data'] [] = array (
								$i,
								( int ) $query->row ['total'] 
						);
					} else {
						$data ['customer'] ['data'] [] = array (
								$i,
								0 
						);
					}
					$data ['xaxis'] [] = array (
							$i,
							date ( 'H', mktime ( $i, 0, 0, date ( 'n' ), date ( 'j' ), date ( 'Y' ) ) ) 
					);
				}
				break;
			case 'week' :
				$date_start = strtotime ( '-' . date ( 'w' ) . ' days' );
				for($i = 0; $i < 7; $i ++) {
					$date = date ( 'Y-m-d', $date_start + ($i * 86400) );
					$query = $this->db->query ( "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '" . ( int ) $this->config->get ( 'config_complete_status_id' ) . "' AND DATE(date_added) = '" . $this->db->escape ( $date ) . "' GROUP BY DATE(date_added)" );
					if ($query->num_rows) {
						$data ['order'] ['data'] [] = array (
								$i,
								( int ) $query->row ['total'] 
						);
					} else {
						$data ['order'] ['data'] [] = array (
								$i,
								0 
						);
					}
					$query = $this->db->query ( "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "customer` WHERE DATE(date_added) = '" . $this->db->escape ( $date ) . "' GROUP BY DATE(date_added)" );
					if ($query->num_rows) {
						$data ['customer'] ['data'] [] = array (
								$i,
								( int ) $query->row ['total'] 
						);
					} else {
						$data ['customer'] ['data'] [] = array (
								$i,
								0 
						);
					}
					$data ['xaxis'] [] = array (
							$i,
							date ( 'D', strtotime ( $date ) ) 
					);
				}
				break;
			default :
			case 'month' :
				for($i = 1; $i <= date ( 't' ); $i ++) {
					$date = date ( 'Y' ) . '-' . date ( 'm' ) . '-' . $i;
					$query = $this->db->query ( "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '" . ( int ) $this->config->get ( 'config_complete_status_id' ) . "' AND (DATE(date_added) = '" . $this->db->escape ( $date ) . "') GROUP BY DAY(date_added)" );
					if ($query->num_rows) {
						$data ['order'] ['data'] [] = array (
								$i,
								( int ) $query->row ['total'] 
						);
					} else {
						$data ['order'] ['data'] [] = array (
								$i,
								0 
						);
					}
					$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE DATE(date_added) = '" . $this->db->escape ( $date ) . "' GROUP BY DAY(date_added)" );
					if ($query->num_rows) {
						$data ['customer'] ['data'] [] = array (
								$i,
								( int ) $query->row ['total'] 
						);
					} else {
						$data ['customer'] ['data'] [] = array (
								$i,
								0 
						);
					}
					$data ['xaxis'] [] = array (
							$i,
							date ( 'j', strtotime ( $date ) ) 
					);
				}
				break;
			case 'year' :
				for($i = 1; $i <= 12; $i ++) {
					$query = $this->db->query ( "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '" . ( int ) $this->config->get ( 'config_complete_status_id' ) . "' AND YEAR(date_added) = '" . date ( 'Y' ) . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)" );
					if ($query->num_rows) {
						$data ['order'] ['data'] [] = array (
								$i,
								( int ) $query->row ['total'] 
						);
					} else {
						$data ['order'] ['data'] [] = array (
								$i,
								0 
						);
					}
					$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE YEAR(date_added) = '" . date ( 'Y' ) . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)" );
					if ($query->num_rows) {
						$data ['customer'] ['data'] [] = array (
								$i,
								( int ) $query->row ['total'] 
						);
					} else {
						$data ['customer'] ['data'] [] = array (
								$i,
								0 
						);
					}
					$data ['xaxis'] [] = array (
							$i,
							date ( 'M', mktime ( 0, 0, 0, $i, 1, date ( 'Y' ) ) ) 
					);
				}
				break;
		}
		$this->response->setOutput ( json_encode ( $data ) );
	}
	public function login() {
		$route = '';
		if (isset ( $this->request->get ['route'] )) {
			$part = explode ( '/', $this->request->get ['route'] );
			if (isset ( $part [0] )) {
				$route .= $part [0];
			}
			if (isset ( $part [1] )) {
				$route .= '/' . $part [1];
			}
		}
		$ignore = array (
				'common/api',
				'common/login',
				'common/forgotten',
				'common/reset' 
		);
		if (! $this->user->isLogged () && ! in_array ( $route, $ignore )) {
			return $this->forward ( 'common/login' );
		}
		if (isset ( $this->request->get ['route'] )) {
			$ignore = array (
					'common/api',
					'common/login',
					'common/logout',
					'common/forgotten',
					'common/reset',
					'error/not_found',
					'error/permission' 
			);
			$config_ignore = array ();
			if ($this->config->get ( 'config_token_ignore' )) {
				$config_ignore = unserialize ( $this->config->get ( 'config_token_ignore' ) );
			}
			$ignore = array_merge ( $ignore, $config_ignore );
			if (! in_array ( $route, $ignore ) && (! isset ( $this->request->get ['token'] ) || ! isset ( $this->session->data ['token'] ) || ($this->request->get ['token'] != $this->session->data ['token']))) {
				return $this->forward ( 'common/login' );
			}
		} else {
			if (! isset ( $this->request->get ['token'] ) || ! isset ( $this->session->data ['token'] ) || ($this->request->get ['token'] != $this->session->data ['token'])) {
				return $this->forward ( 'common/login' );
			}
		}
	}
	public function permission() {
		if (isset ( $this->request->get ['route'] )) {
			$route = '';
			if (isset ( $this->session->data ['project_name'] ) && $this->session->data ['project_name'] == 'WEB') {
				$string = $_SERVER ['QUERY_STRING'];
				$tmpPart = explode ( 'token', $string );
				$search = array (
						'route=',
						'&amp;',
						'/update',
						'/delete' 
				);
				$replace = array (
						'',
						'&',
						'',
						'' 
				);
				$route = trim ( str_replace ( $search, $replace, $tmpPart [0] ), '&' );
			} else {
				$part = explode ( '/', $this->request->get ['route'] );
				if (isset ( $part [0] )) {
					$route .= $part [0];
				}
				if (isset ( $part [1] )) {
					$route .= '/' . $part [1];
				}
			}
			$ignore = array (
					'common/home',
					'common/main',
					'common/api',
					'common/login',
					'common/logout',
					'common/forgotten',
					'common/reset',
					'error/not_found',
					'error/permission',
					'module/account',
					'module/affiliate',
					'module/amazon_checkout_layout',
					'module/banner',
					'module/bestseller',
					'module/carousel',
					'module/category',
					'module/ebaydisplay',
					'module/featured',
					'module/filter',
					'module/google_talk',
					'module/information',
					'module/latest',
					'module/openbaypro',
					'module/pp_layout',
					'module/slideshow',
					'module/special',
					'module/store',
					'module/welcome' 
			);
			if (! in_array ( $route, $ignore ) && ! $this->user->hasPermission ( 'access', $route )) {
				return $this->forward ( 'error/permission' );
			}
		}
	}
}
?>