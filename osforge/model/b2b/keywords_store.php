<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelB2bKeywordsStore extends Model {
	private $table = 'b2b_keywords_store';
	public function addKeywordsStore($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editKeywordsStore($data) {
		return $this->editModel ( $this->table, $data );
	}
	public function deleteKeywordsStore($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getKeywordsStore($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getKeywordsStores($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getTotalKeywordsStores() {
		return $this->getModelTotal ( $this->table );
	}
	public function getDefaultKeywordsStore() {
		return $this->getModelDefault ( $this->table );
	}
}