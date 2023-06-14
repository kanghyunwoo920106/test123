<?php
class Share_model extends CI_Model {
	public $CI = null;
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();
		$this->userinfo = $this->session->userdata('userinfo');
	}

	/* Document View ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	
	// 공유 정보 호출 
	public function get_share_docment($param){
		$qry = $this->db->select('ds.*, um.user_check, um.mem_name, um.mem_email')
			->join("tc_user_mem um", "ds.user_mem_idx = um.idx AND um.use_yn = 'Y'", "left")
			->get_where('tc_doc_share ds', 
				array(
					'ds.share_code'	=>	$param['share_code'], 					
					'ds.use_yn'		=>	'Y'
				)
			);
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		} else return array();		
	}

	// 공유 URL 정보 호출
	public function get_docment_share_url($param){
		$qry = $this->db->select('share_code, doc_id, reg_date')
			->get_where('tc_doc_share', 
				array(
					'doc_id'		=> $param['doc_id'],
					'share_type'	=> 'U', 	
					'use_yn'		=> 'Y'
				)
			);
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		} else return array();		
	}

	//  선택 멤버 공유 하기 정보 저장 
	public function add_document_share_data($param){		
		$sql = "
			INSERT INTO tc_doc_share 
				(share_code, share_type, user_idx, user_mem_idx, doc_id, doc_edit, sheet_id, limit_date, use_yn, reg_date) 
			VALUES 
				(#{share_code}, #{share_type}, #{user_idx}, #{user_mem_idx}, #{doc_id}, #{doc_edit}, #{sheet_id}, #{limit_date}, #{use_yn}, NOW())  
			ON DUPLICATE KEY UPDATE 
				share_code = #{share_code},  doc_edit = #{doc_edit}, sheet_id = #{sheet_id}, use_yn = #{use_yn}, limit_date = #{limit_date}";	

		$rgBinds = array(
			'#{share_code}' => $param['share_code'],
			'#{share_type}' => $param['share_type'],
			'#{user_idx}' => $param['user_idx'],
			'#{user_mem_idx}' => $param['user_mem_idx'],
			'#{doc_id}' => $param['doc_id'],
			'#{doc_edit}' => $param['doc_edit'],
			'#{sheet_id}' => $param['sheet_id'],
			'#{limit_date}' => $param['limit_date'],	
			'#{use_yn}' => 'Y'
		);
		$strQuery = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);
		$this->db->query($strQuery);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}

	// 공유 정보 
	public function get_doc_user_member_data($param){
		$qry = $this->db->select('ds.*, um.mem_name, um.mem_email, um.user_check, tu.user_img_path, tu.user_img_name')
			->order_by('idx', 'DESC')
			->limit(10, $param['s_num'])
			->join('tc_user_mem um', 'ds.user_mem_idx = um.idx', 'left')
			->join('tc_user tu', 'um.user_check = tu.idx AND um.user_check > 0', 'left')
			->get_where('tc_doc_share ds', 
				array(
					'ds.share_type' => 'M',
					'ds.user_idx' => $param["user_idx"],
					'ds.doc_id' => $param["doc_id"],
					'ds.use_yn'=>'Y'
				)
			);
		if( $qry->num_rows() > 0 ){
			return $qry->result_array();
		}else return array();
	}

	public function get_doc_user_member_share_cnt($param){
		$qry = $this->db->select('count(*) as Cnt')		
			->get_where('tc_doc_share ', 
				array(
					'share_type' => 'M',
					'user_idx' => $param["user_idx"],
					'doc_id' => $param["doc_id"],
					'use_yn' => 'Y'
				)
			);
		return $qry->result_array();
	}

	public function get_doc_user_member_share_detail($param){
		$qry = $this->db->select('*')		
			->get_where('tc_doc_share ', 
				array(
					'share_code' => $param["share_code"],
					'doc_id' => $param["doc_id"],
					'use_yn'=>'Y'
				)
			);
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	// 공유 시트 정보 업데이트 	
	public function modify_user_share_sheet_id($param){
		$data = array(
			'sheet_id' => $param['sheet_id']
		);		
		$this->db->where('share_code', $param['share_code']);
		if( $this->db->update('tc_doc_share', $data) ){
			return true;
		}
		else return false;
	}

	// 공유 멤버 삭체 처리 
	public function delete_user_mem_share($param){
		$data = array(
			'use_yn' => 'N'
		);		
		$this->db->where('share_code', $param['share_code']);
		$this->db->where('doc_id', $param['doc_id']);
		if( $this->db->update('tc_doc_share', $data) ){
			return true;
		}
		else return false;
	}

	public function add_document_share_cnt($param){
		$this->db->set('doc_share_cnt', 'doc_share_cnt+1', FALSE);
		$this->db->where('doc_id', $param['doc_id']);
		if( $this->db->update('tc_doc_info') ){
			return true;
		}
		else return false;
	}

	public function subtract_document_share_cnt($param){
		$this->db->set('doc_share_cnt', 'doc_share_cnt-1', FALSE);
		$this->db->where('doc_id', $param['doc_id']);
		if( $this->db->update('tc_doc_info') ){
			return true;
		}
		else return false;
	}

	/* Document View ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* Share View ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	// sheet 수정 정보 저장	-> 공유에서 데이터 만 수정 	
	public function modify_document_sheet($param){		
		$this->db->where('sheet_id', $param['sheet_id']);
		if( $this->db->update('tc_doc_sheet', $param['data']) ){
			return true;
		}
		else return false;
	}
	/* Share View ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
}