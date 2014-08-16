<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelInfoNewsletter extends Model {
	private $table = 'newsletter';
	public function addNewsletter($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editNewsletter($id, $data) {
		$where = "newsletter_id = '" . $id . "'";
		return $this->editModel ( $this->table, $data, $where );
	}
	public function deleteNewsletter($id) {
		$where = "newsletter_id = '" . $id . "'";
		return $this->deleteModel ( $this->table, 0, $where );
	}
	public function getNewsletter($id) {
		$where = "newsletter_id = '" . $id . "'";
		return $this->getModel ( $this->table, 0, $where );
	}
	public function getNewsletters($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		$sql = "SELECT * FROM `" . DB_PREFIX . $this->table . "` ";
		$sort_data = array ( 'newsletter_subject' );
		if (isset ( $data ['sort'] ) && in_array ( $data ['sort'], $sort_data )) {
			$sql .= " ORDER BY " . $data ['sort'];
		} else {
			$sql .= " ORDER BY newsletter_id";
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
	public function getTotalNewsletters() {
		return $this->getModelTotal ( $this->table );
	}
	public function getDefaultNewsletter() {
		return $this->getModelDefault ( $this->table );
	}
}