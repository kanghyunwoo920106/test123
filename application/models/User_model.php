<?php
class User_model extends CI_Model {
	public $CI = null;
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();
		$this->load->library('UserFunction');
		$this->admininfo = $this->session->userdata('admininfo');
	}

	// »ç¿ëÀÚ Á¤º¸ by ID
	public function get_user_data($param) {
		$qry = $this->db->select('*')->get_where('tc_user', array('user_id' => $param['userid']));
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	//  »ç¿ëÀÚ Á¤º¸ by IDX
	public function get_user_data_by_idx($user_idx) {
		$qry = $this->db->select('user.*, cd.code_name')
			->where('user.idx', $user_idx)
			->join('tc_code cd', 'cd.code_gbn ="MEMBER_STATUS" and user.user_state = cd.code_detail')
			->get('tc_user user');
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	// 회원 등록
	public function add_user_data($param){
		$insData = array(			
			'user_id' => $param['userid'],
			'user_name' => $param['usernm'],
			'user_pass' => password_hash($param['userpw'], PASSWORD_DEFAULT),
			'user_state' => $param['userst']		
		);
		$this->db->insert('tc_user', $insData);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;			
	}

	public function add_user_info_data($param){
		$insData = array(			
			'user_idx' => $param['user_idx'],
			'user_image' => $param['user_image'],
			'user_tos_1' => $param['user_tos_1'],
			'user_tos_2' => $param['user_tos_2'],
			'user_tos_3' => $param['user_tos_3']	
		);
		$this->db->insert('tc_user_info', $insData);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}
	// 회원 상태 변경
	public function up_user_state_data($param){
		$this->db->where('idx', $param['user_idx'])
			->set('user_state', $param['user_state'])
			->set('up_date', $param['up_date']);
		if( $this->db->update('tc_user') ){
			return true;
		}
		else return false;
	}

	// 메일 인증 정보 저장
	public function add_auth_data($param){
		$this->db->insert('tc_user_auth', $param);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}

	public function check_user_email($param){
		$qry = $this->db->select('*')->get_where('tc_user', array('user_id' => $param['email']));
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();
	}

	public function add_social_id($param){
		$insData = array(			
			"user_idx" => $param['user_idx'],
			"social_uid" => $param['social_uid'],
			"social_type" => $param['social_type'],
			"social_profile" => $param['profile'],
			"social_connect_date" => date('Y-m-d H:i:s')
		);
		$this->db->insert('tc_user_social', $insData);
		if($this->db->insert_id() > 0){
			return $this->db->insert_id();
		} else return false;
	}

	public function get_admin_data($param){
		$qry = $this->db->select('*')->get_where('tc_admin', array('admin_id' => $param['adminid'], 'use_yn'=>'Y'));
		if( $qry->num_rows() > 0 ){
			return $qry->row_array();
		}else return array();		
	}

	public function update_member_status($param){		
		$this->db->where('idx', $param['idx'])->set('user_state', $param['status']);
		$this->db->set ('up_date' , date('Y-m-d') );
		switch ($param['status']) {
			case 'NM':
				$data['secession_date']='';
				$this->db->set ('secession_date' , 'NULL', false );
			break;
			case 'DO':
				$data['secession_date']='';
				$this->db->set ('secession_date' , 'NULL', false );
			break;
			case 'SE':
				$data['secession_date']=date('Y-m-d');
				$this->db->set ('secession_date' , date('Y-m-d') );
			break;
			case 'FS':
				$data['secession_date']=date('Y-m-d');
				$this->db->set ('secession_date' , date('Y-m-d') );
			break;
			default:
				break;
		}
		if( $this->db->update('tc_user') ){
			$data['codename'] = $param['code_name'];
			return $data;
		} else return array();
	}

	public function update_member_name($param){
		$this->db->where('idx', $param['idx'])->set('user_name', $param['name']);
		if( $this->db->update('tc_user') ){		
			return true;
		}
		else return false;		
	}

	public function update_member_pw($param){
		$newpwd = password_hash($param['pw'], PASSWORD_BCRYPT, ["cost"=>11]);
		$this->db->where('idx', $param['idx'])->set('user_pass', $newpwd);
		if( $this->db->update('tc_user') ){			
			return true;
		}
		else return false;
	}

	public function modify_user_profile($param){
		$this->db->where('idx', $param['user_idx']);

		if(!empty($param['user_name'])){
			$this->db->set('user_name', $param['user_name']);
		}

		if(!empty($param['user_pass'])){
			$this->db->set('user_pass', $param['user_pass']);
		}

		if(!empty($param['user_img_path']) && !empty($param['user_img_name'])){
			$this->db->set('user_img_path', $param['user_img_path']);
			$this->db->set('user_img_name', $param['user_img_name']);
		}
		if($this->db->update('tc_user')){
			return true;
		}
		else return false;
	}
	
	// È¸¿ø Å»Åð »çÀ¯ ÀÔ·Â
	public function add_user_leave_data($param){

		$this->db->trans_begin();
		
		// È¸¿ø »óÅÂ º¯°æ
		$this->up_user_state_data(array(
			"user_idx" => $param['user_idx'], 
			"user_state" => $param['user_state'],
			"up_date" => date('Y-m-d H:i:s')
		));
	
		// Å»Åð »çÀ¯ ÀÔ·Â
		$this->db->insert('tc_user_leave', array(			
			"user_idx" => $param['user_idx'],
			"user_id" => $param['user_id'],
			"leave_reson" => $param['leave_reson'],
			"leave_note" => $param['leave_note'],
			"reg_date" => date('Y-m-d H:i:s')
		));

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}
}