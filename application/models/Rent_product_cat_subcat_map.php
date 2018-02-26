<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rent_product_cat_subcat_map extends MY_Model {

    public $_table = 'tbl_rent_product_cat_subcat_map';
    public $primary_key = 'id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'isactive';

        // get all the categories
    public function get_subcagetories_by_product_cat_id($category_id, $product_id) {

    	$this->db->select('tbl_subcategories_map.*');
    	$this->db->from('tbl_subcategories_map sm');
		$this->db->join('tbl_product_sub_category ps', 'ps.product_id = pr.id', 'LEFT');
		// $this->db->where('wl.user_id', $user_id);

		$query = $this->db->get();

		// echo $this->db->last_query(); die;


    }

    public function get_all_product_categories($product_id) {

    	$this->db->select('sm.*, pc.name');
    	$this->db->from($this->_table.' as sm');
    	$this->db->join('tbl_rent_product_category pc', 'pc.id = sm.category_id', 'LEFT');
    	$this->db->order_by('sm.id', 'ASC');
    	$this->db->where('sm.product_id', $product_id);
    	$query = $this->db->get();
    	
    	//~ echo $this->db->last_query(); die;
    	
    	$result = $query->result_array();

    	return $result;    	
    }
}
