<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelB2bKeywordsMine extends Model {
	private $table = 'b2b_keywords_mine';
	public function addKeywordsMine($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editKeywordsMine($data) {
		return $this->editModel ( $this->table, $data );
	}
	public function deleteKeywordsMine($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getKeywordsMine($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getKeywordsMines($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getTotalKeywordsMines() {
		return $this->getModelTotal ( $this->table );
	}
	public function getDefaultKeywordsMine() {
		return $this->getModelDefault ( $this->table );
	}
}