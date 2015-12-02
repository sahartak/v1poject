<?php
namespace App\Model;

class User extends Model {
    
    protected $table = 'users';
    
	/**
     * Default query
     * @var string 
     */
    protected $default_query = '';
    
    public function __construct(\DBConnection $connection) {
        $this->default_query = "
            SELECT u.*, ua.*
            FROM {$this->table} u
                LEFT JOIN users_advisors ua ON ua.users_advisors_id = u.user_advisor1
       	";
        parent::__construct($connection);
    }

    /**
     * Gets user by uid
     * @param int $uid
     * @return array
     */
    public function getUserByUid($uid) {
        $res = $this->db->rq("
        	{$this->default_query}
            WHERE user_account_num = {$this->db->string_escape($uid)}
            LIMIT 1
        ");
            
        return $this->db->fetch($res);
    }
    
    /**
     * Gets template fields
     * @return array
     */
	public function getTemplateFields() {
        $sql = "{$this->default_query} LIMIT 0";
        
        $fields = $this->getColumns($sql);
        $custom_fields = Array('account_statement');
        $fields = array_merge($fields, $custom_fields);
        
        sort($fields);
        return $fields;
    }
    
    public function getUserStatement($uid) {
        
    }
}