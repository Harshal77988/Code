<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Addresses extends MY_Model {
    public $_table = 'tbl_addresses';
    public $primary_key = 'id';

//    protected $soft_delete = true;
//    protected $soft_delete_key = 'isactive';

    public function get_allData($user_id) {
        
        $this->db->select('*');
        $this->db->from('tbl_addresses');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        $objData = $query->result_array();

        if(isset($objData[0]))
        return $objData[0];
        else
            return NULL;
    }
}