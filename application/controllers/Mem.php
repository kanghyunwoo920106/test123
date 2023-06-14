<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mem extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url'); // redirect(), base_url() 사용하기 위함
		$this->load->library('UserFunction');
		$this->load->library('Common_lib');			
		$this->common_lib->login_check();

		$this->load->library('Member_lib');	
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
	
				$rgHeader = array(
					"h_Title"			=> 'TeemCell',
					"h_StyleSheet"		=> $rgStyleSheet,
					"user_data"			=> $userinfo
				);

				$rgJavaScript[] = '/resources/js/member/'.$method.'.js';

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
	}

	// 사용자 주소록 리스트
	public function mlist(){		
		$this->load->view("member/mem_list");
	}

	// 사용자 주소록 리스트
	public function get_mem_list_prc(){
		$pg_num = (int)$this->input->post('pg_num');
		$mem_order = (int)$this->input->post('mem_order');
		$param = array(			
			"pg_num" => $pg_num,
			"mem_order" => $mem_order
		);
		$reData = $this->member_lib->get_user_member_list($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 사용자 주소록 추가
	public function add_user_mem_prc(){
		$mem_name = trim($this->input->post('mem_name', true));
		$mem_email = trim($this->input->post('mem_email', true));		
		$param = array(			
			"mem_name" => $mem_name,
			"mem_email" => $mem_email			
		);		
		$reData = $this->member_lib->add_user_member($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 사용자 주소록 이름 변경 
	public function up_user_mem_prc(){
		$mem_idx = (int)$this->input->post('idx');
		$mem_name = trim($this->input->post('ch_val', true));		
		$param = array(			
			"mem_idx" => $mem_idx,
			"mem_name" => $mem_name			
		);		
		$reData = $this->member_lib->up_user_member($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 사용자 주소록 삭제 
	public function del_user_mem_prc(){
		$mem_idx = (int)$this->input->post('idx');
		$reData = $this->member_lib->del_user_member(['mem_idx' => $mem_idx, 'use_yn' => 'N']);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 선택한 사용자 주소록 삭제 
	public function del_val_user_mem_prc(){
		$mem_ch_idx = $this->input->post('ch_idx');
		$reData = $this->member_lib->del_chval_user_member(['mem_ch_idx' => $mem_ch_idx, 'use_yn' => 'N']);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);

	}
}