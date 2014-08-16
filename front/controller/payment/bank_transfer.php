<?php
class ControllerPaymentBankTransfer extends Controller {
	private $route = 'payment/bank_transfer';
	private function loadText($route = '') {
		if($route != ''){
			$this->loadLang ( $route );
		}else{
			$this->loadLang ( $this->route ); }
	}
	protected function index() {
		$this->loadText ();

		
		
		

		

		$this->data['bank'] = nl2br($this->config->get('bank_transfer_bank_' . $this->config->get('config_language_id')));

		$this->data['continue'] = $this->url->link('checkout/success');

		$this->initTpl($this->route);	

		$this->render(); 
	}

	public function confirm() {
		$this->loadText ();

		$this->load->model('checkout/order');

		$comment  = $this->language->get('text_instruction') . "\n\n";
		$comment .= $this->config->get('bank_transfer_bank_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->language->get('text_payment');

		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('bank_transfer_order_status_id'), $comment, true);
	}
}
?>