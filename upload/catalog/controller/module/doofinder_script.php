<?php
class ControllerModuleDoofinderScript extends Controller {
    public function index() {

        $this->load->language('module/doofinder_script');

        $data['heading_title'] = $this->language->get('heading_title');
        $cur_code = strtolower($this->session->data['currency']);
        $lang_code = strtolower($this->language->get('code'));
        // remove localization section
        if(strpos($lang_code, '-')){
            $lang_code =  strstr($lang_code, '-',  true);
        }
        $data['code'] = html_entity_decode($this->config->get('doofinder_script_'.$lang_code.'_'.$cur_code));
        // if localized code (i.e. en-GB) is not present, try the generic
        if(trim($data['code']) == ''){
            $lang_code = substr($lang_code, strpos($lang_code, '-'));
            $data['code'] = html_entity_decode($this->config->get('doofinder_script_'.$lang_code.'_'.$cur_code));
        }

        return $this->load->view('module/doofinder_script.tpl', $data);
    }
}
?>