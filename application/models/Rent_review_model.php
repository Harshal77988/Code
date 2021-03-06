<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rent_review_model extends MY_Model {

    public $_table = 'tbl_rent_product_review';
    public $primary_key = 'id';

    public function check_review_product($id, $user_id) {
        $arr = array('product_id' => $id, 'user_id', $user_id);
        $q = $this->db->where($arr)->get('tbl_rent_product_review');
        if ($q->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_review($user_id, $product_id) {
        $arr = array('product_id' => $product_id, 'user_id', $user_id);
        $this->db->select('u.username, ip.*');
        $this->db->join('users u', 'u.id=ip.user_id');
        $q = $this->db->where($arr)->get('tbl_rent_product_review ip');
        $revData = $q->result_array();
        return $revData;
    }

    public function get_all_reiview_products($product_id) {
        $arr = array('product_id' => $product_id);
        $this->db->join('users u', 'u.id=ip.user_id');
        $q = $this->db->where($arr)->order_by('ip.id', 'DESC')->get('tbl_rent_product_review ip');
        $revData = $q->result_array();
        return $revData;
    }

    public function get_review_edit($user_id, $product_id) {
        $arr = array('product_id' => $product_id, 'user_id', $user_id);

        $q = $this->db->where($arr)->get('tbl_rent_product_review ip');
        $revData = $q->result_array();
        return $revData;
    }

}
