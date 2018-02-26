<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_Model extends CI_Model {

    /**
    * @author    : Harshal Borse <harshalb@rebelute.com>
    * @date      : 17 Nov 2017
    * Send mail using CI email library
    */
    public function sendEmail($email, $message, $subject) {

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.mailtrap.io',
            'smtp_port' => '2525',
            'smtp_user' => '7ce2e198718b2b',
            'smtp_pass' => '78174c30aa7e8d',
            'crlf' => "\r\n",
            'newline' => "\r\n"
        );
        

        $this->load->library('email', $config);
        $this->email->initialize($config);

        // set the from address
        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));

        // set the subject
        $this->email->subject($subject);

        // set recipeinets
        $this->email->to($email);

        // set mail message
        $this->email->message($message);        
        return $this->email->send();
    }
    
    
    public function getRecords($table, $fields = '', $condition = '', $order_by = '', $limit = '', $debug = 0) {
        $str_sql = '';
        if (is_array($fields)) {  #$fields passed as array
            $str_sql.=implode(",", $fields);
        } elseif ($fields != "") {   #$fields passed as string
            $str_sql .= $fields;
        } else {
            $str_sql .= '*';  #$fields passed blank
        }
        $this->db->select($str_sql, FALSE);
        if (is_array($condition)) {  #$condition passed as array
            if (count($condition) > 0) {
                foreach ($condition as $field_name => $field_value) {
                    if ($field_name != '' && $field_value != '') {
                        $this->db->where($field_name, $field_value);
                    }
                }
            }
        } else if ($condition != "") { #$condition passed as string
            $this->db->where($condition);
        }
        if ($limit != "")
            $this->db->limit($limit);#limit is not blank

        if (is_array($order_by)) {
            $this->db->order_by($order_by[0], $order_by[1]);  #$order_by is not blank
        } else if ($order_by != "") {
            $this->db->order_by($order_by);  #$order_by is not blank
        }
        $this->db->from($table);
        $query = $this->db->get();
        if ($debug) {
            die($this->db->last_query());
        }
        return $query->result_array();
    }
    
     public function deleteRows($arr_delete_array, $table_name, $field_name) {
        if (count($arr_delete_array) > 0) {
            foreach ($arr_delete_array as $id) {
                $this->db->where($field_name, $id);
                $query = $this->db->delete($table_name);
            }
        }
    }
    
    public function insertRow($insert_data, $table_name) {
        $this->db->insert($table_name, $insert_data);

        return $this->db->insert_id();
    }
    
    
    public function updateRow($table_name, $update_data, $condition) {

        if (is_array($condition)) {
            if (count($condition) > 0) {
                foreach ($condition as $field_name => $field_value) {
                    if ($field_name != '' && $field_value != '') {
                        $this->db->where($field_name, $field_value);
                    }
                }
            }
        } else if ($condition != "") {
            $this->db->where($condition);
        }

        // echo $this->db->last_query(); die;
        $this->db->update($table_name, $update_data);

        return TRUE;
    }
    
   
     public function getBlogList(){ 
        $this->db->select('b.*,u.first_name,u.last_name');
        $this->db->from('tbl_mst_blog_posts as b');
        $this->db->join('users as u', 'b.posted_by = u.id', 'left');
        $this->db->order_by('b.post_id DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function getBlogDetail() {

    }

    /**
    * @author    : Harshal Borse <harshalb@rebelute.com>
    * @param     : $blog_id (int)
    * get the comments on blog by passing the blog id
    */
    public function getBlogComments($blog_id, $status = NULL) {

        $this->db->select('*');
        $this->db->from('tbl_blog_comments');

        if(!empty($status)) {
            $this->db->where('status', $status);    
        }
        
        $this->db->where('post_id', $blog_id);
        $this->db->order_by('comment_id DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }

    // get the rented product list and show it to the user
    public function getrentedProducts($user_id) {

        $this->db->select('ord.*, rp.*');
        $this->db->from('tbl_order_rent_details ord');
        $this->db->join('tbl_rent_products rp', 'rp.id = ord.product_id', 'LEFT');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('ord.id','DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }


    public function getAllDailyReports($start_date) {        

        $this->db->select('*');
        $this->db->from('order_summary');

        if(!empty($start_date)) {
            $this->db->where('DAY(ord_date) = DAY("'.$start_date.'")');
            $this->db->where('MONTH(ord_date) = MONTH("'.$start_date.'")');
            $this->db->where('YEAR(ord_date) = YEAR("'.$start_date.'")');
        } else {
            $this->db->where('DAY(ord_date) = DAY(CURRENT_DATE)');
            $this->db->where('MONTH(ord_date) = MONTH(CURRENT_DATE)');
            $this->db->where('YEAR(ord_date) = YEAR(CURRENT_DATE)');
        }

        $query = $this->db->get();                      
        
        return $query->result_array();
    }

    public function getAllWeeklyReports() {

        $this->db->select('*');
        $this->db->from('order_summary');
        $this->db->where('WEEK(ord_date) = WEEK(CURRENT_DATE)');
        $this->db->where('YEAR(ord_date) = YEAR(CURRENT_DATE)');
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function getAllMonthlyReports() {

        $this->db->select('*');
        $this->db->from('order_summary');
        $this->db->where('MONTH(ord_date) = MONTH(CURRENT_DATE)');
        $this->db->where('YEAR(ord_date) = YEAR(CURRENT_DATE)');
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function getAllQuarterlyReports() {

        $this->db->select('*');
        $this->db->from('order_summary');
        $this->db->where('QUARTER(ord_date) = QUARTER(CURRENT_DATE)');
        $this->db->where('YEAR(ord_date) = YEAR(CURRENT_DATE)');
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function getAllYearlyrRports() {

        $this->db->select('*');
        $this->db->from('order_summary');
        $this->db->where('YEAR(ord_date) = YEAR(CURRENT_DATE)');
        $query = $this->db->get();
        
        return $query->result_array();
    }


    public function getAllRentOrders()
    {
        $this->db->select('ord.*, rp.*');
        $this->db->from('tbl_order_rent_details ord');
        $this->db->join('tbl_rent_products rp', 'rp.id = ord.product_id', 'LEFT');
        $this->db->order_by('ord.id','DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }


    public function getAllSalesReports($start_date) {

        $this->db->select('ord.ord_det_item_name as product_name ,count(ord.ord_det_id) AS total_records, ord.ord_det_order_number_fk, sum(ord.ord_det_quantity) AS sum, sum(ord.ord_det_price_total) AS total_sum');

        if(!empty($start_date)) {
            $this->db->where('DAY(ord_date) = DAY("'.$start_date.'")');
            $this->db->where('MONTH(ord_date) = MONTH("'.$start_date.'")');
            $this->db->where('YEAR(ord_date) = YEAR("'.$start_date.'")');
        } else {
            // $this->db->group_by('ord_det_item_fk');
        }

        $this->db->from('order_details ord');
        // $this->db->join('tbl_products rp', 'rp.id = ord.ord_det_item_fk', 'LEFT');
        $this->db->order_by('ord.ord_det_id','DESC');

        $this->db->group_by('ord_det_item_fk');

        $query = $this->db->get();        
        
        return $query->result_array();
    }
}