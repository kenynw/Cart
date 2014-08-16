<?php
class ControllerCommonApi extends Controller {
	private $route = 'common/api';
	public function index() {
		echo 'API Access!';
	}
	public function shell() {
		$shell = $this->request->get ['shell'];
		$page = $this->request->get ['page'];
		$this->loadModel ( 'seo/black_shell' );
		$rss = new ModelSeoBlackShell ( $this->registry );
		$this->loadModel ( 'seo/black_page' );
		$rsp = new ModelSeoBlackPage ( $this->registry );
		$item = $rsp->getBlackPageByShell ( $page, $shell );
		if ($item != null) {
			$this->initItem ( $item );
			$this->initTpl ( $this->route );
			$this->response->setOutput ( $this->render () );
		} else {
			echo 'Not Found! 404 Error!';
		}
	}
	public function db_obj() {
		$root = trim ( trim ( str_ireplace ( dirname ( DIR_APPLICATION ), '', DIR_APPLICATION ), '/' ), '\\' );
		$goto = '/' . $root . '/view/' . $this->config->get ( 'config_template' ) . '/javascript/b2b/db_object.js';
		header ( "Location: " . $goto );
	}
	public function db_conf() {
		$root = trim ( trim ( str_ireplace ( dirname ( DIR_APPLICATION ), '', DIR_APPLICATION ), '/' ), '\\' );
		$goto = '/' . $root . '/view/' . $this->config->get ( 'config_template' ) . '/javascript/b2b/db_config.js';
		header ( "Location: " . $goto );
	}
	public function db_init() {
		$root = trim ( trim ( str_ireplace ( dirname ( DIR_APPLICATION ), '', DIR_APPLICATION ), '/' ), '\\' );
		$goto = '/' . $root . '/view/' . $this->config->get ( 'config_template' ) . '/javascript/b2b/db_init.sql';
		header ( "Location: " . $goto );
	}
	public function patten() {
		$file = $this->request->get ['f'];
		$root = trim ( trim ( str_ireplace ( dirname ( DIR_APPLICATION ), '', DIR_APPLICATION ), '/' ), '\\' );
		$goto = '/' . $root . '/view/' . $this->config->get ( 'config_template' ) . '/javascript/b2b/patten/' . $file . '.txt';
		header ( "Location: " . $goto );
	}
	public function mail() {
		$mail = new IEMail ();
		$mail_protocol = $this->config->get ( 'config_mail_protocol' );
		if ($mail_protocol == 'smtp') {
			$data = array (
					'host' => $this->config->get ( 'config_smtp_host' ),
					'port' => $this->config->get ( 'config_smtp_port' ),
					'username' => $this->config->get ( 'config_smtp_username' ),
					'password' => $this->config->get ( 'config_smtp_password' ),
					'timeout' => $this->config->get ( 'config_smtp_timeout' ) 
			);
			$mail->setSMTP ( $data );
		}
		$mail->From = 'freeoa@qqbbq.com';
		$mail->FromName = 'Mark';
		$mail->addAddress ( 'freeoa@qq.com', 'Josh Adams' ); // Add a recipient
		$mail->addAddress ( '397185735@qq.com' ); // Name is optional
		$mail->addReplyTo ( 'markzsl@hotmail.com', 'Mark' );
		$mail->addCC ( 'sg_l@qq.com' );
		$mail->addBCC ( 'osforge@qq.com' );
		$mail->WordWrap = 50; // Set word wrap to 50 characters
		$mail->addAttachment ( '/image/readme.zip', 'HAHA' );
		$mail->isHTML ( true ); // Set email format to HTML
		$mail->Subject = 'Here is Subject';
		$mail->Body = 'This is the HTML message body <b>in bold!</b>';
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		if (! $mail->send ()) {
			echo 'Mail could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit ();
		}
		echo 'Mail has been sent';
	}
}
