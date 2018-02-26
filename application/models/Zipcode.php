<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Zipcode extends MY_Model {
	// set the table name
    public $_table = 'us_zipcode';
    // set the primary key
    public $primary_key = 'id';
    // protected $soft_delete = true;
    // protected $soft_delete_key = 'isactive';


    public function getRatesByZipcode($zipcode) {
    	
    	// get all the data from table
    	$get_rate = $this->db->get_where('us_zipcode', array('zipcode' => $zipcode));
    	$result_arry = $get_rate->result_array();
    	return $result_arry;
    }

    function get_dropdown()
    {
        $args = func_get_args();

        $this->db->order_by('state_name', 'ASC');
        $this->db->group_by('state_name');
        if(count($args) == 2)
        {
            list($key, $value) = $args;
        }
        else
        {
            $key = $this->primary_key;
            $value = $args[0];
        }

        $this->trigger('before_dropdown', array( $key, $value ));

        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $this->db->where($this->soft_delete_key, FALSE);
        }

        $result = $this->db->select(array($key, $value))
                           ->get($this->_table)
                           ->result();

        $options = array();

        foreach ($result as $row)
        {
            $options[$row->{$key}] = $row->{$value};
        }

        $options = $this->trigger('after_dropdown', $options);

        return $options;
    }
}