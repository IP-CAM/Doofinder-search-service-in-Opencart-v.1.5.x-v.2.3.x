<?php 
class ControllerFeedDoofinder extends Controller {
	private $error = array(); 

    public function install(){
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('doofinder_feed', array('doofinder_status'=>1));
    }

    public function uninstall(){
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('doofinder_feed', array('doofinder_status'=>0));
    }

	public function index() {
		$this->language->load('feed/doofinder');

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('doofinder_feed', $this->request->post);				

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

        $this->data['entry_mpn_field'] = $this->language->get('entry_mpn_field');
        $this->data['entry_display_prices'] = $this->language->get('entry_display_prices');
        $this->data['entry_prices_with_taxes'] = $this->language->get('entry_prices_with_taxes');
        $this->data['entry_full_category_path'] = $this->language->get('entry_full_category_path');
        $this->data['entry_image_size'] = $this->language->get('entry_image_size');

		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_data_feed'] = $this->language->get('entry_data_feed');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_feed'),
			'href'      => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('feed/doofinder', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('feed/doofinder', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['doofinder_status'])) {
			$this->data['doofinder_status'] = $this->request->post['doofinder_status'];
		} else {
			$this->data['doofinder_status'] = $this->config->get('doofinder_status');
		}

        // IMAGE SIZES
        $this->data['image_sizes'] = array('70'=>'70', '110'=>'110', '220'=>'220', '350'=>'350', '500'=>'500');
        if(isset($this->request->post['doofinder_image_size'])){
            $this->data['doofinder_image_size'] = $this->request->post['doofinder_image_size'];
        } else{
            $this->data['doofinder_image_size'] = $this->config->get('doofinder_image_size') !== null ? 
                $this->config->get('doofinder_image_size') : 110;
        }
        
        // MPN FIELDS
        $this->data['mpn_candidates'] = array('mpn' =>'MPN: Manufacturer Part Number','upc'=>'UPC: Universal Product Code',
                                              'ean'=>'EAN: European Article Number','jan'=>'JAN: Japanese Article Number', 
                                              'isbn'=> 'ISBN: International Standard Book Number', 'model' => 'Product model');
        if (isset($this->request->post['doofinder_mpn_field'])){
            $this->data['doofinder_mpn_field'] = $this->request->post['doofinder_mpn_field'];
        } else {
            $this->data['doofinder_mpn_field'] = $this->config->get('doofinder_mpn_field') ? $this->config->get('doofinder_mpn_field') : 'mpn';
        } 

        // DISPLAY PRICES?
        if(isset($this->request->post['doofinder_display_prices'])){
            $this->data['doofinder_display_prices'] = $this->request->post['doofinder_display_prices'];
        } else{
            $this->data['doofinder_display_prices'] = $this->config->get('doofinder_display_prices') !== null ? $this->config->get('doofinder_display_prices') : 1;
        }

        // DISPLAY PRICES WITH TAXES?
        if(isset($this->request->post['doofinder_prices_with_taxes'])){
            $this->data['doofinder_prices_with_taxes'] = $this->request->post['doofinder_prices_with_taxes'];
        } else{
            $this->data['doofinder_prices_with_taxes'] = $this->config->get('doofinder_prices_with_taxes') !== null ? $this->config->get('doofinder_prices_with_taxes') : 1;
        }

        // USE FULL CATEGORY PATH
        if(isset($this->request->post['doofinder_full_category_path'])){
            $this->data['doofinder_full_category_path'] = $this->request->post['doofinder_full_category_path'];
        } else{
            $this->data['doofinder_full_category_path'] = $this->config->get('doofinder_full_category_path') !== null ? 
                $this->config->get('doofinder_full_category_path') : 1;
        }

        $this->data['data_feeds'] = array();
		$this->load->model('localisation/currency');
        foreach($languages as $lang_code => $lang_description){
            foreach($this->model_localisation_currency->getCurrencies() as $currency){
                $this->data['data_feeds'][$lang_description['name']][$currency['title']] =  HTTP_CATALOG . 'index.php?route=feed/doofinder&amp;currency='.$currency['code'].'&amp;language='.$lang_code;
            }
        }

		$this->template = 'feed/doofinder.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	} 

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'feed/doofinder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}	
}
?>