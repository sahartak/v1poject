<?php
namespace App\Model;

class Trades extends Model {
    
    protected $table = 'trades';
    
    protected $types = array(
        1 => 'Buy',
        2 => 'Sell'
    );
    
    protected $options = array(
        1 => 'CALL',
        2 => 'PUT'
    );
    
    protected $statuses = array(
        'buy' => array(
            1 => 'Open',
            2 => 'Pending',
            3 => 'Disabled',
            4 => 'Closed'
        ),
        'sell' => array(
            1 => 'Closed',
            2 => 'Pending',
            3 => 'Disabled'
        )
    );
    
    protected $priceValues = array(
        'trade_value',
        'trade_fees',
        'trade_invoiced',
        'trade_premium_price',
        'trade_price_contract',
        'trade_strikeprice'
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
     * Returns list of key=>value options
     * @return array
     */
    public function getList($key = 'trades_id', $value = 'trade_details', $where = null) {
        return parent::getList($key, $value, $where);
    }
    
    /**
     * Returns types
     * @return array
     */
    public function getTypes() {
        return $this->types;
    }
    
    /**
     * Returns options
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }
    
    /**
     * Returns statuses
     * @param string $type buy/sell
     * @return array
     */
    public function getStatuses($type = 'buy') {
        return $this->statuses[$type];
    }

    /**
     * Gets stock trade by ref
     * @param int $ref
     * @return array
     */
    public function getTradeByRef($ref) {
        $res = $this->db->rq("
            {$this->default_query}
            WHERE trade_ref = {$this->db->string_escape($ref)}
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
    
    /**
     * Returns user trades
     * @param int $uan user_account_num
     */
    public function getUserTrades($uan) {
        $res = $this->db->rq("
            SELECT *
            FROM {$this->table}
            WHERE user_account_num = {$this->db->string_escape($uan)}
            ORDER BY trade_date DESC, trade_action_date DESC, trades_id DESC
        ");
            
        $trades = array();
        while(($row = $this->db->fetch($res)) !== false) {
            $trades[] = $row;
        }
            
        return $trades;
    }
    
    /**
     * Formats price values
     * @param array $trade
     * @return array
     */
    public function formatPriceValues($trade = array()) {
        return \App\Utility\Formatter::formatPrice($trade, $this->priceValues);
    }
}