<?php
namespace App\Utility;

class Template {
    
    protected $content;
    
    protected $data;
    
    public function __construct($content = null, array $data = array()) {
        $this->content = $content;
        $this->data = $data;
    }
    
    public function setContent($content) {
        $this->content = $content;
        
        return $this;
    }
    
    public function setData(array $data) {
        $this->data = $data;
        
        return $this;
    }
    
    public function process() {
        $find = array_map(function($element){
            return '{' . $element . '}';
        }, array_keys($this->data));
        
        $content = str_replace($find, array_values($this->data), $this->content);
        $content = $this->_processSpecial($content);
        
        $content = $this->_removeEmpty($content);
        
        return $content;
    }
    
    protected function _processSpecial($content) {
        $specials = array(
            '{%date%}' => date('Y-m-d')
        );
        
        return str_replace(array_keys($specials), array_values($specials), $content);
    }
    
    protected function _removeEmpty($content) {
        $content = preg_replace('/{%?[a-z_]+%?}/', '', $content);
        
        return $content;
    }
}