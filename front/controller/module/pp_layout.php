<?php
class ControllerModulePPLayout extends Controller {
	private $route = 'module/pp_layout';
	protected function index($setting) {
		$status = $this->config->get ( 'pp_express_status' );
		
		if ((! $this->cart->hasProducts () && empty ( $this->session->data ['vouchers'] )) || (! $this->cart->hasStock () && ! $this->config->get ( 'config_stock_checkout' )) || (! $this->customer->isLogged () && ($this->cart->hasRecurringProducts () || $this->cart->hasDownload ()))) {
			
			$status = false;
		}
		
		if ($status) {
			
			$this->load->model ( 'payment/pp_express' );
			
			$this->data ['is_mobile'] = $this->model_payment_pp_express->isMobile ();
			
			$this->initTpl ( $this->route );
			
			$this->data ['payment_url'] = $this->url->link ( 'payment/pp_express/express', '', 'SSL' );
			
			$this->render ();
		}
	}
}

?>