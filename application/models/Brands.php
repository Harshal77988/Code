<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brands extends MY_Model {

    public $_table = 'tbl_brands';
    public $primary_key = 'id';


    public function delete_brand($id) {
        $this->db->where('id', $id)->delete('tbl_brands');
        // $this->db->where('product_id', $id)->delete('tbl_highlighted_products');
        // $this->db->where('product_id', $id)->delete('tbl_dow_products');
        return true;
    }

}