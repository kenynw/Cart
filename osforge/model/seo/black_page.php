<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 */
class ModelSeoBlackPage extends Model {
	private $table = 'seo_black_page';
	private $table_to_shell = 'seo_black_page_to_shell';
	private $table_shell = 'seo_black_shell';
	public function addBlackPage($data) {
		$data ['user_id'] = $this->user->getId ();
		$page_id = $this->addModel ( $this->table, $data );
		$where = " shell_id = '" . ( int ) $data ['shell_id'] . "'
				AND page_id = '" . ( int ) $page_id . "'";
		$this->deleteModel ( $this->table_to_shell, 0, $where );
		$data ['page_id'] = $page_id;
		$this->addModel ( $this->table_to_shell, $data );
		return $page_id;
	}
	public function editBlackPage($data) {
		if (isset ( $data ['shell_id_old'] )) {
			$where = " shell_id = '" . ( int ) $data ['shell_id_old'] . "'
				AND page_id = '" . ( int ) $data ['page_id'] . "'";
			$this->deleteModel ( $this->table_to_shell, 0, $where );
			$this->addModel ( $this->table_to_shell, $data );
		}
		return $this->editModel ( $this->table, $data );
	}
	public function deleteBlackPage($id) {
		$result = $this->deleteModel ( $this->table, $id );
		$where = " page_id = '" . ( int ) $id . "'";
		$this->deleteModel ( $this->table_to_shell, 0, $where );
		return $result;
	}
	public function getBlackPage($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getBlackPageByCode($page_code) {
		if ($page_code != '') {
			$where = " page_code = '$page_code' ";
			return $this->getModel ( $this->table, 0, $where );
		}
	}
	public function getBlackPageByShell($page_url, $shell_domain) {
		if ($page_url != "" && $shell_domain != "") {
			$sql = "SELECT p.*, s.shell_domain, s.shell_id, s.shell_build FROM `" . DB_PREFIX . $this->table . "` p
				LEFT JOIN `" . DB_PREFIX . $this->table_to_shell . "` ps
				ON (p.page_id = ps.page_id)
				LEFT JOIN `" . DB_PREFIX . $this->table_shell . "` s
				ON (ps.shell_id = s.shell_id)";
			$where = " s.shell_domain = '$shell_domain' AND p.page_url = '$page_url' ";
			return $this->getModelMulti ( $sql, $where );
		}
	}
	public function getBlackPageByShellId($page_url, $shell_id) {
		if ($page_url != "" && $shell_id != "") {
			$sql = "SELECT p.*, s.shell_domain, s.shell_id, s.shell_build FROM `" . DB_PREFIX . $this->table . "` p
				LEFT JOIN `" . DB_PREFIX . $this->table_to_shell . "` ps
				ON (p.page_id = ps.page_id)
				LEFT JOIN `" . DB_PREFIX . $this->table_shell . "` s
				ON (ps.shell_id = s.shell_id)";
			$where = " s.shell_id = '$shell_id' AND p.page_url = '$page_url' ";
			return $this->getModelMulti ( $sql, $where );
		}
	}
	public function getBlackShellByPage($page_id) {
		$sql = "SELECT s.*, ps.page_id FROM `" . DB_PREFIX . $this->table_shell . "` s
				LEFT JOIN `" . DB_PREFIX . $this->table_to_shell . "` ps
				ON s.shell_id = ps.shell_id ";
		$where = " page_id = '" . ( int ) $page_id . "'";
		return $this->getModelMulti ( $sql, $where );
	}
	public function getBlackPages($param, $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getModelDefault ( $this->table );
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		$sql = "SELECT p.*, s.shell_domain, s.shell_id, s.shell_build FROM `" . DB_PREFIX . $this->table . "` p
				LEFT JOIN `" . DB_PREFIX . $this->table_to_shell . "` ps
				ON (p.page_id = ps.page_id)
				LEFT JOIN `" . DB_PREFIX . $this->table_shell . "` s
				ON (ps.shell_id = s.shell_id) ";
		$where = " p.user_id = " . $this->user->getId ();
		if (isset ( $param ['shell_id'] ) && $param ['shell_id'] > 0) {
			$where .= " AND ps.shell_id = " . ( int ) $param ['shell_id'];
			unset ( $param ['shell_id'] );
		}
		return $this->getModelListMulti ( $sql, $param, $sort_data, $where );
	}
	public function getTotalBlackPages() {
		$where = " user_id = " . $this->user->getId ();
		return $this->getModelTotal ( $this->table, $where );
	}
	public function getDefaultBlackPage() {
		return $this->getModelDefault ( $this->table );
	}
}