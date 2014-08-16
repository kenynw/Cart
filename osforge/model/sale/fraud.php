<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
class ModelSaleFraud extends Model {
	public function getFraud($order_id) {
		$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . "order_fraud` WHERE order_id = '" . ( int ) $order_id . "'" );
		return $query->row;
	}
}
