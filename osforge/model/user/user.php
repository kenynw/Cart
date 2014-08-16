<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelUserUser extends Model {
	private $table = 'user';
	public function addUser($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editUser($data) {
		if (isset ( $data ['password'] )) {
			if ($data ['password'] != '') {
				$salt = substr ( md5 ( uniqid ( rand (), true ) ), 0, 9 );
				$data ['salt'] = $this->db->escape ( $salt );
				$data ['password'] = $this->db->escape ( sha1 ( $salt . sha1 ( $salt . sha1 ( $data ['password'] ) ) ) );
			} else {
				unset ( $data ['password'] );
			}
		}
		$result = $this->editModel ( $this->table, $data );
		return $result;
	}
	public function deleteUser($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getUser($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getUserByUsername($username) {
		$where = " username = '" . $this->db->escape ( $username ) . "' ";
		return $this->getModel ( $this->table, 0, $where );
	}
	public function getUserByCode($code) {
		$where = " code = '" . $this->db->escape ( $code ) . "' AND code != '' ";
		return $this->getModel ( $this->table, 0, $where );
	}
	public function getUserList($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getUsers($param = array()) {
		return $this->getUserList ( $param );
	}
	public function getUserTotal() {
		return $this->getModelTotal ( $this->table );
	}
	public function getTotalUsers() {
		return $this->getUserTotal ();
	}
	public function getTotalUsersByGroupId($user_group_id) {
		$where = " user_group_id = '" . ( int ) $user_group_id . "' ";
		return $this->getModelTotal ( $this->table, $where );
	}
	public function getTotalUsersByEmail($email) {
		$where = " LCASE(email) = '" . $this->db->escape ( utf8_strtolower ( $email ) ) . "' ";
		return $this->getModelTotal ( $this->table, $where );
	}
	public function editPassword($user_id, $password) {
		$data = array (
				'user_id' => ( int ) $user_id,
				'salt' => $this->db->escape ( $salt = substr ( md5 ( uniqid ( rand (), true ) ), 0, 9 ) ),
				'password' => $this->db->escape ( sha1 ( $salt . sha1 ( $salt . sha1 ( $password ) ) ) ),
				'code' => '' 
		);
		return $this->editModel ( $this->table, $data );
	}
	public function getUserDefault() {
		return $this->getModelDefault ( $this->table );
	}
	public function editCode($email, $code) {
		$where = " LCASE(email) = '" . $this->db->escape ( utf8_strtolower ( $email ) ) . "' ";
		$data = array (
				'code' => $this->db->escape ( $code ) 
		);
		return $this->editModel ( $this->table, $data, $where );
	}
}