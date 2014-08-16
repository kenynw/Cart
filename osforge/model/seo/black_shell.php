<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelSeoBlackShell extends Model {
	private $table = 'seo_black_shell';
	public function addBlackShell($data) {
		$data ['user_id'] = $this->user->getId ();
		return $this->addModel ( $this->table, $data );
	}
	public function editBlackShell($data) {
		return $this->editModel ( $this->table, $data );
	}
	public function deleteBlackShell($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getBlackShell($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getBlackShellByDomain($shell_domain) {
		if ($shell_domain != '') {
			$where = " shell_domain = '$shell_domain' ";
			return $this->getModel ( $this->table, 0, $where );
		}
	}
	public function getBlackShells($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		if (! empty ( $param ['filter_name'] )) {
			$where = " shell_domain LIKE '%" . $this->db->escape ( $param ['filter_name'] ) . "%'";
		} else {
			$where = " user_id = " . $this->user->getId ();
		}
		return $this->getModelList ( $this->table, $param, $sort_data, $where );
	}
	public function getTotalBlackShells() {
		$where = " user_id = " . $this->user->getId ();
		return $this->getModelTotal ( $this->table, $where );
	}
	public function getDefaultBlackShell() {
		return $this->getModelDefault ( $this->table );
	}
}