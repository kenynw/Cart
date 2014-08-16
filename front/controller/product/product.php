<?php
class ControllerProductProduct extends Controller {
	private $route = 'product/product';
	private function loadText($route = '') {
		if ($route != '') {
			$this->loadLang ( $route );
		} else {
			$this->loadLang ( $this->route );
		}
	}
	public function index() {
		$this->loadText ();
		$this->loadModel ( 'catalog/category' );
		$rsc = new ModelCatalogCategory ( $this->registry );
		$this->loadModel ( 'catalog/product' );
		$rsp = new ModelCatalogProduct ( $this->registry );
		$this->loadModel ( 'catalog/manufacturer' );
		$rsm = new ModelCatalogManufacturer ( $this->registry );
		
		if (isset ( $this->request->get ['manufacturer_id'] )) {
			$manufacturer_id = $this->request->get ['manufacturer_id'];
		} else {
			$manufacturer_id = '';
		}
		if (isset ( $this->request->get ['search'] )) {
			$search = $this->request->get ['search'];
		} else {
			$search = '';
		}
		if (isset ( $this->request->get ['tag'] )) {
			$tag = $this->request->get ['tag'];
		} else {
			$tag = '';
		}
		if (isset ( $this->request->get ['description'] )) {
			$description = $this->request->get ['description'];
		} else {
			$description = '';
		}
		if (isset ( $this->request->get ['category_id'] )) {
			$category_id = $this->request->get ['category_id'];
		} else {
			$category_id = '';
		}
		if (isset ( $this->request->get ['sub_category'] )) {
			$sub_category = $this->request->get ['sub_category'];
		} else {
			$sub_category = '';
		}		
		if (isset ( $this->request->get ['path'] )) {
			$path = $this->request->get ['path'];
		} else {
			$path = '';
		}
		if (isset ( $this->request->get ['filter'] )) {
			$filter = $this->request->get ['filter'];
		} else {
			$filter = '';
		}
		if (isset ( $this->request->get ['sort'] )) {
			$sort = $this->request->get ['sort'];
		} else {
			$sort = '';
		}
		if (isset ( $this->request->get ['order'] )) {
			$order = $this->request->get ['order'];
		} else {
			$order = '';
		}
		if (isset ( $this->request->get ['page'] )) {
			$page = $this->request->get ['page'];
		} else {
			$page = '';
		}
		if (isset ( $this->request->get ['limit'] )) {
			$limit = $this->request->get ['limit'];
		} else {
			$limit = '';
		}
		if ($limit != '') {
			$page_limit = $limit;
		} else {
			$page_limit = $this->config->get ( 'config_catalog_limit' );
		}
		
		$this->data ['breadcrumbs'] = array ();
		$this->data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'text_home' ),
				'href' => $this->url->link ( 'common/home' ),
				'separator' => false 
		);
		if (isset ( $this->request->get ['path'] )) {
			$path_str = '';
			$parts = explode ( '_', ( string ) $path );
			$cid = ( int ) array_pop ( $parts );
			foreach ( $parts as $path_id ) {
				if (! $path_str) {
					$path_str = $path_id;
				} else {
					$path_str .= '_' . $path_id;
				}
				$category_info = $rsc->getcategory ( $path_id );
				if ($category_info) {
					$this->data ['breadcrumbs'] [] = array (
							'text' => $category_info ['name'],
							'href' => $this->url->link ( 'product/category', 'path=' . $path_str ),
							'separator' => $this->language->get ( 'text_separator' ) 
					);
				}
			}
			// Set the last category breadcrumb
			$category_info = $rsc->getCategory ( $cid );
			if ($category_info) {
				$url = $this->initUrl ( array (
						'sort' => $sort,
						'order' => $order,
						'page' => $page,
						'limit' => $limit 
				) );
				$this->data ['breadcrumbs'] [] = array (
						'text' => $category_info ['name'],
						'href' => $this->url->link ( 'product/category', 'path=' . $path . $url ),
						'separator' => $this->language->get ( 'text_separator' ) 
				);
			}
		}
		
		if (isset ( $this->request->get ['manufacturer_id'] )) {
			$this->data ['breadcrumbs'] [] = array (
					'text' => $this->language->get ( 'text_brand' ),
					'href' => $this->url->link ( 'product/manufacturer' ),
					'separator' => $this->language->get ( 'text_separator' ) 
			);
			$url = $this->initUrl ( array (
					'sort' => $sort,
					'order' => $order,
					'page' => $page,
					'limit' => $limit 
			) );
			$manufacturer_info = $rsm->getmanufacturer ( $manufacturer_id );
			if ($manufacturer_info) {
				$this->data ['breadcrumbs'] [] = array (
						'text' => $manufacturer_info ['name'],
						'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $manufacturer_id . $url ),
						'separator' => $this->language->get ( 'text_separator' ) 
				);
			}
		}
		if (isset ( $this->request->get ['search'] ) || isset ( $this->request->get ['tag'] )) {
			$url = $this->initUrl ( array (
					'search' => $search,
					'tag' => $tag,
					'description' => $description,
					'category_id' => $category_id,
					'sub_category' => $sub_category,
					'sort' => $sort,
					'order' => $order,
					'page' => $page,
					'limit' => $limit 
			) );
			$this->data ['breadcrumbs'] [] = array (
					'text' => $this->language->get ( 'text_search' ),
					'href' => $this->url->link ( 'product/search', $url ),
					'separator' => $this->language->get ( 'text_separator' ) 
			);
		}
		if (isset ( $this->request->get ['product_id'] )) {
			$product_id = ( int ) $this->request->get ['product_id'];
		} else {
			$product_id = 0;
		}
		$product_info = $rsp->getProduct ( $product_id );
		if ($product_info) {
			$this->data['heading_title'] = $product_info['name'];
			$url = $this->initUrl ( array (
					'path' => $path,
					'filter' => $filter,
					'manufacturer_id' => $manufacturer_id,
					'search' => $search,
					'tag' => $tag,
					'description' => $description,
					'category_id' => $category_id,
					'sub_category' => $sub_category,
					'sort' => $sort,
					'order' => $order,
					'page' => $page,
					'limit' => $limit 
			) );
			$this->data ['breadcrumbs'] [] = array (
					'text' => $product_info ['name'],
					'href' => $this->url->link ( 'product/product', $url . '&product_id=' . $this->request->get ['product_id'] ),
					'separator' => $this->language->get ( 'text_separator' ) 
			);
			
			$this->loadModel ( 'catalog/review' );
			$rsv = new ModelCatalogReview ( $this->registry );
			$this->data ['tab_review'] = sprintf ( $this->language->get ( 'tab_review' ), $product_info ['reviews'] );
			$this->data ['product_id'] = $this->request->get ['product_id'];
			$this->data ['manufacturer'] = $product_info ['manufacturer'];
			$this->data ['manufacturers'] = $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $product_info ['manufacturer_id'] );
			$this->data ['model'] = $product_info ['model'];
			$this->data ['reward'] = $product_info ['reward'];
			$this->data ['points'] = $product_info ['points'];
			if ($product_info ['quantity'] <= 0) {
				$this->data ['stock'] = $product_info ['stock_status'];
			} elseif ($this->config->get ( 'config_stock_display' )) {
				$this->data ['stock'] = $product_info ['quantity'];
			} else {
				$this->data ['stock'] = $this->language->get ( 'text_instock' );
			}
			
			$this->loadModel ( 'tool/image' );
			$rsi = new ModelToolImage ( $this->registry );
			if ($product_info ['image']) {
				$this->data ['popup'] = $rsi->resize ( $product_info ['image'], $this->config->get ( 'config_image_popup_width' ), $this->config->get ( 'config_image_popup_height' ) );
			} else {
				$this->data ['popup'] = '';
			}
			
			if ($product_info ['image']) {
				$this->data ['thumb'] = $rsi->resize ( $product_info ['image'], $this->config->get ( 'config_image_thumb_width' ), $this->config->get ( 'config_image_thumb_height' ) );
			} else {
				$this->data ['thumb'] = '';
			}
			
			$this->data ['images'] = array ();
			
			$results = $rsp->getProductImages ( $this->request->get ['product_id'] );
			
			foreach ( $results as $result ) {
				$this->data ['images'] [] = array (
						'popup' => $rsi->resize ( $result ['image'], $this->config->get ( 'config_image_popup_width' ), $this->config->get ( 'config_image_popup_height' ) ),
						'thumb' => $rsi->resize ( $result ['image'], $this->config->get ( 'config_image_additional_width' ), $this->config->get ( 'config_image_additional_height' ) ) 
				);
			}
			
			if (($this->config->get ( 'config_customer_price' ) && $this->customer->isLogged ()) || ! $this->config->get ( 'config_customer_price' )) {
				$this->data ['price'] = $this->currency->format ( $this->tax->calculate ( $product_info ['price'], $product_info ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
			} else {
				$this->data ['price'] = false;
			}
			
			if (( float ) $product_info ['special']) {
				$this->data ['special'] = $this->currency->format ( $this->tax->calculate ( $product_info ['special'], $product_info ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
			} else {
				$this->data ['special'] = false;
			}
			
			if ($this->config->get ( 'config_tax' )) {
				$this->data ['tax'] = $this->currency->format ( ( float ) $product_info ['special'] ? $product_info ['special'] : $product_info ['price'] );
			} else {
				$this->data ['tax'] = false;
			}
			
			$discounts = $rsp->getProductDiscounts ( $this->request->get ['product_id'] );
			
			$this->data ['discounts'] = array ();
			
			foreach ( $discounts as $discount ) {
				$this->data ['discounts'] [] = array (
						'quantity' => $discount ['quantity'],
						'price' => $this->currency->format ( $this->tax->calculate ( $discount ['price'], $product_info ['tax_class_id'], $this->config->get ( 'config_tax' ) ) ) 
				);
			}
			
			$this->data ['options'] = array ();
			$this->loadModel('tool/image');
			$rsa = new ModelToolImage($this->registry);
			
			foreach ( $rsp->getProductOptions ( $this->request->get ['product_id'] ) as $option ) {
				if ($option ['type'] == 'select' || $option ['type'] == 'radio' || $option ['type'] == 'checkbox' || $option ['type'] == 'image') {
					$option_value_data = array ();
					
					foreach ( $option ['option_value'] as $option_value ) {
						if (! $option_value ['subtract'] || ($option_value ['quantity'] > 0)) {
							if ((($this->config->get ( 'config_customer_price' ) && $this->customer->isLogged ()) || ! $this->config->get ( 'config_customer_price' )) && ( float ) $option_value ['price']) {
								$price = $this->currency->format ( $this->tax->calculate ( $option_value ['price'], $product_info ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
							} else {
								$price = false;
							}
							$option_value_data [] = array (
									'product_option_value_id' => $option_value ['product_option_value_id'],
									'option_value_id' => $option_value ['option_value_id'],
									'name' => $option_value ['name'],
									'image' => $rsa->resize ( $option_value ['image'], 50, 50 ),
									'price' => $price,
									'price_prefix' => $option_value ['price_prefix'] 
							);
						}
					}
					$this->data ['options'] [] = array (
							'product_option_id' => $option ['product_option_id'],
							'option_id' => $option ['option_id'],
							'name' => $option ['name'],
							'type' => $option ['type'],
							'option_value' => $option_value_data,
							'required' => $option ['required'] 
					);
				} elseif ($option ['type'] == 'text' || $option ['type'] == 'textarea' || $option ['type'] == 'file' || $option ['type'] == 'date' || $option ['type'] == 'datetime' || $option ['type'] == 'time') {
					$this->data ['options'] [] = array (
							'product_option_id' => $option ['product_option_id'],
							'option_id' => $option ['option_id'],
							'name' => $option ['name'],
							'type' => $option ['type'],
							'option_value' => $option ['option_value'],
							'required' => $option ['required'] 
					);
				}
			}
			
			if ($product_info ['minimum']) {
				$this->data ['minimum'] = $product_info ['minimum'];
			} else {
				$this->data ['minimum'] = 1;
			}
			
			$this->data ['review_status'] = $this->config->get ( 'config_review_status' );
			$this->data ['reviews'] = sprintf ( $this->language->get ( 'text_reviews' ), ( int ) $product_info ['reviews'] );
			$this->data ['rating'] = ( int ) $product_info ['rating'];
			$this->data ['description'] = html_entity_decode ( $product_info ['description'], ENT_QUOTES, 'UTF-8' );
			$this->data ['attribute_groups'] = $rsp->getProductAttributes ( $this->request->get ['product_id'] );
			
			$this->data ['products'] = array ();
			
			$results = $rsp->getProductRelated ( $this->request->get ['product_id'] );
			
			foreach ( $results as $result ) {
				if ($result ['image']) {
					$image = $rsi->resize ( $result ['image'], $this->config->get ( 'config_image_related_width' ), $this->config->get ( 'config_image_related_height' ) );
				} else {
					$image = false;
				}
				
				if (($this->config->get ( 'config_customer_price' ) && $this->customer->isLogged ()) || ! $this->config->get ( 'config_customer_price' )) {
					$price = $this->currency->format ( $this->tax->calculate ( $result ['price'], $result ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
				} else {
					$price = false;
				}
				
				if (( float ) $result ['special']) {
					$special = $this->currency->format ( $this->tax->calculate ( $result ['special'], $result ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
				} else {
					$special = false;
				}
				
				if ($this->config->get ( 'config_review_status' )) {
					$rating = ( int ) $result ['rating'];
				} else {
					$rating = false;
				}
				
				$this->data ['products'] [] = array (
						'product_id' => $result ['product_id'],
						'thumb' => $image,
						'name' => $result ['name'],
						'price' => $price,
						'special' => $special,
						'rating' => $rating,
						'reviews' => sprintf ( $this->language->get ( 'text_reviews' ), ( int ) $result ['reviews'] ),
						'href' => $this->url->link ( 'product/product', 'product_id=' . $result ['product_id'] ) 
				);
			}
			
			$this->data ['tags'] = array ();
			
			if ($product_info ['tag']) {
				$tags = explode ( ',', $product_info ['tag'] );
				
				foreach ( $tags as $item ) {
					$this->data ['tags'] [] = array (
							'tag' => trim ( $item ),
							'href' => $this->url->link ( 'product/search', 'tag=' . trim ( $item ) ) 
					);
				}
			}
			
			$this->data ['text_payment_profile'] = $this->language->get ( 'text_payment_profile' );
			$this->data ['profiles'] = $rsp->getProfiles ( $product_info ['product_id'] );
			
			$rsp->updateViewed ( $this->request->get ['product_id'] );
			
			$this->initTpl ( $this->route );
			$this->children = array (
					'common/column_left',
					'common/column_right',
					'common/content_top',
					'common/content_bottom',
					'common/footer',
					'common/header' 
			);
			$this->response->setOutput ( $this->render () );
		} else {
			$url = $this->initUrl ( array (
					'path' => $path,
					'filter' => $filter,
					'manufacturer_id' => $manufacturer_id,
					'search' => $search,
					'tag' => $tag,
					'description' => $description,
					'category_id' => $category_id,
					'sub_category' => $sub_category,
					'sort' => $sort,
					'order' => $order,
					'page' => $page,
					'limit' => $limit 
			) );
			$this->data ['breadcrumbs'] [] = array (
					'text' => $this->language->get ( 'text_error' ),
					'href' => $this->url->link ( 'product/product', $url . '&product_id=' . $product_id ),
					'separator' => $this->language->get ( 'text_separator' ) 
			);
			
			$this->data ['heading_title'] = $this->language->get ( 'text_error' );
			$this->data ['continue'] = $this->url->link ( 'common/home' );
			
			$this->response->addHeader ( $this->request->server ['SERVER_PROTOCOL'] . '/1.1 404 Not Found' );
			$this->initTpl ( 'error/not_found' );
			$this->children = array (
					'common/column_left',
					'common/column_right',
					'common/content_top',
					'common/content_bottom',
					'common/footer',
					'common/header' 
			);
			$this->response->setOutput ( $this->render () );
		}
	}
	public function review() {
		$this->loadText ();
		$this->loadModel ( 'catalog/review' );
		$rsv = new ModelCatalogReview ( $this->registry );
		
		if (isset ( $this->request->get ['page'] )) {
			$page = $this->request->get ['page'];
		} else {
			$page = 1;
		}
		$this->data ['reviews'] = array ();
		$review_total = $rsv->getTotalReviewsByProductId ( $this->request->get ['product_id'] );
		$results = $rsv->getReviewsByProductId ( $this->request->get ['product_id'], ($page - 1) * 5, 5 );
		
		foreach ( $results as $result ) {
			$this->data ['reviews'] [] = array (
					'author' => $result ['author'],
					'text' => $result ['text'],
					'rating' => ( int ) $result ['rating'],
					'reviews' => sprintf ( $this->language->get ( 'text_reviews' ), ( int ) $review_total ),
					'date_added' => date ( $this->language->get ( 'date_format_short' ), strtotime ( $result ['date_added'] ) ) 
			);
		}
		
		$pagination = new Pagination ();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->text = $this->language->get ( 'text_pagination' );
		$pagination->url = $this->url->link ( 'product/product/review', 'product_id=' . $this->request->get ['product_id'] . '&page={page}' );
		
		$this->data ['pagination'] = $pagination->render ();
		$this->initTpl ( 'product/review' );
		$this->response->setOutput ( $this->render () );
	}
	public function getRecurringDescription() {
		$this->loadText ();
		$this->loadModel ( 'catalog/product' );
		$rsp = new ModelCatalogProduct ( $this->registry );
		
		if (isset ( $this->request->post ['product_id'] )) {
			$product_id = $this->request->post ['product_id'];
		} else {
			$product_id = 0;
		}
		
		if (isset ( $this->request->post ['profile_id'] )) {
			$profile_id = $this->request->post ['profile_id'];
		} else {
			$profile_id = 0;
		}
		
		if (isset ( $this->request->post ['quantity'] )) {
			$quantity = $this->request->post ['quantity'];
		} else {
			$quantity = 1;
		}
		
		$product_info = $rsp->getProduct ( $product_id );
		$profile_info = $rsp->getProfile ( $product_id, $profile_id );
		$json = array ();
		if ($product_info && $profile_info) {
			if (! $json) {
				$frequencies = array (
						'day' => $this->language->get ( 'text_day' ),
						'week' => $this->language->get ( 'text_week' ),
						'semi_month' => $this->language->get ( 'text_semi_month' ),
						'month' => $this->language->get ( 'text_month' ),
						'year' => $this->language->get ( 'text_year' ) 
				);
				if ($profile_info ['trial_status'] == 1) {
					$price = $this->currency->format ( $this->tax->calculate ( $profile_info ['trial_price'] * $quantity, $product_info ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
					$trial_text = sprintf ( $this->language->get ( 'text_trial_description' ), $price, $profile_info ['trial_cycle'], $frequencies [$profile_info ['trial_frequency']], $profile_info ['trial_duration'] ) . ' ';
				} else {
					$trial_text = '';
				}
				$price = $this->currency->format ( $this->tax->calculate ( $profile_info ['price'] * $quantity, $product_info ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
				
				if ($profile_info ['duration']) {
					$text = $trial_text . sprintf ( $this->language->get ( 'text_payment_description' ), $price, $profile_info ['cycle'], $frequencies [$profile_info ['frequency']], $profile_info ['duration'] );
				} else {
					$text = $trial_text . sprintf ( $this->language->get ( 'text_payment_until_canceled_description' ), $price, $profile_info ['cycle'], $frequencies [$profile_info ['frequency']], $profile_info ['duration'] );
				}
				$json ['success'] = $text;
			}
		}
		$this->response->setOutput ( json_encode ( $json ) );
	}
	public function write() {
		$this->loadText ();
		$this->loadModel ( 'catalog/review' );
		$rsv = new ModelCatalogReview ( $this->registry );
		$json = array ();
		if ($this->request->server ['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen ( $this->request->post ['name'] ) < 3) || (utf8_strlen ( $this->request->post ['name'] ) > 25)) {
				$json ['error'] = $this->language->get ( 'error_name' );
			}
			if ((utf8_strlen ( $this->request->post ['text'] ) < 25) || (utf8_strlen ( $this->request->post ['text'] ) > 1000)) {
				$json ['error'] = $this->language->get ( 'error_text' );
			}
			if (empty ( $this->request->post ['rating'] )) {
				$json ['error'] = $this->language->get ( 'error_rating' );
			}
			if (empty ( $this->session->data ['captcha'] ) || ($this->session->data ['captcha'] != $this->request->post ['captcha'])) {
				$json ['error'] = $this->language->get ( 'error_captcha' );
			}
			if (! isset ( $json ['error'] )) {
				$rsv->addReview ( $this->request->get ['product_id'], $this->request->post );
				$json ['success'] = $this->language->get ( 'text_success' );
			}
		}
		$this->response->setOutput ( json_encode ( $json ) );
	}
	public function captcha() {
		$this->load->library ( 'captcha' );
		$captcha = new Captcha ();
		$this->session->data ['captcha'] = $captcha->getCode ();
		$captcha->showImage ();
	}
	public function upload() {
		$this->loadText ();
		$json = array ();
		if (! empty ( $this->request->files ['file'] ['name'] )) {
			$filename = basename ( preg_replace ( '/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode ( $this->request->files ['file'] ['name'], ENT_QUOTES, 'UTF-8' ) ) );
			if ((utf8_strlen ( $filename ) < 3) || (utf8_strlen ( $filename ) > 64)) {
				$json ['error'] = $this->language->get ( 'error_filename' );
			}
			// Allowed file extension types
			$allowed = array ();
			$filetypes = explode ( "\n", $this->config->get ( 'config_file_extension_allowed' ) );
			foreach ( $filetypes as $filetype ) {
				$allowed [] = trim ( $filetype );
			}
			if (! in_array ( substr ( strrchr ( $filename, '.' ), 1 ), $allowed )) {
				$json ['error'] = $this->language->get ( 'error_filetype' );
			}
			// Allowed file mime types
			$allowed = array ();
			$filetypes = explode ( "\n", $this->config->get ( 'config_file_mime_allowed' ) );
			foreach ( $filetypes as $filetype ) {
				$allowed [] = trim ( $filetype );
			}
			if (! in_array ( $this->request->files ['file'] ['type'], $allowed )) {
				$json ['error'] = $this->language->get ( 'error_filetype' );
			}
			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents ( $this->request->files ['file'] ['tmp_name'] );
			if (preg_match ( '/\<\?php/i', $content )) {
				$json ['error'] = $this->language->get ( 'error_filetype' );
			}
			if ($this->request->files ['file'] ['error'] != UPLOAD_ERR_OK) {
				$json ['error'] = $this->language->get ( 'error_upload_' . $this->request->files ['file'] ['error'] );
			}
		} else {
			$json ['error'] = $this->language->get ( 'error_upload' );
		}
		if (! $json && is_uploaded_file ( $this->request->files ['file'] ['tmp_name'] ) && file_exists ( $this->request->files ['file'] ['tmp_name'] )) {
			$file = basename ( $filename ) . '.' . md5 ( mt_rand () );
			// Hide the uploaded file name so people can not link to it directly.
			$json ['file'] = $this->encryption->encrypt ( $file );
			move_uploaded_file ( $this->request->files ['file'] ['tmp_name'], DIR_DOWNLOAD . $file );
			$json ['success'] = $this->language->get ( 'text_upload' );
		}
		$this->response->setOutput ( json_encode ( $json ) );
	}
}
?>