<?php
class ControllerPaymentPPExpress extends Controller {
	private $route = 'payment/pp_express';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		$this->load->model ( 'setting/setting' );
		$this->load->model ( 'setting/extension' );
		$this->load->model ( $this->route );
		$this->error = array ();
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validate ()) {
			unset ( $this->request->post ['pp_express_module'] );
			$this->model_setting_setting->editSetting ( 'pp_express', $this->request->post );
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			$this->redirect ( $this->url->link ( 'extension/payment', 'token=' . $this->session->data ['token'], 'SSL' ) );
		} else {
			$this->data ['error'] = @$this->error;
		}
		$this->data ['text_ipn_url'] = HTTPS_CATALOG . 'index.php?route=payment/pp_express/ipn';
		// button actions
		$this->data ['action'] = $this->url->link ( 'payment/pp_express', 'token=' . $this->session->data ['token'], 'SSL' );
		$this->data ['cancel'] = $this->url->link ( 'extension/payment', 'token=' . $this->session->data ['token'], 'SSL' );
		if (isset ( $this->request->post ['pp_express_username'] )) {
			$this->data ['pp_express_username'] = $this->request->post ['pp_express_username'];
		} else {
			$this->data ['pp_express_username'] = $this->config->get ( 'pp_express_username' );
		}
		if (isset ( $this->request->post ['pp_express_password'] )) {
			$this->data ['pp_express_password'] = $this->request->post ['pp_express_password'];
		} else {
			$this->data ['pp_express_password'] = $this->config->get ( 'pp_express_password' );
		}
		if (isset ( $this->request->post ['pp_express_signature'] )) {
			$this->data ['pp_express_signature'] = $this->request->post ['pp_express_signature'];
		} else {
			$this->data ['pp_express_signature'] = $this->config->get ( 'pp_express_signature' );
		}
		if (isset ( $this->request->post ['pp_express_test'] )) {
			$this->data ['pp_express_test'] = $this->request->post ['pp_express_test'];
		} else {
			$this->data ['pp_express_test'] = $this->config->get ( 'pp_express_test' );
		}
		if (isset ( $this->request->post ['pp_express_method'] )) {
			$this->data ['pp_express_method'] = $this->request->post ['pp_express_method'];
		} else {
			$this->data ['pp_express_method'] = $this->config->get ( 'pp_express_method' );
		}
		if (isset ( $this->request->post ['pp_express_total'] )) {
			$this->data ['pp_express_total'] = $this->request->post ['pp_express_total'];
		} else {
			$this->data ['pp_express_total'] = $this->config->get ( 'pp_express_total' );
		}
		if (isset ( $this->request->post ['pp_express_debug'] )) {
			$this->data ['pp_express_debug'] = $this->request->post ['pp_express_debug'];
		} else {
			$this->data ['pp_express_debug'] = $this->config->get ( 'pp_express_debug' );
		}
		if (isset ( $this->request->post ['pp_express_currency'] )) {
			$this->data ['pp_express_currency'] = $this->request->post ['pp_express_currency'];
		} else {
			$this->data ['pp_express_currency'] = $this->config->get ( 'pp_express_currency' );
		}
		$this->data ['currency_codes'] = $this->model_payment_pp_express->currencyCodes ();
		$this->load->model ( 'localisation/order_status' );
		$this->data ['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses ();
		if (isset ( $this->request->post ['pp_express_canceled_reversal_status_id'] )) {
			$this->data ['pp_express_canceled_reversal_status_id'] = $this->request->post ['pp_express_canceled_reversal_status_id'];
		} else {
			$this->data ['pp_express_canceled_reversal_status_id'] = $this->config->get ( 'pp_express_canceled_reversal_status_id' );
		}
		if (isset ( $this->request->post ['pp_express_completed_status_id'] )) {
			$this->data ['pp_express_completed_status_id'] = $this->request->post ['pp_express_completed_status_id'];
		} else {
			$this->data ['pp_express_completed_status_id'] = $this->config->get ( 'pp_express_completed_status_id' );
		}
		if (isset ( $this->request->post ['pp_express_denied_status_id'] )) {
			$this->data ['pp_express_denied_status_id'] = $this->request->post ['pp_express_denied_status_id'];
		} else {
			$this->data ['pp_express_denied_status_id'] = $this->config->get ( 'pp_express_denied_status_id' );
		}
		if (isset ( $this->request->post ['pp_express_expired_status_id'] )) {
			$this->data ['pp_express_expired_status_id'] = $this->request->post ['pp_express_expired_status_id'];
		} else {
			$this->data ['pp_express_expired_status_id'] = $this->config->get ( 'pp_express_expired_status_id' );
		}
		if (isset ( $this->request->post ['pp_express_failed_status_id'] )) {
			$this->data ['pp_express_failed_status_id'] = $this->request->post ['pp_express_failed_status_id'];
		} else {
			$this->data ['pp_express_failed_status_id'] = $this->config->get ( 'pp_express_failed_status_id' );
		}
		if (isset ( $this->request->post ['pp_express_pending_status_id'] )) {
			$this->data ['pp_express_pending_status_id'] = $this->request->post ['pp_express_pending_status_id'];
		} else {
			$this->data ['pp_express_pending_status_id'] = $this->config->get ( 'pp_express_pending_status_id' );
		}
		if (isset ( $this->request->post ['pp_express_processed_status_id'] )) {
			$this->data ['pp_express_processed_status_id'] = $this->request->post ['pp_express_processed_status_id'];
		} else {
			$this->data ['pp_express_processed_status_id'] = $this->config->get ( 'pp_express_processed_status_id' );
		}
		if (isset ( $this->request->post ['pp_express_refunded_status_id'] )) {
			$this->data ['pp_express_refunded_status_id'] = $this->request->post ['pp_express_refunded_status_id'];
		} else {
			$this->data ['pp_express_refunded_status_id'] = $this->config->get ( 'pp_express_refunded_status_id' );
		}
		if (isset ( $this->request->post ['pp_express_reversed_status_id'] )) {
			$this->data ['pp_express_reversed_status_id'] = $this->request->post ['pp_express_reversed_status_id'];
		} else {
			$this->data ['pp_express_reversed_status_id'] = $this->config->get ( 'pp_express_reversed_status_id' );
		}
		if (isset ( $this->request->post ['pp_express_voided_status_id'] )) {
			$this->data ['pp_express_voided_status_id'] = $this->request->post ['pp_express_voided_status_id'];
		} else {
			$this->data ['pp_express_voided_status_id'] = $this->config->get ( 'pp_express_voided_status_id' );
		}
		if (isset ( $this->request->post ['pp_express_allow_note'] )) {
			$this->data ['pp_express_allow_note'] = $this->request->post ['pp_express_allow_note'];
		} else {
			$this->data ['pp_express_allow_note'] = $this->config->get ( 'pp_express_allow_note' );
		}
		if (isset ( $this->request->post ['pp_express_logo'] )) {
			$this->data ['pp_express_logo'] = $this->request->post ['pp_express_logo'];
		} else {
			$this->data ['pp_express_logo'] = $this->config->get ( 'pp_express_logo' );
		}
		if (isset ( $this->request->post ['pp_express_border_colour'] )) {
			$this->data ['pp_express_border_colour'] = str_replace ( '#', '', $this->request->post ['pp_express_border_colour'] );
		} else {
			$this->data ['pp_express_border_colour'] = $this->config->get ( 'pp_express_border_colour' );
		}
		if (isset ( $this->request->post ['pp_express_header_colour'] )) {
			$this->data ['pp_express_header_colour'] = str_replace ( '#', '', $this->request->post ['pp_express_header_colour'] );
		} else {
			$this->data ['pp_express_header_colour'] = $this->config->get ( 'pp_express_header_colour' );
		}
		if (isset ( $this->request->post ['pp_express_page_colour'] )) {
			$this->data ['pp_express_page_colour'] = str_replace ( '#', '', $this->request->post ['pp_express_page_colour'] );
		} else {
			$this->data ['pp_express_page_colour'] = $this->config->get ( 'pp_express_page_colour' );
		}
		if (isset ( $this->request->post ['pp_express_profile_cancel_status'] )) {
			$this->data ['pp_express_profile_cancel_status'] = $this->request->post ['pp_express_profile_cancel_status'];
		} else {
			$this->data ['pp_express_profile_cancel_status'] = $this->config->get ( 'pp_express_profile_cancel_status' );
		}
		$this->load->model ( 'tool/image' );
		$logo = $this->config->get ( 'pp_express_logo' );
		if (isset ( $this->request->post ['pp_express_logo'] ) && file_exists ( DIR_IMAGE . $this->request->post ['pp_express_logo'] )) {
			$this->data ['thumb'] = $this->model_tool_image->resize ( $this->request->post ['pp_express_logo'], 750, 90 );
		} elseif (($logo != '') && file_exists ( DIR_IMAGE . $logo )) {
			$this->data ['thumb'] = $this->model_tool_image->resize ( $logo, 750, 90 );
		} else {
			$this->data ['thumb'] = $this->model_tool_image->resize ( 'no_image.jpg', 750, 90 );
		}
		$this->data ['no_image'] = $this->model_tool_image->resize ( 'no_image.jpg', 750, 90 );
		if (isset ( $this->request->post ['pp_express_geo_zone_id'] )) {
			$this->data ['pp_express_geo_zone_id'] = $this->request->post ['pp_express_geo_zone_id'];
		} else {
			$this->data ['pp_express_geo_zone_id'] = $this->config->get ( 'pp_express_geo_zone_id' );
		}
		$this->load->model ( 'localisation/geo_zone' );
		$this->data ['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones ();
		if (isset ( $this->request->post ['pp_express_status'] )) {
			$this->data ['pp_express_status'] = $this->request->post ['pp_express_status'];
		} else {
			$this->data ['pp_express_status'] = $this->config->get ( 'pp_express_status' );
		}
		if (isset ( $this->request->post ['pp_express_sort_order'] )) {
			$this->data ['pp_express_sort_order'] = $this->request->post ['pp_express_sort_order'];
		} else {
			$this->data ['pp_express_sort_order'] = $this->config->get ( 'pp_express_sort_order' );
		}
		$this->data ['token'] = $this->session->data ['token'];
		$this->initTpl ( $this->route );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	public function imageLogo() {
		$this->load->model ( 'tool/image' );
		if (isset ( $this->request->get ['image'] )) {
			$this->response->setOutput ( $this->model_tool_image->resize ( html_entity_decode ( $this->request->get ['image'], ENT_QUOTES, 'UTF-8' ), 750, 90 ) );
		}
	}
	protected function validate() {
		if (! $this->user->hasPermission ( 'modify', $this->route )) {
			$this->error ['warning'] = $this->language->get ( 'error_permission' );
		}
		if (empty ( $this->request->post ['pp_express_username'] )) {
			$this->error ['username'] = $this->language->get ( 'error_username' );
		}
		if (empty ( $this->request->post ['pp_express_password'] )) {
			$this->error ['password'] = $this->language->get ( 'error_password' );
		}
		if (empty ( $this->request->post ['pp_express_signature'] )) {
			$this->error ['signature'] = $this->language->get ( 'error_signature' );
		}
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
	public function resend() {
		$this->load->model ( $this->route );
		$this->load->language ( $this->route );
		$json = array ();
		if (isset ( $this->request->get ['paypal_order_transaction_id'] )) {
			$transaction = $this->model_payment_pp_express->getFailedTransaction ( $this->request->get ['paypal_order_transaction_id'] );
			if ($transaction) {
				$call_data = unserialize ( $transaction ['call_data'] );
				$result = $this->model_payment_pp_express->call ( $call_data );
				if ($result) {
					$parent_transaction = $this->model_payment_pp_express->getLocalTransaction ( $transaction ['parent_transaction_id'] );
					if ($parent_transaction ['amount'] == abs ( $transaction ['amount'] )) {
						$this->db->query ( "UPDATE `" . DB_PREFIX . "paypal_order_transaction` SET `payment_status` = 'Refunded' WHERE `transaction_id` = '" . $this->db->escape ( $transaction ['parent_transaction_id'] ) . "' LIMIT 1" );
					} else {
						$this->db->query ( "UPDATE `" . DB_PREFIX . "paypal_order_transaction` SET `payment_status` = 'Partially-Refunded' WHERE `transaction_id` = '" . $this->db->escape ( $transaction ['parent_transaction_id'] ) . "' LIMIT 1" );
					}
					if (isset ( $result ['REFUNDTRANSACTIONID'] )) {
						$transaction ['transaction_id'] = $result ['REFUNDTRANSACTIONID'];
					} else {
						$transaction ['transaction_id'] = $result ['TRANSACTIONID'];
					}
					if (isset ( $result ['PAYMENTTYPE'] )) {
						$transaction ['payment_type'] = $result ['PAYMENTTYPE'];
					} else {
						$transaction ['payment_type'] = $result ['REFUNDSTATUS'];
					}
					if (isset ( $result ['PAYMENTSTATUS'] )) {
						$transaction ['payment_status'] = $result ['PAYMENTSTATUS'];
					} else {
						$transaction ['payment_status'] = 'Refunded';
					}
					if (isset ( $result ['AMT'] )) {
						$transaction ['amount'] = $result ['AMT'];
					} else {
						$transaction ['amount'] = $transaction ['amount'];
					}
					$transaction ['pending_reason'] = (isset ( $result ['PENDINGREASON'] ) ? $result ['PENDINGREASON'] : '');
					$this->model_payment_pp_express->updateTransaction ( $transaction );
					$json ['success'] = $this->language->get ( 'success_transaction_resent' );
				} else {
					$json ['error'] = $this->language->get ( 'error_timeout' );
				}
			} else {
				$json ['error'] = $this->language->get ( 'error_transaction_missing' );
			}
		} else {
			$json ['error'] = $this->language->get ( 'error_data' );
		}
		$this->response->setOutput ( json_encode ( $json ) );
	}
	public function capture() {
		$this->load->language ( $this->route );
		/**
		 * used to capture authorised payments
		 *
		 * capture can be full or partial amounts
		 */
		if (isset ( $this->request->post ['order_id'] ) && $this->request->post ['amount'] > 0 && isset ( $this->request->post ['order_id'] ) && isset ( $this->request->post ['complete'] )) {
			$this->load->model ( $this->route );
			$paypal_order = $this->model_payment_pp_express->getOrder ( $this->request->post ['order_id'] );
			if ($this->request->post ['complete'] == 1) {
				$complete = 'Complete';
			} else {
				$complete = 'NotComplete';
			}
			$call_data = array ();
			$call_data ['METHOD'] = 'DoCapture';
			$call_data ['AUTHORIZATIONID'] = $paypal_order ['authorization_id'];
			$call_data ['AMT'] = number_format ( $this->request->post ['amount'], 2 );
			$call_data ['CURRENCYCODE'] = $paypal_order ['currency_code'];
			$call_data ['COMPLETETYPE'] = $complete;
			$call_data ['MSGSUBID'] = uniqid ( mt_rand (), true );
			$result = $this->model_payment_pp_express->call ( $call_data );
			$transaction = array (
					'paypal_order_id' => $paypal_order ['paypal_order_id'],
					'transaction_id' => '',
					'parent_transaction_id' => $paypal_order ['authorization_id'],
					'note' => '',
					'msgsubid' => $call_data ['MSGSUBID'],
					'receipt_id' => '',
					'payment_type' => '',
					'payment_status' => '',
					'pending_reason' => '',
					'transaction_entity' => 'payment',
					'amount' => '',
					'debug_data' => json_encode ( $result ) 
			);
			if ($result == false) {
				$transaction ['amount'] = number_format ( $this->request->post ['amount'], 2 );
				$paypal_order_transaction_id = $this->model_payment_pp_express->addTransaction_ ( $transaction, $call_data );
				$json ['error'] = true;
				$json ['failed_transaction'] ['paypal_order_transaction_id'] = $paypal_order_transaction_id;
				$json ['failed_transaction'] ['amount'] = $transaction ['amount'];
				$json ['failed_transaction'] ['created'] = date ( "Y-m-d H:i:s" );
				$json ['msg'] = $this->language->get ( 'error_timeout' );
			} else if (isset ( $result ['ACK'] ) && $result ['ACK'] != 'Failure' && $result ['ACK'] != 'FailureWithWarning') {
				$transaction ['transaction_id'] = $result ['TRANSACTIONID'];
				$transaction ['payment_type'] = $result ['PAYMENTTYPE'];
				$transaction ['payment_status'] = $result ['PAYMENTSTATUS'];
				$transaction ['pending_reason'] = (isset ( $result ['PENDINGREASON'] ) ? $result ['PENDINGREASON'] : '');
				$transaction ['amount'] = $result ['AMT'];
				$this->model_payment_pp_express->addTransaction_ ( $transaction );
				unset ( $transaction ['debug_data'] );
				$transaction ['created'] = date ( "Y-m-d H:i:s" );
				$captured = number_format ( $this->model_payment_pp_express->totalCaptured_ ( $paypal_order ['paypal_order_id'] ), 2 );
				$refunded = number_format ( $this->model_payment_pp_express->totalRefundedOrder ( $paypal_order ['paypal_order_id'] ), 2 );
				$transaction ['captured'] = $captured;
				$transaction ['refunded'] = $refunded;
				$transaction ['remaining'] = number_format ( $paypal_order ['total'] - $captured, 2 );
				$transaction ['status'] = 0;
				if ($transaction ['remaining'] == 0.00) {
					$transaction ['status'] = 1;
					$this->model_payment_pp_express->updateOrder ( 'Complete', $this->request->post ['order_id'] );
				}
				$transaction ['void'] = '';
				if ($this->request->post ['complete'] == 1 && $transaction ['remaining'] > 0) {
					$transaction ['void'] = array (
							'paypal_order_id' => $paypal_order ['paypal_order_id'],
							'transaction_id' => '',
							'parent_transaction_id' => $paypal_order ['authorization_id'],
							'note' => '',
							'msgsubid' => '',
							'receipt_id' => '',
							'payment_type' => '',
							'payment_status' => 'Void',
							'pending_reason' => '',
							'amount' => '',
							'debug_data' => 'Voided after capture',
							'transaction_entity' => 'auth' 
					);
					$this->model_payment_pp_express->addTransaction_ ( $transaction ['void'] );
					$this->model_payment_pp_express->updateOrder ( 'Complete', $this->request->post ['order_id'] );
					$transaction ['void'] ['created'] = date ( "Y-m-d H:i:s" );
					$transaction ['status'] = 1;
				}
				$json ['data'] = $transaction;
				$json ['error'] = false;
				$json ['msg'] = 'Ok';
			} else {
				$json ['error'] = true;
				$json ['msg'] = (isset ( $result ['L_SHORTMESSAGE0'] ) ? $result ['L_SHORTMESSAGE0'] : 'There was an error');
			}
		} else {
			$json ['error'] = true;
			$json ['msg'] = 'Missing data';
		}
		$this->response->setOutput ( json_encode ( $json ) );
	}
	public function void() {
		/**
		 * used to void an authorised payment
		 */
		if (isset ( $this->request->post ['order_id'] ) && $this->request->post ['order_id'] != '') {
			$this->load->model ( $this->route );
			$paypal_order = $this->model_payment_pp_express->getOrder ( $this->request->post ['order_id'] );
			$call_data = array ();
			$call_data ['METHOD'] = 'DoVoid';
			$call_data ['AUTHORIZATIONID'] = $paypal_order ['authorization_id'];
			$result = $this->model_payment_pp_express->call ( $call_data );
			if ($result ['ACK'] != 'Failure' && $result ['ACK'] != 'FailureWithWarning') {
				$transaction = array (
						'paypal_order_id' => $paypal_order ['paypal_order_id'],
						'transaction_id' => '',
						'parent_transaction_id' => $paypal_order ['authorization_id'],
						'note' => '',
						'msgsubid' => '',
						'receipt_id' => '',
						'payment_type' => 'void',
						'payment_status' => 'Void',
						'pending_reason' => '',
						'transaction_entity' => 'auth',
						'amount' => '',
						'debug_data' => json_encode ( $result ) 
				);
				$this->model_payment_pp_express->addTransaction_ ( $transaction );
				$this->model_payment_pp_express->updateOrder ( 'Complete', $this->request->post ['order_id'] );
				unset ( $transaction ['debug_data'] );
				$transaction ['created'] = date ( "Y-m-d H:i:s" );
				$json ['data'] = $transaction;
				$json ['error'] = false;
				$json ['msg'] = 'Transaction void';
			} else {
				$json ['error'] = true;
				$json ['msg'] = (isset ( $result ['L_SHORTMESSAGE0'] ) ? $result ['L_SHORTMESSAGE0'] : 'There was an error');
			}
		} else {
			$json ['error'] = true;
			$json ['msg'] = 'Missing data';
		}
		$this->response->setOutput ( json_encode ( $json ) );
	}
	public function refund() {
		$this->load->language ( 'payment/pp_express_refund' );
		// button actions
		$this->data ['action'] = $this->url->link ( 'payment/pp_express/doRefund', 'token=' . $this->session->data ['token'], 'SSL' );
		$this->data ['cancel'] = $this->url->link ( 'payment/pp_express', 'token=' . $this->session->data ['token'], 'SSL' );
		$this->data ['transaction_id'] = $this->request->get ['transaction_id'];
		$this->load->model ( $this->route );
		$pp_transaction = $this->model_payment_pp_express->getTransaction ( $this->request->get ['transaction_id'] );
		$this->data ['amount_original'] = $pp_transaction ['AMT'];
		$this->data ['currency_code'] = $pp_transaction ['CURRENCYCODE'];
		$refunded = number_format ( $this->model_payment_pp_express->totalRefundedTransaction ( $this->request->get ['transaction_id'] ), 2 );
		if ($refunded != 0.00) {
			$this->data ['refund_available'] = number_format ( $this->data ['amount_original'] + $refunded, 2 );
		} else {
			$this->data ['refund_available'] = '';
			$this->data ['attention'] = '';
		}
		$this->data ['token'] = $this->session->data ['token'];
		if (isset ( $this->session->data ['error'] )) {
			$this->data ['error'] = $this->session->data ['error'];
			unset ( $this->session->data ['error'] );
		} else {
			$this->data ['error'] = '';
		}
		$this->initTpl ( 'payment/pp_express_refund' );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	public function doRefund() {
		/**
		 * used to issue a refund for a captured payment
		 *
		 * refund can be full or partial
		 */
		if (isset ( $this->request->post ['transaction_id'] ) && isset ( $this->request->post ['refund_full'] )) {
			$this->load->model ( $this->route );
			$this->load->language ( 'payment/pp_express_refund' );
			if ($this->request->post ['refund_full'] == 0 && $this->request->post ['amount'] == 0) {
				$this->session->data ['error'] = $this->language->get ( 'error_partial_amt' );
			} else {
				$order_id = $this->model_payment_pp_express->getOrderId ( $this->request->post ['transaction_id'] );
				$paypal_order = $this->model_payment_pp_express->getOrder ( $order_id );
				if ($paypal_order) {
					$call_data = array ();
					$call_data ['METHOD'] = 'RefundTransaction';
					$call_data ['TRANSACTIONID'] = $this->request->post ['transaction_id'];
					$call_data ['NOTE'] = urlencode ( $this->request->post ['refund_message'] );
					$call_data ['MSGSUBID'] = uniqid ( mt_rand (), true );
					$current_transaction = $this->model_payment_pp_express->getLocalTransaction ( $this->request->post ['transaction_id'] );
					if ($this->request->post ['refund_full'] == 1) {
						$call_data ['REFUNDTYPE'] = 'Full';
					} else {
						$call_data ['REFUNDTYPE'] = 'Partial';
						$call_data ['AMT'] = number_format ( $this->request->post ['amount'], 2 );
						$call_data ['CURRENCYCODE'] = $this->request->post ['currency_code'];
					}
					$result = $this->model_payment_pp_express->call ( $call_data );
					$transaction = array (
							'paypal_order_id' => $paypal_order ['paypal_order_id'],
							'transaction_id' => '',
							'parent_transaction_id' => $this->request->post ['transaction_id'],
							'note' => $this->request->post ['refund_message'],
							'msgsubid' => $call_data ['MSGSUBID'],
							'receipt_id' => '',
							'payment_type' => '',
							'payment_status' => 'Refunded',
							'transaction_entity' => 'payment',
							'pending_reason' => '',
							'amount' => '-' . (isset ( $call_data ['AMT'] ) ? $call_data ['AMT'] : $current_transaction ['amount']),
							'debug_data' => json_encode ( $result ) 
					);
					if ($result == false) {
						$transaction ['payment_status'] = 'Failed';
						$this->model_payment_pp_express->addTransaction_ ( $transaction, $call_data );
						$this->redirect ( $this->url->link ( 'sale/order/info', 'token=' . $this->session->data ['token'] . '&order_id=' . $paypal_order ['order_id'], 'SSL' ) );
					} else if ($result ['ACK'] != 'Failure' && $result ['ACK'] != 'FailureWithWarning') {
						$transaction ['transaction_id'] = $result ['REFUNDTRANSACTIONID'];
						$transaction ['payment_type'] = $result ['REFUNDSTATUS'];
						$transaction ['pending_reason'] = $result ['PENDINGREASON'];
						$transaction ['amount'] = '-' . $result ['GROSSREFUNDAMT'];
						$this->model_payment_pp_express->addTransaction_ ( $transaction );
						// update transaction to refunded status
						if ($result ['TOTALREFUNDEDAMOUNT'] == $this->request->post ['amount_original']) {
							$this->db->query ( "UPDATE `" . DB_PREFIX . "paypal_order_transaction` SET `payment_status` = 'Refunded' WHERE `transaction_id` = '" . $this->db->escape ( $this->request->post ['transaction_id'] ) . "' LIMIT 1" );
						} else {
							$this->db->query ( "UPDATE `" . DB_PREFIX . "paypal_order_transaction` SET `payment_status` = 'Partially-Refunded' WHERE `transaction_id` = '" . $this->db->escape ( $this->request->post ['transaction_id'] ) . "' LIMIT 1" );
						}
						// redirect back to the order
						$this->redirect ( $this->url->link ( 'sale/order/info', 'token=' . $this->session->data ['token'] . '&order_id=' . $paypal_order ['order_id'], 'SSL' ) );
					} else {
						$this->model_payment_pp_express->log ( json_encode ( $result ) );
						$this->session->data ['error'] = (isset ( $result ['L_SHORTMESSAGE0'] ) ? $result ['L_SHORTMESSAGE0'] : 'There was an error') . (isset ( $result ['L_LONGMESSAGE0'] ) ? '<br />' . $result ['L_LONGMESSAGE0'] : '');
						$this->redirect ( $this->url->link ( 'payment/pp_express/refund', 'token=' . $this->session->data ['token'] . '&transaction_id=' . $this->request->post ['transaction_id'], 'SSL' ) );
					}
				} else {
					$this->session->data ['error'] = $this->language->get ( 'error_data_missing' );
					$this->redirect ( $this->url->link ( 'payment/pp_express/refund', 'token=' . $this->session->data ['token'] . '&transaction_id=' . $this->request->post ['transaction_id'], 'SSL' ) );
				}
			}
		} else {
			$this->session->data ['error'] = $this->language->get ( 'error_data' );
			$this->redirect ( $this->url->link ( 'payment/pp_express/refund', 'token=' . $this->session->data ['token'] . '&transaction_id=' . $this->request->post ['transaction_id'], 'SSL' ) );
		}
	}
	public function install() {
		$this->load->model ( $this->route );
		$this->model_payment_pp_express->install ();
	}
	public function uninstall() {
		$this->load->model ( $this->route );
		$this->model_payment_pp_express->uninstall ();
	}
	public function orderAction() {
		if ($this->config->get ( 'pp_express_status' )) {
			$this->load->model ( $this->route );
			$this->load->language ( 'payment/pp_express_order' );
			$paypal_order = $this->model_payment_pp_express->getOrder ( $this->request->get ['order_id'] );
			if ($paypal_order) {
				$this->data ['paypal_order'] = $paypal_order;
				$this->data ['order_id'] = $this->request->get ['order_id'];
				$this->data ['token'] = $this->session->data ['token'];
				$captured = number_format ( $this->model_payment_pp_express->totalCaptured_ ( $this->data ['paypal_order'] ['paypal_order_id'] ), 2 );
				$refunded = number_format ( $this->model_payment_pp_express->totalRefundedOrder ( $this->data ['paypal_order'] ['paypal_order_id'] ), 2 );
				$this->data ['paypal_order'] ['captured'] = $captured;
				$this->data ['paypal_order'] ['refunded'] = $refunded;
				$this->data ['paypal_order'] ['remaining'] = number_format ( $this->data ['paypal_order'] ['total'] - $captured, 2 );
				if ($paypal_order) {
					$captured = number_format ( $this->model_payment_pp_express->totalCaptured_ ( $paypal_order ['paypal_order_id'] ), 2 );
					$refunded = number_format ( $this->model_payment_pp_express->totalRefundedOrder ( $paypal_order ['paypal_order_id'] ), 2 );
					$this->data ['paypal_order'] = $paypal_order;
					$this->data ['paypal_order'] ['captured'] = $captured;
					$this->data ['paypal_order'] ['refunded'] = $refunded;
					$this->data ['paypal_order'] ['remaining'] = number_format ( $paypal_order ['total'] - $captured, 2 );
				}
				$this->data ['refund_link'] = $this->url->link ( 'payment/pp_express/refund', 'token=' . $this->session->data ['token'], 'SSL' );
				$this->data ['view_link'] = $this->url->link ( 'payment/pp_express/viewTransaction', 'token=' . $this->session->data ['token'], 'SSL' );
				$this->data ['resend_link'] = $this->url->link ( 'payment/pp_express/resend', 'token=' . $this->session->data ['token'], 'SSL' );
				$this->initTpl ( 'payment/pp_express_order' );
				$this->response->setOutput ( $this->render () );
			}
		}
	}
	public function search() {
		$this->load->language ( 'payment/pp_express_search' );
		$this->load->model ( $this->route );
		$this->data ['currency_codes'] = $this->model_payment_pp_express->currencyCodes ();
		$this->data ['default_currency'] = $this->config->get ( 'pp_express_currency' );
		$this->data ['token'] = $this->session->data ['token'];
		$this->data ['date_start'] = date ( "Y-m-d", strtotime ( '-30 days' ) );
		$this->data ['view_link'] = $this->url->link ( 'payment/pp_express/viewTransaction', 'token=' . $this->session->data ['token'], 'SSL' );
		$this->initTpl ( 'payment/pp_express_search' );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	public function doSearch() {
		/**
		 * used to search for transactions from a user account
		 */
		if (isset ( $this->request->post ['date_start'] )) {
			$this->load->model ( $this->route );
			$call_data = array ();
			$call_data ['METHOD'] = 'TransactionSearch';
			$call_data ['STARTDATE'] = gmdate ( $this->request->post ['date_start'] . "\TH:i:s\Z" );
			if (! empty ( $this->request->post ['date_end'] )) {
				$call_data ['ENDDATE'] = gmdate ( $this->request->post ['date_end'] . "\TH:i:s\Z" );
			}
			if (! empty ( $this->request->post ['transaction_class'] )) {
				$call_data ['TRANSACTIONCLASS'] = $this->request->post ['transaction_class'];
			}
			if (! empty ( $this->request->post ['status'] )) {
				$call_data ['STATUS'] = $this->request->post ['status'];
			}
			if (! empty ( $this->request->post ['buyer_email'] )) {
				$call_data ['EMAIL'] = $this->request->post ['buyer_email'];
			}
			if (! empty ( $this->request->post ['merchant_email'] )) {
				$call_data ['RECEIVER'] = $this->request->post ['merchant_email'];
			}
			if (! empty ( $this->request->post ['receipt_id'] )) {
				$call_data ['RECEIPTID'] = $this->request->post ['receipt_id'];
			}
			if (! empty ( $this->request->post ['transaction_id'] )) {
				$call_data ['TRANSACTIONID'] = $this->request->post ['transaction_id'];
			}
			if (! empty ( $this->request->post ['invoice_number'] )) {
				$call_data ['INVNUM'] = $this->request->post ['invoice_number'];
			}
			if (! empty ( $this->request->post ['auction_item_number'] )) {
				$call_data ['AUCTIONITEMNUMBER'] = $this->request->post ['auction_item_number'];
			}
			if (! empty ( $this->request->post ['amount'] )) {
				$call_data ['AMT'] = number_format ( $this->request->post ['amount'], 2 );
				$call_data ['CURRENCYCODE'] = $this->request->post ['currency_code'];
			}
			if (! empty ( $this->request->post ['profile_id'] )) {
				$call_data ['PROFILEID'] = $this->request->post ['profile_id'];
			}
			if (! empty ( $this->request->post ['name_salutation'] )) {
				$call_data ['SALUTATION'] = $this->request->post ['name_salutation'];
			}
			if (! empty ( $this->request->post ['name_first'] )) {
				$call_data ['FIRSTNAME'] = $this->request->post ['name_first'];
			}
			if (! empty ( $this->request->post ['name_middle'] )) {
				$call_data ['MIDDLENAME'] = $this->request->post ['name_middle'];
			}
			if (! empty ( $this->request->post ['name_last'] )) {
				$call_data ['LASTNAME'] = $this->request->post ['name_last'];
			}
			if (! empty ( $this->request->post ['name_suffix'] )) {
				$call_data ['SUFFIX'] = $this->request->post ['name_suffix'];
			}
			$result = $this->model_payment_pp_express->call ( $call_data );
			if ($result ['ACK'] != 'Failure' && $result ['ACK'] != 'FailureWithWarning') {
				$response ['error'] = false;
				$response ['result'] = $this->formatRows ( $result );
				$this->response->setOutput ( json_encode ( $response ) );
			} else {
				$response ['error'] = true;
				$response ['error_msg'] = $result ['L_LONGMESSAGE0'];
			}
			$this->response->setOutput ( json_encode ( $response ) );
		} else {
			$response ['error'] = true;
			$response ['error_msg'] = 'Enter a start date';
			$this->response->setOutput ( json_encode ( $response ) );
		}
	}
	public function viewTransaction() {
		$this->load->model ( $this->route );
		$this->load->language ( 'payment/pp_express_view' );
		$this->data ['transaction'] = $this->model_payment_pp_express->getTransaction ( $this->request->get ['transaction_id'] );
		$this->data ['lines'] = $this->formatRows ( $this->data ['transaction'] );
		$this->data ['view_link'] = $this->url->link ( 'payment/pp_express/viewTransaction', 'token=' . $this->session->data ['token'], 'SSL' );
		$this->data ['token'] = $this->session->data ['token'];
		$this->initTpl ( 'payment/pp_express_view' );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
	private function formatRows($data) {
		$return = array ();
		foreach ( $data as $k => $v ) {
			$elements = preg_split ( "/(\d+)/", $k, - 1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
			if (isset ( $elements [1] ) && isset ( $elements [0] )) {
				if ($elements [0] == 'L_TIMESTAMP') {
					$v = str_replace ( 'T', ' ', $v );
					$v = str_replace ( 'Z', '', $v );
				}
				$return [$elements [1]] [$elements [0]] = $v;
			}
		}
		return $return;
	}
	public function recurringCancel() {
		// cancel an active profile
		$this->load->model ( 'sale/recurring' );
		$this->load->model ( $this->route );
		$this->loadText ( 'sale/recurring' );
		$profile = $this->model_sale_recurring->getProfile ( $this->request->get ['order_recurring_id'] );
		if ($profile && ! empty ( $profile ['profile_reference'] )) {
			$result = $this->model_payment_pp_express->recurringCancel ( $profile ['profile_reference'] );
			if (isset ( $result ['PROFILEID'] )) {
				$this->db->query ( "INSERT INTO `" . DB_PREFIX . "order_recurring_transaction` SET `order_recurring_id` = '" . ( int ) $profile ['order_recurring_id'] . "', `created` = NOW(), `type` = '5'" );
				$this->db->query ( "UPDATE `" . DB_PREFIX . "order_recurring` SET `status` = 4 WHERE `order_recurring_id` = '" . ( int ) $profile ['order_recurring_id'] . "' LIMIT 1" );
				$this->session->data ['success'] = $this->language->get ( 'success_cancelled' );
			} else {
				$this->session->data ['error'] = sprintf ( $this->language->get ( 'error_not_cancelled' ), $result ['L_LONGMESSAGE0'] );
			}
		} else {
			$this->session->data ['error'] = $this->language->get ( 'error_not_found' );
		}
		$this->redirect ( $this->url->link ( 'sale/recurring/info', 'order_recurring_id=' . $this->request->get ['order_recurring_id'] . '&token=' . $this->request->get ['token'], 'SSL' ) );
	}
}
?>