<?php
class Social_model extends CI_Model {
	public $CI = null;
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();		
	}

	public function check_social_id($params){
		$qry = $this->db->select('*')->get_where('tc_user_social', array('social_uid' => $params['social_uid'], "social_type" => $params['social_type']));
		if( $qry->num_rows() > 0 ){
			return $qry->result_array();
		}else return array();
	}	
}