<?php
namespace App\Utility;
require_once('sendwithus/lib/API.php');
use sendwithus\API;

class Pdf {
    
    /**
     * Templating utility
     * @var \App\Utility\Template
     */
    protected $template;
    
    /**
     * Settings model
     * @var \App\Model\Settings
     */
    protected $settings;
    
    /**
     * Template model
     * @var \App\Model\PdfTemplate
     */
    protected $model;
    
    public function __construct(\DBConnection $db) {
        $this->settings = new \App\Model\Settings($db, 'pdf');
        $this->template = new \App\Utility\Template();
        $this->model    = new \App\Model\PdfTemplate($db);
    }
    
    /**
     * Returns PDF header string
     * @return string
     */
    public function getHeader() {
        $header = $this->settings->get('pdf_header', '');
        $logo   = $this->settings->get('pdf_logo');
        
        $replace = array();
        if (!empty($logo)) {
            $replace['logo'] = '<img src="' . UPLOAD_URL . $logo . '" height="70" />';
        }
        
        $this->template->setContent($header);
        $this->template->setData($replace);
        
        return $this->template->process();
    }
    
    /**
     * Returns PDF footer string
     * @return string
     */
    public function getFooter() {
        return $this->settings->get('pdf_footer', '');
    }
    
    /**
     * Returns PDF body based on template name
     * @param string $name
     * @param array $data
     * @return string
     */
    public function getBody($name, array $data) {
        $pdfTemplate = $this->model->getPdfTemplateBySlug($name);
        
        $pdfContent = '';
        
        if(is_array($pdfTemplate)){
        	if($pdfTemplate['pdf_external_id']){
        		$API_KEY = $this->settings->get('pdf_sendwithus_key');
				$options = array();
				$api = new API($API_KEY, $options);
				$response = $api->get_template($pdfTemplate['pdf_external_id']);
				$response = $api->get_template($pdfTemplate['pdf_external_id'],$response->versions[0]->id);
        		
				$pdfContent = $response->html;
        	}else{
        		$pdfContent = $pdfTemplate['content'];
        	}
        }
        
        $this->template->setContent($pdfContent);
        $this->template->setData($data);
        
        return $this->template->process();
    }
    
}