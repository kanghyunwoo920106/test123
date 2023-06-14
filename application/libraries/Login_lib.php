<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_lib {
	var $CI;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('UserFunction');
		$this->CI->load->library('Common_lib');
		$this->CI->load->model('Common_model');
		$this->CI->load->model('Social_model');
		$this->CI->load->model('User_model');	
	}
	public function login_prc($param){
		$res = $this->CI->User_model->get_user_data($param);
		if(empty($res)){
			$returnOjb = array('code'=>500, 'rlt'=>false, 'msg'=>'이메일 또는 패스워드가 일치하지 않습니다.');
		}
		else {
			if (!password_verify($param['userpw'], $res['user_pass'])){				
				$returnOjb = array('code'=>501, 'rlt'=>false, 'msg'=>'이메일 또는 패스워드가 일치하지 않습니다.');
			} else {
				switch($res['user_state']){
					case 'NM' :
						$user_img = !empty($res['user_img_path']) && !empty($res['user_img_name']) ? $res['user_img_path'].'/s_'.$res['user_img_name'] : '';
						$login_data = array(
							'idx' => $res['idx'],
							'user_id' => $res['user_id'],
							'user_name' => $res['user_name'],
							'join_type' => $res['join_type'],
							'user_img' => $user_img
						);
						$this->CI->session->set_userdata(array("userinfo"=>$login_data));
						$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=>'');
						break;
					case 'TM' :
						// 인증 메일 발송 부분
						$returnOjb = array('code'=>201, 'rlt'=>false, 'msg'=>'등록하신 메일 주소로 인증 URL을 발송 하였습니다. \n 인증 확인 후 다시 시도해 주세요');
						break;					
					default :
						$returnOjb = array('code'=>204, 'rlt'=>false, 'msg'=>'아이디를 확인해주세요');
						break;
				}
			}
		}
		return $returnOjb;
	}
	
	// 회원 가입 처리 
	public function create_account_prc($param){
		$ac_prc = true;
		$name = '/^[가-힣a-zA-Z0-9 ]+$/';
		
		// 입력값 체크 -> 이름
		if (!preg_match($name, $param['usernm'])) {
			$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'이름을 정확히 입력해 주세요!');
			$ac_prc = false;
		}

		if(mb_strlen($param['usernm'], "UTF-8") < 2 || mb_strlen($param['usernm'], "UTF-8") > 10) {
			$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'이름은 최소 2자리 ~ 최대 10자리 이내로 입력해주세요.');
			$ac_prc = false;
		}

		// 입력값 체크 -> 이메일
		if (!filter_var($param['userid'], FILTER_VALIDATE_EMAIL) && $ac_prc == true) {
			$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'이메일을 정확히 입력해 주세요!');
			$ac_prc = false;
		}

		// 입력값 체크 -> 비밀번호
		if($ac_prc == true){			
			if(strlen($param['userpw']) < 8 || strlen($param['userpw']) > 16) {				
				$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'비밀번호는 영문, 숫자, 특수문자를 혼합하여 최소 8자리 ~ 최대 16자리 이내로 입력해주세요.');
				$ac_prc = false;
			}
			
			if((preg_match("/\s/u", $param['userpw']) == true) && $ac_prc == true) {
				$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'비밀번호는 공백없이 입력해주세요.');
				$ac_prc = false;
			}			
		}

		// 약관 동의 확인 
		if($ac_prc == true){
			if($param['tos_1'] != 'Y' || $param['tos_2'] != 'Y'){
				$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'필수 약관에 동의를 해주셔야 합니다.');
				$ac_prc = false;
			}
		}


		if($ac_prc == true){
			$id_check = $this->CI->User_model->get_user_data(array("userid"=>$param['userid']));
			if(empty($id_check)){
				// 회원 데이터 등록 
				$param_add = array(
					"userid" => $param['userid'],
					"usernm" => $param['usernm'],
					"userpw" => $param['userpw'],
					"userst" => 'TM'
				);
				$user_idx = $this->CI->User_model->add_user_data($param_add);
				if($user_idx){
					// 부가 정보 입력 
					$this->CI->User_model->add_user_info_data(
						array(
							"user_idx" => $user_idx,
							"user_image" => null,
							"user_tos_1" => $param['tos_1'] == 'Y' ? 'Y' : 'N',
							"user_tos_2" => $param['tos_2'] == 'Y' ? 'Y' : 'N',
							"user_tos_3" => $param['tos_3'] == 'Y' ? 'Y' : 'N',
						)
					);


					// 인증 코드 생성 				
					$param_auth = array(
						"user_idx" => $user_idx,
						"auth_type" => 'A',
						"auth_code" => $this->CI->userfunction->fnStrUniqId('tca'),
						"use_yn" => 'T'					
					);
					$auth_idx = $this->CI->User_model->add_auth_data($param_auth);

					$code_str_encode = $this->CI->userfunction->fnSimpleCrypt($param_auth['auth_code'],"e");

					// 인증 이메일 발송 
					/* ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
					
					// 인증 코드 
					$api_auth = $this->CI->common_lib->tw_api_sign_prc();
					if(!$api_auth){
						$returnOjb = array('code'=>423, 'rlt'=>false, 'msg'=>'인증 메일 발송 오류');					
					}
					else {
						$target_url = APP_URL."email";
						$arHeaders = array('accept: application/json', 'Content-Type: application/json', 'Authorization: Bearer '.$api_auth['accessToken']);
						$arParams = array(
							"from" => SEND_FROM_MAIL,
							"to" => [$param['userid']],
							"templateName" => "Teemcell_auth",
							"templateDataKeyValues" => [
								array("key" => "site-url", "value" => WEB_URL), 
								array("key" => "auth-code", "value" => $code_str_encode),
								array("key" => "customer-url", "value" => CUSTOMER_URL)
							]
						);					
						$send_mail = $this->CI->userfunction->fnCurlExec($target_url, 'POST', $arHeaders, $arParams);
						if($send_mail['code'] == 200 && $send_mail['data']['success'] == 'true'){
							$this->CI->Common_model->add_send_mail_log(
									array(
										'send_mail' => $param['userid'],
										'send_type' => 'SI',
										'success_yn' => 'Y',
										'rlt_data' => $send_mail
									)
								);
							$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=>'가입된 이메일 주소로 인증 URL를 발송 하였습니다.');
						} else {
							$this->CI->Common_model->add_send_mail_log(
									array(
										'send_mail' => $param['userid'],
										'send_type' => 'SI',
										'success_yn' => 'N',
										'rlt_data' => $send_mail
									)
								);
							$returnOjb = array('code'=>423, 'rlt'=>false, 'msg'=>'가입된 이메일 주소로 인증 URL를 발송 오류.');
						}						
					}
				/* ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */	
				}
				else {
					$returnOjb = array('code'=>422, 'rlt'=>false, 'msg'=>'등록중 오류가 발생 하였습니다. 잠시후 다시 시도해 주세요');
				}
			} else {
				$returnOjb = array('code'=>425, 'rlt'=>false, 'msg'=>'이미 사용중인 메일 주소 입니다.');
			}
		}		
		return $returnOjb;
	}

	// NAVER 토큰 값 처리 
	public function naver_token_info_prc($param){
		$client_id = MAVER_CLIENT_ID;
		$client_secret = NAVER_CLIENT_SECRET;
		$redirectURI = urlencode(WEB_URL."/login/nvrcb_prc");
		$login_token_url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$param['code']."&state=".$param['state'];
		$data = $this->CI->userfunction->fnCurlExec($login_token_url);

		if($data['code'] == 200){
			if(empty($data['data']['access_token'])){
				$returnOjb = array('code'=>501, 'rlt'=>false, 'msg'=>'값이 올바르지 않습니다.');
			} else {
				$url_ac = "https://openapi.naver.com/v1/nid/me";
				$data_t = $this->CI->userfunction->fnCurlExec($url_ac, 'GET', array("Authorization: Bearer ".$data['data']['access_token']));
				if($data_t['code'] == 200 && $data_t['data']['resultcode'] == '00'){

					$social_id = $data_t['data']['response']['id'];
					$social_user_email = $data_t['data']['response']['email'];
					$social_user_name = $data_t['data']['response']['name'];

					$sns_returnObj = $this->social_id_check(array('type'=>'Naver', 'uid'=>$social_id, 'email'=>$social_user_email, 'name'=>$social_user_name));
					$returnOjb = $sns_returnObj;
					
				}
				else {
					$returnOjb = array('code'=>503, 'rlt'=>false, 'msg'=>'값이 올바르지 않습니다.');		
				}
			}
		} else {
			$returnOjb = array('code'=>502, 'rlt'=>false, 'msg'=>'값이 올바르지 않습니다.');
		}
		return $returnOjb;
	}

	// KAKAO 토큰 값 처리 
	public function kakao_token_info_prc($param){
		$client_id = KAKAO_REST_API_KEY;
		$client_secret = KAKAO_CLIENT_SECRET;
		$redirectURI = urlencode("http://127.0.0.1/login/kaocb_prc");
		$login_token_url = 'https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id='.$client_id.'&redirect_uri='.$redirectURI.'&client_secret='.$client_secret.'&code='.$param['code'];		
		$data = $this->CI->userfunction->fnCurlExec($login_token_url);
		
		if($data['code'] == 200){
			if(empty($data['data']['access_token'])){
				$returnOjb = array('code'=>501, 'rlt'=>false, 'msg'=>'값이 올바르지 않습니다.');
			}
			else {
				$url_ac = "https://kapi.kakao.com/v2/user/me";
				$data_t = $this->CI->userfunction->fnCurlExec($url_ac, 'GET', array("Authorization: Bearer ".$data['data']['access_token']));
				if($data_t['code'] == 200 && !empty($data_t['data']['id'])){

					
					$social_id = $data_t['data']['id'];
					$user_email = $data_t['data']['kakao_account']['email'];
					$returnOjb = array('code'=>200, 'data'=>$data_t);
				}
				else {
					$returnOjb = array('code'=>503, 'rlt'=>false, 'msg'=>'값이 올바르지 않습니다.');		
				}
			}
		} else {
			$returnOjb = array('code'=>503, 'rlt'=>false, 'msg'=>'값이 올바르지 않습니다.');
		}
		return $returnOjb;	
	}	

	// 소셜 ID 확인
	public function social_id_check($param){
		$ch_social = $this->CI->Social_model->check_social_id(array('social_uid'=>$param['uid'], 'social_type'=>$param['type']));
		if(!empty($ch_social['user_idx'])){
			//정상일때
			$returnOjb = $this->social_login_prc(array('useridx'=>$ch_social['user_idx']));
		}
		else {
			$social_data = array('type'=>$param['type'], 'uid'=>$param['uid'], 'email'=>$param['email'], 'name'=>$param['name']);
			$social_data_en = json_encode($social_data);			
			$social_data_cy = $this->CI->userfunction->fnSimpleCrypt($social_data_en, 'e');
			$returnOjb = array('code'=>599, 'data'=>$social_data_cy, 'rlt'=>false, 'msg'=>'기존의 가입 이력이 없는 소셜 계정 입니다. 회원 가입 하시겠습니까?');
		}	
		return $returnOjb;
	}

	// 소셜 로그인 처리 
	public function social_login_prc($param){
		$res = $this->CI->User_model->get_user_data_by_idx(array('useridx'=>$param['useridx']));
		switch($res['state']){
			case 'Y' :
				$this->CI->session->set_userdata(array("userinfo"=>$res));
				$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=>'');
				break;
			case 'T' :
				// 인증 메일 발송 부분
				$returnOjb = array('code'=>201, 'rlt'=>false, 'msg'=>'등록하신 메일 주소로 인증 URL을 발송 하였습니다. \n 인증 확인 후 다시 시도해 주세요');
				break;
			case 'N' :
				$returnOjb = array('code'=>204, 'rlt'=>false, 'msg'=>'아이디를 확인해주세요');
				break;
		}
		return $returnOjb;
	}



	// 소셜 회원 가입
	public function social_join_prc($param){
		$param['udt'];
		// 동일 이메일 확인 

		// 동일 이메일 주소가 없을 경우 가입 처리 

		// 동일한 이메일 주소가 있음 
		// -> 동일 이메일 주소에 소셜 등록 등록전 기존 이메일 주소 계정 확인

		//  --> 신규 가입시 임이로 메일 주소 생성후 가입 처리 그 user_idx 로 소셜 등록
		
	}

	// 비밀 번호 찾가 메일 발송 처리 
	public function find_password_prc($param){
		$act = true;
		// 메일 주소 확인 
		$id_check = $this->CI->User_model->get_user_data(array("userid"=>$param['userid']));
		if(empty($id_check)){
			$code = 421;
			$msg = '입력한 이메일 정보가 없습니다.';
			$act = false;
		}

		if($act === true) {
			// 비밀번호 찾기 인증 코드 등록 				
			$param_auth = array(
				"user_idx" => $id_check['idx'],
				"auth_type" => 'P',
				"auth_code" => $this->CI->userfunction->fnStrUniqId('tca'),
				"use_yn" => 'T'					
			);
			$auth_idx = $this->CI->User_model->add_auth_data($param_auth);

			$code_str_encode = $this->CI->userfunction->fnSimpleCrypt($param_auth['auth_code'],"e");
			// 인증 이메일 발송 
			/* ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
			// API 인증 코드 
			$api_auth = $this->CI->common_lib->tw_api_sign_prc();
			if(!$api_auth){
				$code = 424;
				$msg = '인증 메일 발송 오류';
				$act = false;
			}
			else {
				$target_url = APP_URL."email";
				$arHeaders = array('accept: application/json', 'Content-Type: application/json', 'Authorization: Bearer '.$api_auth['accessToken']);
				$arParams = array(
					"from" => SEND_FROM_MAIL,
					"to" => array($param['userid']),
					"templateName" => "Teemcell_findpw",
					"templateDataKeyValues" => [
						array("key" => "site-url", "value" => WEB_URL), 
						array("key" => "auth-code", "value" => $code_str_encode), 
						array("key" => "customer-url", "value" => CUSTOMER_URL)
					]
				);				
				$send_mail = $this->CI->userfunction->fnCurlExec($target_url, 'POST', $arHeaders, $arParams);	
				if($send_mail['code'] == 200 && $send_mail['data']['success'] == 'true'){
					$this->CI->Common_model->add_send_mail_log(
							array(
								'send_mail' => $param['userid'],
								'send_type' => 'FP',
								'success_yn' => 'Y',
								'rlt_data' => $send_mail
							)
						);
					$msg = '가입된 이메일 주소로 인증 URL를 발송 하였습니다.';
				} else {
					$this->CI->Common_model->add_send_mail_log(
							array(
								'send_mail' => $param['userid'],
								'send_type' => 'FP',
								'success_yn' => 'N',
								'rlt_data' => $send_mail
							)
						);
					$code = 424;
					$msg = '가입된 이메일 주소로 인증 URL를 발송 오류.';
					$act = false;
				}				
			}
		/* ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */	
		}

		if($act === true){
			$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=> $msg);
		} else {
			$returnOjb = array('code'=>424, 'rlt'=>false, 'msg'=> $msg);
		}
		return $returnOjb;
	}	
	/* 관리자 ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */ 
	// 관리자 로그인 처리 
	public function manager_login_prc($param){
		$ip_log = $this->CI->Common_model->get_admin_login_ip_log();
		if($ip_log === false){
			$returnOjb = array('code'=>505, 'rlt'=>false, 'msg'=>'동일 IP로 로그인 실패건이 다수 존재 합니다.\n개발팀에 문의 해 주세요!');
			return $returnOjb;
			exit;
		}		
		$res = $this->CI->User_model->get_admin_data($param);
		if(empty($res)){
			$this->CI->Common_model->add_admin_login_log(array("admin_id"=>$param['adminid'], "success_yn"=>"N"));
			$returnOjb = array('code'=>500, 'rlt'=>false, 'msg'=>'아이디, 패스워드를 확인해주세요.');
		}
		else {
			if (!password_verify($param['adminpw'], $res['admin_pass'])){
				$this->CI->Common_model->add_admin_login_log(array("admin_id"=>$param['adminid'], "success_yn"=>"N"));
				$returnOjb = array('code'=>502, 'rlt'=>false, 'msg'=>'아이디, 패스워드를 확인해주세요.');
			} else {
				$this->CI->Common_model->add_admin_login_log(array("admin_id"=>$param['adminid'], "success_yn"=>"Y"));

				$admin_data = array(
					"ad_idx" => $res['idx'], 
					"ad_id" => $res['admin_id'],
					"ad_name" => $res['admin_name'],
					"ad_state" => $res['use_yn']
				);
				$this->CI->session->set_userdata(array("admininfo"=>$admin_data));
				$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=>'');				
			}
		}		
		return $returnOjb;
	}

	// 관리자 회원 로그인 처리 
	public function admin_user_login_prc($param){
		// 메일 주소 확인 
		$res = $this->CI->User_model->get_user_data_by_idx($param['user_idx']);
		if(empty($res)){
			return array('code'=>425, 'msg'=>'회원 정보가 전재 하지 않습니다.');
			exit;		
		}

		switch($res['user_state']){
			case 'NM' :
				$user_img = !empty($res['user_img_path']) && !empty($res['user_img_name']) ? $res['user_img_path'].'/s_'.$res['user_img_name'] : '';
				$login_data = array(
					'idx' => $res['idx'],
					'user_id' => $res['user_id'],
					'user_name' => $res['user_name'],
					'join_type' => $res['join_type'],
					'user_img' => $user_img
				);
				$this->CI->session->set_userdata(array("userinfo"=>$login_data));
				$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=>'');
			break;
			case 'TM' :
				// 인증 메일 발송 부분
				$returnOjb = array('code'=>201, 'msg'=>'아직 임시 등록 상태 입니다.');
			break;					
			default :
				$returnOjb = array('code'=>204, 'msg'=>'회원 상태가 정상 상태가 아닙니다.');
			break;
		}
		return $returnOjb;
	}
	/* 관리자 ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */ 
}
