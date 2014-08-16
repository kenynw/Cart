<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
require_once DIR_SYSTEM . 'library/pclzip/pclzip.lib.php';
class IZip {
	/**
	 * create a zip file with some files or directories
	 * Example:
	 * ZipCreate(CACHE_DIR . /abc.zip', PUBLIC_DIR . 'index.php,FtpDir,images/tmp');
	 *
	 * @param string $fileName        	
	 * @param string $fileList        	
	 * @param bool $cover        	
	 * @return mixed
	 */
	public function ZipCreate($fileName, $fileList, $cover = true) {
		$zip = new PclZip ( $fileName );
		if ($cover) {
			$zip->create ( $fileList );
		} else {
			$zip->add ( $fileList );
		}
	}
	/**
	 * get zip file info
	 *
	 * @param string $fileName        	
	 * @return mixed
	 */
	public function ZipInfo($fileName) {
		$zip = new PclZip ( $fileName );
		return $zip->listContent ();
	}
	/**
	 * get zip file info
	 *
	 * @param string $fileName        	
	 * @param string $filePath        	
	 * @return void
	 */
	public function UnZip($fileName, $filePath = '') {
		$zip = new PclZip ( $fileName );
		if ($filePath == '') {
			// $filePath = substr ( $fileName, 0, - 4 );
			$filePath = dirname ( $fileName );
		}
		return $zip->extract ( PCLZIP_OPT_PATH, $filePath );
	}
}
