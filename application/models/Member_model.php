<?php
class Member_model extends CI_Model {
	public $CI = null;
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();
		$this->load->library('UserFunction');
	}

	// 주소록 추가	
	public function add_user_member($param){
		$sql = "
			INSERT INTO tc_user_mem 
				(user_idx, user_check, mem_name, mem_email, mem_memo, use_yn, reg_date) 
			VALUES 
				(#{user_idx}, #{user_check}, #{mem_name}, #{mem_email}, #{mem_memo}, #{use_yn}, NOW())  
			ON DUPLICATE KEY UPDATE 
				mem_name = #{mem_name}, use_yn = #{use_yn}, up_date = NOW()";
		$rgBinds = array(
			'#{user_idx}'	=> $param['user_idx'],
			'#{user_check}'	=> $param['user_check'],
			'#{mem_name}'	=> $param['mem_name'],
			'#{mem_email}'	=> $param['mem_email'],
			'#{mem_memo}'	=> $param['mem_memo'],
			'#{use_yn}'		=> $param['use_yn']
		);
		$strQry = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);
		$this->db->query($strQry);		
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}

	// 회원 주소록 리스트 
	public function get_user_member_list($param){
		$qry = $this->db->select("um.*, us.idx as user_idx, us.user_name, us.user_img_path, us.user_img_name")
			->order_by($param['order_tar'], $param['order_type'])
			->limit(10, $param['s_num'])
			->join('tc_user us', "um.user_check = us.idx AND us.user_state IN ('NM', 'DO', 'TM')", 'left')
			->get_where("tc_user_mem um", array('um.user_idx' => $param['user_idx'], 'um.use_yn'=>'Y'));
		if( $qry->num_rows() > 0 ){
			return $qry->result_array();
		}else return array();
	}

	// 주소록 총 건수 
	public function get_user_member_cnt($param){
		$qry = $this->db->select('count(*) as cnt')
			->where('user_idx', $param['user_idx'])
			->where('use_yn', 'Y')
			->get('tc_user_mem');
		return $qry->row_array();
	}
	
	public function check_user_data($param){
		$qry = $this->db->select('idx, user_id')
			->where('user_id', $param['user_id'])
			->where_in('user_state', ['NM', 'DO', 'TM'])
			->get('tc_user');
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}
	
	// 주소록 정보 변경
	public function up_user_member($param){
		$this->db->where('idx', $param['mem_idx']);
		$this->db->where('user_idx', $param['user_idx']);
		if( $this->db->update('tc_user_mem', $param['up_data']) ){
			return true;
		}
		else return false;
	}

	

	// 주소록 삭제
	public function del_user_member($param){
		$this->db->where('idx', $param['mem_idx']);
		$this->db->where('user_idx', $param['user_idx']);
		if( $this->db->update('tc_user_mem', ['use_yn' => $param['use_yn']]) ){
			return true;
		}
		else return false;
	}

	// 선택 주소록 다중 삭제
	public function del_chval_user_member($param){
		$this->db->where_in('idx', $param['mem_idx_txt']);
		$this->db->where('user_idx', $param['user_idx']);
		if( $this->db->update('tc_user_mem', ['use_yn' => $param['use_yn']]) ){
			return true;
		}
		else return false;
	}

	// 주소록 상세 정보
	public function get_user_member_detail($param){
		$qry = $this->db->select('*')
			->where('idx', $param['mem_idx'])
			->where('user_idx', $param['user_idx'])
			->where('use_yn', 'Y')
			->get('tc_user_mem');
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	/* Document View ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	// 회원 주소록 리스트 
	public function get_modal_user_member_list($param){
		$sql = "
				SELECT 
					a.*
				FROM 
					(
						SELECT 
							*
						FROM 
							tc_user_mem
						WHERE 
							user_idx = #{user_idx}
						AND 
							use_yn = 'Y'
					) a LEFT JOIN 
					(
						SELECT 
							user_mem_idx
						FROM 
							tc_doc_share
						WHERE 
							doc_id = #{document_id}
						AND 
							use_yn = 'Y'
					) b ON a.idx = b.user_mem_idx
				WHERE b.user_mem_idx IS NULL ";
		$rgBinds = array(
			'#{document_id}' => $param['doc_id'],
			'#{user_idx}' => $param['user_idx']
		);
		$strQuery = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);
		$qry = $this->db->query($strQuery);
		if( $qry->num_rows() > 0 ){
			return $qry->result_array();
		}else return array();
	}

	/* Document View ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */

	/* Common ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	// 내 ID를 등록한 주소록 리스트 
	public function get_user_member_email_check_data($param){
		$qry = $this->db->select('*')			
			->where('mem_email', $param['user_id'])
			->where('use_yn', 'Y')
			->get('tc_user_mem');
		if( $qry->num_rows() > 0 ){
			return $qry->result_array();
		}else return array();

	}

	/* Common ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
}