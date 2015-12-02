<?php
namespace App\Model;

abstract class Model {
    
    /**
     * Database connection
     * @var \DBConnection
     */
    protected $db;
    
    /**
     * Table name
     * @var string
     */
    protected $table;
    
    /**
     * ID field
     * @var string 
     */
    protected $idField = 'id';
    
    public function __construct(\DBConnection $connection) {
        $this->db = $connection;
    }
    
    /**
     * Returns key/value list
     * @param string $key key field
     * @param string $value value field
     * @param string $where where constraint
     * @return array
     */
    public function getList($key, $value, $where = null) {
        $query = "SELECT {$key}, {$value} FROM {$this->table}";
        if (!empty($where)) {
            $query .= " WHERE $where";
        }
        
        $res = $this->db->rq($query);
        
        $list = array();
        while (($row = $this->db->fetch($res)) !== false) {
            $list[$row[$key]] = $row[$value];
        }
        
        return $list;
    }
    
	/**
     * Returns list of field names
     * @param string $query
     * @return array
     */
    public function getColumns($query) {
    	$res = $this->db->rq($query);
    	
    	$list = array();
        while (($row = mysql_fetch_field($res)) !== false) {
            $list[]= $row->name;
        }
        
        return $list;
    }
    
    /**
     * Returns record based on id
     * @param int $id
     * @return array
     */
    public function getRecord($id) {
        $query = "SELECT * FROM {$this->table} WHERE {$this->idField} = {$this->db->string_escape($id)}";
        $res = $this->db->rq($query);
        
        return $this->db->fetch($res);
    }
    
    /**
     * Returns list of records
     * @param string $where
     * @return array
     */
    public function getRecords($where = null) {
        $query = "SELECT * FROM {$this->table}";
        
        if (!empty($where)) {
            $query .= " WHERE $where";
        }
        
        $res = $this->db->rq($query);
        
        $result = array();
        if ($this->db->num_rows($res)) {
            while(false !== ($row = $this->db->fetch($res))) {
                $result[] = $row;
            }
        }
        
        return $result;
    }
    
    /**
     * Updates record
     * @param int $id
     * @param array $data
     * @return boolean
     */
    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET ";
        
        foreach ($data as $name => $value) {
            $query .= "$name = '{$this->db->string_escape($value)}', ";
        }
        $query = rtrim($query, ', ');
        
        $query .= " WHERE {$this->idField} = {$this->db->string_escape($id)}";
        
        $this->db->rq($query);
        
        return $this->db->affected_rows() > 0;
    }
    
    /**
     * Adds record to the database
     * @param array $data
     * @return integer
     */
    public function insert($data = array()) {
        $query = "INSERT INTO {$this->table} (";
        
        $query .= implode(', ', array_keys($data));
        $query .= ') VALUES (';
        
        foreach ($data as $key => $value) {
            $query .= "'{$this->db->string_escape($value)}', ";
        }
        
        $query = rtrim($query, ', ');
        $query .= ')';
        
        $this->db->rq($query);
        
        return $this->db->last_id();
    }
    
    /**
     * Deletes record
     * @param int|array $where
     * @return boolean
     */
    public function delete($where) {
        if (is_numeric($where)) {
            $where = array(
                $this->idField => $where
            );
        }
        
        $query = "DELETE FROM {$this->table} WHERE ";
        
        foreach ($where as $name => $value) {
            $query .= "$name = '{$this->db->string_escape($value)}' AND ";
        }
        $query = rtrim($query, ' AND ');
        
        $this->db->rq($query);
        
        return $this->db->affected_rows() > 0;
    }
}