<?php
class Main extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('UserFunction');
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
				$rgHeader = array(
					"h_Title"			=> WEB_TITLE,
					"h_StyleSheet"		=> $rgStyleSheet					
				);
				$rgJavaScript[] = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js';
				switch($method){
					case 'test' : 
						$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."animate.css/animate.min.css";

						$rgJavaScript[] = ADMIN_TEMPLATE_PATH."bootstrap-notify/bootstrap-notify.js";

						$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.".SPREADJS_VAR.".css";
						$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.excel2013white.".SPREADJS_VAR.".css";
						$rgStyleSheet[] = DESIGNER_PATH."css/gc.spread.sheets.designer.".SPREADJS_VAR.".min.css";
		
						$rgJavaScript[] = SPREADJS_PATH."scripts/gc.spread.sheets.all.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.charts.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.shapes.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.print.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.barcode.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.pdf.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/interop/gc.spread.excelio.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = DESIGNER_PATH."scripts/gc.spread.sheets.designer.resource.ko.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = DESIGNER_PATH."scripts/gc.spread.sheets.designer.all.".SPREADJS_VAR.".min.js";

						$rgJavaScript[] = SPREADJS_PATH."scripts/FileSaver.min.js";
						$rgJavaScript[] = SPREADJS_PATH."license_tc.js";
						$rgJavaScript[] = SPREADJS_PATH."license_tc_de.js";
						$rgJavaScript[] = ADMIN_JS_PATH."jquery-ui.js";
						

						$rgJavaScript[] = '/resources/js/main/'.$method.'.js';
						
					break;
					default :
						$rgJavaScript[] = '/resources/js/main/'.$method.'.js';						
					break;
				}
				$rgStyleSheet[] = CSS_PATH."custom.css";


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
	/* MAIN ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	public function index(){
		$this->userinfo = $this->session->userdata('userinfo');
		if(!empty($this->userinfo)){
			header('Location: /TCmain', TRUE, null);
		}
		$this->load->view("main/main");
	}
	/* MAIN ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */

	public function test_prc(){
		$this->load->view("test/doc_view");
	}


}