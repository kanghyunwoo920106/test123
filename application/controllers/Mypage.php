<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mypage extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('UserFunction');
		$this->load->library('Common_lib');
		$this->common_lib->login_check();
		
		$this->load->library('User_lib');	
   }
   public function _remap($method)	{
		if(method_exists($this, $method)) {
			$userinfo = $this->session->userdata('userinfo');			
			if(strpos($method, '_prc') == TRUE) {
				$this->{$method}();
			} else {
				$rgStyleSheet = array();
				$rgJavaScript = array();

				$strHeadType = 'head';
				$strTailType = 'footer';

				$rgStyleSheet[] = ADMIN_TEMPLATE_PATH.'animate.css/animate.min.css';
				$rgStyleSheet[] = CSS_PATH.'custom.css';

				if($method == 'profile'){				
					$rgJavaScript[] = '/resources/js/mypage/'.$method.'.js';
				} else {				
				}

				$rgHeader = array(
					"h_Title"			=> 'TeemCell Test',
					"h_StyleSheet"		=> $rgStyleSheet,					
					"user_data"			=> $userinfo
				);				

				$rgFooter = array(
					"f_JavaScript" 		=> $rgJavaScript
				);

				$this->load->view('include/'.$strHeadType, $rgHeader);			
				$this->{$method}();
				$this->load->view('include/'.$strTailType, $rgFooter);
			}
		} else  {
			show_404();
		}
	}
	/* Profile ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	public function profile(){		
		$res = $this->user_lib->get_user_data();

		if($res['code'] == '200'){			
			$data = $res['data'];
			$this->load->view('mypage/profile', $data);
		} else {
			$this->session->unset_userdata('userinfo');
			header('Location: /login', TRUE, null);
		}
	}

	// 프로필 이미지 변경
	public function change_profile_img_prc(){
		$param = array(			
			'FILES' => $_FILES
		);		
		$reData = $this->user_lib->change_profile_img($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 닉네임 수정 
	public function change_user_name_prc(){
		$user_new_name = trim($this->input->post('newName', true));
		$reData = $this->user_lib->change_user_name(array('user_new_name' => $user_new_name));
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 비밀 번호 변경 
	public function change_password_prc(){
		$user_now_pwd = trim($this->input->post('nowpwd', true));
		$user_new_pwd = trim($this->input->post('chpwd', true));
		$re_user_new_pwd = trim($this->input->post('re-chpwd', true));
		$param = array(
			"user_now_pwd" => $user_now_pwd,
			"user_new_pwd" => $user_new_pwd,
			"re_user_new_pwd" => $re_user_new_pwd
		);		
		$res = $this->user_lib->change_user_password($param);
		echo json_encode($res, JSON_UNESCAPED_UNICODE);
	}

	// 회원 탈퇴 처리 
	public function leave_user_prc(){
		$leave_res = trim($this->input->post('leaveRes', true));
		$leave_note = trim($this->input->post('leaveNote', true));
		$leave_pwd = trim($this->input->post('leavePwd', true));
		$param = array(
			"leave_res" => $leave_res,
			"leave_note" => $leave_note,
			"leave_pwd" => $leave_pwd
		);		
		$res = $this->user_lib->leave_user_prc($param);
		echo json_encode($res, JSON_UNESCAPED_UNICODE);
	}
	/* Profile ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	
}