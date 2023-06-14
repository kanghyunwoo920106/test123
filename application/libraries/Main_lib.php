<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main_lib {
	var $CI;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library('UserFunction');
		$this->CI->load->model('Main_model');
		$this->CI->load->helper('url');
		$this->userinfo = $this->CI->session->userdata('userinfo');
	}

	//  메인 템플릿 리스트 
	public function get_main_template_list(){
		$reData = $this->CI->Main_model->get_main_template_list();	
		if($reData){
			return array("code"=>200, "data"=>$reData);
		}else{
			return array("code"=>400, "msg"=>"Not Data");
		}
	}

	//  메인 등록 문서 리스트 
	public function get_main_user_doc_list(){
		$reData = $this->CI->Main_model->get_main_user_doc_list(array("user_idx"=>$this->userinfo['idx']));	
		if($reData){
			return array("code"=>200, "data"=>$reData);
		}else{
			return array("code"=>400, "msg"=>"Not Data");
		}
	}
}