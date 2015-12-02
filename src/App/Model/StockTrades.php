<?php
namespace App\Model;

class StockTrades extends Model {
    
    protected $table = 'stock_trades';
    
    protected $types = array(
        1 => 'Buy',
        2 => 'Sell',
        3 => 'Cover',
        4 => 'Short'
    );
    
    protected $priceValues = array(
        'trade_price_share',
        'trade_value',
        'trade_fees',
        'trade_invoiced'
    );
    
	/**
     * Default query
     * @var string 
     */
    protected $default_query = '';
    
    public function __construct(\DBConnection $connection) {
        $this->default_query = "
            SELECT t.*, s.stocks_symbol, s.stocks_name, u.*, ua.* FROM {$this->table} t
            JOIN stocks s ON t.stocks_id = s.stocks_id
            JOIN users u ON t.user_account_num = u.user_account_num
            JOIN users_advisors ua ON ua.users_advisors_id = user_advisor1
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
     * Formats price values
     * @param array $trade
     * @return array
     */
    public function formatPriceValues($trade = array()) {
        return \App\Utility\Formatter::formatPrice($trade, $this->priceValues);
    }
}