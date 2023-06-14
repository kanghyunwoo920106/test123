<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Share extends CI_Controller {
    public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('UserFunction');
		$this->load->library('Common_lib');
		$this->load->library('Share_lib');
		$this->load->library('Member_lib');
   }

   public function _remap($method)	{
		if(method_exists($this, $method)) {			
			if(strpos($method, '_prc') == TRUE) {
				$this->{$method}();
			} else {
				$rgStyleSheet = array();
				$rgJavaScript = array();
				$strHeadType = 'head';
				$strTailType = 'footer';

				switch($method){
					case 'doc' :
						$share_code_en = urldecode($this->uri->segment(3));
						if(empty($share_code_en)){
							show_404();		
						}

						$reData = $this->share_lib->get_share_data(['share_en' => $share_code_en]);
						if($reData['code'] != 200){
							show_404();
						}

						$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.".SPREADJS_VAR.".css";
						$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.excel2013white.".SPREADJS_VAR.".css";

						$rgJavaScript[] = ADMIN_TEMPLATE_PATH."bootstrap-notify/bootstrap-notify.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/gc.spread.sheets.all.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/interop/gc.spread.excelio.".SPREADJS_VAR.".min.js";	
						
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.charts.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.shapes.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/resources/ko/gc.spread.sheets.resources.ko.".SPREADJS_VAR.".min.js";


						$rgJavaScript[] = SPREADJS_PATH."scripts/FileSaver.min.js";
						$rgJavaScript[] = SPREADJS_PATH."license_tc.js";
						$rgJavaScript[] = ADMIN_JS_PATH."jquery-ui.js";

						$rgJavaScript[] = JS_PATH."share/".$method."_com.js";

						if($reData['data']['doc_edit'] == 'M'){
							$rgStyleSheet[] = DESIGNER_PATH."css/gc.spread.sheets.designer.".SPREADJS_VAR.".min.css";

							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.charts.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.shapes.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.print.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.barcode.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.pdf.".SPREADJS_VAR.".min.js";

							$rgJavaScript[] = DESIGNER_PATH."scripts/gc.spread.sheets.designer.resource.ko.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = DESIGNER_PATH."scripts/gc.spread.sheets.designer.all.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/FileSaver.min.js";

							$rgJavaScript[] = SPREADJS_PATH."license_tc_de.js";
							$rgJavaScript[] = JS_PATH."share/m".$method.".js";
						}
						else {
							$rgJavaScript[] = JS_PATH."share/".$method.".js";
						}
					break;
				}				
				$rgHeader = array(					
					"h_StyleSheet"		=> $rgStyleSheet,					
				);				
				$rgFooter = array(
					"f_JavaScript"		=> $rgJavaScript
				);
				$this->load->view('include/'.$strHeadType, $rgHeader);			
				$this->{$method}();
				$this->load->view('include/'.$strTailType, $rgFooter);
			}
		} else {
			show_404();
		}
	}

	public function index(){    
		echo urlencode($this->userfunction->fnSimpleCrypt('sae_6450d525234ee40', 'e'));
	}

	public function doc(){		
		$share_code_en = urldecode($this->uri->segment(3));
		if(empty($share_code_en)){
			show_404();		
		}
		
		$reData = $this->share_lib->get_share_data(['share_en' => $share_code_en]);
		if($reData['code'] != 200){
			show_404();
		}

		$data['shcd_en']	= $share_code_en;
		if($reData['data']['doc_edit'] == 'M'){			
			$this->load->view('share/m_document', $data);
		}
		else {
			$this->load->view('share/document', $data);
		}
	}

	// 공유 문서 상세 정보 
	public function get_documet_prc(){
		$share_encode = trim($this->input->post('shcd_en'));
		$reData = $this->share_lib->get_share_document(['share_en' => $share_encode]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}
	
	// 공유 분서 저장
	public function modify_document_prc(){
		$share_encode = trim($this->input->post('shcd_en'));
		$doc_data = trim($this->input->post('doc_data'));
		$param = array(
			'share_en' => $share_encode,
			'doc_data' => $doc_data
		);		
		$reData = $this->share_lib->modify_share_document($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	public function error_prc(){
		show_404();
	}
}
