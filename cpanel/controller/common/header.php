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
		if (! $this->user->isLogged () || ! isset ( $this->request->get ['token'] ) || ! isset ( $this->session->data ['token'] ) || ($this->request->get ['token'] != $this->session->data ['token'])) {
			$this->data ['logged'] = '';
			$this->data ['home'] = $this->url->link ( 'common/login', '', 'SSL' );
		} else {
			$this->data ['logged'] = sprintf ( $this->language->get ( 'text_logged' ), $this->user->getUserName () );
			$this->data ['pp_express_status'] = $this->config->get ( 'pp_express_status' );
			$this->data ['home'] = $this->url->link ( 'common/home', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['affiliate'] = $this->url->link ( 'sale/affiliate', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['attribute'] = $this->url->link ( 'catalog/attribute', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['attribute_group'] = $this->url->link ( 'catalog/attribute_group', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['backup'] = $this->url->link ( 'tool/backup', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['banner'] = $this->url->link ( 'design/banner', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['category'] = $this->url->link ( 'catalog/category', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['country'] = $this->url->link ( 'localisation/country', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['coupon'] = $this->url->link ( 'sale/coupon', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['currency'] = $this->url->link ( 'localisation/currency', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['customer'] = $this->url->link ( 'sale/customer', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['customer_fields'] = $this->url->link ( 'sale/customer_field', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['customer_group'] = $this->url->link ( 'sale/customer_group', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['customer_ban_ip'] = $this->url->link ( 'sale/customer_ban_ip', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['custom_field'] = $this->url->link ( 'design/custom_field', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['download'] = $this->url->link ( 'catalog/download', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['error_log'] = $this->url->link ( 'tool/error_log', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['feed'] = $this->url->link ( 'extension/feed', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['filter'] = $this->url->link ( 'catalog/filter', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['geo_zone'] = $this->url->link ( 'localisation/geo_zone', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['information'] = $this->url->link ( 'catalog/information', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['language'] = $this->url->link ( 'localisation/language', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['layout'] = $this->url->link ( 'design/layout', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['logout'] = $this->url->link ( 'common/logout', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['contact'] = $this->url->link ( 'sale/contact', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['manager'] = $this->url->link ( 'extension/manager', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['manufacturer'] = $this->url->link ( 'catalog/manufacturer', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['module'] = $this->url->link ( 'extension/module', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['option'] = $this->url->link ( 'catalog/option', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['order'] = $this->url->link ( 'sale/order', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['order_status'] = $this->url->link ( 'localisation/order_status', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['payment'] = $this->url->link ( 'extension/payment', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['product'] = $this->url->link ( 'catalog/product', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['profile'] = $this->url->link ( 'catalog/profile', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_sale_order'] = $this->url->link ( 'report/sale_order', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_sale_tax'] = $this->url->link ( 'report/sale_tax', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_sale_shipping'] = $this->url->link ( 'report/sale_shipping', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_sale_return'] = $this->url->link ( 'report/sale_return', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_sale_coupon'] = $this->url->link ( 'report/sale_coupon', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_product_viewed'] = $this->url->link ( 'report/product_viewed', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_product_purchased'] = $this->url->link ( 'report/product_purchased', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_customer_online'] = $this->url->link ( 'report/customer_online', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_customer_order'] = $this->url->link ( 'report/customer_order', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_customer_reward'] = $this->url->link ( 'report/customer_reward', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_customer_credit'] = $this->url->link ( 'report/customer_credit', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['report_affiliate_commission'] = $this->url->link ( 'report/affiliate_commission', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['review'] = $this->url->link ( 'catalog/review', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['return'] = $this->url->link ( 'sale/return', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['return_action'] = $this->url->link ( 'localisation/return_action', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['return_reason'] = $this->url->link ( 'localisation/return_reason', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['return_status'] = $this->url->link ( 'localisation/return_status', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['shipping'] = $this->url->link ( 'extension/shipping', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['setting'] = $this->url->link ( 'setting/store', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['store'] = HTTP_CATALOG;
			$this->data ['stock_status'] = $this->url->link ( 'localisation/stock_status', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['tax_class'] = $this->url->link ( 'localisation/tax_class', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['tax_rate'] = $this->url->link ( 'localisation/tax_rate', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['total'] = $this->url->link ( 'extension/total', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['user'] = $this->url->link ( 'user/user', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['user_group'] = $this->url->link ( 'user/user_permission', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['voucher'] = $this->url->link ( 'sale/voucher', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['voucher_theme'] = $this->url->link ( 'sale/voucher_theme', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['weight_class'] = $this->url->link ( 'localisation/weight_class', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['length_class'] = $this->url->link ( 'localisation/length_class', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['zone'] = $this->url->link ( 'localisation/zone', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_show_menu'] = $this->config->get ( 'openbaymanager_show_menu' );
			$this->data ['openbay_link_extension'] = $this->url->link ( 'extension/openbay', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_orders'] = $this->url->link ( 'extension/openbay/orderList', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_items'] = $this->url->link ( 'extension/openbay/itemList', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_ebay'] = $this->url->link ( 'openbay/openbay', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_ebay_settings'] = $this->url->link ( 'openbay/openbay/settings', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_ebay_links'] = $this->url->link ( 'openbay/openbay/viewItemLinks', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_ebay_orderimport'] = $this->url->link ( 'openbay/openbay/viewOrderImport', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_amazon'] = $this->url->link ( 'openbay/amazon', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_amazon_settings'] = $this->url->link ( 'openbay/amazon/settings', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_amazon_links'] = $this->url->link ( 'openbay/amazon/itemLinks', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_amazonus'] = $this->url->link ( 'openbay/amazonus', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_amazonus_settings'] = $this->url->link ( 'openbay/amazonus/settings', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_link_amazonus_links'] = $this->url->link ( 'openbay/amazonus/itemLinks', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['openbay_markets'] = array (
					'ebay' => $this->config->get ( 'openbay_status' ),
					'amazon' => $this->config->get ( 'amazon_status' ),
					'amazonus' => $this->config->get ( 'amazonus_status' ) 
			);
			$this->data ['paypal_express'] = $this->url->link ( 'payment/pp_express', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['paypal_express_search'] = $this->url->link ( 'payment/pp_express/search', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['recurring_profile'] = $this->url->link ( 'sale/recurring', 'token=' . $this->session->data ['token'], 'SSL' );
			$this->data ['stores'] = array ();
			$this->load->model ( 'setting/store' );
			$results = $this->model_setting_store->getStores ();
			foreach ( $results as $result ) {
				$this->data ['stores'] [] = array (
						'name' => $result ['name'],
						'href' => $result ['url'] 
				);
			}
		}
		$this->initTpl ( $this->route );
		$this->render ();
	}
}
?>