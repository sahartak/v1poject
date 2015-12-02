<?php
namespace App\Model;

class PdfTemplate extends Model {
    
    protected $table = 'pdf_templates';
    
    /**
     * Returns list of key=>value options
     * @return array
     */
    public function getList($key = 'id', $value = 'name', $where = null) {
        return parent::getList($key, $value, $where);
    }
    
    /**
     * Returns template based on slug
     * @param string $slug
     * @return array
     */
    public function getPdfTemplateBySlug($slug) {
        $query = "SELECT content, pdf_external_id FROM {$this->table} WHERE slug = '{$this->db->string_escape($slug)}'";
        $res = $this->db->rq($query);
        
        return $this->db->fetch($res);
    }
}