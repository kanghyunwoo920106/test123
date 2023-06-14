<?php
class Main_model extends CI_Model {
	public $CI = null;
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();
		$this->userinfo = $this->session->userdata('userinfo');
	}

	public function get_main_template_list(){
		$strQuery = "
			SELECT 
				aa.idx,
				aa.tem_id,
				aa.tem_title,
				aa.tem_memo,
				aa.img_path,
				aa.img_name,
				date_format(aa.reg_date, '%Y-%m-%d') as reg_date,
				aa.tem_sort,
				bb.cate_name
			FROM 
				(
					SELECT 
						a.*,	
						( SELECT l_cate FROM tc_doc_template_category  WHERE a.idx = tem_idx LIMIT 1) AS l_cate
					FROM 
						tc_doc_template a	
						
					WHERE 
						a.use_yn = 'Y'
					ORDER BY a.tem_sort ASC
					LIMIT 11
				) aa 
				LEFT JOIN tc_template_category bb ON aa.l_cate =  bb.idx";
		$qry = $this->db->query($strQuery);
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}


	public function get_main_user_doc_list($param){
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
				tc.code_name as doc_color, 
				tu.user_name,
				date_format(aa.r_date, '%Y-%m-%d') as r_date
			FROM 
				(
					SELECT 
						DISTINCT a.doc_id,
						a.r_date,
						a.dtype,
						a.share_code
					FROM (
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
					) a
				) aa INNER JOIN tc_doc_info du ON aa.doc_id = du.doc_id 
				LEFT JOIN tc_doc_memo dm ON du.user_idx = #{user_idx} AND  aa.doc_id = dm.doc_id
				LEFT JOIN tc_code tc ON tc.code_gbn = 'doc_color' AND du.doc_color = tc.code_detail
				LEFT JOIN tc_user tu ON du.user_idx = tu.idx
			WHERE 
				1=1 
			ORDER BY aa.r_date DESC
			LIMIT 0, 11 ";
		
		$rgBinds = array(
			'#{user_idx}'	=> $param['user_idx']	
		);
		$strQry = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);		
		$qry = $this->db->query($strQry);
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}
}