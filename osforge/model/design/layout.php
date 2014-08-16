<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
class ModelDesignLayout extends Model {
	public function addLayout($data) {
		$this->db->query ( "INSERT INTO " . DB_PREFIX . "layout SET name = '" . $this->db->escape ( $data ['name'] ) . "'" );
		$layout_id = $this->db->getLastId ();
		if (isset ( $data ['layout_route'] )) {
			foreach ( $data ['layout_route'] as $layout_route ) {
				$this->db->query ( "INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = '" . ( int ) $layout_id . "', store_id = '" . ( int ) $layout_route ['store_id'] . "', route = '" . $this->db->escape ( $layout_route ['route'] ) . "'" );
			}
		}
	}
	public function editLayout($layout_id, $data) {
		$this->db->query ( "UPDATE " . DB_PREFIX . "layout SET name = '" . $this->db->escape ( $data ['name'] ) . "' WHERE layout_id = '" . ( int ) $layout_id . "'" );
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "layout_route WHERE layout_id = '" . ( int ) $layout_id . "'" );
		if (isset ( $data ['layout_route'] )) {
			foreach ( $data ['layout_route'] as $layout_route ) {
				$this->db->query ( "INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = '" . ( int ) $layout_id . "', store_id = '" . ( int ) $layout_route ['store_id'] . "', route = '" . $this->db->escape ( $layout_route ['route'] ) . "'" );
			}
		}
	}
	public function deleteLayout($layout_id) {
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "layout WHERE layout_id = '" . ( int ) $layout_id . "'" );
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "layout_route WHERE layout_id = '" . ( int ) $layout_id . "'" );
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . ( int ) $layout_id . "'" );
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . ( int ) $layout_id . "'" );
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "information_to_layout WHERE layout_id = '" . ( int ) $layout_id . "'" );
	}
	public function getLayout_($layout_id) {
		$query = $this->db->query ( "SELECT DISTINCT * FROM " . DB_PREFIX . "layout WHERE layout_id = '" . ( int ) $layout_id . "'" );
		return $query->row;
	}
	public function getLayouts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "layout";
		$sort_data = array (
				'name' 
		);
		if (isset ( $data ['sort'] ) && in_array ( $data ['sort'], $sort_data )) {
			$sql .= " ORDER BY " . $data ['sort'];
		} else {
			$sql .= " ORDER BY name";
		}
		if (isset ( $data ['order'] ) && ($data ['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		if (isset ( $data ['start'] ) || isset ( $data ['limit'] )) {
			if ($data ['start'] < 0) {
				$data ['start'] = 0;
			}
			if ($data ['limit'] < 1) {
				$data ['limit'] = 20;
			}
			$sql .= " LIMIT " . ( int ) $data ['start'] . "," . ( int ) $data ['limit'];
		}
		$query = $this->db->query ( $sql );
		return $query->rows;
	}
	public function getLayoutRoutes($layout_id) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "layout_route WHERE layout_id = '" . ( int ) $layout_id . "'" );
		return $query->rows;
	}
	public function getTotalLayouts() {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "layout" );
		return $query->row ['total'];
	}
	public function getDefaultLayout() {
		return $this->getModelDefault ( "`" . DB_PREFIX . "layout`" );
	}
	public function getLayout($route) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "layout_route WHERE '" . $this->db->escape ( $route ) . "' LIKE CONCAT(route, '%') AND store_id = '" . ( int ) $this->config->get ( 'config_store_id' ) . "' ORDER BY route DESC LIMIT 1" );
		if ($query->num_rows) {
			return $query->row ['layout_id'];
		} else {
			return 0;
		}
	}
}