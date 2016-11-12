<?php
class ControllerExtensionModuleDoofinderscript extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/doofinder_script');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('doofinder_script', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
        }

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        $this->load->model('localisation/currency');
        $currencies = $this->model_localisation_currency->getCurrencies();


        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_content_top'] = $this->language->get('text_content_top');
        $data['text_content_bottom'] = $this->language->get('text_content_bottom');
        $data['text_column_left'] = $this->language->get('text_column_left');
        $data['text_column_right'] = $this->language->get('text_column_right');

        $data['entry_code'] = $this->language->get('entry_code');
        $data['entry_layout'] = $this->language->get('entry_layout');
        $data['entry_position'] = $this->language->get('entry_position');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_add_module'] = $this->language->get('button_add_module');
        $data['button_remove'] = $this->language->get('button_remove');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['code'])) {
            $data['error_code'] = $this->error['code'];
        } else {
            $data['error_code'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_extension'),
            'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('extension/module/doofinder_script', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/module/doofinder_script', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        $data['doofinder_codes'] = array();

        foreach($languages as $lang_code => $lang_description){
            $lang_code = strtolower($lang_code);
            if(strpos($lang_code, '-')){
                $lang_code =  strstr($lang_code, '-',  true);
            }
            $data['doofinder_codes'][$lang_code] = array();
            foreach($currencies as $currency){
                $cur_code = strtolower($currency['code']);
                $parameter_name = 'doofinder_script_'.$lang_code.'_'.$cur_code;
                if(isset($this->request->post[$parameter_name]) && trim($this->request->post[$parameter_name]) != ''){
                    $data['doofinder_codes'][$lang_code][$cur_code] = $this->request->post[$parameter_name];
                } else if ($this->config->get($parameter_name) !== null && ($this->config->get($parameter_name)) != ''){
                    $data['doofinder_codes'][$lang_code][$cur_code] = $this->config->get($parameter_name);
                } else {
                    $data['doofinder_codes'][$lang_code][$cur_code] = null;
                }
            }
        }

        $data['modules'] = array();

        if (isset($this->request->post['doofinder_script_status'])) {
            $data['doofinder_script_status'] = $this->request->post['doofinder_script_status'];
        } else {
            $data['doofinder_script_status'] = $this->config->get('doofinder_script_status');
        }


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        $this->response->setOutput($this->load->view('extension/module/doofinder_script', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/doofinder_script')) {
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