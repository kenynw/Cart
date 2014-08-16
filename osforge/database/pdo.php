<?php
final class DBPDO {
	private $link;
	public function __construct($hostname, $username, $password, $database) {
		try {
			$this->link = new PDO ( "mysql:host=$hostname;dbname=$database", $username, $password, array ( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' ) );
		} catch ( PDOException $e ) {
			throw new ErrorException ( 'Connection failed: ' . $e->getMessage () );
		}
	}
	public function query($sql) {
		if (stripos ( $sql, 'select' ) !== false) {
			$query = $this->link->prepare ( $sql );
			$query->execute ();
		} else {
			$query = $this->link->exec ( $sql );
		}
		if (stripos ( $sql, 'select' ) !== false) {
			$data = array ();
			$i = 0;
			while ( ($row = $query->fetch ()) != false ) {
				$data [] = $row;
				$i ++;
			}
			$result = new stdClass ();
			$result->num_rows = $i;
			$result->row = isset ( $data [0] ) ? $data [0] : array ();
			$result->rows = $data;
			unset ( $data );
			return $result;
		} else {
			return $query;
		}
	}
	public function escape($value) {
		return $value;
	}
	public function countAffected() {
	}
	public function getLastId() {
		return $this->link->lastInsertId ();
	}
	public function __destruct() {
		$this->link = null;
	}
}
