<?php
class ModelInfoInfo extends Model {
	private $table = 'info';
	private $table_desc = 'info_description';
	private $table_category_desc = 'info_category_description';
	private $table_to_category = 'info_to_category';
	private $table_to_store = 'info_to_store';
	private $table_to_layout = 'info_to_layout';
	private $table_url_alias = 'url_alias';
	public function addInfo($post) {
		$id = $this->addModel ( $this->table, $post );
		if (isset ( $post ['category_id'] )) {
			$tmp = array (
					'category_id' => ( int ) $post ['category_id'],
					'information_id' => ( int ) $id
			);
			$this->addModel ( $this->table_to_category, $tmp );
		}
		foreach ( $post ['information_description'] as $language_id => $value ) {
			$tmp = array (
					'information_id' => ( int ) $id,
					'language_id' => ( int ) $language_id,
					'title' => $value ['title'],
					'description' => $value ['description'],
					'meta_description' => $value ['meta_description'],
					'meta_keyword' => $value ['meta_keyword']
			);
			$this->addModel ( $this->table_desc, $tmp );
		}
		if (isset ( $post ['information_store'] )) {
			foreach ( $post ['information_store'] as $store_id ) {
				$tmp = array (
						'information_id' => ( int ) $id,
						'store_id' => ( int ) $store_id
				);
				$this->addModel ( $this->table_to_store, $tmp );
			}
		}
		if (isset ( $post ['information_layout'] )) {
			foreach ( $post ['information_layout'] as $store_id => $layout ) {
				if ($layout) {
					$tmp = array (
							'information_id' => ( int ) $id,
							'store_id' => ( int ) $store_id,
							'layout_id ' => ( int ) $layout ['layout_id']
					);
					$this->addModel ( $this->table_to_layout, $tmp );
				}
			}
		}
		if ($post ['keyword']) {
			$tmp = array (
					'information_id' => ( int ) $id,
					'keyword' => $post ['keyword']
			);
			$this->addModel ( $this->table_url_alias, $tmp );
		}
		$this->cache->delete ( 'information' );
	}
	public function editInfo($id, $post) {
		$tmp = array (
				'sort_order' => ( int ) $post ['sort_order'],
				'bottom' => (isset ( $post ['bottom'] ) ? ( int ) $post ['bottom'] : 0),
				'status' => ( int ) $post ['status']
		);
		$where = " information_id = '" . ( int ) $id . "'";
		$this->editModel ( $this->table, $tmp, $where );
		$this->db->query ( "DELETE FROM `" . DB_PREFIX . $this->table_to_category . "`
				WHERE information_id = '" . ( int ) $id . "'" );
		if (isset ( $post ['category_id'] )) {
			$this->db->query ( "INSERT INTO `" . DB_PREFIX . $this->table_to_category . "`
				SET `category_id` = '" . ( int ) $post ['category_id'] . "'
				, `information_id` = '" . ( int ) $id . "' " );
		}
		$this->db->query ( "DELETE FROM `" . DB_PREFIX . $this->table_desc . "`
				WHERE information_id = '" . ( int ) $id . "'" );
		foreach ( $post ['information_description'] as $language_id => $value ) {
			$this->db->query ( "INSERT INTO `" . DB_PREFIX . $this->table_desc . "`
					SET information_id = '" . ( int ) $id . "'
					, language_id = '" . ( int ) $language_id . "'
					, title = '" . $this->db->escape ( $value ['title'] ) . "'
					, meta_keyword = '" . $this->db->escape ( $value ['meta_keyword'] ) . "'
					, meta_description = '" . $this->db->escape ( $value ['meta_description'] ) . "'
					, description = '" . $this->db->escape ( $value ['description'] ) . "'" );
		}
		$this->db->query ( "DELETE FROM `" . DB_PREFIX . $this->table_to_store . "`
				WHERE information_id = '" . ( int ) $id . "'" );
		if (isset ( $post ['information_store'] )) {
			foreach ( $post ['information_store'] as $store_id ) {
				$this->db->query ( "INSERT INTO `" . DB_PREFIX . $this->table_to_store . "`
						SET information_id = '" . ( int ) $id . "', store_id = '" . ( int ) $store_id . "'" );
			}
		}
		$this->db->query ( "DELETE FROM `" . DB_PREFIX . $this->table_to_layout . "`
				WHERE information_id = '" . ( int ) $id . "'" );
		if (isset ( $post ['information_layout'] )) {
			foreach ( $post ['information_layout'] as $store_id => $layout ) {
				if ($layout ['layout_id']) {
					$this->db->query ( "INSERT INTO `" . DB_PREFIX . $this->table_to_layout . "`
							SET information_id = '" . ( int ) $id . "'
							, store_id = '" . ( int ) $store_id . "'
							, layout_id = '" . ( int ) $layout ['layout_id'] . "'" );
				}
			}
		}
		$this->db->query ( "DELETE FROM `" . DB_PREFIX . $this->table_url_alias . "`
				WHERE query = 'information_id=" . ( int ) $id . "'" );
		if ($post ['keyword']) {
			$this->db->query ( "INSERT INTO `" . DB_PREFIX . $this->table_url_alias . "`
					SET query = 'information_id=" . ( int ) $id . "'
					, keyword = '" . $this->db->escape ( $post ['keyword'] ) . "'" );
		}
		$this->cache->delete ( 'information' );
	}
	public function deleteInfo($id) {
		$this->deleteModel ( $this->table, ( int ) $id );
		$this->db->query ( "DELETE FROM `" . DB_PREFIX . $this->table_desc . "`
				WHERE information_id = '" . ( int ) $id . "'" );
		$this->db->query ( "DELETE FROM `" . DB_PREFIX . $this->table_to_store . "`
				WHERE information_id = '" . ( int ) $id . "'" );
		$this->db->query ( "DELETE FROM `" . DB_PREFIX . $this->table_to_layout . "`
				WHERE information_id = '" . ( int ) $id . "'" );
		$this->db->query ( "DELETE FROM `" . DB_PREFIX . $this->table_url_alias . "`
				WHERE query = 'information_id=" . ( int ) $id . "'" );
		$this->cache->delete ( 'information' );
	}
	public function getInfo($id) {
		$sql = "SELECT DISTINCT *, (SELECT keyword FROM `" . DB_PREFIX . $this->table_url_alias . "`
				WHERE query = 'information_id=" . ( int ) $id . "')
				AS keyword
				FROM `" . DB_PREFIX . $this->table . "` ";
		$where = " information_id = '" . ( int ) $id . "'";
		return $this->getModelMulti ( $sql, $where );
	}
	public function getInfos_($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		$sql = "SELECT * FROM `" . DB_PREFIX . $this->table . "`  i
					LEFT JOIN `" . DB_PREFIX . $this->table_desc . "`  id
					ON i.information_id = id.information_id ";
		if (isset ( $param ['category_id'] ) && ($param ['category_id'] > 0)) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . $this->table_to_category . "` ic
						ON i.information_id = ic.information_id
						WHERE id.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "'
						AND ic.category_id = '" . ( int ) $param ['category_id'] . "' ";
		} else {
			$sql .= " WHERE id.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "'";
		}
		if (isset ( $param ['sort'] ) && $param ['sort'] != '') {
			$sql .= " ORDER BY " . $param ['sort'];
		} else {
			$sql .= " ORDER BY i.sort_order";
		}
		if (isset ( $param ['order'] ) && ($param ['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		if (isset ( $param ['start'] ) || isset ( $param ['limit'] )) {
			if ($param ['start'] < 0) {
				$param ['start'] = 0;
			}
			if ($param ['limit'] < 1) {
				$param ['limit'] = 20;
			}
			$sql .= " LIMIT " . ( int ) $param ['start'] . "," . ( int ) $param ['limit'];
		}
		$query = $this->db->query ( $sql );
		return $query->rows;
	}
	public function getInfos($category_id = 0) {
		$sql = "SELECT * FROM `" . DB_PREFIX . $this->table . "` i
				LEFT JOIN `" . DB_PREFIX . $this->table_desc . "` id ON (i.information_id = id.information_id)
				LEFT JOIN `" . DB_PREFIX . $this->table_to_store . "` i2s ON (i.information_id = i2s.information_id)
				LEFT JOIN `" . DB_PREFIX . $this->table_to_category . "` ic ON (i.information_id = ic.information_id) ";
		$where = " id.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "'
				AND i2s.store_id = '" . ( int ) $this->config->get ( 'config_store_id' ) . "'
				AND i.status = '1' ";
		if ($category_id > 0) {
			$where .= " AND ic.category_id = '$category_id' ";
		}
		$param = array (
				'sort' => " i.sort_order, LCASE(id.title) "
		);
		return $this->getModelListMulti ( $sql, $param, null, $where );
	}
	public function getTotalInfos($category_id = 0) {
		if ($category_id > 0) {
			$where = " category_id = $category_id ";
			return $this->getModelTotal ( $this->table_to_category, $where );
		} else {
			return $this->getModelTotal ( $this->table );
		}
	}
	public function getDefaultInfo() {
		return $this->getModelDefault ( $this->table );
	}
	public function getInfoCategory($id) {
		$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . $this->table_to_category . "` ic
				LEFT JOIN `" . DB_PREFIX . $this->table_category_desc . "` cd
				ON ic.category_id = cd.category_id
				WHERE information_id = '" . ( int ) $id . "'" );
		return $query->row;
	}
	public function getInfoStores($id) {
		$information_store_data = array ();
		$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . $this->table_to_store . "`
				WHERE information_id = '" . ( int ) $id . "'" );
		foreach ( $query->rows as $result ) {
			$information_store_data [] = $result ['store_id'];
		}
		return $information_store_data;
	}
	public function getInfoLayouts($id) {
		$information_layout_data = array ();
		$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . $this->table_to_layout . "`
				WHERE information_id = '" . ( int ) $id . "'" );
		foreach ( $query->rows as $result ) {
			$information_layout_data [$result ['store_id']] = $result ['layout_id'];
		}
		return $information_layout_data;
	}
	public function getInfoDescriptions($id) {
		$information_description_data = array ();
		$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . $this->table_desc . "`
				WHERE information_id = '" . ( int ) $id . "'" );
		foreach ( $query->rows as $result ) {
			$information_description_data [$result ['language_id']] = array (
					'title' => $result ['title'],
					'description' => $result ['description'],
					'meta_keyword' => $result ['meta_keyword'],
					'meta_description' => $result ['meta_description'] 
			);
		}
		return $information_description_data;
	}
	public function getTotalInfoByLayoutId($layout_id) {
		$where = " layout_id = '" . ( int ) $layout_id . "' ";
		return $this->getModelTotal ( $this->table_to_layout, $where );
	}
	public function getInfoLayoutId($information_id) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "information_to_layout
				WHERE information_id = '" . ( int ) $information_id . "'
				AND store_id = '" . ( int ) $this->config->get ( 'config_store_id' ) . "'" );
		if ($query->num_rows) {
			return $query->row ['layout_id'];
		} else {
			return false;
		}
	}
}