<?php
class ControllerFeedDoofinderConfig extends Controller {
    public function index() {
        $config = array();
        $platform = array('name'=>'OpenCart', 'version' => VERSION);
        $module = array('version'=>'1.2.1', 'feed'=> HTTP_SERVER. 'index.php?route=feed/doofinder');
        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        $options = array();
        $options['language'] = array_map('strtoupper',array_keys($languages));
        $options['currency'] = array();
        $this->load->model('localisation/currency');
        $available_currencies = $this->model_localisation_currency->getCurrencies();
        foreach($available_currencies as $cur){
            if($cur['status']){
                $options['currency'][] = strtoupper($cur['code']);
            }
        }

        $config['platform'] = $platform;
        $config['module'] = $module;
        $config['module']['options'] = $options;

        $this->response->addHeader("Content-Type:application/json; charset=utf-8");
        $this->response->setOutput($this->json_encode($config));
    }



    private function json_encode($data){
        function walk_apply_html_entities($item, $key){
            if(is_string($item))
                $item = htmlentities($item);
        }
        array_walk_recursive($data, 'walk_apply_html_entities');
        return str_replace("\\/", "/", html_entity_decode(json_encode($data)));
    }
}

?>