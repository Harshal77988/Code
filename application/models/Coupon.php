<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coupon extends MY_Model {

    public $_table = 'discounts';
    public $primary_key = 'id';


    public function getAllDiscounts() {
    	$this->db->select('disc_code, disc_description, disc_value_discounted, disc_value_required, disc_quantity_required');
    	$this->db->from('discounts');
    	$this->db->where('disc_type_fk', '2');
    	$this->db->order_by('disc_id', 'DESC');
    	$result = $this->db->get();

    	return $result->result_array();
    }
}