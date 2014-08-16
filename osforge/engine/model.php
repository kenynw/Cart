<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
abstract class Model {
	protected $registry;
	public function __construct($registry) {
		$this->registry = $registry;
	}
	public function __get($key) {
		return $this->registry->get ( $key );
	}
	public function __set($key, $value) {
		$this->registry->set ( $key, $value );
	}
	public function addModel($table, $data) {
		$arr = $this->getModelDefault ( $table );
		$autoKey = $this->getModelDefault ( $table, 0, 1 );
		$bind = array ();
		foreach ( $arr as $k => $v ) {
			if ($autoKey != '') {
				unset ( $data [$autoKey] );
			}
			if (array_key_exists ( $k, $data )) {
				$bind [$k] = $this->db->escape ( $data [$k] );
			}
			if ($k == 'date_added') {
				$bind ['date_added'] = date ( $this->language->get ( 'date_format_long' ) );
			}
			if ($k == 'date_modified') {
				$bind ['date_modified'] = date ( $this->language->get ( 'date_format_long' ) );
			}
		}
		$this->db->query ( "INSERT INTO `" . DB_PREFIX . $table . "`
				(" . sprintf ( "`%s`", implode ( "`,`", array_keys ( $bind ) ) ) . ") 
				VALUES (" . sprintf ( "'%s'", implode ( "','", $bind ) ) . ") " );
		return $this->db->getLastId ();
	}
	public function editModel($table, $data, $where = '') {
		$arr = $this->getModelDefault ( $table );
		$bind = array ();
		foreach ( $arr as $k => $v ) {
			if (array_key_exists ( $k, $data )) {
				$bind [$k] = $this->db->escape ( $data [$k] );
			}
			if ($k == 'date_modified') {
				$bind ['date_modified'] = date ( $this->language->get ( 'date_format_long' ) );
			}
		}
		$whereStr = '';
		if ($where != '') {
			$whereStr = " WHERE " . str_ireplace ( 'where', '', $where );
		} else {
			$priKey = $this->getModelDefault ( $table, 1 );
			if (array_key_exists ( $priKey, $bind )) {
				$whereStr = " WHERE " . $priKey . '=' . $bind [$priKey];
				unset ( $bind [$priKey] );
			} else {
				$this->data ['error_warning'] = "PriKey Missing!";
				exit ();
			}
		}
		$setStr = '';
		foreach ( $bind as $k => $v ) {
			$setStr .= "{$k} = '{$v}',";
		}
		$setStr = rtrim ( $setStr, "," );
		return $this->db->query ( "UPDATE `" . DB_PREFIX . $table . "` 
				SET $setStr $whereStr " );
	}
	public function deleteModel($table, $id, $where = '') {
		$whereStr = '';
		if ($where != '') {
			$whereStr = " WHERE " . str_ireplace ( 'where', '', $where );
		} else {
			$priKey = $this->getModelDefault ( $table, 1 );
			$whereStr = " WHERE $priKey = '" . $id . "' ";
		}
		return $this->db->query ( "DELETE FROM `" . DB_PREFIX . $table . "` $whereStr " );
	}
	public function getModel($table, $id, $where = '') {
		$sql = "SELECT DISTINCT * FROM `" . DB_PREFIX . $table . "` ";
		$whereStr = '';
		if ($where != '') {
			$whereStr = " WHERE " . str_ireplace ( 'where', '', $where );
		} else {
			$priKey = $this->getModelDefault ( $table, 1 );
			$whereStr = " WHERE $priKey = '" . $id . "' ";
		}
		$sql .= " $whereStr";
		$query = $this->db->query ( $sql );
		return $query->row;
	}
	public function getModelMulti($sql, $where = '') {
		$whereStr = '';
		if ($where != '') {
			$whereStr = " WHERE " . str_ireplace ( 'where', '', $where );
		}
		$sql .= " $whereStr";
		$query = $this->db->query ( $sql );
		return $query->row;
	}
	public function getModelList($table, $param = array(), $sort_data = array(), $where = '') {
		$sql = "SELECT * FROM `" . DB_PREFIX . $table . "` ";
		$whereStr = '';
		if ($where != '') {
			$whereStr = " WHERE " . str_ireplace ( 'where', '', $where );
		}
		$sql .= " $whereStr";
		if (isset ( $param ['sort'] )) {
			if ($sort_data != null) {
				if (in_array ( $param ['sort'], $sort_data )) {
					$sql .= " ORDER BY " . $param ['sort'];
				} else {
					$sql .= " ORDER BY 1";
				}
			} else {
				$sql .= " ORDER BY " . $param ['sort'];
			}
		} else {
			$sql .= " ORDER BY 1";
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
	public function getModelListMulti($sql, $param, $sort_data = array(), $where = '') {
		$whereStr = '';
		if ($where != '') {
			$whereStr = " WHERE " . str_ireplace ( 'where', '', $where );
		}
		$sql .= " $whereStr";
		if (isset ( $param ['sort'] )) {
			if ($sort_data != null) {
				if (in_array ( $param ['sort'], $sort_data )) {
					$sql .= " ORDER BY " . $param ['sort'];
				} else {
					$sql .= " ORDER BY 1";
				}
			} else {
				$sql .= " ORDER BY " . $param ['sort'];
			}
		} else {
			$sql .= " ORDER BY 1";
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
	public function getModelTotal($table, $where = '') {
		$whereStr = '';
		if ($where != '') {
			$whereStr = " WHERE " . str_ireplace ( 'where', '', $where );
		}
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . $table . "` $whereStr " );
		return $query->row ['total'];
	}
	public function getModelDefault($table, $retPri = 0, $extra = 0) {
		$query = $this->db->query ( "DESC `" . DB_PREFIX . $table . "` " );
		$arr = $query->rows;
		$item = array ();
		$keyNum = 0;
		foreach ( $arr as $row ) {
			$item [$row ["Field"]] = $row ["Default"];
			if ($retPri != 0 && $row ["Key"] == "PRI" && $keyNum == 0) {
				$item ['pri'] = strtolower ( $row ["Field"] );
			} elseif ($extra != 0 && $row ["Extra"] == 'auto_increment') {
				$item ['extra'] = strtolower ( $row ["Field"] );
			}
		}
		if ($retPri != 0) {
			if (! array_key_exists ( "pri", $item )) {
				$item ["pri"] = array_shift ( $arr );
			}
			return $item ["pri"];
		} elseif ($extra != 0) {
			return isset ( $item ['extra'] ) ? $item ['extra'] : '';
		} else {
			return $item;
		}
	}
}