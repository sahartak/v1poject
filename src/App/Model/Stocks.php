<?php
namespace App\Model;

class Stocks extends Model {
    
    protected $table = 'stocks';
    
    protected $apiUrl = 'http://query.yahooapis.com/v1/public/yql';

    /**
     * Returns list of key=>value options
     * @return array
     */
    public function getList($key = 'stocks_id', $value = 'stocks_symbol', $where = null) {
        return parent::getList($key, $value, $where);
    }
    
    /**
     * Returns details for given stock id
     * @param int $stocks_id
     * @return array
     */
    public function getDetails($stocks_id) {
        $res = $this->db->rq("
            SELECT details_id, details_ref, stocks_id, date, volume, value, value_change
            FROM stock_details
            WHERE stocks_id = {$this->db->string_escape($stocks_id)}
            ORDER BY date DESC, details_id DESC
            LIMIT 200
        ");
        
        $array = array();
        while(($row = $this->db->fetch($res)) != false) {
            $array[] = $row;
        }
        
        return $array;
    }
    
    /**
     * Return detail
     * @param int $detail
     * @return array
     */
    public function getDetail($detail) {
        $res = $this->db->rq("
            SELECT details_id, date, value
            FROM stock_details
            WHERE details_id = {$this->db->string_escape($detail)}
        ");
            
        return $this->db->fetch($res);
    }
    
    /**
     * Return last detail
     * @param int $id
     * @return arrayS
     */
    public function getLastDetail($id) {
        $res = $this->db->rq("
            SELECT *
            FROM stock_details
            WHERE details_id = {$this->db->string_escape($detail)}
            ORDER BY date DESC
            LIMIT 1
        ");
            
        return $this->db->fetch($res);
    }
    
    /**
     * Edits details field
     * @param int $id
     * @param string $field
     * @param string $value
     * @return boolean
     */
    public function editDetailField($id, $field, $value) {
        $res = $this->db->rq("
            UPDATE stock_details
            SET $field = '{$this->db->string_escape($value)}'
            WHERE details_id = '{$this->db->string_escape($id)}'
        ");
            
        return $this->db->affected_rows() > 0;
    }
    
    /**
     * Creates detail
     * @param int $stock stock id
     * @param array $data
     * @return boolean
     */
    public function createDetail($stock, $data = array()) {
    	$current = CUSTOMTIME;
        $default = array(
            'datetime' => date('Y-m-d H:i:s', $current),
        	'date' => date('Y-m-d', $current),
            'value' => 0,
            'volume' => null,
        	'ref'	=> $this->_getRef()
        );
        
        if($data['date']){
        	$time = strtotime($data['date']);
        	$data['date'] = date('Y-m-d', $time);
        	$data['datetime'] = date('Y-m-d H:i:s', $time);
        }
        
        $data = array_merge($default, $data);
        $check_exist_q = $this->db->rq("SELECT value FROM stock_details WHERE stocks_id='".$stock."' and date(date)='".$data['date']."'");
		$exist = $this->db->num_rows($check_exist_q) > 0;

		if($exist){
			$res = $this->db->rq("UPDATE stock_details SET volume='".$data['volume']."', 
				value='".$data['value']."', 
				value_change='".$this->_getValueChange($stock, $data['value'], $data['date'])."',
				date='".$data['datetime']."' 
				where stocks_id='".$stock."' and date(date)='".$data['date']."'");
		}else{
	        $res = $this->db->rq("
	            INSERT INTO stock_details (stocks_id, details_ref, date, value, value_change, volume)
	            VALUES (
	                '$stock',
	                '{$data['ref']}',
	                '{$data['datetime']}',
	                '{$data['value']}',
	                '{$this->_getValueChange($stock, $data['value'], $data['date'])}',
	                '{$data['volume']}'
	            )
	        ");
		}
                
        if ($this->db->affected_rows() > 0) {
            return $this->db->last_id();
        }
        
        return false;
    }
    
    /**
     * Updates stock values
     * @return int
     */
    public function updateStockValues($type = 'all') {
        $where = null;
        if ($type != 'all') {
            $where = "checking = '$type'";
        }else{
        	$where = "checking is not null and checking != ''";
        }
        
        $stocks = $this->getList('stocks_id', 'stocks_symbol', $where);
        
        if (count($stocks) == 0) {
            return 0;
        }
        
        $updated = 0;
        $values = $this->_fetchStockValues(array_values($stocks));
        
        $stocksReversed = array_flip($stocks);
        $ref = $this->_getRef();
        foreach($values as $quote) {
            $data = array(
                'value' => $quote->LastTradePriceOnly,
                'volume' => $quote->Volume,
            	'ref' => $ref
            );
            
            if ($this->createDetail($stocksReversed[$quote->symbol], $data)) {
                $updated++;
            }
        }
        
        return $updated;
    }
    
    protected function _fetchStockValues($stocks = array()) {
        $query = 'select * from yahoo.finance.quote where symbol in ("' . implode('","', $stocks) . '")';
        
        $url = $this->apiUrl . '?q=' . urlencode($query) . '&env=http%3A%2F%2Fdatatables.org%2Falltables.env&format=json';
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        $str = curl_exec($curl);
        curl_close($curl);
        
        $array = json_decode($str);
        $quotes = count($array->query->results->quote) > 1 ? $array->query->results->quote : array($array->query->results->quote);
        
        return $quotes;
    }
    
    /**
     * Computes value change of given stock
     * @param int $stock
     * @param int $value
     * @return int
     */
    protected function _getValueChange($stock, $value, $date=null) {
        //$res = $this->db->rq("SELECT value FROM stock_details WHERE stocks_id='$stock' and date(date)!='".$date."' ORDER BY date DESC LIMIT 1");
        $res = $this->db->rq("SELECT value FROM stock_details WHERE stocks_id='$stock'  ORDER BY date DESC LIMIT 1");
        $row = $this->db->fetch($res);
        if(!$row)
            return 0;
		$lastValue = \array_get($row, 'value');
        
        if (!empty($lastValue) && $lastValue != 0) {
            return round(($value - $lastValue) / $lastValue * 100, 2);
        }
        else {
            return 0;
        }
    }


    /**
     * Returns ref number
     * @return int
     */
    protected function _getRef() {
        return hexdec(substr(uniqid(''), 0, 10))-81208208208;
    }
}