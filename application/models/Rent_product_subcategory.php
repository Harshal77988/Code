<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rent_product_subcategory extends MY_Model {

    public $_table = 'tbl_rent_product_subcategory';
    public $primary_key = 'id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'isactive';

    // delete the category from database table
    function delete_cat($pId) {
        $this->db->where('id', $pId);
        return $this->db->delete('tbl_rent_product_subcategory');
    }

    function get_sub_categories($category_id) {

        $this->db->select('pc.id, pc.name, pc.description, pc.parent_id');
        $this->db->from('tbl_rent_product_subcategory pc');
        $this->db->where('pc.parent_id', $category_id);
        // $this->db->group_by('id');
        $query = $this->db->get();

        // echo $this->db->last_query(); die;

        $name = $query->result_array();

        if (isset($name[0]))
            return $name;
        else
            return NULL;
    }

//     function get_level($group_id) {

//         $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
//         return $result->level;
//         //echo $this->db->last_query();exit;
//     }

//     function get_all_details() {
//         $this->db->select('ipc.*,pa.attrubute_value');
//         $this->db->from('tbl_product_category ipc');
//         $this->db->join('tbl_product_sub_category ipcs', 'ipc.id=ipcs.p_category_id', 'left');
//         $this->db->join('tbl_p_attributes pa', 'pa.id=ipcs.p_sub_category_id', 'left');
//         $query = $this->db->get();
//         return $query->result_array();
//     }

//     function get_category_name_by_id($categoryId) {
//         $this->db->select('ipc.name,ipc.description');
//         $this->db->from('tbl_product_category ipc');
//         $this->db->where('id', $categoryId);
//         $query = $this->db->get();
//         $name = $query->result_array();
// //        echo '<pre>';print_r($name[0]);die;
//         if (isset($name[0]))
//             return $name[0];
//         else
//             return NULL;
//     }
    
//     public function get_all_categories() {

//         $this->db->select('pc.id, pc.name, pc.description');
//         $this->db->from('tbl_product_category pc');
//         $this->db->join('tbl_product_sub_category psc', 'pc.id = psc.p_category_id', 'LEFT');
//         $this->db->where('psc.p_category_id IS NULL');
//         $query = $this->db->get();

//         // echo $this->db->last_query(); die;

//         $name = $query->result_array();

//         if (isset($name[0]))
//             return $name;
//         else
//             return NULL;
//     }

//     public function get_all_categories_by_level($category_id) {

//         $this->db->select('pc.id, pc.name, pc.description');
//         $this->db->from('tbl_product_category pc');
//         $this->db->join('tbl_product_sub_category psc', 'pc.id = psc.p_category_id', 'LEFT');

//         if(!empty($category_id))
//             $this->db->where('psc.p_category_id', $category_id);


//         $query = $this->db->get();

//         // echo $this->db->last_query(); die;

//         $name = $query->result_array();

//         if (isset($name[0]))
//             return $name;
//         else
//             return NULL;
//     }

// function service_category() {
//      //   $this->db->where('id', $pId);
//         $q=$this->db->limit(3)->get('tbl_product_category');
//         return $q->result_array();
//     }
}
