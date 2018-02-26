<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	/*
	* @author : Harshal Borse <harshal@rebelute.com>
	*
	* @date : 26 Oct 2017
	*
	* Social link model to display the dunamic social icons in footer for frontend
	*/
	class Social_links extends MY_Model
	{
		/* set the table parameters */
		public $_table = 'tbl_social_links';
		public $primary_key = 'id';
		protected $soft_delete = true;
		protected $soft_delete_key = 'status';

		// get all social records which are not user yet
		public function getAllDisabled() {
			
			// query for getting all the records
			$get_records = $this->db->get_where('tbl_social_links', array('status' => '1'));
			
			// execute the query and get records array
			$result_array = $get_records->result_array();

			// return the array to the view
			return $result_array;
		}
	}
    