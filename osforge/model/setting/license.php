<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.3
 */
class ModelSettingLicense extends Model {
	private $table = 'license';
	public function addLicense($data) {
		return $this->addModel ( $this->table, $data );
	}
	public function editLicense($data) {
		return $this->editModel ( $this->table, $data );
	}
	public function deleteLicense($id) {
		return $this->deleteModel ( $this->table, $id );
	}
	public function getLicense($id) {
		return $this->getModel ( $this->table, $id );
	}
	public function getLicenseActive() {
		$where = " status > 0 AND project_name = '" . strtoupper ( PROJECT ) . "'";
		return $this->getModel ( $this->table, 0, $where );
	}
	public function getLicenses($param = array(), $sort_data = array()) {
		if (! $sort_data) {
			$item = $this->getDefaultLicense();
			foreach ( $item as $k => $v ) {
				$sort_data [] = $k;
			}
		}
		return $this->getModelList ( $this->table, $param, $sort_data );
	}
	public function getTotalLicenses() {
		return $this->getModelTotal ( $this->table );
	}
	public function getDefaultLicense() {
		return $this->getModelDefault ( $this->table );
	}
}