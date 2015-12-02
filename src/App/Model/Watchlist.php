<?php
namespace App\Model;

class Watchlist extends Model {
    
    protected $table = 'stock_watchlist';
    
    /**
     * Returns list of key=>value options
     * @return array
     */
    public function getList($key = 'id', $value = 'stock_name', $where = null) {
        return parent::getList($key, $value, $where);
    }
    
    /**
     * Get stock list for widget
     * @param string $where
     */
    public function getWidgetStocks($where = null) {
        $stocks = $this->getRecords($where);
        
        return $this->_prepareForWidget($stocks);
    }
    
    /**
     * Prepare records for widget
     * @param array $list
     * @return string
     */
    protected function _prepareForWidget($list) {
        $list = array_map(function($item){
            return '"' . $item['stock_exch'] . ':' . $item['stock_name'] . '"';
        }, $list);
        
        return implode(',', $list);
    }
}