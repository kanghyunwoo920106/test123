<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TCmain extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('UserFunction');
		$this->load->library('Common_lib');
		$this->load->library('Main_lib');
		$this->common_lib->login_check();
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

				$rgHeader = array(
					"h_Title"			=> WEB_TITLE,
					"h_StyleSheet"		=> $rgStyleSheet,
					"user_data"			=> $userinfo
				);

				$rgJavaScript[] = '/resources/js/tcmain/'.$method.'.js';

				$rgFooter = array(
					"f_JavaScript"		=> $rgJavaScript
				);

				$this->load->view('include/'.$strHeadType, $rgHeader);
				$this->load->view('include/header_main');
				$this->{$method}();
				$this->load->view('include/'.$strTailType, $rgFooter);
			}
		} else  {
			show_404();
		}
	}
	/* MAIN ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	public function index(){
		$this->load->view('tcmain/main');
	}

	// 메인 테플릿 리스트 
	public function get_main_template_list_prc(){
		$res = $this->main_lib->get_main_template_list();
		echo json_encode($res, JSON_UNESCAPED_UNICODE);
	}

	// 메인 내문서 리스트 
	public function get_main_user_doc_list_prc(){
		$res = $this->main_lib->get_main_user_doc_list();
		echo json_encode($res, JSON_UNESCAPED_UNICODE);
	}


	/* MAIN ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */


}