<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog_comment extends MY_Model {

    public $_table = 'tbl_blog_comments';
    public $primary_key = 'id';


    public function updateCommentStatus($comment_id, $status) {

    	if($status == '1') {
    		$this->db->set('status', '0');
    	} else {
    		$this->db->set('status', '1');
    	}
    	
        $this->db->where('comment_id', $comment_id);
        $this->db->update('tbl_blog_comments');
        return true;
    }

}