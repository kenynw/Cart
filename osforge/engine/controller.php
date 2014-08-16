<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
abstract class Controller {
	protected $registry;
	protected $id;
	protected $layout;
	protected $template;
	protected $children = array ();
	protected $data = array ();
	protected $output;
	protected $error = array ();
	public function __construct($registry) {
		$this->registry = $registry;
	}
	public function __get($key) {
		return $this->registry->get ( $key );
	}
	public function __set($key, $value) {
		$this->registry->set ( $key, $value );
	}
	protected function forward($route, $args = array()) {
		return new Action ( $route, $args );
	}
	protected function redirect($url, $status = 302) {
		header ( 'Status: ' . $status );
		header ( 'Location: ' . str_replace ( array (
				'&amp;',
				"\n",
				"\r" 
		), array (
				'&',
				'',
				'' 
		), $url ) );
		exit ();
	}
	protected function getChild($child, $args = array()) {
		$action = new Action ( $child, $args );
		if (file_exists ( $action->getFile () )) {
			require_once ($action->getFile ());
			$class = $action->getClass ();
			$controller = new $class ( $this->registry );
			$controller->{$action->getMethod ()} ( $action->getArgs () );
			return $controller->output;
		} else {
			trigger_error ( 'Error: Could not load controller ' . $child . '!' );
			exit ();
		}
	}
	protected function hasAction($child, $args = array()) {
		$action = new Action ( $child, $args );
		if (file_exists ( $action->getFile () )) {
			require_once ($action->getFile ());
			$class = $action->getClass ();
			$controller = new $class ( $this->registry );
			if (method_exists ( $controller, $action->getMethod () )) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	protected function loadModel($route) {
		$file = DIR_SYSTEM . 'model/' . $route . '.php';
		if (! file_exists ( $file )) {
			$file = DIR_APPLICATION . 'model/' . $route . '.php';
		}
		if (file_exists ( $file )) {
			include_once ($file);
			// $class = 'Model' . preg_replace ( '/[^a-zA-Z0-9]/', '', $route );
			// $path_parts = pathinfo($route);
			// $class = $path_parts['filename'];
		} else {
			trigger_error ( 'Error: Could not load model ' . $route . '!' );
			exit ();
		}
	}
	protected function render() {
		foreach ( $this->children as $child ) {
			$this->data [basename ( $child )] = $this->getChild ( $child );
		}
		if (file_exists ( DIR_TEMPLATE . $this->template )) {
			extract ( $this->data );
			ob_start ();
			require (DIR_TEMPLATE . $this->template);
			$this->output = ob_get_contents ();
			ob_end_clean ();
			return $this->output;
		} else {
			trigger_error ( 'Error: Could not load template ' . DIR_TEMPLATE . $this->template . '!' );
			exit ();
		}
	}
	protected function initTpl($tpl) {
		$tpl = str_ireplace ( '.htm', '', $tpl ) . '.htm';
		$root = trim ( trim ( str_ireplace ( dirname ( DIR_APPLICATION ), '', DIR_APPLICATION ), '/' ), '\\' );
		if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/' . $tpl )) {
			$this->data ['res'] = '/' . $root . '/view/' . $this->config->get ( 'config_template' ) . '/';
			$this->template = $this->config->get ( 'config_template' ) . '/template/' . $tpl;
		} else {
			$this->data ['res'] = '/' . $root . '/view/default/';
			$this->template = 'default/template/' . $tpl;
		}
	}
	protected function initList($route, $total, $sort_data) {
		if (isset ( $this->request->get ['sort'] )) {
			$sort = $this->request->get ['sort'];
		} else {
			$sort = '';
		}
		if (isset ( $this->request->get ['order'] )) {
			$order = $this->request->get ['order'];
		} else {
			$order = '';
		}
		if (isset ( $this->request->get ['page'] )) {
			$page = $this->request->get ['page'];
		} else {
			$page = 1;
		}
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
		$this->data ['insert'] = $this->url->link ( $route . '/insert', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		$this->data ['delete'] = $this->url->link ( $route . '/delete', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		$param = array (
				'sort' => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->config->get ( 'config_admin_limit' ),
				'limit' => $this->config->get ( 'config_admin_limit' ),
				'url' => $url 
		);
		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset ( $this->request->get ['page'] )) {
			$url .= '&page=' . $this->request->get ['page'];
		}
		foreach ( $sort_data as $my_sort ) {
			$tmp = explode ( '.', $my_sort );
			$my_sort = $tmp [count ( $tmp ) - 1];
			$this->data ['sort_' . $my_sort] = $this->url->link ( $route, 'token=' . $this->session->data ['token'] . '&sort=' . $my_sort . $url, 'SSL' );
		}
		$url = '';
		if (isset ( $this->request->get ['sort'] )) {
			$url .= '&sort=' . $this->request->get ['sort'];
		}
		if (isset ( $this->request->get ['order'] )) {
			$url .= '&order=' . $this->request->get ['order'];
		}
		$pagination = new Pagination ();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get ( 'config_admin_limit' );
		$pagination->text = $this->language->get ( 'text_pagination' );
		$pagination->url = $this->url->link ( $route, 'token=' . $this->session->data ['token'] . $url . '&page={page}', 'SSL' );
		$this->data ['pagination'] = $pagination->render ();
		$this->data ['sort'] = $sort;
		$this->data ['order'] = $order;
		return $param;
	}
	protected function initUrl($param = array()) {
		$url = '';
		foreach ( $param as $k => $v ) {
			if ($v != '') {
				$url .= '&' . $k . '=' . $v;
			}
		}
		return $url;
	}
	protected function initUrlGet($param = array()) {
		$url = '';
		foreach ( $param as $k ) {
			if (isset ( $this->request->get [$k] )) {
				$url .= '&' . $k . '=' . $this->request->get [$k];
			}
		}
		return $url;
	}
	protected function initItem($item) {
		foreach ( $item as $k => $v ) {
			if (isset ( $this->request->post [$k] )) {
				$this->data [$k] = $this->request->post [$k];
			} elseif (! empty ( $v ) || $v == 0) {
				$this->data [$k] = $v;
			} else {
				$this->data [$k] = '';
			}
		}
	}
	protected function loadLang($route) {
		if ($route != '') {
			$this->data = array_merge ( $this->data, $this->language->load ( $route ) );
		}
	}
	protected function goBack($route) {
		$url = $this->initUrlGet ( array (
				'sort',
				'order',
				'page' 
		) );
		$this->redirect ( $this->url->link ( $route, 'token=' . $this->session->data ['token'] . $url, 'SSL' ) );
	}
	protected function initNotice() {
		if (isset ( $this->session->data ['error'] )) {
			$this->data ['error_warning'] = $this->session->data ['error'];
			unset ( $this->session->data ['error'] );
		} elseif (isset ( $this->error ['warning'] )) {
			$this->data ['error_warning'] = $this->error ['warning'];
		} else {
			$this->data ['error_warning'] = '';
		}
		if (isset ( $this->session->data ['success'] )) {
			$this->data ['success'] = $this->session->data ['success'];
			unset ( $this->session->data ['success'] );
		} else {
			$this->data ['success'] = '';
		}
	}
	protected function initMeta() {
		$str_find = array (
				'&quot;',
				'"' 
		);
		$str_replace = array (
				'',
				'' 
		);
		$meta_title = $this->config->get ( 'config_title' );
		$meta_keywords = $this->config->get ( 'config_meta_keywords' );
		$meta_description = $this->config->get ( 'config_meta_description' );
		$route = isset ( $this->request->get ['route'] ) ? $this->request->get ['route'] : 'common/home';
		$this->loadModel ( 'catalog/meta_tag' );
		$rsm = new ModelCatalogMetaTag ( $this->registry );
		$meta = $rsm->getMetaTagByLocation ( $route );
		if ($route == 'product/category') {
			$this->loadModel ( 'catalog/category' );
			$rsc = new ModelCatalogCategory ( $this->registry );
			if (isset ( $this->request->get ['path'] )) {
				$parts = explode ( '_', ( string ) $this->request->get ['path'] );
				$item = $rsc->getCategory ( ( int ) end ( $parts ) );
				if ($item != null) {
					$parentName = '';
					$itemParent = $rsc->getCategory ( $item ['parent_id'] );
					if ($itemParent != null) {
						$parentName = $itemParent ['name'];
					}
					$find = array (
							"*",
							"@",
							"!" 
					);
					$replace = array (
							$parentName,
							$item ['name'],
							$item ['category_id'] 
					);
					if (isset ( $meta ['meta_title'] ) && $meta ['meta_title'] != '') {
						$meta_title = str_replace ( $find, $replace, $meta ['meta_title'] );
					} else {
						$meta_title = $item ['name'] . $this->language->get ( 'text_meta_divider' ) . $this->config->get ( 'config_title' );
					}
					if (isset ( $item ['meta_keyword'] ) && $item ['meta_keyword'] != '') {
						$meta_keywords = $item ['meta_keyword'];
					} elseif (isset ( $meta ['meta_keywords'] ) && $meta ['meta_keywords'] != '') {
						$meta_keywords = str_replace ( $find, $replace, $meta ['meta_keywords'] );
					} else {
						$meta_keywords = $this->config->get ( 'config_meta_keywords' ) . $this->language->get ( 'text_meta_divider' ) . $item ['name'];
					}
					if (isset ( $item ['meta_description'] ) && $item ['meta_description'] != '') {
						$meta_description = $item ['meta_description'];
					} elseif (isset ( $meta ['meta_description'] ) && $meta ['meta_description'] != '') {
						$meta_description = str_replace ( $find, $replace, $meta ['meta_description'] );
					} else {
						$meta_description = str_replace ( $str_find, $str_replace, trim ( utf8_substr ( strip_tags ( html_entity_decode ( $item ['name'] . $this->language->get ( 'text_meta_divider' ) . $item ['description'], ENT_QUOTES, 'UTF-8' ) ), 0, 100 ), $this->language->get ( 'text_meta_divider' ) ) );
					}
				}
			}
		} elseif ($route == 'product/product') {
			$this->loadModel ( 'catalog/category' );
			$rsc = new ModelCatalogCategory ( $this->registry );
			$this->loadModel ( 'catalog/product' );
			$rsp = new ModelCatalogProduct ( $this->registry );
			if ($this->request->get ['product_id']) {
				$item = $rsp->getProduct ( ( int ) $this->request->get ['product_id'] );
				if ($item != null) {
					$nameFirst = '';
					$nameLast = '';
					if (isset ( $this->request->get ['path'] )) {
						$parts = explode ( '_', ( string ) $this->request->get ['path'] );
						$firstId = ( int ) $parts [0];
						$lastId = ( int ) end ( $parts );
						$itemFirst = $rsc->getCategory ( $firstId );
						if ($itemFirst != null) {
							$nameFirst = $itemFirst ['name'];
						}
						$itemLast = $rsc->getCategory ( $lastId );
						if ($itemLast != null) {
							$nameLast = $itemLast ['name'];
						}
					}
					$find = array (
							"*",
							"@",
							"!",
							"#",
							"^" 
					);
					$replace = array (
							$nameLast,
							$item ['name'],
							$item ['product_id'],
							sprintf ( "%.2f", $item ['price'] ),
							$nameFirst 
					);
					if (isset ( $meta ['meta_title'] ) && $meta ['meta_title'] != '') {
						$meta_title = str_replace ( $find, $replace, $meta ['meta_title'] );
					} else {
						$meta_title = $item ['name'];
					}
					if (isset ( $item ['meta_keyword'] ) && $item ['meta_keyword'] != '') {
						$meta_keywords = $item ['meta_keyword'];
					} elseif (isset ( $meta ['meta_keywords'] ) && $meta ['meta_keywords'] != '') {
						$meta_keywords = str_replace ( $find, $replace, $meta ['meta_keywords'] );
					} else {
						$meta_keywords = $this->config->get ( 'config_meta_keywords' ) . $this->language->get ( 'text_meta_divider' ) . $item ['name'];
					}
					if (isset ( $item ['meta_description'] ) && $item ['meta_description'] != '') {
						$meta_description = $item ['meta_description'];
					} elseif (isset ( $meta ['meta_description'] ) && $meta ['meta_description'] != '') {
						$meta_description = str_replace ( $find, $replace, $meta ['meta_description'] );
					} else {
						$meta_description = str_replace ( $str_find, $str_replace, trim ( utf8_substr ( strip_tags ( html_entity_decode ( $item ['name'] . $this->language->get ( 'text_meta_divider' ) . $item ['description'], ENT_QUOTES, 'UTF-8' ) ), 0, 100 ), $this->language->get ( 'text_meta_divider' ) ) );
					}
				}
			}
		} elseif ($route == 'info/category') {
			$this->load->model ( 'info/category' );
			if (isset ( $_GET ['path'] )) {
				$id = $this->model_info_category->getIdByPath ( $_GET ['path'] );
				$item = $this->model_info_category->getItem ( $id );
				if ($item != null) {
					$itemParent = $this->model_info_category->getItem ( $item ['parent_id'] );
					$find = array (
							"*",
							"@",
							"!" 
					);
					$replace = array (
							$itemParent ['name'],
							$item ['name'],
							$item ['category_id'] 
					);
					if (isset ( $meta ['meta_title'] ) && $meta ['meta_title'] != '') {
						$meta_title = str_replace ( $find, $replace, $meta ['meta_title'] );
					} else {
						$meta_title = $item ['name'] . $this->language->get ( 'text_meta_divider' ) . $this->config->get ( 'config_title' );
					}
					if (isset ( $item ['meta_keyword'] ) && $item ['meta_keyword'] != '') {
						$meta_keywords = $item ['meta_keyword'];
					} elseif (isset ( $meta ['meta_keywords'] ) && $meta ['meta_keywords'] != '') {
						$meta_keywords = str_replace ( $find, $replace, $meta ['meta_keywords'] );
					} else {
						$meta_keywords = $this->config->get ( 'config_meta_keywords' ) . $this->language->get ( 'text_meta_divider' ) . $item ['name'];
					}
					if (isset ( $item ['meta_description'] ) && $item ['meta_description'] != '') {
						$meta_description = $item ['meta_description'];
					} elseif (isset ( $meta ['meta_description'] ) && $meta ['meta_description'] != '') {
						$meta_description = str_replace ( $find, $replace, $meta ['meta_description'] );
					} else {
						$meta_description = str_replace ( $str_find, $str_replace, trim ( utf8_substr ( strip_tags ( html_entity_decode ( $item ['name'] . $this->language->get ( 'text_meta_divider' ) . $item ['description'], ENT_QUOTES, 'UTF-8' ) ), 0, 100 ), $this->language->get ( 'text_meta_divider' ) ) );
					}
				}
			}
		} elseif ($route == 'info/info') {
			$this->load->model ( 'info/info' );
			if (isset ( $_GET ['information_id'] )) {
				$item = $this->model_info_info->getItem ( ( int ) $_GET ['information_id'] );
				if ($item != null) {
					if (isset ( $_GET ['path'] )) {
						$parts = explode ( '_', ( string ) $_GET ['path'] );
						$firstId = ( int ) $parts [0];
						$lastId = ( int ) array_pop ( $parts );
						$itemFirst = $this->model_info_category->getItem ( $firstId );
						$itemLast = $this->model_info_category->getItem ( $lastId );
					} else {
						$itemFirst = null;
						$itemLast = null;
					}
					$find = array (
							"*",
							"@",
							"!",
							"#",
							"^" 
					);
					$replace = array (
							$itemLast ['name'],
							$item ['title'],
							$item ['product_id'],
							sprintf ( "%.2f", $item ['price'] ),
							$itemFirst ['name'] 
					);
					if (isset ( $meta ['meta_title'] ) && $meta ['meta_title'] != '') {
						$meta_title = str_replace ( $find, $replace, $meta ['meta_title'] );
					} else {
						$meta_title = $item ['title'];
					}
					if (isset ( $item ['meta_keyword'] ) && $item ['meta_keyword'] != '') {
						$meta_keywords = $item ['meta_keyword'];
					} elseif (isset ( $meta ['meta_keywords'] ) && $meta ['meta_keywords'] != '') {
						$meta_keywords = str_replace ( $find, $replace, $meta ['meta_keywords'] );
					} else {
						$meta_keywords = $this->config->get ( 'config_meta_keywords' ) . $this->language->get ( 'text_meta_divider' ) . $item ['title'];
					}
					if (isset ( $item ['meta_description'] ) && $item ['meta_description'] != '') {
						$meta_description = $item ['meta_description'];
					} elseif (isset ( $meta ['meta_description'] ) && $meta ['meta_description'] != '') {
						$meta_description = str_replace ( $find, $replace, $meta ['meta_description'] );
					} else {
						$meta_description = str_replace ( $str_find, $str_replace, trim ( utf8_substr ( strip_tags ( html_entity_decode ( $item ['title'] . $this->language->get ( 'text_meta_divider' ) . $item ['description'], ENT_QUOTES, 'UTF-8' ) ), 0, 100 ), $this->language->get ( 'text_meta_divider' ) ) );
					}
				}
			}
		}
		$this->data ['meta_title'] = $meta_title;
		$this->data ['meta_keywords'] = $meta_keywords;
		$this->data ['meta_description'] = $meta_description;
	}
	protected function getCpanelMenu($clear = 0) {
		$menu_data = $this->cache->get ( 'cpanel_menu' );
		if ((! $menu_data) || ($clear != 0)) {
			$menu_data = array ();
			$this->loadModel ( 'user/user_page' );
			$rs = new ModelUserUserPage ( $this->registry );
			$list = $rs->getUserPageListCpanel ( PROJECT );
			$permissions = $this->user->getPermission ();
			foreach ( $list as $item ) {
				if ($this->user->hasPermission ( 'access', $item ['route'] )) {
					$menu_data [] = array (
							'title' => $this->language->get ( $item ['menu_key'] ),
							'text_1' => $this->language->get ( $item ['menu_key'] ),
							'href_1' => '',
							'text_2' => $this->language->get ( $item ['language_key'] ),
							'href_2' => ($item ['route'] != '') ? $this->url->link ( $item ['route'] . '&token=' . $this->session->data ['token'] ) : '' 
					);
				}
			}
			$menu_data = Helper::reOrganize ( $menu_data, 'title' );
			$this->cache->set ( 'cpanel_menu', $menu_data );
		}
		return $menu_data;
	}
}
