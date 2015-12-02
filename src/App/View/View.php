<?php
namespace App\View;

/**
 * Simple view implementation
 */
class View {
    
    protected $path;
    
    protected $vars = array();
    
    /**
     * Constructor
     * @param string $name view file name
     */
    public function __construct($name) {
        $path = SRC_PATH . 'views/' . $name . '.php';
        if (file_exists($path)) {
            $this->path = $path;
        }
        else {
            trigger_error('View file not exists!');
        }
    }
    
    /**
     * Sets variable for the view
     * @param string $name variable name
     * @param mixed $value variable 
     */
    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }
    
    /**
     * Gets variable
     * @param string $name variable name
     * @return mixed
     */
    public function __get($name) {
        if (isset($this->vars[$name])) {
            return $this->vars[$name];
        }
        
        return null;
    }
    
    /**
     * Checks if variable exists
     * @param string $name variable name
     * @return boolean
     */
    public function __isset($name) {
        return isset($this->vars[$name]);
    }
    
    /**
     * Renders view
     * @param array $vars variables passed to the view
     */
    public function render(array $vars = array()) {
        ob_start();
        
        $variables = array_merge($this->vars, $vars);
        extract($variables);
        
        include($this->path);
        
        return ob_get_clean();
    }
    
}