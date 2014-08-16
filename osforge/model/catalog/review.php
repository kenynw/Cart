<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
class ModelCatalogReview extends Model {
	public function addReview_($data) {
		$this->db->query ( "INSERT INTO " . DB_PREFIX . "review SET author = '" . $this->db->escape ( $data ['author'] ) . "', product_id = '" . $this->db->escape ( $data ['product_id'] ) . "', text = '" . $this->db->escape ( strip_tags ( $data ['text'] ) ) . "', rating = '" . ( int ) $data ['rating'] . "', status = '" . ( int ) $data ['status'] . "', date_added = NOW()" );
		$this->cache->delete ( 'product' );
	}
	public function editReview($review_id, $data) {
		$this->db->query ( "UPDATE " . DB_PREFIX . "review SET author = '" . $this->db->escape ( $data ['author'] ) . "', product_id = '" . $this->db->escape ( $data ['product_id'] ) . "', text = '" . $this->db->escape ( strip_tags ( $data ['text'] ) ) . "', rating = '" . ( int ) $data ['rating'] . "', status = '" . ( int ) $data ['status'] . "', date_added = NOW() WHERE review_id = '" . ( int ) $review_id . "'" );
		$this->cache->delete ( 'product' );
	}
	public function deleteReview($review_id) {
		$this->db->query ( "DELETE FROM " . DB_PREFIX . "review WHERE review_id = '" . ( int ) $review_id . "'" );
		$this->cache->delete ( 'product' );
	}
	public function getReview($review_id) {
		$query = $this->db->query ( "SELECT DISTINCT *, (SELECT pd.name FROM " . DB_PREFIX . "product_description pd WHERE pd.product_id = r.product_id AND pd.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "') AS product FROM " . DB_PREFIX . "review r WHERE r.review_id = '" . ( int ) $review_id . "'" );
		return $query->row;
	}
	public function getReviews($data = array()) {
		$sql = "SELECT r.review_id, pd.name, r.author, r.rating, r.status, r.date_added FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product_description pd ON (r.product_id = pd.product_id) WHERE pd.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "'";
		$sort_data = array (
				'pd.name',
				'r.author',
				'r.rating',
				'r.status',
				'r.date_added' 
		);
		if (isset ( $data ['sort'] ) && in_array ( $data ['sort'], $sort_data )) {
			$sql .= " ORDER BY " . $data ['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
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
	public function getTotalReviews() {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review" );
		return $query->row ['total'];
	}
	public function getDefaultReview() {
		return $this->getModelDefault ( "`" . DB_PREFIX . "review`" );
	}
	public function getTotalReviewsAwaitingApproval() {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review WHERE status = '0'" );
		return $query->row ['total'];
	}
	public function addReview($product_id, $data) {
		$this->db->query ( "INSERT INTO " . DB_PREFIX . "review SET author = '" . $this->db->escape ( $data ['name'] ) . "', customer_id = '" . ( int ) $this->customer->getId () . "', product_id = '" . ( int ) $product_id . "', text = '" . $this->db->escape ( $data ['text'] ) . "', rating = '" . ( int ) $data ['rating'] . "', date_added = NOW()" );
	}
	public function getReviewsByProductId($product_id, $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}
		if ($limit < 1) {
			$limit = 20;
		}
		$query = $this->db->query ( "SELECT r.review_id, r.author, r.rating, r.text, p.product_id, pd.name, p.price, p.image, r.date_added FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . ( int ) $product_id . "' AND p.date_available <= NOW() AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "' ORDER BY r.date_added DESC LIMIT " . ( int ) $start . "," . ( int ) $limit );
		return $query->rows;
	}
	public function getTotalReviewsByProductId($product_id) {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . ( int ) $product_id . "' AND p.date_available <= NOW() AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "'" );
		return $query->row ['total'];
	}
}
