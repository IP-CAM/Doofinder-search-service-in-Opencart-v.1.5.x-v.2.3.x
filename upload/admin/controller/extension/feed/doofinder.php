<?php 
class ControllerExtensionFeedDoofinder extends Controller {
	private $error = array(); 

    public function install(){
        $this->load->model('setting/setting');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/doofinder');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/doofinder');
        $settings = $this->model_setting_setting->getSetting('doofinder_feed');
        $settings['doofinder_feed_status'] = 1;
        $this->model_setting_setting->editSetting('doofinder_feed', $settings);
    }

    public function uninstall(){
        $this->load->model('setting/setting');
        $settings = $this->model_setting_setting->getSetting('doofinder_feed');
        $settings['doofinder_feed_status'] = 0;
        $this->model_setting_setting->editSetting('doofinder_feed', $settings);
    }

	public function index() {
		$this->language->load('extension/feed/doofinder');

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/feed/doofinder', 'token=' . $this->session->data['token'], true),
			'separator' => ' :: '
		);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=feed', true);
		$data['action'] = $this->url->link('extension/feed/doofinder', 'token=' . $this->session->data['token'], true);

		$data['heading_title'] = $this->language->get('heading_title');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save'] = $this->language->get('button_save');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_mpn_field'] = $this->language->get('entry_mpn_field');
        $data['entry_display_prices'] = $this->language->get('entry_display_prices');
        $data['entry_prices_with_taxes'] = $this->language->get('entry_prices_with_taxes');
        $data['entry_full_category_path'] = $this->language->get('entry_full_category_path');
        $data['entry_image_size'] = $this->language->get('entry_image_size');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_data_feed'] = $this->language->get('entry_data_feed');

		$data['tab_general'] = $this->language->get('tab_general');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('doofinder_feed', $this->request->post);				
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=feed', true));
		}




		if (isset($this->request->post['doofinder_feed_status'])) {
			$data['doofinder_feed_status'] = $this->request->post['doofinder_feed_status'];
		} else {
			$data['doofinder_feed_status'] = $this->config->get('doofinder_feed_status');
		}

        // IMAGE SIZES
        $data['image_sizes'] = array('70'=>'70', '110'=>'110', '220'=>'220', '350'=>'350', '500'=>'500');
        if(isset($this->request->post['doofinder_image_size'])){
            $data['doofinder_image_size'] = $this->request->post['doofinder_image_size'];
        } else{
            $data['doofinder_image_size'] = $this->config->get('doofinder_image_size') !== null ? 
                $this->config->get('doofinder_image_size') : 110;
        }
        
        // MPN FIELDS
        $data['mpn_candidates'] = array('mpn' =>'MPN: Manufacturer Part Number','upc'=>'UPC: Universal Product Code',
                                              'ean'=>'EAN: European Article Number','jan'=>'JAN: Japanese Article Number', 
                                              'isbn'=> 'ISBN: International Standard Book Number', 'model' => 'Product model');
        if (isset($this->request->post['doofinder_mpn_field'])){
            $data['doofinder_mpn_field'] = $this->request->post['doofinder_mpn_field'];
        } else {
            $data['doofinder_mpn_field'] = $this->config->get('doofinder_mpn_field') ? $this->config->get('doofinder_mpn_field') : 'mpn';
        } 

        // DISPLAY PRICES?
        if(isset($this->request->post['doofinder_display_prices'])){
            $data['doofinder_display_prices'] = $this->request->post['doofinder_display_prices'];
        } else{
            $data['doofinder_display_prices'] = $this->config->get('doofinder_display_prices') !== null ? $this->config->get('doofinder_display_prices') : 1;
        }

        // DISPLAY PRICES WITH TAXES?
        if(isset($this->request->post['doofinder_prices_with_taxes'])){
            $data['doofinder_prices_with_taxes'] = $this->request->post['doofinder_prices_with_taxes'];
        } else{
            $data['doofinder_prices_with_taxes'] = $this->config->get('doofinder_prices_with_taxes') !== null ? $this->config->get('doofinder_prices_with_taxes') : 1;
        }

        // USE FULL CATEGORY PATH
        if(isset($this->request->post['doofinder_full_category_path'])){
            $data['doofinder_full_category_path'] = $this->request->post['doofinder_full_category_path'];
        } else{
            $data['doofinder_full_category_path'] = $this->config->get('doofinder_full_category_path') !== null ? 
                $this->config->get('doofinder_full_category_path') : 1;
        }

        $data['data_feeds'] = array();
		$this->load->model('localisation/currency');
        foreach($languages as $lang_code => $lang_description){
            foreach($this->model_localisation_currency->getCurrencies() as $currency){
                $data['data_feeds'][$lang_description['name']][$currency['title']] =  HTTP_CATALOG . 'index.php?route=feed/doofinder&amp;currency='.$currency['code'].'&amp;language='.$lang_code;
            }
        }

        $this->response->setOutput($this->load->view('extension/feed/doofinder', $data));

	} 

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/doofinder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        return !$this->error;
	}	
}
?>