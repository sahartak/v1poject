<?php
function addLog($log_area='', $log_section='', $log_user='', $log_admin='', $log_details='') {
	$user_ip=GetHostByName($_SERVER["REMOTE_ADDR"]);
	
	$db=new DBConnection();
	$query='INSERT INTO logs SET 
	log_area="'.$log_area.'",log_section="'.$log_section.'",log_user="'.$log_user.'",log_admin="'.$log_admin.'",log_details="'.$log_details.'", 
	log_date="'.date('Y-m-d H:i:s', CUSTOMTIME).'", log_ip="'.$user_ip.'"';
	$db->rq($query);
}

/**
 * Checks if key exists in an array, if yes, return it, if no,
 * returns default value
 * 
 * @param array $array
 * @param int|string $key
 * @param mixed $default
 * @return mixed
 */
function array_get(array $array, $key, $default = null) {
    return array_key_exists($key, $array) ? $array[$key] : $default;
}

/**
 * Creates select box
 * @param string $name select name
 * @param array $options select options
 * @param string $default selected value
 */
function create_select($name, array $options, $additional = array()) {
    $defaults = array(
        'empty' => false,
        'default' => '',
        'disabled' => false,
        'class' => ''
    );
    
    $additional = array_merge($defaults, $additional);
    
    $string = '<select id="' . str_replace(array('[', ']'), '', $name) . '" name="' . $name . '"' . ($additional['disabled'] ? ' disabled="disabled"' : '') . ($additional['class'] ? ' class="' . $additional['class'] . '"' : '') . '>';
    
    if ($additional['empty']) {
        $string .= '<option value="">' . $additional['empty'] . '</option>';
    }
    
    foreach ($options as $value => $name) {
        $string .= '<option value="' . $value . '"' . ($additional['default'] == $value ? ' selected="selected"' : '') . '>' . $name . '</option>';
    }
    
    return $string . '</select>';
}