<?php
class ControllerInfoInfo extends Controller {
	private $route = 'info/info';
	public function index() {
		$this->loadModel ( $this->route );
		$rs = new ModelInfoInfo ( $this->registry );
		
		$item = null;
		$list = array ();
		$cate = null;
		if (isset ( $this->request->get ['information_id'] )) {
			$information_id = ( int ) $this->request->get ['information_id'];
			$cate = $rs->getInfoCategory ( $information_id );
			$param = array (
					'sort' => 'sort_order',
					'order' => 'ASC',
					'start' => 0,
					'limit' => PHP_INT_MAX,
					'category_id' => $cate ['category_id'] 
			);
			$records = $rs->getInfos ( $param );
			foreach ( $records as $temp ) {
				$list [] = array (
						'information_id' => $temp ['information_id'],
						'name' => $temp ['title'],
						'description' => htmlspecialchars_decode($temp ['description']),
						'href' => $this->url->link ( 'info/info', 'information_id=' . $temp ['information_id'] ) 
				);
				if ($temp ['information_id'] == $information_id) {
					$item = array (
							'information_id' => $temp ['information_id'],
							'name' => $temp ['title'],
							'description' => htmlspecialchars_decode($temp ['description']),
							'href' => $this->url->link ( 'info/info', 'information_id=' . $temp ['information_id'] ) 
					);
				}
			}
		}
		$this->data ['cate'] = $cate;
		$this->data ['item'] = $item;
		$this->data ['list'] = $list;
		
		$this->initTpl ( $this->route );
		$this->children = array (
				'common/footer',
				'common/header' 
		);
		$this->response->setOutput ( $this->render () );
	}
}
?>