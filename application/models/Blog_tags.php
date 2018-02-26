<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog_tags extends MY_Model {

    public $_table = 'tbl_blog_tags';
    public $primary_key = 'id';

    public function getBlogTags() {

    	try {
    		
    		$this->db->select('*');
	        $this->db->from('tbl_blog_tags');
	        $this->db->group_by('tag');
	        $query = $this->db->get();
	        return $query->result_array();	

    	} catch (Exception $e) {
    		return $e;	
    	}    	
    }
}