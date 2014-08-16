<?php
class ControllerPaymentCheque extends Controller {
	private $route = 'payment/cheque';
	private function loadText($route = '') {
		if($route != ''){
			$this->loadLang ( $route );
		}else{
			$this->loadLang ( $this->route ); }
	}
	protected function index() {
		$this->loadText ();

		
		
		
		

		

		$this->data['payable'] = $this->config->get('cheque_payable');
		$this->data['address'] = nl2br($this->config->get('config_address'));

		$this->data['continue'] = $this->url->link('checkout/success');
		
		$this->initTpl($this->route);

		$this->render(); 
	}

	public function confirm() {
		$this->loadText ();

		$this->load->model('checkout/order');

		$comment  = $this->language->get('text_payable') . "\n";
		$comment .= $this->config->get('cheque_payable') . "\n\n";
		$comment .= $this->language->get('text_address') . "\n";
		$comment .= $this->config->get('config_address') . "\n\n";
		$comment .= $this->language->get('text_payment') . "\n";

		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('cheque_order_status_id'), $comment, true);
	}
}
?>