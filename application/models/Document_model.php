<?php
class Document_model extends CI_Model {
	public $CI = null;
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();
		$this->load->library('UserFunction');
	}

	/* Document ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	// 문서 기본정보 등록
	public function add_document_info($param) {		
		$this->db->insert('tc_doc_info', 
			array(
				'doc_id'		=> $param['doc_id'],
				'user_idx'		=> $param['user_idx'],
				'doc_title'		=> $param['doc_title'],
				'doc_type'		=> $param['doc_type'],
				'tem_id'		=> $param['tem_id'],
				'doc_color'		=> $param['doc_color'],
				'doc_share_cnt' => $param['doc_share_cnt'],
				'use_yn'		=> $param['use_yn'],
				'reg_date'		=> $param['reg_date'],
			)
		);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}
	// 문서 문서 뎅터 등록
	public function add_document_data($param) {
		$this->db->insert('tc_doc_data', 
			array(
				'doc_id'		=> $param['doc_id'],
				'doc_data'		=> $param['doc_data'],
				'use_yn'		=> $param['use_yn'],
				'reg_date'		=> $param['reg_date'],
			)
		);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}

	//  문서 메모 등록
	public function add_document_memo($param){
		$sql = "
			INSERT INTO tc_doc_memo 
				(doc_id, user_idx, doc_memo, use_yn, reg_date) 
			VALUES 
				(#{doc_id}, #{user_idx}, #{doc_memo}, #{use_yn}, NOW())  
			ON DUPLICATE KEY UPDATE 
				doc_memo = #{doc_memo}, use_yn = #{use_yn}, up_date = NOW()";
		$rgBinds = array(
			'#{doc_id}'		=> $param['doc_id'],
			'#{user_idx}'	=> $param['user_idx'],
			'#{doc_memo}'	=> $param['doc_memo'],
			'#{use_yn}'		=> $param['use_yn'],
		);
		$strQuery = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);
		$this->db->query($strQuery);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}
	
	// 문서 sheet data 등록
	public function add_document_sheet_data($param){
		//ini_set("memory_limit","2048M");
		//$this->userfunction->fnWriteLog("[write] query_11", '', true);
		$sql = "
			INSERT INTO tc_doc_sheet 
				(doc_id, sheet_id, sheet_name, sheet_data, use_yn, reg_date) 
			VALUES 
				(#{doc_id}, #{sheet_id}, #{sheet_name}, #{sheet_data}, #{use_yn}, NOW())  
			ON DUPLICATE KEY UPDATE 
				sheet_data = #{sheet_data}, use_yn = #{use_yn}, up_date = NOW()";
		$rgBinds = array(
			'#{doc_id}'		=> $param['doc_id'],
			'#{sheet_id}'	=> $param['sheet_id'],
			'#{sheet_name}'	=> $param['sheet_name'],
			'#{sheet_data}'	=> $param['sheet_data'],
			'#{use_yn}'		=> $param['use_yn'],
		);
		$strQuery = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);
		$this->db->query($strQuery);
		if($this->db->insert_id() > 0){
			return true;
		} else return false;
	}

	public function add_document_sheet_dt_data($param){
		$sql = "
			INSERT INTO tc_doc_sheet_data 
				(sheet_id, dt_x, dt_y, dt_data) 
			VALUES 
				(#{sheet_id}, #{dt_x}, #{dt_y}, #{dt_data})  
			ON DUPLICATE KEY UPDATE 
				dt_data = #{dt_data}";
		$rgBinds = array(			
			'#{sheet_id}'	=> $param['sheet_id'],
			'#{dt_x}'		=> $param['dt_x'],
			'#{dt_y}'		=> $param['dt_y'],
			'#{dt_data}'	=> $param['dt_data']
		);
		$strQuery = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);
		$this->db->query($strQuery);
		if($this->db->insert_id() > 0){
			return true;
		} else return false;
	}

	// 문서 수정 정보 저장
	public function add_document_history_data($param) {
		$this->db->insert('tc_doc_history', $param);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}

	// 문서 수정 정보 sheet 정보 저장
	public function add_document_history_sheet_data($param){
		$this->db->insert('tc_doc_history_sheet', $param);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}
	/* Document ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* Document View ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */

	// doc 정보
	public function get_document_info($param){
		$qry = $this->db->select('df.*, tc.code_name as doc_color_dt, dt.doc_data')
			->where('df.doc_id', $param['doc_id'])
			->where('df.user_idx', $param['user_idx'])
			->where('df.use_yn', 'Y')
			->join('tc_code tc', 'tc.code_gbn = "DOC_COLOR" AND df.doc_color = tc.code_detail', 'left')
			->join('tc_doc_data dt', 'dt.doc_id = df.doc_id', 'left')
			->get('tc_doc_info df');

		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	public function get_document_doc_id($param){
		$qry = $this->db->select('df.*, tc.code_name as doc_color_dt, dt.doc_data')
			->where('df.doc_id', $param['doc_id'])
			->where('df.use_yn', 'Y')
			->join('tc_code tc', 'tc.code_gbn = "DOC_COLOR" AND df.doc_color = tc.code_detail', 'left')
			->join('tc_doc_data dt', 'dt.doc_id = df.doc_id', 'left')
			->get('tc_doc_info df');

		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	public function get_document_memo($param){
		$qry = $this->db->select('doc_memo')
			->get_where('tc_doc_memo', 
				array(
					'doc_id'	=> $param['doc_id'], 
					'user_idx'	=> $param['user_idx'], 
					'use_yn'	=> 'Y'
				)
			);
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	// doc sheet 정보
	public function get_document_sheet($param){
		$qry = $this->db->select('*')
			->order_by('idx', 'ASC')
			->get_where('tc_doc_sheet', 
				array(
					'doc_id' => $param['doc_id'], 
					'use_yn'=>'Y'
				)
			);		

		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	public function get_document_sheet_dt($param){
		$qry = $this->db->select('*')
			->order_by('idx', 'ASC')
			->get_where('tc_doc_sheet_data', 
				array(
					'sheet_id' => $param['sheet_id']
				)
			);		

		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	/****** modify ******/
	// 문서 삭제
	public function delete_document($param){
		$data = array(
			'use_yn' => 'N'
		);
		$this->db->where('doc_id', $param['doc_id']);
		$this->db->where('user_idx', $param['user_idx']);
		if( $this->db->update('tc_doc_info', $data) ){
			$this->db->set('use_yn', 'N')->where('doc_id', $param['doc_id'])->update('tc_doc_sheet');
			$this->db->set('use_yn', 'N')->where('doc_id', $param['doc_id'])->update('tc_doc_share');
			return true;
		}
		else return false;
	}

	// doc 수정 정보 저장 
	public function modify_document_info($param){
		$data = array(
			'doc_title' => $param['doc_title'],			
			'doc_color' => $param['doc_color'],
			'up_date' => date('Y-m-d H:i:s')
		);
		$this->db->where('doc_id', $param['doc_id']);
		$this->db->where('user_idx', $param['user_idx']);
		if( $this->db->update('tc_doc_info', $data) ){
			return true;
		}
		else return false;
	}

	public function modify_document_data($param){
		$data = array(			
			'doc_data' => $param['doc_data']
		);
		$this->db->where('doc_id', $param['doc_id']);
		if( $this->db->update('tc_doc_data', $data) ){
			return true;
		}
		else return false;
	}

	// 문서의 속한 시트 상태 변경
	public function change_sheet_all_yn($param){
		$data = array(
			'use_yn'	=> $param['use_yn'],				
			'up_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('doc_id', $param['doc_id']);
		if( $this->db->update('tc_doc_sheet', $data) ){
			return true;
		}
		else return false;
	}

	// sheet 수정 정보 저장	
	public function modify_document_sheet($param){	
		$this->db->where('sheet_id', $param['sheet_id']);
		if( $this->db->update('tc_doc_sheet', $param['data']) ){
			return true;
		}
		else return false;
	}
	/* Document View ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* Document Share ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	// doc sheet 정보
	public function get_document_user_sheet($param){
		$qry = $this->db->select('*')
			->order_by('idx', 'ASC')
			->get_where('tc_doc_sheet', 
				array(
					'doc_id' => $param['doc_id'], 
					'use_yn'=>'Y'
				)
			);		

		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	// doc Sheet 상세 정보 
	public function get_documet_sheet_detail($param){
		$qry = $this->db->select('*')
			->get_where('tc_doc_sheet', 
				array(
					'doc_id' => $param['doc_id'], 
					'sheet_id' => $param['sheet_id'], 
					'use_yn'=>'Y'
				)
			);		
		if( $qry->num_rows() > 0 ) {
			return $qry->row_array();
		}
		else return array();
	}

	/* Document Share ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* MY Document ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */

	// 내 문서 리스트 
	public function get_my_document_list($param){
		$where_str = "";

		if($param['doc_color'] != 'all'){
			$where_str = " AND du.doc_color = '".$param['doc_color']."' ";
		}

		switch($param['doc_type']){
			case 'A' :
			default:
				$str_data_from = "(
					SELECT 
						doc_id,	
						up_date AS r_date,
						'M' AS dtype,
						'N' AS share_code
					FROM 
						tc_doc_info
					WHERE 
						user_idx = #{user_idx}
					AND
						use_yn= 'Y'
					UNION ALL
					SELECT 
						us.doc_id,
						us.reg_date AS r_date,
						'S' AS dtype,
						us.share_code
					FROM 
						(
							SELECT 
								idx
							FROM 
								tc_user_mem
							WHERE 
								user_check = #{user_idx}
						) um 
						INNER JOIN tc_doc_share us ON um.idx = us.user_mem_idx
					WHERE 
						us.use_yn= 'Y'
				) a	";
				break;
			case 'M' :
				$str_data_from = "(
					SELECT 
						doc_id,	
						up_date AS r_date,
						'M' AS dtype,						
						'N' as share_code
					FROM 
						tc_doc_info
					WHERE 
						user_idx = #{user_idx}
					AND
						use_yn= 'Y' ) a";
				break;
			case 'S' :
				$str_data_from = "(
					SELECT 
						us.doc_id,
						us.reg_date AS r_date,
						'S' AS dtype,
						us.share_code
					FROM 
						(
							SELECT 
								idx
							FROM 
								tc_user_mem
							WHERE 
								user_check = #{user_idx}
						) um 
						INNER JOIN tc_doc_share us ON um.idx = us.user_mem_idx
					WHERE 
						us.use_yn= 'Y' ) a";
				break;
		}
		$sql = "
			SELECT 
				aa.dtype,
				aa.share_code,
				du.idx, 
				du.user_idx, 
				du.doc_id, 
				du.doc_title,
				du.doc_share_cnt,
				dm.doc_memo, 
				date_format(du.reg_date, '%Y-%m-%d') as reg_date, 
				date_format(du.up_date, '%Y-%m-%d') as up_date, 
				tc.code_name, 
				tu.user_name,
				date_format(aa.r_date, '%Y-%m-%d') as r_date
			FROM 
				(
					SELECT 
						DISTINCT a.doc_id,
						a.r_date,
						a.dtype,
						a.share_code
					FROM ".$str_data_from."
				) aa INNER JOIN tc_doc_info du ON aa.doc_id = du.doc_id 
				LEFT JOIN tc_doc_memo dm ON dm.user_idx = #{user_idx} AND aa.doc_id = dm.doc_id
				LEFT JOIN tc_code tc ON tc.code_gbn = 'doc_color' AND du.doc_color = tc.code_detail
				LEFT JOIN tc_user tu ON du.user_idx = tu.idx
			WHERE 
				1=1 ".$where_str."
			ORDER BY aa.r_Date ".$param['doc_order']."
			LIMIT #{s_num}, 10	";
		
		$rgBinds = array(
			'#{user_idx}'	=> $param['user_idx'],
			'#{s_num}'		=> $param['s_num'],				
		);
		$strQry = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);		
		$qry = $this->db->query($strQry);
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();		
	}
	// 내 문서 수정
	public function modify_user_document($param){		
		$this->db->where('doc_id', $param['doc_id']);
		$this->db->where('user_idx', $param['user_idx']);
		if( $this->db->update('tc_doc_info', $param['data']) ){
			return true;
		}
		else return false;
	}
	/* MY Document ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* History ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */

	// history 리스트 
	public function get_doc_history_list($param){
		$qry = $this->db->select("idx, his_info, user_idx, doc_id, reg_date")
			->order_by('reg_date', 'DESC')
			->get_where('tc_doc_history', 
				array(
					'doc_id'	=> $param['doc_id']					
				)
			);		
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	public function get_doc_history_data($param){
		$qry = $this->db->select('*')
			->get_where('tc_doc_history', 
				array(					
					'idx' => $param['his_id'],
					'doc_id' => $param['doc_id'],
					'user_idx' => $param['user_idx']
				)
			);		
		if( $qry->num_rows() > 0 ) {
			return $qry->row_array();
		}
		else return array();
	}

	public function get_doc_history_sheet($param){
		$qry = $this->db->select('*')
			->order_by('reg_date', 'ASC')
			->get_where('tc_doc_history_sheet', 
				array(
					'his_idx' => $param['his_id'], 
					'doc_id' => $param['doc_id']
				)
			);		
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	/* History ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */

	/* Template ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */

	// 
	public function get_template_category($param){
		$qry = $this->db->select('*')
			->order_by('sort', 'ASC')
			->get_where('tc_template_category', 
				array(
					'cate' => $param['cate_num'],
					'cate_type' => $param['cate_type'],
					'use_yn' => 'Y',
				)
			);		
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	// Template LIST
	public function get_template_list($param){
		$where_str = '';
		$where_sub_str = '';
		$where_search_str = '';

		if(!empty($param['search_title'])){
			$where_search_str .= " AND tem_title LIKE '%".$param['search_title']."%'";
		}

		if(!empty($param['lcate'])){
			$where_str .= " AND l_cate = ".$param['lcate'];
		}

		if(!empty($param['mcate'])){
			$where_str .= " AND m_cate = ".$param['mcate'];			
		}

		if(!empty($param['scate'])){
			$where_str .= " AND s_cate = ".$param['scate'];	
		}


		$strQuery = "
			SELECT 
				b.idx,
				b.tem_id,
				b.tem_title,
				b.tem_memo,
				b.img_path,
				b.img_name,
				date_format(b.reg_date, '%Y-%m-%d') as reg_date,
				c.cate_name
			FROM 
				(					
					SELECT
						ba.tem_idx, MIN(ba.l_cate) AS l_cate
					FROM 
						(
							SELECT
								tem_idx, l_cate
							FROM 
								tc_doc_template_category
							WHERE 
								use_yn = 'Y'
							AND 
								tem_idx > 0
							".$where_str."
						) ba GROUP BY tem_idx
				) a 
				INNER JOIN tc_doc_template b ON a.tem_idx = b.idx 
				LEFT JOIN tc_template_category c ON a.l_cate = c.idx 
			WHERE 
				b.use_yn = 'Y'
				".$where_search_str."
			ORDER BY b.tem_sort ". $param['doc_order'].", b.idx DESC
			LIMIT ".$param['s_num'].", 10";
		$qry = $this->db->query($strQuery);			
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	// Template 상세 정보 
	public function get_template_data($param){
		$qry = $this->db->select('*')
			->get_where('tc_doc_template', 
				array(
					'tem_id' => $param['tem_id'],
					'use_yn' => 'Y'
				)
			);		
		if( $qry->num_rows() > 0 ) {
			return $qry->row_array();
		}
		else return array();
	}

	/* Template ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
}