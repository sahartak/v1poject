<?php
namespace App\Utility;

class Formatter {
    
    /**
     * Formats price
     * @param string|array $value
     * @return string|array
     */
    public static function formatPrice($value, $keys = array()) {
        if (is_array($value) && !empty($keys)) {
            foreach ($keys as $key) {
                if (isset($value[$key])) {
                    $value[$key] = self::formatPrice($value[$key]);
                }
            }
            
            return $value;
        }
        elseif (is_string($value)) {
            return '$' . number_format($value, 2, '.', ',');
        }
    }
}