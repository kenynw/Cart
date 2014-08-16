<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelSeoStatPage extends Model {
	private $table = 'seo_stat_page';
	public function addStatPage($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editStatPage($data) {
		return $this->editModel ( $this->table, $data );
	}
	public function deleteStatPage($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getStatPage($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getStatPages($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getTotalStatPages() {
		return $this->getModelTotal ( $this->table );
	}
	public function getDefaultStatPage() {
		return $this->getModelDefault ( $this->table );
	}
}