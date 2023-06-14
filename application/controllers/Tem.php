<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url'); // redirect(), base_url() 사용하기 위함
		$this->load->library('UserFunction');
		$this->load->library('Common_lib');	
	}
	public function index(){
		$this->ch_auth();
	}

	// 회원 가입 인증코드 확인
	public function ch_auth(){
		$en_auth_code = trim($this->input->get('tc_cd', true));		
		if(empty($en_auth_code)){
			$this->load->view("login/auth_fali01");
		} else {
			$res = $this->common_lib->chech_auth_code_prc(array("en_auth_code" => $en_auth_code));
			print_r($res);
			
			if($res['code'] == 200) {
				$this->load->view("login/auth_success");
			} else {
				$this->load->view("login/auth_fali01");
			}
		}
	}
}