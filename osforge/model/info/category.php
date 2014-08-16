<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelInfoCategory extends Model {
	public function addCategory($data) {
		$this->db->query ( "INSERT INTO " . DB_PREFIX . "info_category SET parent_id = '" . ( int ) $data ['parent_id'] . "', `top` = '" . (isset ( $data ['top'] ) ? ( int ) $data ['top'] : 0) . "', `column` = '" . ( int ) $data ['column'] . "', sort_order = '" . ( int ) $data ['sort_order'] . "', status = '" . ( int ) $data ['status'] . "', date_modified = NOW(), date_added = NOW()" );
		$category_id = $this->db->getLastId ();
		if (isset ( $data ['image'] )) {
			$this->db->query ( "UPDATE " . DB_PREFIX . "info_category SET image = '" . $this->db->escape ( html_entity_decode ( $data ['image'], ENT_QUOTES, 'UTF-8' ) ) . "' WHERE category_id = '" . ( int ) $category_id . "'" );
		}
		foreach ( $data ['category_description'] as $language_id => $value ) {
			$this->db->query ( "INSERT INTO " . DB_PREFIX . "info_category_description SET category_id = '" . ( int ) $category_id . "', language_id = '" . ( int ) $language_id . "', name = '" . $this->db->escape ( $value ['name'] ) . "', meta_keyword = '" . $this->db->escape ( $value ['meta_keyword'] ) . "', meta_description = '" . $this->db->escape ( $value ['meta_description'] ) . "', description = '" . $this->db->escape ( $value ['description'] ) . "'" );
		}
		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;
		$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . "info_category_path` WHERE category_id = '" . ( int ) $data ['parent_id'] . "' ORDER BY `level` ASC" );
		foreach ( $query->rows as $result ) {
			$this->db->query ( "INSERT INTO `" . DB_PREFIX . "info_category_path` SET `category_id` = '" . ( int ) $category_id . "', `path_id` = '" . ( int ) $result ['path_id'] . "', `level` = '" . ( int ) $level . "'" );
			$level ++;
		}
		$this->db->query ( "INSERT INTO `" . DB_PREFIX . "info_category_path` SET `category_id` = '" . ( int ) $category_id . "', `path_id` = '" . ( int ) $category_id . "', `level` = '" . ( int ) $level . "'" );
		if (isset ( $data ['category_filter'] )) {
			foreach ( $data ['category_filter'] as $filter_id ) {
				$this->db->query ( "INSERT INTO " . DB_PREFIX . "info_category_filter SET category_id = '" . ( int ) $category_id . "', filter_id = '" . ( int ) $filter_id . "'" );
			}
		}
		if (isset ( $data ['category_store'] )) {
			foreach ( $data ['category_store'] as $store_id ) {
				$this->db->query ( "INSERT INTO " . DB_PREFIX . "info_category_to_store SET category_id = '" . ( int ) $category_id . "', store_id = '" . ( int ) $store_id . "'" );
			}
		}
		// Set which layout to use with this category
		if (isset ( $data ['category_layout'] )) {
			foreach ( $data ['category_layout'] as $store_id => $layout ) {
				if ($layout ['layout_id']) {
					$this->db->query ( "INSERT INTO " . DB_PREFIX . "info_category_to_layout SET category_id = '" . ( int ) $category_id . "', store_id = '" . ( int ) $store_id . "', layout_id = '" . ( int ) $layout ['layout_id'] . "'" );
				}
			}
		}
		if ($data ['keyword']) {
			$this->db->query ( "INSERT INTO " . DB_PREFIX . "url_alias SET query = 'info_category_id=" . ( int ) $category_id . "', keyword = '" . $this->db->escape ( $data ['keyword'] ) . "'" );
		}
		$this->cache->delete ( 'category' );
	}
	public function editCategory($category_id, $data) {
		$this->db->query ( "UPDATE " . DB_PREFIX . "info_category SET parent_id = '" . ( int ) $data ['parent_id'] . "', `top` = '" . (isset ( $data ['top'] ) ? ( int ) $data ['top'] : 0) . "', `column` = '" . ( int ) $data ['column'] . "', sort_order = '" . ( int ) $data ['sort_order'] . "', status = '" . ( int ) $data ['status'] . "', date_modified = NOW() WHERE category_id = '" . ( int ) $category_id . "'" );
		if (isset ( $data ['image'] )) {
			$this->db->query ( "UPDATE " . DB_PREFIX . "info_category SET image = '" . $this->db->escape ( html_entity_decode ( $data ['image'], ENT_QUOTES, 'UTF-8' ) ) . "' WHERE category_id = '" . ( int ) $category_id . "'" );
		}
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "info_category_description WHERE category_id = '" . ( int ) $category_id . "'" );
		foreach ( $data ['category_description'] as $language_id => $value ) {
			$this->db->query ( "INSERT INTO " . DB_PREFIX . "info_category_description SET category_id = '" . ( int ) $category_id . "', language_id = '" . ( int ) $language_id . "', name = '" . $this->db->escape ( $value ['name'] ) . "', meta_keyword = '" . $this->db->escape ( $value ['meta_keyword'] ) . "', meta_description = '" . $this->db->escape ( $value ['meta_description'] ) . "', description = '" . $this->db->escape ( $value ['description'] ) . "'" );
		}
		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . "info_category_path` WHERE path_id = '" . ( int ) $category_id . "' ORDER BY level ASC" );
		if ($query->rows) {
			foreach ( $query->rows as $category_path ) {
				// Delete the path below the current one
				$this->db->query ( "DELETE FROM `" . DB_PREFIX . "info_category_path` WHERE category_id = '" . ( int ) $category_path ['category_id'] . "' AND level < '" . ( int ) $category_path ['level'] . "'" );
				$path = array ();
				// Get the nodes new parents
				$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . "info_category_path` WHERE category_id = '" . ( int ) $data ['parent_id'] . "' ORDER BY level ASC" );
				foreach ( $query->rows as $result ) {
					$path [] = $result ['path_id'];
				}
				// Get whats left of the nodes current path
				$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . "info_category_path` WHERE category_id = '" . ( int ) $category_path ['category_id'] . "' ORDER BY level ASC" );
				foreach ( $query->rows as $result ) {
					$path [] = $result ['path_id'];
				}
				// Combine the paths with a new level
				$level = 0;
				foreach ( $path as $path_id ) {
					$this->db->query ( "REPLACE INTO `" . DB_PREFIX . "info_category_path` SET category_id = '" . ( int ) $category_path ['category_id'] . "', `path_id` = '" . ( int ) $path_id . "', level = '" . ( int ) $level . "'" );
					$level ++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query ( "DELETE FROM `" . DB_PREFIX . "info_category_path` WHERE category_id = '" . ( int ) $category_id . "'" );
			// Fix for records with no paths
			$level = 0;
			$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . "info_category_path` WHERE category_id = '" . ( int ) $data ['parent_id'] . "' ORDER BY level ASC" );
			foreach ( $query->rows as $result ) {
				$this->db->query ( "INSERT INTO `" . DB_PREFIX . "info_category_path` SET category_id = '" . ( int ) $category_id . "', `path_id` = '" . ( int ) $result ['path_id'] . "', level = '" . ( int ) $level . "'" );
				$level ++;
			}
			$this->db->query ( "REPLACE INTO `" . DB_PREFIX . "info_category_path` SET category_id = '" . ( int ) $category_id . "', `path_id` = '" . ( int ) $category_id . "', level = '" . ( int ) $level . "'" );
		}
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "info_category_filter WHERE category_id = '" . ( int ) $category_id . "'" );
		if (isset ( $data ['category_filter'] )) {
			foreach ( $data ['category_filter'] as $filter_id ) {
				$this->db->query ( "INSERT INTO " . DB_PREFIX . "info_category_filter SET category_id = '" . ( int ) $category_id . "', filter_id = '" . ( int ) $filter_id . "'" );
			}
		}
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "info_category_to_store WHERE category_id = '" . ( int ) $category_id . "'" );
		if (isset ( $data ['category_store'] )) {
			foreach ( $data ['category_store'] as $store_id ) {
				$this->db->query ( "INSERT INTO " . DB_PREFIX . "info_category_to_store SET category_id = '" . ( int ) $category_id . "', store_id = '" . ( int ) $store_id . "'" );
			}
		}
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "info_category_to_layout WHERE category_id = '" . ( int ) $category_id . "'" );
		if (isset ( $data ['category_layout'] )) {
			foreach ( $data ['category_layout'] as $store_id => $layout ) {
				if ($layout ['layout_id']) {
					$this->db->query ( "INSERT INTO " . DB_PREFIX . "info_category_to_layout SET category_id = '" . ( int ) $category_id . "', store_id = '" . ( int ) $store_id . "', layout_id = '" . ( int ) $layout ['layout_id'] . "'" );
				}
			}
		}
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'info_category_id=" . ( int ) $category_id . "'" );
		if ($data ['keyword']) {
			$this->db->query ( "INSERT INTO " . DB_PREFIX . "url_alias SET query = 'info_category_id=" . ( int ) $category_id . "', keyword = '" . $this->db->escape ( $data ['keyword'] ) . "'" );
		}
		$this->cache->delete ( 'category' );
	}
	public function deleteCategory($category_id) {
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "info_category_path WHERE category_id = '" . ( int ) $category_id . "'" );
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "info_category_path WHERE path_id = '" . ( int ) $category_id . "'" );
		foreach ( $query->rows as $result ) {
			$this->deleteCategory ( $result ['category_id'] );
		}
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "info_category WHERE category_id = '" . ( int ) $category_id . "'" );
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "info_category_description WHERE category_id = '" . ( int ) $category_id . "'" );
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "info_category_filter WHERE category_id = '" . ( int ) $category_id . "'" );
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "info_category_to_store WHERE category_id = '" . ( int ) $category_id . "'" );
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "info_category_to_layout WHERE category_id = '" . ( int ) $category_id . "'" );
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "info_to_category WHERE category_id = '" . ( int ) $category_id . "'" );
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'info_category_id=" . ( int ) $category_id . "'" );
		$this->cache->delete ( 'category' );
	}
	// Function to repair any erroneous categories that are not in the category path table.
	public function repairCategory($parent_id = 0) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "info_category WHERE parent_id = '" . ( int ) $parent_id . "'" );
		foreach ( $query->rows as $category ) {
			// Delete the path below the current one
			$this->db->query ( "DELETE FROM `" . DB_PREFIX . "info_category_path` WHERE category_id = '" . ( int ) $category ['category_id'] . "'" );
			// Fix for records with no paths
			$level = 0;
			$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . "info_category_path` WHERE category_id = '" . ( int ) $parent_id . "' ORDER BY level ASC" );
			foreach ( $query->rows as $result ) {
				$this->db->query ( "INSERT INTO `" . DB_PREFIX . "info_category_path` SET category_id = '" . ( int ) $category ['category_id'] . "', `path_id` = '" . ( int ) $result ['path_id'] . "', level = '" . ( int ) $level . "'" );
				$level ++;
			}
			$this->db->query ( "REPLACE INTO `" . DB_PREFIX . "info_category_path` SET category_id = '" . ( int ) $category ['category_id'] . "', `path_id` = '" . ( int ) $category ['category_id'] . "', level = '" . ( int ) $level . "'" );
			$this->repairCategory ( $category ['category_id'] );
		}
	}
	public function getCategory_($category_id) {
		$query = $this->db->query ( "SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR ' &gt; ') FROM " . DB_PREFIX . "info_category_path cp LEFT JOIN " . DB_PREFIX . "info_category_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id AND cd1.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "' GROUP BY cp.category_id) AS path, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . ( int ) $category_id . "') AS keyword FROM " . DB_PREFIX . "info_category c LEFT JOIN " . DB_PREFIX . "info_category_description cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '" . ( int ) $category_id . "' AND cd2.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "'" );
		return $query->row;
	}
	public function getCategories_($data) {
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, c.parent_id, c.sort_order FROM " . DB_PREFIX . "info_category_path cp LEFT JOIN " . DB_PREFIX . "info_category c ON (cp.path_id = c.category_id) LEFT JOIN " . DB_PREFIX . "info_category_description cd1 ON (c.category_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "info_category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "' AND cd2.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "'";
		if (! empty ( $data ['filter_name'] )) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape ( $data ['filter_name'] ) . "%'";
		}
		$sql .= " GROUP BY cp.category_id ORDER BY name";
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
	public function getCategoryDescriptions($category_id) {
		$category_description_data = array ();
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "info_category_description WHERE category_id = '" . ( int ) $category_id . "'" );
		foreach ( $query->rows as $result ) {
			$category_description_data [$result ['language_id']] = array (
					'name' => $result ['name'],
					'meta_keyword' => $result ['meta_keyword'],
					'meta_description' => $result ['meta_description'],
					'description' => $result ['description'] 
			);
		}
		return $category_description_data;
	}
	public function getCategoryFilters_($category_id) {
		$category_filter_data = array ();
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "info_category_filter WHERE category_id = '" . ( int ) $category_id . "'" );
		foreach ( $query->rows as $result ) {
			$category_filter_data [] = $result ['filter_id'];
		}
		return $category_filter_data;
	}
	public function getCategoryStores($category_id) {
		$category_store_data = array ();
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "info_category_to_store WHERE category_id = '" . ( int ) $category_id . "'" );
		foreach ( $query->rows as $result ) {
			$category_store_data [] = $result ['store_id'];
		}
		return $category_store_data;
	}
	public function getCategoryLayouts($category_id) {
		$category_layout_data = array ();
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "info_category_to_layout WHERE category_id = '" . ( int ) $category_id . "'" );
		foreach ( $query->rows as $result ) {
			$category_layout_data [$result ['store_id']] = $result ['layout_id'];
		}
		return $category_layout_data;
	}
	public function getTotalCategories() {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "info_category" );
		return $query->row ['total'];
	}
	public function getTotalCategoriesByImageId($image_id) {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "info_category WHERE image_id = '" . ( int ) $image_id . "'" );
		return $query->row ['total'];
	}
	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "info_category_to_layout WHERE layout_id = '" . ( int ) $layout_id . "'" );
		return $query->row ['total'];
	}
	public function getCategory($category_id) {
		$query = $this->db->query ( "SELECT DISTINCT * FROM " . DB_PREFIX . "info_category c LEFT JOIN " . DB_PREFIX . "info_category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "info_category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . ( int ) $category_id . "' AND cd.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "' AND c2s.store_id = '" . ( int ) $this->config->get ( 'config_store_id' ) . "' AND c.status = '1'" );
		return $query->row;
	}
	public function getCategories($parent_id = 0) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "info_category c LEFT JOIN " . DB_PREFIX . "info_category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "info_category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . ( int ) $parent_id . "' AND cd.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "' AND c2s.store_id = '" . ( int ) $this->config->get ( 'config_store_id' ) . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)" );
		return $query->rows;
	}
	public function getCategoryFilters($category_id) {
		$implode = array ();
		$query = $this->db->query ( "SELECT filter_id FROM " . DB_PREFIX . "info_category_filter WHERE category_id = '" . ( int ) $category_id . "'" );
		foreach ( $query->rows as $result ) {
			$implode [] = ( int ) $result ['filter_id'];
		}
		$filter_group_data = array ();
		if ($implode) {
			$filter_group_query = $this->db->query ( "SELECT DISTINCT f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (" . implode ( ',', $implode ) . ") AND fgd.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "' GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)" );
			foreach ( $filter_group_query->rows as $filter_group ) {
				$filter_data = array ();
				$filter_query = $this->db->query ( "SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode ( ',', $implode ) . ") AND f.filter_group_id = '" . ( int ) $filter_group ['filter_group_id'] . "' AND fd.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "' ORDER BY f.sort_order, LCASE(fd.name)" );
				foreach ( $filter_query->rows as $filter ) {
					$filter_data [] = array (
							'filter_id' => $filter ['filter_id'],
							'name' => $filter ['name'] 
					);
				}
				if ($filter_data) {
					$filter_group_data [] = array (
							'filter_group_id' => $filter_group ['filter_group_id'],
							'name' => $filter_group ['name'],
							'filter' => $filter_data 
					);
				}
			}
		}
		return $filter_group_data;
	}
	public function getCategoryLayoutId($category_id) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "info_category_to_layout WHERE category_id = '" . ( int ) $category_id . "' AND store_id = '" . ( int ) $this->config->get ( 'config_store_id' ) . "'" );
		if ($query->num_rows) {
			return $query->row ['layout_id'];
		} else {
			return false;
		}
	}
	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "info_category c LEFT JOIN " . DB_PREFIX . "info_category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . ( int ) $parent_id . "' AND c2s.store_id = '" . ( int ) $this->config->get ( 'config_store_id' ) . "' AND c.status = '1'" );
		return $query->row ['total'];
	}
	public function getDefaultCategory() {
		return $this->getModelDefault ( "info_category" );
	}
}