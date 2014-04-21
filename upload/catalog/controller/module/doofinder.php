<?php  
class ControllerModuleDoofinder extends Controller {
	protected function index() {
		$this->language->load('module/doofinder');

		$this->data['heading_title'] = $this->language->get('heading_title');

        $cur_code = strtolower($this->currency->getCode());
        $lang_code = strtolower($this->language->get('code'));

        $this->data['code'] = html_entity_decode($this->config->get('doofinder_code_'.$lang_code.'_'.$cur_code));
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/doofinder.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/doofinder.tpl';
		} else {
			$this->template = 'default/template/module/doofinder.tpl';
		}
		
		$this->render();
	}
}
?>