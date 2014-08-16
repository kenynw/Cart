<?php
class ControllerLocalisationCountry extends Controller {
	private $route = 'localisation/country';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		$this->getList ();
	}
	public function insert() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelLocalisationCountry ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->addCountry ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function update() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelLocalisationCountry ( $this->registry );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {
			$rs->editCountry ( $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getForm ();
	}
	public function delete() {
		$this->loadText ();
		$this->loadModel ( $this->route );
		$rs = new ModelLocalisationCountry ( $this->registry );
		if (isset ( $this->request->post ['selected'] ) && $this->validateDelete ()) {
			foreach ( $this->request->post ['selected'] as $id ) {
				$rs->deleteCountry ( $id );
			}
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->goBack ( $this->route );
		}
		$this->getList ();
	}
	protected function getList() {
		$id = 'country_id';
		$sort_data = array (
				'name',
				'iso_code_2',
				'iso_code_3'				
		);
		$this->loadModel ( $this->route );
		$rs = new ModelLocalisationCountry ( $this->registry );
		$record_total = $rs->getTotalCountries ();
		$param = $this->initList ( $this->route, $record_total, $sort_data );
		$results = $rs->getCountries_ ( $param, $sort_data );
		$records = array ();
		foreach ( $results as $result ) {
			$action = array ();
			$action [] = array (
					'text' => $this->language->get ( 'text_edit' ),
					'href' => $this->url->link ( $this->route . '/update', 'token=' . $this->session->data ['token'] . '&id=' . $result [$id] . $param ['url'], 'SSL' )
			);
			$result ['action'] = $action;
			$result ['selected'] = isset ( $this->request->post ['selected'] ) && in_array ( $result [$id], $this->request->post ['selected'] );
			$records [] = $result;
		}
		
		$this->data ['list'] = $records;
		$this->initNotice ();
		$this->initTpl ( 'localisation/country_list' );
		$this->children = array (
				'common/header',
				'common/footer'
		);
		$this->response->setOutput ( $this->render () );		
	}
	protected function getForm() {
		$this->loadModel ( $this->route );
		$rs = new ModelLocalisationCountry ( $this->registry );
		$this->data ['token'] = $this->session->data ['token'];
		$id = isset ( $this->request->get ['id'] ) ? $this->request->get ['id'] : '';
		if (isset ( $this->error ['name'] )) {
			$this->data ['error_name'] = $this->error ['name'];
		} else {
			$this->data ['error_name'] = '';
		}
		$url = $this->initUrlGet ( array (
				'sort',
				'order',
				'page'
		) );
		if ($id != '') {
			$this->data ['action'] = $this->url->link ( $this->route . '/update', 'token=' . $this->session->data ['token'] . '&id=' . $id . $url, 'SSL' );
		} else {
			$this->data ['action'] = $this->url->link ( $this->route . '/insert', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		}
		$this->data ['cancel'] = $this->url->link ( $this->route, 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		if (($id != '') && ($this->request->server ['REQUEST_METHOD'] != 'POST')) {
			$item = $rs->getCountry_ ( $id );
		} else {
			$item = $rs->getDefaultCountry ();
		}
		$this->initItem ( $item );
		$this->initNotice ();
		$this->initTpl ( 'localisation/country_form' );
		$this->children = array (
				'common/header',
				'common/footer'
		);
		$this->response->setOutput ( $this->render () );	
	}
	protected function validateForm() {			
		if (! $this->user->hasPermission ( 'modify', $this->route )) {
			$this->error ['warning'] = $this->language->get ( 'error_permission' );
		}
		if ((utf8_strlen ( $this->request->post ['name'] ) < 3) || (utf8_strlen ( $this->request->post ['name'] ) > 128)) {
			$this->error ['name'] = $this->language->get ( 'error_name' );
		}
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
	protected function validateDelete() {
		if (! $this->user->hasPermission ( 'modify', $this->route )) {
			$this->error ['warning'] = $this->language->get ( 'error_permission' );
		}
		$this->loadModel('setting/store');
		$rss = new ModelSettingStore($this->registry);
		$this->loadModel('sale/customer');
		$rsc = new ModelSaleCustomer($this->registry);
		$this->loadModel('sale/affiliate');
		$rsa = new ModelSaleAffiliate($this->registry);
		$this->loadModel('localisation/zone');
		$rsz = new ModelLocalisationZone($this->registry);
		$this->loadModel('localisation/geo_zone');
		$rsg = new ModelLocalisationGeoZone($this->registry);
		foreach ( $this->request->post ['selected'] as $country_id ) {
			if ($this->config->get ( 'config_country_id' ) == $country_id) {
				$this->error ['warning'] = $this->language->get ( 'error_default' );
			}
			$store_total = $rss->getTotalStoresByCountryId ( $country_id );
			if ($store_total) {
				$this->error ['warning'] = sprintf ( $this->language->get ( 'error_store' ), $store_total );
			}
			$address_total = $rsc->getTotalAddressesByCountryId ( $country_id );
			if ($address_total) {
				$this->error ['warning'] = sprintf ( $this->language->get ( 'error_address' ), $address_total );
			}
			$affiliate_total = $rsa->getTotalAffiliatesByCountryId ( $country_id );
			if ($affiliate_total) {
				$this->error ['warning'] = sprintf ( $this->language->get ( 'error_affiliate' ), $affiliate_total );
			}
			$zone_total = $rsz->getTotalZonesByCountryId ( $country_id );
			if ($zone_total) {
				$this->error ['warning'] = sprintf ( $this->language->get ( 'error_zone' ), $zone_total );
			}
			$zone_to_geo_zone_total = $rsg->getTotalZoneToGeoZoneByCountryId ( $country_id );
			if ($zone_to_geo_zone_total) {
				$this->error ['warning'] = sprintf ( $this->language->get ( 'error_zone_to_geo_zone' ), $zone_to_geo_zone_total );
			}
		}
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>