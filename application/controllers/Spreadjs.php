<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spreadjs extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('url'); // redirect(), base_url() 사용하기 위함
		$this->load->library('UserFunction');
		$this->load->library('Common_lib');
		$this->load->library('Spreadjs_lib');
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

				$rgStyleSheet[] = '/resources/SpreadJS/css/gc.spread.sheets.excel2013white.15.2.5.css';
				$rgJavaScript[] = '/resources/SpreadJS/scripts/gc.spread.sheets.all.15.2.5.min.js';
				$rgJavaScript[] = '/resources/SpreadJS/scripts/resources/ko/gc.spread.sheets.resources.ko.15.2.5.min.js';
				
				$rgHeader = array(
					"h_Title"			=> 'TeemCell Test',
					"h_Meta"			=> null,
					"h_StyleSheet"		=> $rgStyleSheet,
					"h_JavaScript"		=> $rgJavaScript,
					"user_data"			=> $userinfo
				);

				$rgFooter = array();

				$this->load->view('include/'.$strHeadType, $rgHeader);			
				$this->{$method}();
				$this->load->view('include/'.$strTailType, $rgFooter);
			}
		} else  {
			show_404();
		}
	}

	public function test01() {
		$this->load->view('spreadjs/test01');
	}

	public function test01_prc(){
		$doc_id = trim($this->input->post('doc_id'));
		$doc_title = trim($this->input->post('doc_title'));
		$doc_data = trim($this->input->post('doc_data'));
		$doc_limit = trim($this->input->post('doc_limit'));

		if($doc_id == ""){	
			$doc_id = uniqid('udoc_');	
		}		
		$params = array(
			"doc_id" => $doc_id,
			"doc_title" => $doc_title,
			"doc_data" => $doc_data,
			"doc_limit" => $doc_limit	
		);

		$reData = $this->spreadjs_lib->add_document_share_prc($params);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

    public function test02(){
        $this->load->view('spreadjs/test02');
    }

    public function test03(){
        $this->load->view('spreadjs/test03');
    }

	public function test04(){
        $this->load->view('spreadjs/test04');
    }

	public function test05(){
        $this->load->view('spreadjs/test05');
    }

	// 파일 업로드 테스트
	public function test06(){
        $this->load->view('spreadjs/test06');
    }
}