<?php
/**
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.2
 */
class Helper {
	/**
	 * Generate a unique ID
	 *
	 * @return string the unique identifier, as a string.
	 */
	public static function getUid() {
		return md5 ( uniqid ( rand (), true ) );
	}
	/**
	 * 0 => 000000,1 => 000001,20 => 000020,432 => 000432
	 *
	 * @param int $num        	
	 * @param int $n        	
	 * @return string
	 */
	public static function idPad($num, $n = 6) {
		return str_pad ( ( int ) $num, $n, "0", STR_PAD_LEFT );
	}
	/**
	 * print an array
	 */
	public static function p() {
		$args = func_get_args ();
		if (count ( $args ) < 1) {
			print_r ( "<font color='red'>p() need options" );
			return;
		}
		echo '<div style="width:100%;text-align:left"><pre>';
		foreach ( $args as $arg ) {
			if (is_array ( $arg )) {
				print_r ( $arg );
				echo '<br>';
			} else if (is_string ( $arg )) {
				echo $arg . '<br>';
			} else {
				var_dump ( $arg );
				echo '<br>';
			}
		}
		echo '</pre></div>';
	}
	public static function is_assoc($arr) {
		return array_keys ( $arr ) !== range ( 0, count ( $arr ) - 1 );
	}
	/**
	 * reorganize an array by the given field, like group by.
	 *
	 * @param array $list        	
	 * @param string $field        	
	 * @return array
	 */
	public static function reOrganize($list, $field) {
		$arr = array ();
		foreach ( $list as $item ) {
			$name = $item [$field];
			unset ( $item [$field] );
			$arr [$name] ['title'] = $name;
			$arr [$name] ['item'] [] = $item;
		}
		return $arr;
	}
	/**
	 * create encode string
	 *
	 * @param string $string        	
	 * @param string $key        	
	 * @return string
	 */
	public static function cmEncode($plain) {
		$password = '';
		for($i = 0; $i < 10; $i ++) {
			$password .= self::cm_rand ();
		}
		$salt = substr ( md5 ( $password ), 0, 2 );
		$password = md5 ( $salt . $plain ) . ':' . $salt;
		return $password;
	}
	/**
	 * check the $plain is same as $encrypted
	 *
	 * @param string $plain        	
	 * @param string $encrypted        	
	 * @return boolean
	 */
	public static function cmDecode($plain, $encrypted) {
		if (self::notNull ( $plain ) && self::notNull ( $encrypted )) {
			$stack = explode ( ':', $encrypted );
			if (sizeof ( $stack ) != 2)
				return false;
			if (md5 ( $stack [1] . $plain ) == $stack [0]) {
				return true;
			}
		}
		return false;
	}
	/**
	 * Redirect to another page or site
	 *
	 * @param
	 *        	string The url to redirect to
	 */
	public static function redirect($url, $time = 0) {
		while ( strstr ( $url, '&&' ) )
			$url = str_replace ( '&&', '&', $url );
		while ( strstr ( $url, '&amp;&amp;' ) )
			$url = str_replace ( '&amp;&amp;', '&amp;', $url );
		while ( strstr ( $url, '&amp;' ) )
			$url = str_replace ( '&amp;', '&', $url );
		if (! headers_sent ()) {
			if ($time === 0) {
				header ( "Location: " . $url );
				exit ( 0 );
			}
			header ( "refresh:" . $time . ";url=" . $url . "" );
			session_write_close ();
			exit ( 0 );
		} else {
			exit ( "<meta http-equiv='Refresh' content='" . $time . ";URL=" . $url . "'>" );
		}
	}
	/**
	 * post the form
	 *
	 * @param unknown $action        	
	 * @param string $hiddenField        	
	 * @param string $target        	
	 * @param string $formId        	
	 * @param string $method        	
	 * @return string
	 */
	public static function postForm($action, $hiddenField = null, $target = '_parent', $formId = 'myForm', $method = 'post') {
		if ($target == 'hidden') {
			$html = "<iframe name='myFrame' id='myFrame' frameborder='0' scrolling='no' style='display:none;'></iframe>";
			$target = 'myFrame';
		} elseif ($target == 'iframe') {
			$html = "<iframe name='myFrame' id='myFrame' frameborder='0' scrolling='auto' height='1050' width='950'></iframe>";
			$target = 'myFrame';
		} else {
			$html = "";
		}
		$html .= "<form action='$action' method='$method' id='$formId' name='$formId' target='$target'>";
		foreach ( $hiddenField as $k => $v ) {
			$html .= "<input type=hidden name='$k' id='$k' value='$v'>";
		}
		$html .= "</form>";
		$html .= "<script type='text/javascript'>window.status='$action';document.getElementById('$formId').submit();</script>";
		return $html;
	}
	/**
	 * js alert
	 *
	 * @param string $info        	
	 * @param string $url        	
	 * @param int $window        	
	 * @param boolean $close        	
	 *
	 * @return void
	 *
	 */
	public static function jsAlert($info, $url = '', $window = 0, $close = false) {
		$alert = '<script language="javascript">alert("' . $info . '");';
		if ($url != '') { // 1.self,2.parent,3.opener;
			if ($window == 2) {
				$alert .= 'window.parent.location.href="' . $url . '";';
			} elseif ($window == 3) {
				$alert .= 'window.opener.parent.location.href="' . $url . '";';
			} else {
				$alert .= 'window.location.href="' . $url . '";';
			}
		} else {
			if ($window == 1) {
				$alert .= 'history.go(-1);';
			} elseif ($window == 2) {
				$alert .= 'window.parent.location.reload();';
			} elseif ($window == 3) {
				$alert .= 'window.opener.parent.location.reload();';
			}
		}
		if ($close) {
			$alert .= 'window.close();';
		}
		$alert .= '</script>';
		echo $alert;
	}
	/**
	 * Make a string's first character lowercase
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function lc_first($str) {
		if (false === function_exists ( 'lcfirst' )) {
			$str [0] = strtolower ( $str [0] );
			return ( string ) $str;
		} else {
			return lcfirst ( $str );
		}
	}
	public static function r_trim($str, $remove = '') {
		$str = ( string ) $str;
		$remove = ( string ) $remove;
		if (empty ( $remove )) {
			return rtrim ( $str );
		} else {
			$len = strlen ( $remove );
			$offset = strlen ( $str ) - $len;
			while ( $offset > 0 && $offset == strpos ( $str, $remove, $offset ) ) {
				$str = substr ( $str, 0, $offset );
				$offset = strlen ( $str ) - $len;
			}
			return rtrim ( $str );
		}
	}
	/**
	 * Get the first Pinyin of the a chinese string
	 *
	 * @param string $str        	
	 * @access public
	 * @return string
	 */
	public static function Pinyin($str) {
		$ret = "";
		$s1 = iconv ( "UTF-8", "gb2312", $str );
		$s2 = iconv ( "gb2312", "UTF-8", $s1 );
		if ($s2 == $str) {
			$str = $s1;
		}
		for($i = 0; $i < strlen ( $str ); $i ++) {
			$s1 = substr ( $str, $i, 1 );
			$p = ord ( $s1 );
			if ($p > 160) {
				$s2 = substr ( $str, $i ++, 2 );
				$ret .= self::_getFirstChar ( $s2 );
			} else {
				$ret .= $s1;
			}
		}
		return $ret;
	}
	private static function _getFirstChar($str) {
		$fchar = ord ( $str {0} );
		if ($fchar >= ord ( "A" ) and $fchar <= ord ( "z" ))
			return strtoupper ( $str {0} );
		$s1 = iconv ( "UTF-8", "gb2312", $str );
		$s2 = iconv ( "gb2312", "UTF-8", $s1 );
		if ($s2 == $str) {
			$s = $s1;
		} else {
			$s = $str;
		}
		$asc = ord ( $s {0} ) * 256 + ord ( $s {1} ) - 65536;
		if ($asc >= - 20319 and $asc <= - 20284)
			return "A";
		if ($asc >= - 20283 and $asc <= - 19776)
			return "B";
		if ($asc >= - 19775 and $asc <= - 19219)
			return "C";
		if ($asc >= - 19218 and $asc <= - 18711)
			return "D";
		if ($asc >= - 18710 and $asc <= - 18527)
			return "E";
		if ($asc >= - 18526 and $asc <= - 18240)
			return "F";
		if ($asc >= - 18239 and $asc <= - 17923)
			return "G";
		if ($asc >= - 17922 and $asc <= - 17418)
			return "H";
		if ($asc >= - 17417 and $asc <= - 16475)
			return "J";
		if ($asc >= - 16474 and $asc <= - 16213)
			return "K";
		if ($asc >= - 16212 and $asc <= - 15641)
			return "L";
		if ($asc >= - 15640 and $asc <= - 15166)
			return "M";
		if ($asc >= - 15165 and $asc <= - 14923)
			return "N";
		if ($asc >= - 14922 and $asc <= - 14915)
			return "O";
		if ($asc >= - 14914 and $asc <= - 14631)
			return "P";
		if ($asc >= - 14630 and $asc <= - 14150)
			return "Q";
		if ($asc >= - 14149 and $asc <= - 14091)
			return "R";
		if ($asc >= - 14090 and $asc <= - 13319)
			return "S";
		if ($asc >= - 13318 and $asc <= - 12839)
			return "T";
		if ($asc >= - 12838 and $asc <= - 12557)
			return "W";
		if ($asc >= - 12556 and $asc <= - 11848)
			return "X";
		if ($asc >= - 11847 and $asc <= - 11056)
			return "Y";
		if ($asc >= - 11055 and $asc <= - 10247)
			return "Z";
		return null;
	}
	public static function cmGetIP() {
		if (isset ( $_SERVER )) {
			if (isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
				$ip = $_SERVER ['HTTP_X_FORWARDED_FOR'];
			} elseif (isset ( $_SERVER ['HTTP_CLIENT_IP'] )) {
				$ip = $_SERVER ['HTTP_CLIENT_IP'];
			} elseif (isset ( $_SERVER ['HTTP_X_FORWARDED'] )) {
				$ip = $_SERVER ['HTTP_X_FORWARDED'];
			} elseif (isset ( $_SERVER ['HTTP_X_CLUSTER_CLIENT_IP'] )) {
				$ip = $_SERVER ['HTTP_X_CLUSTER_CLIENT_IP'];
			} elseif (isset ( $_SERVER ['HTTP_FORWARDED_FOR'] )) {
				$ip = $_SERVER ['HTTP_FORWARDED_FOR'];
			} elseif (isset ( $_SERVER ['HTTP_FORWARDED'] )) {
				$ip = $_SERVER ['HTTP_FORWARDED'];
			} else {
				$ip = $_SERVER ['REMOTE_ADDR'];
			}
		} else {
			if (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
				$ip = getenv ( 'HTTP_X_FORWARDED_FOR' );
			} elseif (getenv ( 'HTTP_CLIENT_IP' )) {
				$ip = getenv ( 'HTTP_CLIENT_IP' );
			} else {
				$ip = getenv ( 'REMOTE_ADDR' );
			}
		}
		return $ip;
	}
	public static function notNull($value) {
		if (! isset ( $value ))
			return false;
		if (is_array ( $value )) {
			if (count ( $value ) > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			if ((is_string ( $value ) || is_int ( $value )) && ($value != '') && (strtolower ( $value ) != 'null') && (strlen ( trim ( $value ) ) > 0)) {
				return true;
			} else {
				return false;
			}
		}
	}
	/**
	 * Return a random value
	 *
	 * @param string $min        	
	 * @param string $max        	
	 * @return string number
	 */
	public static function cm_rand($min = null, $max = null) {
		static $seeded;
		if (! isset ( $seeded )) {
			mt_srand ( ( double ) microtime () * 1000000 );
			$seeded = true;
		}
		if (isset ( $min ) && isset ( $max )) {
			if ($min >= $max) {
				return $min;
			} else {
				return mt_rand ( $min, $max );
			}
		} else {
			return mt_rand ();
		}
	}
	/**
	 * returns a random string
	 *
	 * @param int $length        	
	 * @return string
	 */
	public static function cm_rand_str($length = 4, $type = 'mixed') {
		if (($type != 'mixed') && ($type != 'chars') && ($type != 'digits'))
			return false;
		$rand_value = '';
		while ( strlen ( $rand_value ) < $length ) {
			if ($type == 'digits') {
				$char = self::cm_rand ( 0, 9 );
			} else {
				$char = chr ( self::cm_rand ( 0, 255 ) );
			}
			if ($type == 'mixed') {
				if (preg_match ( '/^[a-z0-9]$/i', $char ))
					$rand_value .= $char;
			} elseif ($type == 'chars') {
				if (preg_match ( '/^[a-z]$/i', $char ))
					$rand_value .= $char;
			} elseif ($type == 'digits') {
				if (preg_match ( '/^[0-9]$/', $char ))
					$rand_value .= $char;
			}
		}
		if ($type == 'mixed' && ! preg_match ( '/^(?=.*[\w]+.*)(?=.*[\d]+.*)[\d\w]{' . $length . ',}$/', $rand_value )) {
			$rand_value .= self::cm_rand ( 0, 9 );
		}
		return $rand_value;
	}
	/**
	 * return an substring
	 *
	 * @param string $str        	
	 * @param int $length        	
	 * @param int $start        	
	 * @param string $charset        	
	 * @param string $suffix        	
	 * @return string
	 */
	public static function cm_truncate_string($str, $length = 150, $start = 0, $charset = 'utf-8', $suffix = '...') {
		if ($str == "")
			return $str;
		if (is_array ( $str ))
			return $str;
		$str = trim ( $str );
		switch ($charset) {
			case 'utf-8' :
			case 'UTF8' :
				$charLen = 3;
				break;
			default :
				$charLen = 2;
				break;
		}
		if (strlen ( $str ) <= ($length * $charLen)) {
			return $str;
		}
		if (function_exists ( 'mb_substr' )) {
			$slice = mb_substr ( $str, $start, $length, $charset );
		} else if (function_exists ( 'iconv_substr' )) {
			$slice = iconv_substr ( $str, $start, $length, $charset );
		} else {
			$re = array ();
			$matches = array ();
			$re ['utf-8'] = '/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/';
			$re ['gb2312'] = '/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/';
			$re ['gbk'] = '/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/';
			$re ['big5'] = '/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/';
			preg_match_all ( $re [$charset], $str, $matches );
			$slice = join ( '', array_slice ( $matches [0], $start, $length ) );
		}
		return $slice . $suffix;
	}
	/**
	 * return truncated paragraph
	 *
	 * @param string $paragraph        	
	 * @param number $size        	
	 * @param string $word        	
	 * @return string
	 */
	public static function cm_truncate_paragraph($paragraph, $size = 100, $word = ' ') {
		$cm_paragraph = "";
		$word = explode ( " ", $paragraph );
		$zv_total = count ( $word );
		if ($zv_total > $size) {
			for($x = 0; $x < $size; $x ++) {
				$cm_paragraph = $cm_paragraph . $word [$x] . " ";
			}
			$cm_paragraph = trim ( $cm_paragraph );
		} else {
			$cm_paragraph = trim ( $paragraph );
		}
		return $cm_paragraph;
	}
	/**
	 * auto change the charset
	 *
	 * @param string $charContent        	
	 * @param string $from        	
	 * @param string $to        	
	 * @return string
	 */
	public static function cm_auto_charset($charContent, $from = 'gbk', $to = 'utf-8') {
		$from = strtoupper ( $from ) == 'UTF8' ? 'utf-8' : $from;
		$to = strtoupper ( $to ) == 'UTF8' ? 'utf-8' : $to;
		if (strtoupper ( $from ) === strtoupper ( $to ) || empty ( $charContent ) || (is_scalar ( $charContent ) && ! is_string ( $charContent ))) {
			return $charContent;
		}
		if (is_string ( $charContent )) {
			if (function_exists ( 'mb_convert_encoding' )) {
				return mb_convert_encoding ( $charContent, $to, $from );
			} elseif (function_exists ( 'iconv' )) {
				return iconv ( $from, $to, $charContent );
			} else {
				return $charContent;
			}
		} elseif (is_array ( $charContent )) {
			foreach ( $charContent as $key => $val ) {
				$_key = self::autoCharset ( $key, $from, $to );
				$charContent [$_key] = self::autoCharset ( $val, $from, $to );
				if ($key != $_key)
					unset ( $charContent [$key] );
			}
			return $charContent;
		} else {
			return $charContent;
		}
	}
	/**
	 * $str 原始中文字符串
	 * $encoding 原始字符串的编码，默认GBK
	 * $prefix 编码后的前缀，默认"&#"
	 * $postfix 编码后的后缀，默认";"
	 */
	public static function cm_unicode_encode($str, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
		$str = iconv ( $encoding, 'UCS-2', $str );
		$arrstr = str_split ( $str, 2 );
		$unistr = '';
		for($i = 0, $len = count ( $arrstr ); $i < $len; $i ++) {
			$dec = hexdec ( bin2hex ( $arrstr [$i] ) );
			$unistr .= $prefix . $dec . $postfix;
		}
		return $unistr;
	}
	/**
	 * $str Unicode编码后的字符串
	 * $decoding 原始字符串的编码，默认GBK
	 * $prefix 编码字符串的前缀，默认"&#"
	 * $postfix 编码字符串的后缀，默认";"
	 */
	public static function cm_unicode_decode($unistr, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
		$arruni = explode ( $prefix, $unistr );
		$unistr = '';
		for($i = 1, $len = count ( $arruni ); $i < $len; $i ++) {
			if (strlen ( $postfix ) > 0) {
				$arruni [$i] = substr ( $arruni [$i], 0, strlen ( $arruni [$i] ) - strlen ( $postfix ) );
			}
			$temp = intval ( $arruni [$i] );
			$unistr .= ($temp < 256) ? chr ( 0 ) . chr ( $temp ) : chr ( $temp / 256 ) . chr ( $temp % 256 );
		}
		return iconv ( 'UCS-2', $encoding, $unistr );
	}
	/**
	 * remove common HTML from text for display as paragraph
	 *
	 * @param string $clean_it        	
	 * @param string $extraTags        	
	 * @return string
	 */
	public static function cm_html_clean($clean_it, $extraTags = '') {
		if (! is_array ( $extraTags ))
			$extraTags = array (
					$extraTags 
			);
		$clean_it = preg_replace ( '/\r/', ' ', $clean_it );
		$clean_it = preg_replace ( '/\t/', ' ', $clean_it );
		$clean_it = preg_replace ( '/\n/', ' ', $clean_it );
		$clean_it = nl2br ( $clean_it );
		while ( strstr ( $clean_it, '<br>' ) )
			$clean_it = str_replace ( '<br>', ' ', $clean_it );
		while ( strstr ( $clean_it, '<br />' ) )
			$clean_it = str_replace ( '<br />', ' ', $clean_it );
		while ( strstr ( $clean_it, '<br/>' ) )
			$clean_it = str_replace ( '<br/>', ' ', $clean_it );
		while ( strstr ( $clean_it, '<p>' ) )
			$clean_it = str_replace ( '<p>', ' ', $clean_it );
		while ( strstr ( $clean_it, '</p>' ) )
			$clean_it = str_replace ( '</p>', ' ', $clean_it );
		while ( strstr ( $clean_it, '<span class="smallText">' ) )
			$clean_it = str_replace ( '<span class="smallText">', ' ', $clean_it );
		while ( strstr ( $clean_it, '</span>' ) )
			$clean_it = str_replace ( '</span>', ' ', $clean_it );
		$taglist = array (
				'strong',
				'b',
				'u',
				'i',
				'em' 
		);
		$taglist = array_merge ( $taglist, (is_array ( $extraTags ) ? $extraTags : array (
				$extraTags 
		)) );
		foreach ( $taglist as $tofind ) {
			if ($tofind != '')
				$clean_it = preg_replace ( "/<[\/\!]*?" . $tofind . "[^<>]*?>/si", ' ', $clean_it );
		}
		while ( strstr ( $clean_it, '  ' ) )
			$clean_it = str_replace ( '  ', ' ', $clean_it );
		$clean_it = strip_tags ( $clean_it );
		return $clean_it;
	}
	/**
	 * function to override PHP's is_writable()
	 *
	 * @var string
	 * @return boolean
	 */
	public static function isWriteable($filePath, $make_unwritable = false) {
		if (is_dir ( $filePath ))
			return is_writable ( $filePath );
		$fp = @fopen ( $filePath, 'a' );
		if ($fp) {
			@fclose ( $fp );
			if ($make_unwritable)
				self::setUnWritable ( $filePath );
			$fp = @fopen ( $filePath, 'a' );
			if ($fp) {
				@fclose ( $fp );
				return true;
			}
		}
		return false;
	}
	/**
	 * attempts to make the specified file read-only
	 *
	 * @var string
	 * @return boolean
	 */
	public static function setUnWritable($filePath) {
		return @chmod ( $filePath, 0444 );
	}
	/**
	 * create a directory if it's not exist
	 *
	 * @param string $path        	
	 * @return boolean
	 */
	public static function dirCreate($path) {
		if (empty ( $path )) {
			return;
		}
		if (! is_dir ( $path )) {
			if (! is_dir ( dirname ( $path ) )) {
				self::dirCreate ( dirname ( $path ) );
			}
			@mkdir ( $path );
			chmod ( $path, 0777 );
		}
	}
	/**
	 * delete a directory
	 *
	 * @param string $path        	
	 * @return boolean
	 *
	 */
	public static function dirDelete($path) {
		$success = true;
		if (file_exists ( $path )) {
			$path = (substr ( $path, - 1 ) != DS) ? $path . DS : $path;
			$handle = opendir ( $path );
			while ( false != ($fileName = readdir ( $handle )) ) {
				if (! in_array ( $fileName, array (
						'.',
						'..' 
				) )) {
					if (! is_dir ( $path . $fileName )) {
						if (! @unlink ( $path . $fileName )) {
							$success = false;
							break;
						}
					} else {
						self::dirDelete ( $path . $fileName );
					}
				}
			}
			closedir ( $handle );
			if (! @rmdir ( $path )) {
				$success = false;
			}
		}
		return $success;
	}
	/**
	 * copy a directory
	 *
	 * @param string $dirfrom        	
	 * @param string $dirto        	
	 * @param string $cover        	
	 * @return void
	 *
	 */
	public static function dirCopy($dirfrom, $dirto, $cover = true) {
		if (! file_exists ( $dirfrom )) {
			return;
		}
		if (! file_exists ( $dirto )) {
			self::dirCreate ( $dirto );
		}
		$handle = opendir ( $dirfrom );
		while ( false != ($file = readdir ( $handle )) ) {
			if (! in_array ( $file, array (
					'.',
					'..' 
			) )) {
				if (is_dir ( $dirfrom . DS . $file )) {
					self::dirCopy ( $dirfrom . DS . $file, $dirto . DS . $file );
				} else {
					if (! file_exists ( $dirto . DS . $file ) || $cover) {
						copy ( $dirfrom . DS . $file, $dirto . DS . $file );
					}
				}
			}
		}
		closedir ( $handle );
	}
	/**
	 * get the direcotry list
	 *
	 * @param string $dir        	
	 * @return array
	 *
	 */
	public static function dirRead($dir) {
		$dirArray [] = NULL;
		if (false != ($handle = opendir ( $dir ))) {
			$i = 0;
			while ( false !== ($file = readdir ( $handle )) ) {
				if ($file != "." && $file != ".." && ! strpos ( $file, "." )) {
					$dirArray [$i] = $file;
					$i ++;
				}
			}
			closedir ( $handle );
		}
		return $dirArray;
	}
	/**
	 * get the size of the directory
	 *
	 * @param string $dirname        	
	 * @param bool $format        	
	 * @return int
	 *
	 */
	public static function dirSize($dirname, $format = true) {
		if (! file_exists ( $dirname ) or ! is_dir ( $dirname ))
			return false;
		if (! $handle = opendir ( $dirname ))
			return false;
		$size = 0;
		while ( false !== ($file = readdir ( $handle )) ) {
			if ($file == "." or $file == "..")
				continue;
			$file = $dirname . SL . $file;
			if (is_dir ( $file )) {
				$size += self::dirSize ( $file );
			} else {
				$size += @filesize ( $file );
			}
		}
		closedir ( $handle );
		if ($format) {
			$size = self::formatSize ( $size );
		}
		return $size;
	}
	/**
	 * Format file size
	 *
	 * @param int $bytes
	 *        	size in bytes
	 * @param int $precision        	
	 * @return string File size in KB, MB, GB
	 */
	public static function formatSize($bytes, $precision = 2) {
		$units = array (
				'B',
				'KB',
				'MB',
				'GB',
				'TB' 
		);
		$bytes = max ( $bytes, 0 );
		$pow = floor ( ($bytes ? log ( $bytes ) : 0) / log ( 1024 ) );
		$pow = min ( $pow, count ( $units ) - 1 );
		$bytes /= pow ( 1024, $pow );
		return round ( $bytes, $precision ) . ' ' . $units [$pow];
	}
	/**
	 * get sub-directori(es) of a directory, not including the directory which its name is one of ".", ".." or ".svn"
	 *
	 * @param string $dir
	 *        	Path to the directory
	 * @return array
	 */
	public static function getSubDir($dir) {
		if (! file_exists ( $dir )) {
			return array ();
		}
		$subDirs = array ();
		$dirIterator = new DirectoryIterator ( $dir );
		foreach ( $dirIterator as $dir ) {
			if ($dir->isDot () || ! $dir->isDir ()) {
				continue;
			}
			$dir = $dir->getFilename ();
			if ($dir == '.svn') {
				continue;
			}
			$subDirs [] = $dir;
		}
		return $subDirs;
	}
	/**
	 * create an empty file
	 *
	 * @param string $filename        	
	 * @return string
	 */
	public static function fileCreate($filename) {
		if (file_exists ( $filename ))
			return false;
		self::dirCreate ( dirname ( $filename ) );
		return @file_put_contents ( $filename, '' );
	}
	/**
	 * write to a file
	 *
	 * @param string $filename        	
	 * @param string $content        	
	 * @param string $type        	
	 * @return boolean
	 */
	public static function fileWrite($filename, $content, $type = 1) {
		self::dirCreate ( dirname ( $filename ) );
		if ($type == 1) {
			if (file_exists ( $filename ))
				self::fileDelete ( $filename );
			self::fileCreate ( $filename );
			self::fileWrite ( $filename, $content, 2 );
		} else {
			if (! is_writable ( $filename ))
				return false;
			$handle = @fopen ( $filename, 'a' );
			if (! $handle)
				return false;
			$result = @fwrite ( $handle, $content );
			if (! $result)
				return false;
			@fclose ( $handle );
			return true;
		}
	}
	/**
	 * read a file to a string
	 *
	 * @param string $filename        	
	 * @return string
	 */
	public static function fileRead($filename) {
		if (function_exists ( 'file_get_contents' )) {
			return nl2br ( file_get_contents ( $filename ) );
		} else {
			$fp = fopen ( $filename, "rb" );
			$str = nl2br ( fread ( $fp, filesize ( $filename ) ) );
			fclose ( $fp );
			return $str;
		}
	}
	/**
	 * copy a file
	 *
	 * @param string $filename        	
	 * @param string $newfilename        	
	 * @return boolean
	 */
	public static function fileCopy($filename, $newfilename) {
		if (! file_exists ( $filename ) || ! is_writable ( $filename ))
			return false;
		self::dirCreate ( dirname ( $newfilename ) );
		return @copy ( $filename, $newfilename );
	}
	/**
	 * move a file
	 *
	 * @param string $filename        	
	 * @param string $newfilename        	
	 * @return boolean
	 */
	public static function fileMove($filename, $newfilename) {
		if (! file_exists ( $filename ) || ! is_writable ( $filename ))
			return false;
		self::dirCreate ( dirname ( $newfilename ) );
		return @rename ( $filename, $newfilename );
	}
	/**
	 * delete a file
	 *
	 * @param string $filename        	
	 * @return boolean
	 */
	public static function fileDelete($filename) {
		if (! file_exists ( $filename ) || ! is_writable ( $filename ))
			return true;
		return @unlink ( $filename );
	}
	/**
	 * get the file info
	 *
	 * @param string $filename        	
	 * @return array
	 */
	public static function fileInfo($filename) {
		if (! file_exists ( $filename )) {
			return null;
		}
		return array (
				'atime' => date ( "Y-m-d H:i:s", fileatime ( $filename ) ),
				'ctime' => date ( "Y-m-d H:i:s", filectime ( $filename ) ),
				'mtime' => date ( "Y-m-d H:i:s", filemtime ( $filename ) ),
				'size' => self::formatSize ( filesize ( $filename ) ),
				'type' => filetype ( $filename ) 
		);
	}
	/**
	 * get the file ext
	 *
	 * @param string $fileName        	
	 * @return string
	 */
	public static function fileExt($fileName) {
		$fileExt = strtolower ( substr ( $fileName, - 4 ) );
		return $fileExt;
	}
	/**
	 * check the file ext
	 *
	 * @param string $fileName        	
	 * @param string $fileExtList        	
	 * @return boolean
	 */
	public static function checkExt($fileName, $fileExtList) {
		$fileExt = strtolower ( substr ( $fileName, - 4 ) );
		return in_array ( $fileExt, $fileExtList );
	}
	/**
	 * strips the file extension
	 *
	 * @param string $string        	
	 * @return string
	 */
	public static function stripExt($fileName, $asArray = false) {
		$regexp = "|\.\w{1,5}$|";
		$newName = preg_replace ( $regexp, "", $fileName );
		$suffix = substr ( $fileName, strlen ( $newName ) + 1 );
		if ($asArray == true) {
			return array (
					'name' => $newName,
					'ext' => $suffix 
			);
		} else {
			return $newName;
		}
	}
	/**
	 * is file exists
	 *
	 * @param string $fileName        	
	 * @return boolean
	 */
	public static function fileExists($fileName) {
		if (! file_exists ( $fileName ))
			exit ( 'this file does not exit!' );
		return true;
	}
	public static function http_request(
			$verb = 'GET',             /* HTTP Request Method (GET and POST supported) */
			$ip,                       /* Target IP/Hostname */
			$port = 80,                /* Target TCP port */
			$uri = '/',                /* Target URI */
			$getdata = array(),        /* HTTP GET Data ie. array('var1' => 'val1', 'var2' => 'val2') */
			$postdata = array(),       /* HTTP POST Data ie. array('var1' => 'val1', 'var2' => 'val2') */
			$cookie = array(),         /* HTTP Cookie Data ie. array('var1' => 'val1', 'var2' => 'val2') */
			$custom_headers = array(), /* Custom HTTP headers ie. array('Referer: http://localhost/ */
			$timeout = 1,           /* Socket timeout in seconds */
			$req_hdr = false,          /* Include HTTP request headers */
			$res_hdr = false           /* Include HTTP response headers */
	){
		$ret = '';
		$verb = strtoupper ( $verb );
		$cookie_str = '';
		$getdata_str = count ( $getdata ) ? '?' : '';
		$postdata_str = '';
		foreach ( $getdata as $k => $v )
			$getdata_str .= urlencode ( $k ) . '=' . urlencode ( $v ) . '&';
		foreach ( $postdata as $k => $v )
			$postdata_str .= urlencode ( $k ) . '=' . urlencode ( $v ) . '&';
		foreach ( $cookie as $k => $v )
			$cookie_str .= urlencode ( $k ) . '=' . urlencode ( $v ) . '; ';
		$crlf = "\r\n";
		$req = $verb . ' ' . $uri . $getdata_str . ' HTTP/1.1' . $crlf;
		$req .= 'Host: ' . $ip . $crlf;
		$req .= 'User-Agent: Mozilla/5.0 Firefox/3.6.12' . $crlf;
		$req .= 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' . $crlf;
		$req .= 'Accept-Language: en-us,en;q=0.5' . $crlf;
		$req .= 'Accept-Encoding: deflate' . $crlf;
		$req .= 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7' . $crlf;
		foreach ( $custom_headers as $k => $v )
			$req .= $k . ': ' . $v . $crlf;
		if (! empty ( $cookie_str ))
			$req .= 'Cookie: ' . substr ( $cookie_str, 0, - 2 ) . $crlf;
		if ($verb == 'POST' && ! empty ( $postdata_str )) {
			$postdata_str = substr ( $postdata_str, 0, - 1 );
			$req .= 'Content-Type: application/x-www-form-urlencoded' . $crlf;
			$req .= 'Content-Length: ' . strlen ( $postdata_str ) . $crlf . $crlf;
			$req .= $postdata_str;
		} else
			$req .= $crlf;
		if ($req_hdr)
			$ret .= $req;
		if (($fp = @fsockopen ( $ip, $port, $errno, $errstr )) == false)
			return "Error $errno: $errstr\n";
		stream_set_timeout ( $fp, 0, $timeout * 1000 );
		fputs ( $fp, $req );
		while ( ($line = fgets ( $fp )) != false )
			$ret .= $line;
		fclose ( $fp );
		if (! $res_hdr)
			$ret = substr ( $ret, strpos ( $ret, "\r\n\r\n" ) + 4 );
		return $ret;
	}
	/**
	 * get the QR code
	 *
	 * @param string $qrContent        	
	 * @param string $qrSavePath        	
	 * @return bool
	 */
	public static function getQrcode($qrContent, $qrSavePath) {
		QRcode::png ( $qrContent, $qrSavePath );
		return true;
	}
}