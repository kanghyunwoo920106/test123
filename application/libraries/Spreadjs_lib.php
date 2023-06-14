<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spreadjs_lib {
	var $CI;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library('UserFunction');
		$this->CI->load->model('Main_model');
		$this->CI->load->model('Spreadjs_model');
		$this->CI->load->helper('url');
	}

	public function add_document_share_prc($params){
	
		// sheet 별 처리 
		$doc_data = json_decode($params['doc_data'], true);		
		
		// sheets 별도 분리
		$doc_data_sheets = $doc_data['sheets'];

		// sheets 정보 삭제
		unset($doc_data['sheets']);	
		$doc_params = array(
			"doc_id" => $params['doc_id'],
			"doc_title" => $params['doc_title'],
			"doc_data" => json_encode($doc_data, JSON_UNESCAPED_UNICODE)
		);
		$ret = $this->CI->Main_model->add_document_data($doc_params);

		if(count($doc_data_sheets) > 0){
			foreach($doc_data_sheets as $row){
				$sheet_data = array(
					"doc_id" => $params['doc_id'],
					"sheet_id" => uniqid('usheet_'),
					"sheet_name" => $row['name'],
					"sheet_data" => json_encode($row, JSON_UNESCAPED_UNICODE)
				);
				$res2 = $this->CI->Main_model->add_document_sheet_data($sheet_data);
			}
		}

		// 공유 정보 및 공유 키 생성 
		$share_data = array(
			"share_code" => uniqid('ushare_'),
			"doc_id" => $params['doc_id'],			
			"doc_limit" => $params['doc_limit']			
		);
		$res3 = $this->CI->Spreadjs_model->add_document_share_data($share_data);


		$share_encode = $this->CI->userfunction->my_simple_crypt($share_data['share_code'], 'e');


		if($res3) {
			return array('code'=>200,"data"=>$share_encode);
		}
		else return array('code'=>500 ,"msg"=>"잠시 후에 다시 시도해 주세요");
	}	
}