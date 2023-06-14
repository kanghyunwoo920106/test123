<?php
class Common_model extends CI_Model {
	public $CI = null;
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();
		$this->load->library('UserFunction');
	}

	public function get_code_member_status(){
		$qry = $this->db->select('code_detail,code_name')
			->where('code_gbn','MEMBER_STATUS')
			->where('use_yn','Y')
			->where('code_type','A')
			->order_by('sort_order', 'ASC')
			->get('tc_code');
		if( $qry->num_rows() > 0 ){
			return $qry->result_array();
		} else return array();
	}

	public function get_code_name($param){
		$qry = $this->db->select('code_name')
				->where('code_gbn', $param['code_gbn'])
				->where('code_detail', $param['code_detail'])
				->where('use_yn', 'Y')
				->limit('1')->get('tc_code');
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		} else return array();
	}

	// 인증 코드 
	public function get_auth_data($param){
		$qry = $this->db->select('ua.*, us.user_id')
			->where('ua.auth_code', $param['authcode'])
			->where('ua.auth_type', $param['auth_type'])
			->where('ua.use_yn', $param['use_yn'])
			->join('tc_user us', "ua.user_idx = us.idx AND us.user_state NOT IN ('SE', 'FE')", 'left')
			->get('tc_user_auth ua');
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	// 인증 코드 상태 변경
	public function up_auth_data($param){	
		$this->db->where('auth_code', $param['authcode'])
			->set('use_yn', $param['use_yn']);
		if( $this->db->update('tc_user_auth') ){
			return true;
		}
		else return false;
	}

	// 관리자 로그인 이력 정보 저장
	public function add_admin_login_log($param){
		$insData = array(			
			"admin_id" => $param['admin_id'],
			"login_date_time" => date("Y-m-s H:i:s"),
			"login_ip" => $this->input->ip_address(),
			"login_success_yn" => $param['success_yn']
		);
		$this->db->insert('tc_admin_login_log', $insData);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}

	// 관리자 로그인 IP로 실패 횟수 확인
	public function get_admin_login_ip_log(){
		$qry = $this->db->select('*')
				->where('login_ip', $this->input->ip_address())				
				->where('login_success_yn', 'N')
				->get('tc_admin_login_log');
		if( $qry->num_rows() > 3 ){
			return FALSE;
		} else return TRUE;
	}

	// 문서 색 적용 데이터 
	public function get_doc_color(){
		$qry = $this->db->select('code_detail, code_name')
			->where('code_gbn','DOC_COLOR')
			->where('use_yn','Y')
			->where('code_type','A')
			->order_by('sort_order', 'ASC')
			->get('tc_code');
		if( $qry->num_rows() > 0 ){
			return $qry->result_array();
		} else return array();
	}

	// 발송 LOG 
	public function add_send_mail_log($param){
		$insData = array(			
			"send_mail" => $param['send_mail'],
			"send_type" => $param['send_type'],
			"success_yn" => $param['success_yn'],
			"result_data" => json_encode($param['rlt_data'], JSON_UNESCAPED_UNICODE),
		);
		$this->db->insert('tc_mail_send_log', $insData);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}


}