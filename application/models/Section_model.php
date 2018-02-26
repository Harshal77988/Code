<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Section_model extends MY_Model {
    
    public $_table = 'tbl_mst_cms';
    public $primary_key = 'cms_id';
    protected $soft_delete = true;
    protected $soft_delete_key = '0';    
}