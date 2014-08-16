<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelB2bProCollection extends Model {
	private $table = 'b2b_pro_collection';
	public function addProCollection($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editProCollection($data) {
		return $this->editModel ( $this->table, $data );
	}
	public function deleteProCollection($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getProCollection($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getProCollections($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getTotalProCollections() {
		return $this->getModelTotal ( $this->table );
	}
	public function getDefaultProCollection() {
		return $this->getModelDefault ( $this->table );
	}
}