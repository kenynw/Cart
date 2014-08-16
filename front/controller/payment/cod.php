<?php
class ControllerPaymentCod extends Controller {
	private $route = 'payment/cod';
	protected function index() {
		$this->data['button_confirm'] = $this->language->get('button_confirm');


		$this->data['continue'] = $this->url->link('checkout/success');

		$this->initTpl($this->route);		

		$this->render();
	}

	public function confirm() {
		$this->load->model('checkout/order');

		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('cod_order_status_id'));
	}
}
?>