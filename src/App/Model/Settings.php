<?php
namespace App\Model;

class Settings extends Model {
    
    protected $section;
    
    public function __construct(\DBConnection $connection, $section = 'general') {
        $this->db = $connection;
        $this->section = $section;
    }
    
    public function __destruct() {
        $this->db->close();
    }


    /**
     * Adds settings
     * @param string $name
     * @param mixed $value
     */
    public function add($name, $value) {
        $this->db->rq("
            INSERT INTO global_settings (variable, variable_value, section)
            VALUES ('{$this->db->string_escape($name)}', '{$this->db->string_escape($value)}', '{$this->section}')
        ");
            
        return $this->db->affected_rows() > 0;
    }
    
    /**
     * Updates setting
     * @param string $name
     * @param mixed $value
     * @return boolean
     */
    public function update($name, $value) {
        if ($this->check($name)) {
            $this->db->rq("UPDATE global_settings SET variable_value = '{$this->db->string_escape($value)}' WHERE variable = '{$this->db->string_escape($name)}'");
            return $this->db->affected_rows() > 0;
        }
        else {
            return $this->add($name, $value);
        }
    }
    
    /**
     * Checks if setting exists
     * @param string $name
     * @return boolean
     */
    public function check($name) {
        $res = $this->db->rq("SELECT global_settings_id FROM global_settings WHERE variable = '{$this->db->string_escape($name)}'");
        return $this->db->num_rows($res) > 0;
    }
    
    /**
     * Gets setting value
     * @param string $name
     * @param mixed $default defaul value
     * @return mixed
     */
    public function get($name, $default = null) {
        $res = $this->db->rq("SELECT variable_value FROM global_settings WHERE variable = '{$this->db->string_escape($name)}'");
        $row = $this->db->fetch($res);
        
        if (is_array($row)) {
            return $row['variable_value'];
        }
        
        return $default;
    }
    
    /**
     * Gets all settings from section
     * @return array
     */
    public function getAll() {
        $res = $this->db->rq("SELECT variable, variable_value FROM global_settings WHERE section = '{$this->section}'");
        
        $array = array();
        while(($row = $this->db->fetch($res)) !== false) {
            $array[$row['variable']] = $row['variable_value'];
        }
        
        return $array;
    }
}