<?php
class ModelInfoFeedback extends Model {
	private $table = 'feedback';
	public function addFeedback($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editFeedback($id, $data) {
		$data ['id'] = $id;
		return $this->editModel ( $this->table, $data );
	}
	public function deleteFeedback($id) {
		return $this->deleteModel ( $this->table, ( int ) $id );
	}
	public function getFeedback($id) {
		return $this->getModel ( $this->table, ( int ) $id );
	}
	public function getFeedbacks($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getTotalFeedbacks() {
		return $this->getModelTotal ( $this->table );
	}
	public function getDefaultFeedback() {
		return $this->getModelDefault ( $this->table );
	}
}