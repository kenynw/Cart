<?php
/**
 * IEC
 *
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
final class Registry {
	private $data = array ();
	public function get($key) {
		return (isset ( $this->data [$key] ) ? $this->data [$key] : null);
	}
	public function set($key, $value) {
		$this->data [$key] = $value;
	}
	public function has($key) {
		return isset ( $this->data [$key] );
	}
}
