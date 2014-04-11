<?php 
class ControllerFeedDoofinder extends Controller {
	public function index() {
        if(isset($this->request->get['language']) && $this->request->get['language'] != $this->session->data['language']){
            $lang_code = $this->request->get['language'];
            $this->load->model('localisation/language');
            $languages = $this->model_localisation_language->getLanguages();
            if(in_array($lang_code, array_keys($languages))){
                $this->session->data['language'] = $lang_code;
                $this->config->set('config_language_id', $languages[$lang_code]['language_id']);
                $this->config->set('config_language', $languages[$lang_code]['code']);
            }
            

        }
		if ($this->config->get('doofinder_status')) { 
			$output  = '<?xml version="1.0" encoding="UTF-8" ?>';
			$output .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0" xmlns:d="http://www.doofinder.com/ns/1.0">';
			$output .= '<channel>';
			$output .= '<title><![CDATA[' . $this->config->get('config_name') . ']]></title>'; 
			$output .= '<description><![CDATA[' . $this->config->get('config_meta_description') . ']]></description>';
			$output .= '<link>' . HTTP_SERVER . '</link>';

			$this->load->model('catalog/category');

			$this->load->model('catalog/product');

			$this->load->model('tool/image');

			$products = $this->model_catalog_product->getProducts();

            // CUSTOM FEED OPTIONS
            $display_prices = $this->config->get('doofinder_display_prices') !== null ? 
                $this->config->get('doofinder_display_prices') : 1;
            $prices_with_taxes = $this->config->get('doofinder_prices_with_taxes') !== null ? 
                $this->config->get('doofinder_prices_with_taxes') : 1;
            $full_category_path = $this->config->get('doofinder_full_category_path') !== null ?
                $this->config->get('doofinder_full_category_path') : 1 ;
            $image_size = $this->config->get('doofinder_image_size') != null ?
                $this->config->get('doofinder_image_size') : 110 ;

			foreach ($products as $product) {
				if ($product['description']) {
					$output .= '<item>';
					$output .= '<title><![CDATA[' . $product['name'] . ']]></title>';
					$output .= '<link>' . $this->url->link('product/product', 'product_id=' . $product['product_id']) . '</link>';
					$output .= '<description><![CDATA[' . $product['description'] . ']]></description>';
					$output .= '<g:brand><![CDATA[' . $product['manufacturer'] . ']]></g:brand>';
					$output .= '<g:condition>new</g:condition>';
					$output .= '<g:id>' . $product['product_id'] . '</g:id>';

					if ($product['image']) {
						$output .= '<g:image_link>' . $this->model_tool_image->resize($product['image'], $image_size, $image_size) . '</g:image_link>';
					} else {
						$output .= '<g:image_link>' . $this->model_tool_image->resize('no_image.jpg', $image_size, $image_size) . '</g:image_link>';
					}
                    // MPN FIELD
                    $doofinder_mpn_field = $this->config->get('doofinder_mpn_field') ? $this->config->get('doofinder_mpn_field'): 'mpn';
					$output .= '<g:mpn><![CDATA[' . $product[$doofinder_mpn_field] . ']]></g:mpn>';

					$currencies = array(
						'USD', 
						'EUR', 
						'GBP'
					);

					if (in_array($this->currency->getCode(), $currencies)) {
						$currency_code = $this->currency->getCode();
						$currency_value = $this->currency->getValue();
					} else {
						$currency_code = 'USD';
						$currency_value = $this->currency->getValue('USD');
					}
                    if ($display_prices){
                        // SALE_PRICE
                        if((float)$product['special']){
                            $price = $prices_with_taxes ? $this->tax->calculate($product['special'], $product['tax_class_id']) : (float)$product['special'];
                            $output .= '<g:sale_price><![CDATA['.$this->currency->format($price, $currency_code, $currency_value, false).']]></g:sale_price>';
                        }
                        // REGULAR PRICE
                        $price = $prices_with_taxes ? $this->tax->calculate($product['price'], $product['tax_class_id']) : (float)$product['price'];
                        $output .= '<g:price><![CDATA['.$this->currency->format($price, $currency_code, $currency_value, false).']]></g:price>';
                                                                            
                    }

					$categories = $this->model_catalog_product->getCategories($product['product_id']);

					foreach ($categories as $category) {
						$path = $this->getPath($category['category_id']);

						if ($path) {
							$string = '';

                            $paths = explode('_', $path);

                            if(!$full_category_path){
                                $paths = [array_pop($paths)];
                            }

							foreach ($paths as $path_id) {
								$category_info = $this->model_catalog_category->getCategory($path_id);

								if ($category_info) {
									if (!$string) {
										$string = $category_info['name'];
									} else {
										$string .= ' > ' . $category_info['name'];
									}
								}
							}

							$output .= '<g:product_type><![CDATA[' . $string . ']]></g:product_type>';
						}
					}

					$output .= '<g:quantity>' . $product['quantity'] . '</g:quantity>';
					$output .= '<g:upc>' . $product['upc'] . '</g:upc>'; 
					$output .= '<g:weight><![CDATA[' . $this->weight->format($product['weight'], $product['weight_class_id']) . ']]></g:weight>';
					$output .= '<g:availability>' . ($product['quantity'] ? 'in stock' : 'out of stock') . '</g:availability>';
					$output .= '</item>';
				}
			}

			$output .= '</channel>'; 
			$output .= '</rss>';	

			$this->response->addHeader('Content-Type: application/xml');
			$this->response->setOutput($output);
		}
	}

	protected function getPath($parent_id, $current_path = '') {
		$category_info = $this->model_catalog_category->getCategory($parent_id);

		if ($category_info) {
			if (!$current_path) {
				$new_path = $category_info['category_id'];
			} else {
				$new_path = $category_info['category_id'] . '_' . $current_path;
			}	

			$path = $this->getPath($category_info['parent_id'], $new_path);

			if ($path) {
				return $path;
			} else {
				return $new_path;
			}
		}
	}		
}
?>