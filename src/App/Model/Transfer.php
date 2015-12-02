<?php
namespace App\Model;

class Transfer extends Model {
    
    protected $table = 'transfers';
    
    protected $types = array(
        1 => 'Deposit',
        2 => 'Withdraw'
    );
    
    protected $statuses = array(
        1 => 'Transfered',
        2 => 'Pending',
        3 => 'Disabled'
    );
    
    protected $codeTypes = array(
        1 => 'SWIFT Code',
        2 => 'IBAN Code',
        3 => 'ABA #',
        4 => 'BSC Code'
    );
    
    protected $priceValues = array(
        'tr_value',
        'tr_fees',
        'tr_total'
    );
    
	/**
     * Default query
     * @var string 
     */
    protected $default_query = '';
    
    public function __construct(\DBConnection $connection) {
        $this->default_query = "
            SELECT t.*, u.*, ua.*
            FROM {$this->table} t
                LEFT JOIN users u ON t.user_account_num = u.user_account_num
                LEFT JOIN users_advisors ua ON ua.users_advisors_id = user_advisor1
        ";
        parent::__construct($connection);
    }


    /**
     * Returns types
     * @return array
     */
    public function getTypes() {
        return $this->types;
    }
    
    /**
     * Returns statuses
     * @return array
     */
    public function getStatuses() {
        return $this->statuses;
    }
    
    /**
     * Returns bank code types
     * @return array
     */
    public function getCodeTypes() {
        return $this->codeTypes;
    }

    /**
     * Gets stock trade by ref
     * @param int $ref
     * @return array
     */
    public function getTransferByRef($ref) {
        $res = $this->db->rq("
            {$this->default_query}
            WHERE tr_ref = {$this->db->string_escape($ref)}
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
        sort($fields);
        
        return $fields;
    }
    
    public function getUserTransfers($uan) {
        $res = $this->db->rq("
            SELECT *
            FROM {$this->table}
            WHERE user_account_num = {$this->db->string_escape($uan)}
            ORDER BY tr_date DESC, tr_system_update DESC, transfers_id DESC
        ");
            
        $transfers = array();
        while(($row = $this->db->fetch($res)) !== false) {
            $transfers[] = $row;
        }
            
        return $transfers;
    }
    
    /**
     * Formats price values
     * @param array $transfer
     * @return array
     */
    public function formatPriceValues($transfer) {
        return \App\Utility\Formatter::formatPrice($transfer, $this->priceValues);
    }
    
}