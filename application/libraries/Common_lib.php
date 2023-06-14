<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_lib {
	var $CI;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('UserFunction');
		$this->CI->load->model('Common_model');

		$this->CI->load->model('Member_model');
	}

	public function login_check(){
		$this->userinfo = $this->CI->session->userdata('userinfo');
		if ($this->userinfo){			
			return true;
		} else {
			header('Location: /login?reurl='.$_SERVER['REQUEST_URI'], TRUE, null);
			exit;
		}
	}
	
	public function admin_login_check(){
		$this->admininfo = $this->CI->session->userdata('admininfo');
		if ($this->admininfo){			
			return true;
		} else {
			header('Location: /login/tc_manager?reurl='.$_SERVER['REQUEST_URI'], TRUE, null);
			exit;
		}
	}

	public function member_status_code(){
		$rlt = $this->CI->Common_model->get_code_member_status();
		if(empty($rlt)){
			return false;
		}
		else return $rlt;
	}

	// 인증 요청 
	public function tw_api_sign_prc(){
		$target_url = APP_URL.'sign';
		$arHeaders = array('accept: application/json', 'Content-Type: application/json');
		$arParams = array(
			'appId' => APP_ID,
			'appSecretKey' => APP_SECRET_KEY
		);
		$responses = $this->CI->userfunction->fnCurlExec($target_url, 'POST', $arHeaders, $arParams);
	
		$return_data = array();		
		if($responses['code'] == 200 && $responses['data']['success'] == true){
			$return_data['accessToken'] = $responses['data']['data']['accessToken'];
			return $return_data;
		} else return false;
	}

	// 회원 가입 인증 코드 확인 
	public function check_auth_code_prc($param){
		$this->CI->load->model('User_model');		
		// 코드값 복호화 처리 
		$code_str_decode = $this->CI->userfunction->fnSimpleCrypt($param['en_auth_code'],'d');
		if(empty($code_str_decode)){			
			$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'값이 올바르지 않습니다.');
		} else {			
			// DB 인증 코드 확인 -> 임시 상태임
			$res_auth = $this->CI->Common_model->get_auth_data(array('use_yn'=>'T', 'auth_type'=>'A', 'authcode'=>$code_str_decode));

			if($res_auth){
				// 인증 상태로 변경 처리 
				$res_up = $this->CI->Common_model->up_auth_data(array('use_yn'=>'Y', 'authcode'=>$code_str_decode));
				// 회원 상태 벼경
				$param_user = array(
					'user_idx' => $res_auth['user_idx'],
					'user_state' => 'NM',
					'up_date' => date('Y-m-d H:i:s')
				);			
				$res_user = $this->CI->User_model->up_user_state_data($param_user);

				$this->check_user_member_data(
					array(
						'user_id' => $res_auth['user_id'],
						'up_user_idx' => $res_auth['user_idx']
					)
				);
				
				$returnOjb = array('code'=>200, 'data'=>'값이 인증 되었습니다.');
			}
			else {
				$returnOjb = array('code'=>425, 'rlt'=>false, 'msg'=>'값이 올바르지 않습니다.');
			}
		}
		return $returnOjb;
	}

	public function array_doc_color_code(){
		$returnOjb = [];
		$rlt = $this->CI->Common_model->get_doc_color();
		foreach($rlt as $row){
			$returnOjb[$row['code_name']] = $row['code_detail'];
		}
		return $returnOjb;
	}

	// 인증 코드 유효 체크
	public function check_public_auth_code($param){
		// 코드값 복호화 처리 
		$code_str_decode = $this->CI->userfunction->fnSimpleCrypt($param['en_auth_code'],'d');
		if(empty($code_str_decode)){			
			return array('code'=>400, 'rlt'=>false, 'msg'=>'값이 올바르지 않습니다.');
			exit;
		} 

		// DB 인증 코드 확인 -> 비밀번호 변경 임시 상태 코드 값이 있는지 확인
		$res_auth = $this->CI->Common_model->get_auth_data(array('use_yn'=>'T', 'auth_type'=>$param['auth_type'], 'authcode'=>$code_str_decode));
		if(empty($res_auth)){
			return array('code'=>400, 'rlt'=>false, 'msg'=>'값이 올바르지 않습니다.');
			exit;
		}

		// 시간 확인 
		$nowday = date('Y-m-d H:i:s');
		$chkday = $res_auth['reg_date'];		
		$gapMinute = (int)((strtotime($nowday) - strtotime($chkday)) / 60);		
		switch($param['auth_type']){
			case 'P': 
					// 비밀 번호 30분 유효
					if($gapMinute > 30){
						return array('code'=>400, 'rlt'=>false, 'msg'=>'인증 코드 유효 시간이 만료 하였습니다. 다시 비밀 번호 찾기를 시도 해 주세요');
						exit;
					}
				break;
			case 'A': 
					// 가입 인증 24시간 유효
					if($gapMinute > (60 * 24)){
						return array('code'=>400, 'rlt'=>false, 'msg'=>'인증 코드 유효 시간이 만료 하였습니다.');
						exit;
					}
				break;
		}
		return array('code'=>200, 'data'=>$res_auth);		
	}

	/* 공통 기능  ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */ 
	// 회원 가입시 주소록에 등록 되어 있으면 user 정보 업데이트
	public function check_user_member_data($param){
		// 주소 테이블에서 내 아이디와 동일 메일 주소가 있는지 확인 
		$check_mem_list = $this->CI->Member_model->get_user_member_email_check_data(
			array(
				'user_id' => $param['user_id']
			)
		);
		if(count($check_mem_list) > 0){
			foreach($check_mem_list as $row){
				$this->CI->Member_model->up_user_member(
					[
						'user_idx'	=> $row['user_idx'],
						'mem_idx'	=> $row['idx'],
						'up_data'	=> [
							'user_check' => $param['up_user_idx']
						]
					]
				);
			}
			return array('code'=>200);
		} else {
			return array('code'=>425);
		}		
	}
	/* 공통 기능  ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */ 


}
