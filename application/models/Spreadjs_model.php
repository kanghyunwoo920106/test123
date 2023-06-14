<?php
class Spreadjs_model extends CI_Model {
	public $CI = null;
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();
		$this->userinfo = $this->session->userdata('userinfo');
	}

	public function add_document_share_data($params) {
		// Total 점수 입력
		$sql = "
			INSERT INTO 
				tc_document_share 
			SET
				share_code = #{share_code},
                doc_id = #{doc_id},
                state = #{state},
				limit_date = DATE_ADD(NOW(), INTERVAL #{doc_limit} DAY),
                reg_date = NOW()
			 ";
		$rgBinds = array(
			'#{share_code}' => $params['share_code'],
			'#{doc_id}' => $params['doc_id'],
			'#{doc_limit}' => $params['doc_limit'],			
			'#{state}' => 'Y'
		);
		$strQuery = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);
		$this->db->query($strQuery);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		}
		else return false;
	}

	public function sel_user_document($params){
		$sql = " 
			SELECT 
				*
			FROM
				tc_document_user
			WHERE 
				doc_id = #{doc_id} ";
		$rgBinds = array(
			'#{doc_id}' => $params['doc_id']
		);
		$strQuery = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);
		$qry = $this->db->query($strQuery);
		if( $qry->num_rows() > 0 ) {
			return $qry->row_array();
		}
		else return array();
	}

	public function sel_user_document_sheet($params){
		$sql = " 
			SELECT 
				*
			FROM
				tc_document_sheet
			WHERE 
				doc_id = #{doc_id}
			AND
				state = 'Y'
			ORDER BY idx ASC ";
		$rgBinds = array(
			'#{doc_id}' => $params['doc_id']
		);
		$strQuery = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);
		$qry = $this->db->query($strQuery);
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();

	}
}