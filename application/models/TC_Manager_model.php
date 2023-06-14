<?php
class TC_Manager_model extends CI_Model {
	public $CI = null;
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();		
	}

	public function get_admin_menu_main(){
		$qry = $this->db->select('*')			
			->where('use_yn','Y')
			->where('cate_type','m')
			->order_by('sort')
			->get('tc_admin_menu');
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	public function get_admin_menu_sub($param){
		$qry = $this->db->select('*')
			->where('use_yn','Y')
			->where('cate_type','s')
			->where('cate',$param['cate'])
			->order_by('sort')
			->get('tc_admin_menu');
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	/* 회원 관리 ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	private function str_member_list_sql($param, $count) {
		$sql_from = " 
			FROM 
				tc_user 
			WHERE
				user_state NOT IN ('SE', 'FS ') ";
		$sql_where ='';
		if($count == 'N'){
			$sql_add =  "
				ORDER BY ".$param['tabledata']['order']." ".$param['tabledata']['order_dir']."
				LIMIT ".$param['tabledata']['start'].", ".$param['tabledata']['length'];
			return $sql_from.$sql_where.$sql_add;
		}
		else {
			return $sql_from.$sql_where;
		}
	}

	public function get_member_list($param){				
		$sql = ' SELECT * ';
		$sql .= $this->str_member_list_sql($param, 'N');
		$qry = $this->db->query($sql);		
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	public function get_member_list_cnt($param){				
		$sql = 'SELECT IFNULL(count(1),0) AS cnt';
		$sql .= $this->str_member_list_sql($param, 'Y');
		$qry = $this->db->query($sql);
		return $qry->row_array();
	}

	private function str_user_mem_list_sql($param, $count) {
		$sql_from = " 
			FROM 
				tc_user_member a
				LEFT JOIN tc_doc_info b ON a.user_idx = b.idx   
			WHERE 
				1 = 1 ";
		$sql_where ='';
		if($count == 'N'){
			$sql_add = "
				ORDER BY ".$param['tabledata']['order']." ".$param['tabledata']['order_dir']."
				LIMIT ".$param['tabledata']['start'].", ".$param['tabledata']['length'];
			return $sql_from.$sql_where.$sql_add;
		}
		else {
			return $sql_from.$sql_where;
		}
	}


	public function get_user_mem_list($param){
		$sql = ' SELECT a.*  ';
		$sql .= $this->str_user_mem_list_sql($param, 'N');
		$qry = $this->db->query($sql);		
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	public function get_user_mem_list_cnt($param){
		$sql = 'SELECT IFNULL(count(1),0) AS cnt';
		$sql .= $this->str_user_mem_list_sql($param, 'Y');
		$qry = $this->db->query($sql);
		return $qry->row_array();		
	}
	/* 회원 관리 ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */

	/* 공지 사항 ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	private function str_notice_list_sql($param, $count) {
		$sql_from = "
			FROM 
				tc_common_board 
			WHERE 
				category = 'N' 
			AND
				use_yn = 'Y'";
		$sql_where ='';	
		if($count == 'N'){
			$sql_add = "
				ORDER BY ".$param['tabledata']['order']." ".$param['tabledata']['order_dir']."
				LIMIT ".$param['tabledata']['start']." , ".$param['tabledata']['length'];
			return $sql_from.$sql_where.$sql_add;
		}
		else {
			return $sql_from.$sql_where;
		}
	}

	public function get_notice_list($param){				
		$sql = ' SELECT * ';
		$sql .= $this->str_notice_list_sql($param, 'N');
		$qry = $this->db->query($sql);		
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	public function get_notice_list_cnt($param){				
		$sql = 'SELECT IFNULL(count(1),0) AS cnt';
		$sql .= $this->str_notice_list_sql($param, 'Y');
		$qry = $this->db->query($sql);
		return $qry->row_array();
	}

	public function get_board_content($param) {
		$qry = $this->db->select('*')->get_where('tc_common_board', array('idx' => $param['board_idx'], 'use_yn'=>'Y'));
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	// 공지사항 등록 
	public function add_notice_prc($params){
		$add_params = array(
			'category' => 'N',
			'title' => $params['notice_title'],
			'contents' => nl2br($params['notice_content']),
			'use_yn' => 'Y',
			'reg_date' => date('Y-m-d H:i:s')
		);
		$ret = $this->db->insert('tc_common_board',$add_params);
		if( $this->db->insert_id() > 0 ){
			return true;
		}
		else return false;
	}
	/* 공지사항 ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */

	/* 문서 관리 ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	private function str_doc_user_list_sql($param, $count) {
		$sql_from = "
			FROM 
				tc_doc_info 
			WHERE
				use_yn = 'Y'";
		$sql_where ='';	
		if($count == 'N'){
			$sql_add = "
				ORDER BY ".$param['tabledata']['order']." ".$param['tabledata']['order_dir']."
				LIMIT ".$param['tabledata']['start']." , ".$param['tabledata']['length'];
			return $sql_from.$sql_where.$sql_add;
		}
		else {
			return $sql_from.$sql_where;
		}
	}

	public function get_doc_user_list($param){
		$sql = ' SELECT * ';
		$sql .= $this->str_doc_user_list_sql($param, 'N');
		$qry = $this->db->query($sql);		
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();

	}

	public function get_doc_user_list_cnt($param){
		$sql = 'SELECT IFNULL(count(1),0) AS cnt';
		$sql .= $this->str_doc_user_list_sql($param, 'Y');
		$qry = $this->db->query($sql);
		return $qry->row_array();

	}

	public function get_document_info($param){
		$qry = $this->db->select('df.*, tc.code_name as doc_color_dt, dt.doc_data')
			->where('df.idx', $param['doc_idx'])			
			->where('df.use_yn', 'Y')
			->join('tc_code tc', 'tc.code_gbn = "DOC_COLOR" AND df.doc_color = tc.code_detail', 'left')
			->join('tc_doc_data dt', 'dt.doc_id = df.doc_id', 'left')
			->get('tc_doc_info df');
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	public function get_document_user_sheet($param){
		$qry = $this->db->select('*')
			->order_by('idx', 'ASC')
			->get_where('tc_doc_sheet', array('doc_id' => $param['doc_id'], 'use_yn'=>'Y'));		
		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	public function get_template_list($param){


		$where_str = '';
		$where_sub_str = '';
		if(!empty($param['lcate'])){
			$where_str .= " AND l_cate = ".$param['lcate'];
		}

		if(!empty($param['mcate'])){
			$where_str .= " AND m_cate = ".$param['mcate'];			
		}

		if(!empty($param['scate'])){
			$where_str .= " AND s_cate = ".$param['scate'];	
		}

		if(!empty($param['search'])){
			$where_sub_str .= " AND tem_title like '%".$param['search']."%'";
		}

		$strQuery = "
			SELECT 				
				b.*
			FROM 
				(
					SELECT
						DISTINCT tem_idx
					FROM 
						tc_doc_template_category
					WHERE 
						use_yn = 'Y'
						".$where_str."
				) a 
				INNER JOIN tc_doc_template b ON a.tem_idx = b.idx 
				WHERE 
					b.use_yn = 'Y'
				".$where_sub_str."
			ORDER BY tem_sort ASC";
		$qry = $this->db->query($strQuery);

		if( $qry->num_rows() > 0 ) {
			return $qry->result_array();
		}
		else return array();
	}

	public function add_template_document($param){
		// Total 점수 입력
		$sql = "
			INSERT INTO 
				tc_doc_template 
			SET
				tem_id = #{tem_id},				
                tem_title = #{tem_title},   
                tem_data = #{tem_data},
				tem_memo = #{tem_memo},
                img_path = #{img_path},
				img_name = #{img_name},
                use_yn = 'Y',
                reg_date = NOW()
			 ";		
		$rgBinds = array(
			'#{tem_id}' => $this->userfunction->fnStrUniqId('template'),			
			'#{tem_title}' => $param['tem_title'],
			'#{tem_data}' => $param['tem_data'],
			'#{tem_memo}' => $param['tem_memo'],
			'#{img_path}' => $param['img_path'],
			'#{img_name}' => $param['img_name'],
			'#{use_yn}' => 'Y'
		);		
		$strQuery = $this->userfunction->fnBindParam($this->db, $sql, $rgBinds);
		$this->db->query($strQuery);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		}
		else return false;
	}

	// 템플릿 수정 
	public function modify_template_document($param){
		$data = array(
			'tem_title' => $param['template_title'],
			'tem_data' => $param['template_data'],
			'tem_memo' => $param['template_memo']
		);

		if($param['img_path'] && $param['img_name']){
			$data['img_path'] = $param['img_path'];
			$data['img_name'] = $param['img_name'];
		}
		$this->db->where('idx', $param['template_idx']);
		if( $this->db->update('tc_doc_template', $data) ){
			return true;
		}
		else return false;
	}

	// 템플릿 삭제 처리 
	public function up_template_use($param){
		$data = array(		
			'use_yn' => $param['use_yn']
		);
		$this->db->where('idx',$param['idx']);
		if( $this->db->update('tc_doc_template', $data) ){
			return true;
		}
		else return false;

	}

	// 템플릿 카테고리 정보 
	public function add_template_cate($param){
		$this->db->insert('tc_doc_template_category', $param);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}
	

	public function up_template_sort($param){
		$data = array(		
			'tem_sort' => $param['sort']
		);
		$this->db->where('idx',$param['idx']);
		if( $this->db->update('tc_doc_template', $data) ){
			return true;
		}
		else return false;
	}
	
	// 템플릿 카테고리 리스트
	public function get_template_detail_category($param){
		$qry = $this->db->select("
			idx,
			tem_idx,
			l_cate,
			(SELECT cate_name FROM tc_template_category WHERE idx =  l_cate AND use_yn = 'Y') AS l_cate_name,
			m_cate,
			(SELECT cate_name FROM tc_template_category WHERE idx =  m_cate AND use_yn = 'Y') AS m_cate_name,
			s_cate,
			(SELECT cate_name FROM tc_template_category WHERE idx =  s_cate AND use_yn = 'Y') AS s_cate_name
		")
			->get_where('tc_doc_template_category', array('tem_idx'=> $param['idx'], 'use_yn'=>'Y'));
		if( $qry->num_rows() > 0 ){
			return $qry->result_array();
		}else return array();		
	}

	// 선택 분류 정보
	public function get_template_category_by_idx($param){
		$qry = $this->db->select('*')->get_where('tc_doc_template_category', array('idx' => $param['idx'], 'use_yn'=>'Y'));
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}
	
	// 템플릿 상세 내용
	public function get_template_detail($param){
		$qry = $this->db->select('*')->get_where('tc_doc_template', array('idx' => $param['idx'], 'use_yn'=>'Y'));
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	public function get_category_list($param){
		$qry = $this->db->select('*')->order_by('sort')->get_where('tc_template_category', array('cate' => $param['cate_idx'], 'use_yn'=>'Y'));
		if( $qry->num_rows() > 0 ){
			return $qry->result_array();
		}else return array();
	}	

	public function get_category_detail($param){
		$qry = $this->db->select('*')->get_where('tc_template_category', array('idx'=> $param['idx'], 'use_yn'=>'Y'));
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();		
	}

	public function change_template_cate_name($param){
		$data = array(
			'cate_name' => $param['cate_name'],
			'up_date' => date('Y-m-s H:i:s')
		);
		$this->db->where('idx',$param['idx']);
		if( $this->db->update('tc_template_category', $data) ){
			return true;
		}
		else return false;
	}

	// 카테고리 추가
	public function add_template_category($param){
		$insData = array(			
			'cate' => $param['cate'],
			'cate_type' => $param['cate_type'],
			'cate_name' =>  $param['cate_name'],
			'active_code' =>  $param['active_code'],
			'use_yn' => 'Y',
			'reg_date' => date('Y-m-s H:i:s')
		);
		$this->db->insert('tc_template_category', $insData);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}

	public function del_template_cate($param){
		$data = array(
			'use_yn' => 'N',
			'up_date' => date('Y-m-s H:i:s')
		);
		$this->db->where('idx',$param['idx']);
		if( $this->db->update('tc_template_category', $data) ){
			return true;
		}
		else return false;
	}
	public function up_template_category_main_sort($param){
		$data = array(
			'sort' => $param['sort'],
			'up_date' => date('Y-m-s H:i:s')
		);
		$this->db->where('idx',$param['idx']);
		if( $this->db->update('tc_template_category', $data) ){
			return true;
		}
		else return false;
	}

	// 기존 템플릿 문서에 카테고리 추가 
	public function add_doc_templay_category($param){
		$insData = array(			
			'tem_idx' => $param['tem_idx'],
			'l_cate' => $param['l_cate'],
			'm_cate' =>  $param['m_cate'],
			's_cate' =>  $param['s_cate'],
			'use_yn' => 'Y'
		);
		$this->db->insert('tc_doc_template_category', $insData);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}

	// 기존 템플릿 문서에 카테고리 수정 
	public function up_doc_templay_category($param){
		$data = array(
			'l_cate' => $param['l_cate'],
			'm_cate' => $param['m_cate'],
			's_cate' => $param['s_cate'],
		);
		$this->db->where('idx',$param['idx']);
		if( $this->db->update('tc_doc_template_category', $data) ){
			return true;
		}
		else return false;
	}

	// 기존 템플릿 문서에 카테고리 삭제 
	public function del_doc_template_category($param){
		$this->db->where('idx', $param['idx']);
		if( $this->db->update('tc_doc_template_category', ['use_yn' => 'N']) ){
			return true;
		}
		else return false;
	}

	
	/* 문서 관리 ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */

}