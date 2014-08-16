<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
class ModelB2bKeywordsAnalysis extends Model {
	private $table = 'b2b_keywords_analysis';
	public function addKeywordsAnalysis($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editKeywordsAnalysis($data) {
		return $this->editModel ( $this->table, $data );
	}
	public function deleteKeywordsAnalysis($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getKeywordsAnalysis($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getKeywordsAnalyses($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getTotalKeywordsAnalyses() {
		return $this->getModelTotal ( $this->table );
	}
	public function getDefaultKeywordsAnalysis() {
		return $this->getModelDefault ( $this->table );
	}
}