<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders_summary extends MY_Model {

    public $_table = 'order_summary';
    public $primary_key = 'ord_order_number';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    function get_by_id($user_id, $start = null, $limit = null) {

        $this->db->select('p.id, p.category_id, p.image_url, p.product_name, os.*, od.*');
        $this->db->from('order_details od');
        $this->db->join('order_summary os', 'os.ord_order_number = od.ord_det_order_number_fk', 'LEFT');
        $this->db->join('tbl_products p', 'p.id = od.ord_det_item_fk', 'LEFT');
        // $this->db->join('tbl_products_image ipm', 'ipm.product_id = p.id', 'RIGHT');
        $this->db->where('os.ord_user_fk', $user_id);
        $this->db->order_by('ord_order_number', 'DESC');
        $this->db->group_by('ord_order_number');
        if ($start != null && $limit != null)
            $this->db->limit($limit, $start);
        else
            $this->db->limit(10, 0);
        $query = $this->db->get();

       // echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_all_orders($start = null, $limit = null) {

        $this->db->select('p.*,os.*,od.*, ors.*');
        $this->db->from('order_details od');
        $this->db->join('order_summary os', 'os.ord_order_number = od.ord_det_order_number_fk', 'LEFT');
        $this->db->join('tbl_products p', 'p.id = od.ord_det_item_fk', 'LEFT');
        $this->db->join('order_status ors', 'ors.ord_status_id = os.ord_status', 'LEFT');
        // $this->db->join('tbl_products_image ipm', 'ipm.product_id = p.id', 'RIGHT');
        $this->db->order_by('os.ord_order_number', 'DESC');
        $this->db->group_by('os.ord_order_number');

        if ($start != null && $limit != null)
            $this->db->limit($limit, $start);
        else
            $this->db->limit(10, 0);

        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    public function getTotalOrderAmount() {
        $this->db->select('SUM(ord_tax_total) + sum(ord_total) AS order_total');
        $this->db->from('order_summary');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getOrderStatus() {

        $this->db->select('os.ord_status, ords.*, count(ord_order_number) as total_order');
        $this->db->from('order_summary os');
        $this->db->join('order_status ords', 'ords.ord_status_id = os.ord_status', 'LEFT');
        $this->db->group_by('os.ord_status');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getRentOrderCount() {

        $this->db->select('count(id) as total_orders');
        $this->db->from('tbl_order_rent_details');
        $this->db->group_by('order_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getOrdersThisDay() {

        $this->db->select('count(ord_order_number) as tot_day');
        $this->db->from('order_summary');
        $this->db->where('DAY(ord_date) = DAY(CURRENT_DATE)');
        $this->db->where('MONTH(ord_date) = MONTH(CURRENT_DATE)');
        $this->db->where('YEAR(ord_date) = YEAR(CURRENT_DATE)');
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function getOrdersThisMonth() {

        $this->db->select('count(ord_order_number) as tot_month');
        $this->db->from('order_summary');
        $this->db->where('MONTH(ord_date) = MONTH(CURRENT_DATE)');
        $this->db->where('YEAR(ord_date) = YEAR(CURRENT_DATE)');
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function getOrdersThisYear() {

        $this->db->select('count(ord_order_number) as tot_year');
        $this->db->from('order_summary');
        $this->db->where('YEAR(ord_date) = YEAR(CURRENT_DATE)');
        $query = $this->db->get();
        
        return $query->result_array();
    }

    // get all the rent section orders and display it in to the admin rent orders tabs
    public function getAllRentOrders()
    {
        $this->db->select('*');
        $this->db->from('tbl_order_rent_details rod');
        // $this->db->join('order_status ords', 'ords.ord_status_id = os.ord_status', 'LEFT');
        $query = $this->db->get();        
        
        return $query->result_array();
    }

    // get all the pre-order section orders and display it in to the admin pre-orders tab
    public function getAllPreOrders($start = null, $limit = null)
    {
        $this->db->select('p.*,os.*,od.*, ors.*');
        $this->db->from('order_details od');
        $this->db->join('order_summary os', 'os.ord_order_number = od.ord_det_order_number_fk', 'LEFT');
        $this->db->join('tbl_products p', 'p.id = od.ord_det_item_fk', 'LEFT');
        $this->db->join('order_status ors', 'ors.ord_status_id = os.ord_status', 'LEFT');
        $this->db->order_by('os.ord_order_number', 'DESC');
        $this->db->where('os.order_type', '2');
        $this->db->group_by('os.ord_order_number');

        if ($start != null && $limit != null)
            $this->db->limit($limit, $start);
        else
            $this->db->limit(10, 0);

        $query = $this->db->get();
        return $query->result_array();
    }


    // change order status from admin
    public function changeOrderStatus($status, $order_id) {
        $this->db->set('ord_status', $status);
        $this->db->where('ord_order_number', $order_id);
        
        if($this->db->update('order_summary')) {
            return true;
        }        
    }
}

/* End of file Orders_summary.php */
/* Location: ./models/backend/Orders_summary.php */