<?php
class ControllerCommonLogin extends Controller {
	private $route = 'common/login';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		
		if ($this->user->isLogged () && isset ( $this->request->get ['token'] ) && ($this->request->get ['token'] == $this->session->data ['token'])) {
			$this->redirect ( $this->url->link ( 'common/home', 'token=' . $this->session->data ['token'], 'SSL' ) );
		}
		
		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validate ()) {
			$this->session->data ['token'] = md5 ( mt_rand () );
			
			if (isset ( $this->request->post ['redirect'] ) && (strpos ( $this->request->post ['redirect'], HTTP_SERVER ) === 0 || strpos ( $this->request->post ['redirect'], HTTPS_SERVER ) === 0)) {
				$this->redirect ( $this->request->post ['redirect'] . '&token=' . $this->session->data ['token'] );
			} else {
				$this->redirect ( $this->url->link ( 'common/main', 'token=' . $this->session->data ['token'], 'SSL' ) );
			}
		}
		
		if (isset ( $this->request->post ['username'] )) {
			$this->data ['username'] = $this->request->post ['username'];
		} else {
			$this->data ['username'] = '';
		}
		if (isset ( $this->request->post ['userpass'] )) {
			$this->data ['userpass'] = $this->request->post ['userpass'];
		} else {
			$this->data ['userpass'] = '';
		}
		
		if (! isset ( $this->error ['warning'] ) && (isset ( $this->session->data ['token'] ) && ! isset ( $this->request->get ['token'] )) || ((isset ( $this->request->get ['token'] ) && (isset ( $this->session->data ['token'] ) && ($this->request->get ['token'] != $this->session->data ['token']))))) {
			$this->error ['warning'] = $this->language->get ( 'error_token' ) . '<br />';
		}
		if (isset ( $this->error ['warning'] ) && $this->error ['warning'] != '') {
			$this->data ['warning'] = $this->error ['warning'];
		} else {
			$this->data ['warning'] = '';
		}
		
		$this->data ['action'] = $this->url->link ( 'common/login', '', 'SSL' );
		
		if (isset ( $this->request->get ['route'] )) {
			$route = $this->request->get ['route'];
			
			unset ( $this->request->get ['route'] );
			
			if (isset ( $this->request->get ['token'] )) {
				unset ( $this->request->get ['token'] );
			}
			
			$url = '';
			
			if ($this->request->get) {
				$url .= http_build_query ( $this->request->get );
			}
			
			$this->data ['redirect'] = $this->url->link ( $route, $url, 'SSL' );
		} else {
			$this->data ['redirect'] = '';
		}
		
		if ($this->config->get ( 'config_password' )) {
			$this->data ['forgotten'] = $this->url->link ( 'common/forgotten', '', 'SSL' );
		} else {
			$this->data ['forgotten'] = '';
		}
		
		$this->initNotice ();
		$this->initTpl ( $this->route );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		
		$this->response->setOutput ( $this->render () );
	}
	protected function validate() {
		if (empty ( $this->session->data ['captcha'] ) || ($this->session->data ['captcha'] != $this->request->post ['captcha'])) {
			$this->error ['warning'] = $this->language->get ( 'error_captcha' ) . '<br />';
		} else {
			$this->error ['warning'] = '';
		}
		if (! isset ( $this->request->post ['username'] ) || ! isset ( $this->request->post ['userpass'] ) || ! $this->user->login ( $this->request->post ['username'], $this->request->post ['userpass'] )) {
			$this->error ['warning'] .= $this->language->get ( 'error_login' ) . '<br />';
		}
		if ($this->error ['warning'] == '') {
			return true;
		} else {
			return false;
		}
	}
	public function captcha() {
		$this->load->library ( 'captcha' );
		$captcha = new Captcha ();
		$this->session->data ['captcha'] = $captcha->getCode ();
		$captcha->showImage ();
	}
}
?>