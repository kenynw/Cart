<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
require_once DIR_SYSTEM . 'library/phpexcel/PHPExcel.php';
class IExcel extends PHPExcel {
	public function setSheetFirst($sheetList, $startCell = 'A1', $nullValue = null, $strictNullComparison = false) {
		if (is_array ( $sheetList ) && $sheetList != null) {
			if (is_array ( $sheetList [0] )) {
				$arr = $sheetList [0];
			} else {
				$arr = $sheetList;
			}
			if (Helper::is_assoc ( $arr )) {
				foreach ( $arr as $k => $v ) {
					$arr [$k] = $k;
				}
			}
			$this->getActiveSheet ()->fromArray ( $arr, $nullValue, $startCell, $strictNullComparison );
		}
	}
	public function setSheet($sheetList, $startCell = 'A1', $sheetTitle = 'Sheet1', $sheetIndex = 0, $nullValue = null, $strictNullComparison = false) {
		$this->setActiveSheetIndex ( $sheetIndex );
		$this->getActiveSheet ()->setTitle ( $sheetTitle );
		$this->getActiveSheet ()->fromArray ( $sheetList, $nullValue, $startCell, $strictNullComparison );
	}
	public function saveSheet($fileName = '', $writerType = 'Excel5') {
		if ($fileName == '') {
			$fileName = 'New' . date ( "Ymd" );
		}
		if ($writerType == 'Excel2007') {
			$contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
			$fileName = str_ireplace ( '.xlsx', '', $fileName ) . '.xlsx';
		} elseif ($writerType == 'Excel5') {
			$contentType = 'application/vnd.ms-excel';
			$fileName = str_ireplace ( '.xls', '', $fileName ) . '.xls';
		} else {
			$contentType = 'application/octet-stream';
		}
		header ( "Content-Type: $contentType;charset=utf-8" );
		header ( 'Content-Disposition: attachment;filename="' . $fileName . '"' );
		header ( 'Cache-Control: max-age=0' );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this, $writerType );
		$objWriter->save ( 'php://output' );
		exit ();
	}
	public function loadSheet($fileName, $column = 0, $readerType = 'Excel5', $sheetIndex = 0) {
		$objReader = PHPExcel_IOFactory::createReader ( $readerType );
		$objExcel = $objReader->load ( $fileName );
		$objWorksheet = $objExcel->getActiveSheet ( $sheetIndex );
		$highestRow = $objWorksheet->getHighestRow ();
		$highestColumn = PHPExcel_Cell::columnIndexFromString ( $objWorksheet->getHighestColumn () );
		if (($column > 0) && ($column != $highestColumn)) {
			Helper::jsAlert ( 'Error: Excel file error!', '', 1 );
			exit ();
		}
		$list = $objWorksheet->toArray ();
		return $list;
	}
}