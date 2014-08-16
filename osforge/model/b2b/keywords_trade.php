<?php
/**
 * IEC
*
* @copyright IeCart.Net
* @license http://www.iecart.net/license/
* @version 1.4.1
*/
class ModelB2bKeywordsTrade extends Model {
	private $table = 'b2b_keywords_trade';
	public function addKeywordsTrade($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editKeywordsTrade($data) {
		return $this->editModel ( $this->table, $data );
	}
	public function deleteKeywordsTrade($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getKeywordsTrade($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getKeywordsTrades($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getTotalKeywordsTrades() {
		return $this->getModelTotal ( $this->table );
	}
	public function getDefaultKeywordsTrade() {
		return $this->getModelDefault ( $this->table );
	}
}