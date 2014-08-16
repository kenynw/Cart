<?php
/**
 * IEC
*
* @copyright IeCart.Net
* @license http://www.iecart.net/license/
* @version 1.4.2
*/
class ModelB2bAlibabaCategory extends Model {
	private $table = 'b2b_alibaba_category';
	public function addAlibabaCategory($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editAlibabaCategory($data) {
		return $this->editModel ( $this->table, $data );
	}
	public function deleteAlibabaCategory($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getAlibabaCategory($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getAlibabaCategories($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getTotalAlibabaCategories() {
		return $this->getModelTotal ( $this->table );
	}
	public function getDefaultAlibabaCategory() {
		return $this->getModelDefault ( $this->table );
	}
}