<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url'); // redirect(), base_url() 사용하기 위함
		$this->load->library('UserFunction');
		$this->load->library('Common_lib');
		$this->load->library('Login_lib');
	}

	public function _remap($method)	{
		if(method_exists($this, $method)) {
			if(strpos($method, '_prc') == TRUE) {
				$this->{$method}();
			} else {
				$rgStyleSheet = array();
				$rgJavaScript = array();

				$strHeadType = 'head_login';
				$strTailType = 'footer';

				$rgStyleSheet[] = ADMIN_TEMPLATE_PATH.'animate.css/animate.min.css';
				$rgStyleSheet[] = CSS_PATH.'custom.css';
			
				$rgJavaScript[] = JS_PATH.'login.js';

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

	public function index() {
		$this->login();
	}

    public function login() {
		$this->userinfo = $this->session->userdata('userinfo');
		if($this->userinfo){
			header('Location: /TCmain', TRUE, null);
		}

        $data['title'] = "Login";
        $data['reurl'] = $this->input->get('reurl', true);
		$this->load->view("login/login",$data);
    }

	// 로그인 처리
	public function login_prc(){
		$param['userid'] = trim($this->input->post('user_id', true));
		$param['userpw'] = trim($this->input->post('user_pass', true));
		$res = $this->login_lib->login_prc($param);
		echo json_encode($res, JSON_UNESCAPED_UNICODE);
	}

	// 회원 가입 처리 
	public function account_prc(){
		$param['usernm'] = trim($this->input->post('user_name', true));
		$param['userid'] = trim($this->input->post('user_email', true));
		$param['userpw'] = trim($this->input->post('user_pass', true));	

		$param['tos_1'] = trim($this->input->post('tos1', true));	
		$param['tos_2'] = trim($this->input->post('tos2', true));	
		$param['tos_3'] = trim($this->input->post('tos3', true));

		$res = $this->login_lib->create_account_prc($param);
		echo json_encode($res, JSON_UNESCAPED_UNICODE);
	}	

	// 비밀 번호 찾기 처리 
	public function find_password_prc(){
		$param['userid'] = trim($this->input->post('femail', true));
		$res = $this->login_lib->find_password_prc($param);
		echo json_encode($res, JSON_UNESCAPED_UNICODE);
	}

	// logout 처리 
	public function signout(){
		$this->session->unset_userdata('userinfo');
		header('Location: /', TRUE, null);
	}
	
	// 네이버 회원 가입 동의 
	public function nvrcb_prc(){
		$code = trim($this->input->get('code', true));
		$state = trim($this->input->get('state', true));
		
		$res = $this->login_lib->naver_token_info_prc(array('code'=>$code, 'state'=>$state));
		switch($res['code']){
			case '200' :
				redirect('/tcmain', 'auto');
			break;
			case '599' :	// 회원 가입, 회원 연동 페이지			
				$data['code_dt'] = $res['data'];
				$this->load->view("login/login_naver",$data);
			break;
			default :
				redirect('/login/login', 'auto');
			break;

		}
		echo json_encode($res, JSON_UNESCAPED_UNICODE);
	}

	// 카카오 
	public function kaocb_prc(){
		$code = trim($this->input->get('code', true));

		$res = $this->login_lib->kakao_token_info_prc(array('code'=>$code));
		echo json_encode($res, JSON_UNESCAPED_UNICODE);		
	}
	
	/* 관리자 ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */ 

	public function tc_manager(){
		$data['title'] = "Admin";
		$this->load->view("/manager/login/login", $data);
	}

	public function manager_login_prc(){
		$param['adminid'] = trim($this->input->post('user_id', true));
		$param['adminpw'] = trim($this->input->post('user_pass', true));

		$res = $this->login_lib->manager_login_prc($param);
		echo json_encode($res, JSON_UNESCAPED_UNICODE);
	}

	public function manager_signout(){
		$this->session->unset_userdata('admininfo');
		redirect('/login/tc_manager', 'auto');
	}

	/* 관리자 ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */ 
}