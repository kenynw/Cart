<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelCatalogMetaTag extends Model {
	private $table = 'meta_tag';
	public function getMetaTag($id) {
		return $this->getModel ( $this->table, ( int ) $id );
	}
	public function getMetaTagByLocation($meta_location) {
		$where = " meta_location = ' $meta_location '";
		return $this->getModel ( $this->table, 0, $where );
	}
	public function getMetaTags($param, $sort_data) {
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getTotalMetaTags() {
		return $this->getModelTotal ( $this->table );
	}
}