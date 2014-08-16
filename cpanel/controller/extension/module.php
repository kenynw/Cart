<?php
class ControllerExtensionModule extends Controller {
	private $route = 'extension/module';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		
		$this->load->model ( 'setting/extension' );
		$extensions = $this->model_setting_extension->getInstalled ( 'module' );
		foreach ( $extensions as $key => $value ) {
			if (! file_exists ( DIR_APPLICATION . 'controller/module/' . $value . '.php' )) {
				$this->model_setting_extension->uninstall ( 'module', $value );
				unset ( $extensions [$key] );
			}
		}
		
		$this->data ['extensions'] = array ();
		$files = glob ( DIR_APPLICATION . 'controller/module/*.php' );
		if ($files) {
			foreach ( $files as $file ) {
				$extension = basename ( $file, '.php' );
				$this->loadText ( 'module/' . $extension );
				$action = array ();
				if (! in_array ( $extension, $extensions )) {
					$action [] = array (
							'text' => $this->language->get ( 'text_install' ),
							'href' => $this->url->link ( 'extension/module/install', 'token=' . $this->session->data ['token'] . '&extension=' . $extension, 'SSL' ) 
					);
				} else {
					$action [] = array (
							'text' => $this->language->get ( 'text_edit' ),
							'href' => $this->url->link ( 'module/' . $extension . '', 'token=' . $this->session->data ['token'], 'SSL' ) 
					);
					$action [] = array (
							'text' => $this->language->get ( 'text_uninstall' ),
							'href' => $this->url->link ( 'extension/module/uninstall', 'token=' . $this->session->data ['token'] . '&extension=' . $extension, 'SSL' ) 
					);
				}
				$this->data ['extensions'] [] = array (
						'name' => $this->language->get ( 'heading_title' ),
						'action' => $action 
				);
			}
		}
		$this->initNotice ();
		$this->initTpl ( $this->route );
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		
		$this->response->setOutput ( $this->render () );
	}
	public function install() {
		$this->loadText ();
		
		if (! $this->user->hasPermission ( 'modify', $this->route )) {
			$this->session->data ['error'] = $this->language->get ( 'error_permission' );
			$this->redirect ( $this->url->link ( 'extension/module', 'token=' . $this->session->data ['token'], 'SSL' ) );
		} else {
			$this->load->model ( 'setting/extension' );
			$this->model_setting_extension->install ( 'module', $this->request->get ['extension'] );
			$this->load->model ( 'user/user_group' );
			$this->model_user_user_group->addPermission ( $this->user->getId (), 'access', 'module/' . $this->request->get ['extension'] );
			$this->model_user_user_group->addPermission ( $this->user->getId (), 'modify', 'module/' . $this->request->get ['extension'] );
			require_once (DIR_APPLICATION . 'controller/module/' . $this->request->get ['extension'] . '.php');
			$class = 'ControllerModule' . str_replace ( '_', '', $this->request->get ['extension'] );
			$class = new $class ( $this->registry );
			if (method_exists ( $class, 'install' )) {
				$class->install ();
			}
			$this->redirect ( $this->url->link ( 'extension/module', 'token=' . $this->session->data ['token'], 'SSL' ) );
		}
	}
	public function uninstall() {
		$this->loadText ();
		
		if (! $this->user->hasPermission ( 'modify', $this->route )) {
			$this->session->data ['error'] = $this->language->get ( 'error_permission' );
			
			$this->redirect ( $this->url->link ( 'extension/module', 'token=' . $this->session->data ['token'], 'SSL' ) );
		} else {
			$this->load->model ( 'setting/extension' );
			$this->load->model ( 'setting/setting' );
			
			$this->model_setting_extension->uninstall ( 'module', $this->request->get ['extension'] );
			
			$this->model_setting_setting->deleteSetting ( $this->request->get ['extension'] );
			
			require_once (DIR_APPLICATION . 'controller/module/' . $this->request->get ['extension'] . '.php');
			
			$class = 'ControllerModule' . str_replace ( '_', '', $this->request->get ['extension'] );
			$class = new $class ( $this->registry );
			
			if (method_exists ( $class, 'uninstall' )) {
				$class->uninstall ();
			}
			
			$this->redirect ( $this->url->link ( 'extension/module', 'token=' . $this->session->data ['token'], 'SSL' ) );
		}
	}
}