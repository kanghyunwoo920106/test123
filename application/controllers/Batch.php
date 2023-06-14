<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('UserFunction');
		$this->load->library('Common_lib');
	}
	public function _remap($method)	{
		if(method_exists($this, $method)) {
			if(strpos($method, '_prc') == TRUE) {
				$this->{$method}();
			} else {
				show_404();
			}
		} else  {
			show_404();
		}
	}

	// 회원 멤버 
	public function member_mapping_prc(){
		// 내 주소록 회원 가입 회원과 동기화 

		// 주소록 호출 
		
		// 매칭 된 회원 리스트 현재 상태 확인 

		// 비매칭 회원 이메일 체크 등록
	}
}