<?php

namespace App\Utility;

if (!defined('SRC_PATH')) {
    define('SRC_PATH', dirname(__FILE__) . '/../../');
}

class Config {
    
    public static $configs = array();
    
    public static function getConfig($name) {
        $config = false;
        
        $file = SRC_PATH . 'config/' . $name . '.php';
        if (!isset(self::$configs[$name]) && file_exists($file)) {
            self::$configs[$name] = require $file;
        }
        
        return self::$configs[$name];
    }
}
