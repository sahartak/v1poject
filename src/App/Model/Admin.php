<?php

namespace App\Model;

class Admin extends Model {
    
    protected $table = 'ul_logins';
    
    public function getAdmin($id) {
        $query = $this->db->rq("
            SELECT * FROM {$this->table}
            WHERE id = {$this->db->string_escape($id)}
        ");
            
        return $this->db->fetch($query);
    }
}