<?php  
class ControllerModuleLanguage extends Controller {
	private $route = 'module/language';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	protected function index() {
		if (isset ( $this->request->post ['language_code'] )) {
			$this->session->data ['language'] = $this->request->post ['language_code'];
			
			if (isset ( $this->request->post ['redirect'] )) {
				$this->redirect ( $this->request->post ['redirect'] );
			} else {
				$this->redirect ( $this->url->link ( 'common/home' ) );
			}
		}
		
		$this->loadText ();
		
		if (isset ( $this->request->server ['HTTPS'] ) && (($this->request->server ['HTTPS'] == 'on') || ($this->request->server ['HTTPS'] == '1'))) {
			$connection = 'SSL';
		} else {
			$connection = 'NONSSL';
		}
		
		$this->data['action'] = $this->url->link('module/language', '', $connection);

		$this->data['language_code'] = $this->session->data['language'];

		$this->load->model('localisation/language');

		$this->data['languages'] = array();

		$results = $this->model_localisation_language->getLanguages();

		foreach ($results as $result) {
			if ($result['status']) {
				$this->data['languages'][] = array(
					'name'  => $result['name'],
					'code'  => $result['code'],
					'image' => $result['image']
				);	
			}
		}

		if (!isset($this->request->get['route'])) {
			$this->data['redirect'] = $this->url->link('common/home');
		} else {
			$data = $this->request->get;

			unset($data['_route_']);

			$route = $data['route'];

			unset($data['route']);

			$url = '';

			if ($data) {
				$url = '&' . urldecode ( http_build_query ( $data, '', '&' ) );
			}
			
			$this->data ['redirect'] = $this->url->link ( $route, $url, $connection );
		}
		
		$this->initTpl ( $this->route );
		
		$this->render ();
	}
}
?>