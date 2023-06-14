<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth_lib {
	var $CI;
	public function __construct() {
		$this->CI =& get_instance();
        $this->CI->load->helper('url');
		$this->CI->load->library('UserFunction');
		$this->CI->load->library('Common_lib');
		$this->CI->load->model('User_model');
		$this->CI->load->model('Common_model');
	}

	// 비밀번호 변경 처리 
	public function change_user_password($param){
		// 인증 코드 확인
		$res_code = $this->CI->common_lib->check_public_auth_code(array("en_auth_code" => $param['en_auth_code'], "auth_type" => 'P'));		
		if($res_code['code'] == 200){
			$ac_prc = true;
			
			// 입력값 체크 -> 비밀번호 자리수 확인 
			if(strlen($param['user_pwd']) < 8 || strlen($param['user_pwd']) > 16) {				
				$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'비밀번호는 영문, 숫자, 특수문자를 혼합하여 최소 8자리 ~ 최대 16자리 이내로 입력해주세요.');
				$ac_prc = false;
			}

			// 빈칸 확인
			if((preg_match("/\s/u", $param['user_pwd']) == true) && $ac_prc == true) {
				$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'비밀번호는 공백없이 입력해주세요.');
				$ac_prc = false;
			}

			// 비밀번호 확인 값
			if(($param['user_pwd'] != $param['re_user_pwd']) && $ac_prc == true){
				$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'재입력한 비밀번호가 일치하지 않습니다.');
				$ac_prc = false;
			}

			if($ac_prc == true){
				// 인증 코드 사용 처리 
				$this->CI->Common_model->up_auth_data(array('use_yn'=>'Y', 'authcode'=>$res_code['data']['auth_code']));

				// 비밀 번호 변경 처리 
				$res_pw = $this->CI->User_model->update_member_pw(array("idx" =>$res_code['data']['user_idx'], "pw" => $param['user_pwd']));
				if($res_pw){
					$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=>'비밀번호가 변경되었습니다.');
				} else {
					$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'재입력한 비밀번호가 일치하지 않습니다.');
				}
			}
			return $returnOjb;			
		}
		else {
			return $res_code;
		}
	}	
}
