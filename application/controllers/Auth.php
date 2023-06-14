<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url'); // redirect(), base_url() 사용하기 위함
		$this->load->library('UserFunction');
		$this->load->library('Common_lib');
		$this->load->library('Auth_lib');
	}
	public function _remap($method)	{
		if(method_exists($this, $method)) {
			if(strpos($method, '_prc') == TRUE) {
				$this->{$method}();
			} else {
				$rgStyleSheet = array();
				$rgJavaScript = array();

				$strHeadType = 'head_login';
				$strTailType = 'footer_login';

				$rgStyleSheet[] = ADMIN_TEMPLATE_PATH.'animate.css/animate.min.css';
				$rgStyleSheet[] = CSS_PATH.'custom.css';
				
				$rgJavaScript[] = JS_PATH.'auth/'.$method.'.js';

				$rgHeader = array(
					"h_Title"			=> WEB_TITLE,
					"h_StyleSheet"		=> $rgStyleSheet,
				);

				$rgFooter = array(
					"f_JavaScript"		=> $rgJavaScript
				);

				$this->load->view('include/'.$strHeadType, $rgHeader);			
				$this->{$method}();
				$this->load->view('include/'.$strTailType, $rgFooter);
			}
		} else  {
			show_404();
		}
	}

	public function index(){
		$this->ch_auth();
	}

	// 회원 가입 인증코드 확인
	public function chauth(){
		$en_auth_code = trim(urldecode($this->uri->segment(3)));
		if(empty($en_auth_code)){
			$this->load->view("login/auth_fali01");
		} else {
			$res = $this->common_lib->check_auth_code_prc(array("en_auth_code" => $en_auth_code));
			if($res['code'] == 200) {
				$this->load->view("login/auth_success");
			} else {
				$this->load->view("login/auth_fali01");
			}
		}
	}

	// 비밀 번호 변경 페이지
	public function fpw(){
		$en_auth_code = trim(urldecode($this->uri->segment(3)));

		// 코드 확인 
		$res = $this->common_lib->check_public_auth_code(array("en_auth_code" => $en_auth_code, "auth_type" => 'P'));
		if($res['code'] == 200){
			$data['tccd'] = $en_auth_code;
			$this->load->view("login/change_password", $data);
		} else {
			$this->load->view("login/auth_fali01");
		}
	}

	public function fpw_prc(){
		$en_auth_code = trim($this->input->post('tccd', true));
		$user_pwd = trim($this->input->post('urpw', true));
		$re_user_pwd = trim($this->input->post('reurpw', true));
		$param = array(
			"en_auth_code" => $en_auth_code,
			"user_pwd" => $user_pwd,
			"re_user_pwd" => $re_user_pwd
		);		
		$res = $this->auth_lib->change_user_password($param);
		echo json_encode($res, JSON_UNESCAPED_UNICODE);
	}
}