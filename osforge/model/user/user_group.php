<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelUserUserGroup extends Model {
	private $table = 'user_group';
	public function addUserGroup($data) {
		$data ['permission'] = isset ( $data ['permission'] ) ? serialize ( $data ['permission'] ) : '';
		return $this->addModel ( $this->table, $data );
	}
	public function editUserGroup($data) {
		$data ['permission'] = isset ( $data ['permission'] ) ? serialize ( $data ['permission'] ) : '';
		return $this->editModel ( $this->table, $data );
	}
	public function deleteUserGroup($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getUserGroup($id) {
		$user_group = $this->getModel ( $this->table, $id );
		$user_group ['permission'] = unserialize ( $user_group ['permission'] );
		return $user_group;
	}
	public function getUserGroupList($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getUserGroups($param = array()) {
		return $this->getUserGroupList ( $param );
	}
	public function getUserGroupTotal() {
		return $this->getModelTotal ( $this->table );
	}
	public function getTotalUserGroups() {
		return $this->getUserGroupTotal ();
	}
	public function getUserGroupDefault() {
		return $this->getModelDefault ( $this->table );
	}
	public function addPermission($user_id, $type, $page) {
		$user_query = $this->db->query ( "SELECT DISTINCT user_group_id FROM `" . DB_PREFIX . "user`
				WHERE user_id = '" . ( int ) $user_id . "'" );
		$user_group_id = ( int ) $user_query->row ['user_group_id'];
		if ($user_group_id > 0) {
			$user_group_query = $this->db->query ( "SELECT DISTINCT * FROM `" . DB_PREFIX . $this->table . "`
					WHERE user_group_id = '" . $user_group_id . "'" );
			if ($user_group_query->num_rows) {
				$data = unserialize ( $user_group_query->row ['permission'] );
				$data [$type] [] = $page;
				$this->db->query ( "UPDATE `" . DB_PREFIX . $this->table . "` SET permission = '" . serialize ( $data ) . "'
						WHERE user_group_id = '" . $user_group_id . "'" );
			}
		}
	}
}