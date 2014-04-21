<?php
class ControllerModuleDoofinder extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('module/doofinder');

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        $this->load->model('localisation/currency');
        $currencies = $this->model_localisation_currency->getCurrencies();
        

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('doofinder', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');

		$this->data['entry_code'] = $this->language->get('entry_code');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/doofinder', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/doofinder', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['doofinder_codes'] = array();

        foreach($languages as $lang_code => $lang_description){
            $lang_code = strtolower($lang_code);
            $this->data['doofinder_codes'][$lang_code] = array();
            foreach($currencies as $currency){
                $cur_code = strtolower($currency['code']);
                $parameter_name = 'doofinder_code_'.$lang_code.'_'.$cur_code;
                if(isset($this->request->post[$parameter_name]) && trim($this->request->post[$parameter_name]) != ''){
                    $this->data['doofinder_codes'][$lang_code][$cur_code] = $this->request->post[$parameter_name];
                } else if ($this->config->get($parameter_name) !== null && ($this->config->get($parameter_name)) != ''){
                    $this->data['doofinder_codes'][$lang_code][$cur_code] = $this->config->get($parameter_name);
                } else {
                    $this->data['doofinder_codes'][$lang_code][$cur_code] = null;
                }
            }
        }

		$this->data['modules'] = array();

		if (isset($this->request->post['doofinder_module'])) {
			$this->data['modules'] = $this->request->post['doofinder_module'];
		} elseif ($this->config->get('doofinder_module')) { 
			$this->data['modules'] = $this->config->get('doofinder_module');
		}			

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/doofinder.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/doofinder')) {
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