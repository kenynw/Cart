<?php
class ControllerInfoCategory extends Controller {
	private $route = 'info/category';
	public function index() {
		$this->loadModel ( $this->route );
		$rs = new ModelInfoCategory ( $this->registry );
		$this->loadModel ( 'info/info' );
		$rsi = new ModelInfoInfo ( $this->registry );
		
		$cate = null;
		$list = array ();
		$item = null;
		if (isset ( $this->request->get ['category_id'] )) {
			$category_id = ( int ) $this->request->get ['category_id'];
			$cate = $rs->getcategory ( $category_id );
			$param = array (
					'sort' => 'sort_order',
					'order' => 'ASC',
					'start' => 0,
					'limit' => PHP_INT_MAX,
					'category_id' => $category_id 
			);
			$records = $rsi->getInfos ( $param );
			if ($records) {
				$item = $records [0];
				$item ['name'] = $records [0] ['title'];
				$item ['description'] = htmlspecialchars_decode ( $records [0] ['description'] );
			}
			foreach ( $records as $temp ) {
				$list [] = array (
						'information_id' => $temp ['information_id'],
						'name' => $temp ['title'],
						'description' => htmlspecialchars_decode ( $temp ['description'] ),
						'href' => $this->url->link ( 'info/info', 'information_id=' . $temp ['information_id'] ) 
				);
			}
		}
		
		$this->loadModel ( $this->route );
		$this->load->model ( 'info/info' );
		$rs = new ModelInfoCategory ( $this->registry );
		$rsi = new ModelInfoInfo ( $this->registry );
		
		$list = $rs->getCategories ( $param );
		$this->data ['menu_list'] = array ();
		foreach ( $list as $item ) {
			if ($item ['column'] > 0) {
				$param = array (
						'sort' => 'sort_order',
						'order' => 'ASC',
						'start' => 0,
						'limit' => PHP_INT_MAX,
						'category_id' => $item['category_id']
				);
				$infos = $rsi->getInfos ($param);
				$arr = array ();
				foreach ($infos as $tmp){
					$arr [] = array('name' => $tmp ['title'],'href' => $this->url->link ( 'info/info', 'information_id=' . $tmp ['information_id'] ));
				}
		
				$this->data['menu_list'][] = array(
						'name' => $item ['name'],
						'href' => $this->url->link ( 'info/category', 'category_id=' . $item ['category_id'] ),
						'item' => $arr
				);
			}
		}
		
		$this->data ['cate'] = $cate;
		$this->data ['list'] = $list;
		$this->data ['item'] = $item;
		
		$this->initTpl ( 'info/info' );
		$this->initTpl ( $this->route );
		$this->children = array (
				'common/footer',
				'common/header' 
		);
		$this->response->setOutput ( $this->render () );
	}
}
?>