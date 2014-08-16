<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelInfoMetaTag extends Model {
	private $table = 'meta_tag';
	public function addMetaTag($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editMetaTag($data) {
		return $this->editModel ( $this->table, $data );
	}
	public function deleteMetaTag($id) {
		return $this->deleteModel ( $this->table,  ( int ) $id );
	}
	public function getMetaTag($id) {
		return $this->getModel ( $this->table, ( int ) $id );
	}
	public function getMetaTags($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getTotalMetaTag() {
		return $this->getModelTotal ( $this->table );
	}
	public function getDefaultMetaTag() {
		return $this->getModelDefault ( $this->table );
	}
}