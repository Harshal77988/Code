<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends MY_Model {
	// set the table name
    public $_table = 'tbl_contact_us';
    // set the primary key
    public $primary_key = 'id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'isactive';
}