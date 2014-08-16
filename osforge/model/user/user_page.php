<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelUserUserPage extends Model {
	private $table = 'user_page';
	public function addUserPage($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editUserPage($data) {
		return $this->editModel ( $this->table, $data );
	}
	public function deleteUserPage($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getUserPage($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getUserPageByRoute($route) {
		$where = " route='$route' ";
		return $this->getModel ( $this->table, 0, $where );
	}
	public function getUserPageList($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getUserPageListCpanel($project) {
		$param = array (
				'sort' => 'sort_order',
				'order' => 'ASC' 
		);
		$where = " status > 0 AND project_name = '" . strtoupper ( $project ) . "' ";
		return $this->getModelList ( $this->table, $param, array (), $where );
	}
	public function getUserPageTotal() {
		return $this->getModelTotal ( $this->table );
	}
	public function getUserPageDefault() {
		return $this->getModelDefault ( $this->table );
	}
}