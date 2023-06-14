<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Doc extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('UserFunction');
		$this->load->library('Common_lib');	
		$this->common_lib->login_check();

		$this->load->library('Document_lib');
		$this->load->library('Share_lib');
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
				
				$doc_edit = 'N';
				
				$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."animate.css/animate.min.css";
				$rgJavaScript[] = ADMIN_TEMPLATE_PATH."bootstrap-notify/bootstrap-notify.js";

				switch($method){

					case 'write' : case 'view' : 
						$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.".SPREADJS_VAR.".css";
						$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.excel2013white.".SPREADJS_VAR.".css";
						$rgStyleSheet[] = DESIGNER_PATH."css/gc.spread.sheets.designer.".SPREADJS_VAR.".min.css";
		
						$rgJavaScript[] = SPREADJS_PATH."scripts/gc.spread.sheets.all.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.charts.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.shapes.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.print.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.barcode.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.pdf.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.pivot.pivottables.".SPREADJS_VAR.".min.js";
						

						$rgJavaScript[] = SPREADJS_PATH."scripts/interop/gc.spread.excelio.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = DESIGNER_PATH."scripts/gc.spread.sheets.designer.resource.ko.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = DESIGNER_PATH."scripts/gc.spread.sheets.designer.all.".SPREADJS_VAR.".min.js";

						$rgJavaScript[] = SPREADJS_PATH."scripts/FileSaver.min.js";
						$rgJavaScript[] = SPREADJS_PATH."license_tc.js";
						$rgJavaScript[] = SPREADJS_PATH."license_tc_de.js";
						$rgJavaScript[] = ADMIN_JS_PATH."jquery-ui.js";
						$rgJavaScript[] = JS_PATH."document/doc_com.js";

						$rgJavaScript[] = JS_PATH."document/".$method.".js";
						
					break;
					case 'views' :
						$share_id = trim(urldecode($this->uri->segment(3)));
						if(empty($share_id)){
							show_404();
						}
						$reData = $this->share_lib->get_share_data_de(['share_decode' => $share_id]);
						if(empty($reData)){
							show_404();
						}

						if($reData['data']['doc_edit'] == 'M'){
							$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.".SPREADJS_VAR.".css";
							$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.excel2013white.".SPREADJS_VAR.".css";
							$rgStyleSheet[] = DESIGNER_PATH."css/gc.spread.sheets.designer.".SPREADJS_VAR.".min.css";
			
							$rgJavaScript[] = SPREADJS_PATH."scripts/gc.spread.sheets.all.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.charts.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.shapes.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.print.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.barcode.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.pdf.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.pivot.pivottables.".SPREADJS_VAR.".min.js";

							$rgJavaScript[] = SPREADJS_PATH."scripts/interop/gc.spread.excelio.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = DESIGNER_PATH."scripts/gc.spread.sheets.designer.resource.ko.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = DESIGNER_PATH."scripts/gc.spread.sheets.designer.all.".SPREADJS_VAR.".min.js";

							$rgJavaScript[] = SPREADJS_PATH."scripts/FileSaver.min.js";
							$rgJavaScript[] = SPREADJS_PATH."license_tc.js";
							$rgJavaScript[] = SPREADJS_PATH."license_tc_de.js";
							$rgJavaScript[] = ADMIN_JS_PATH."jquery-ui.js";
							$rgJavaScript[] = JS_PATH."document/doc_com.js";
							$doc_edit = 'Y';
							$rgJavaScript[] = JS_PATH.'document/'.$method.'_m.js';
						}
						else {
							$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.".SPREADJS_VAR.".css";
							$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.excel2013white.".SPREADJS_VAR.".css";
							$rgJavaScript[] = SPREADJS_PATH."scripts/gc.spread.sheets.all.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/FileSaver.min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/interop/gc.spread.excelio.".SPREADJS_VAR.".min.js";							

							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.charts.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.shapes.".SPREADJS_VAR.".min.js";
							$rgJavaScript[] = SPREADJS_PATH."scripts/resources/ko/gc.spread.sheets.resources.ko.".SPREADJS_VAR.".min.js";

							$rgJavaScript[] = SPREADJS_PATH."license_tc.js";
							$rgJavaScript[] = ADMIN_JS_PATH."jquery-ui.js";
							$rgJavaScript[] = JS_PATH."document/doc_com.js";
							$rgJavaScript[] = JS_PATH.'document/'.$method.'.js';
						}

					break;
					case 'history' :
						$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.".SPREADJS_VAR.".css";
						$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.excel2013white.".SPREADJS_VAR.".css";

						$rgJavaScript[] = SPREADJS_PATH."scripts/gc.spread.sheets.all.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.charts.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/plugins/gc.spread.sheets.shapes.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."scripts/resources/gc.spread.sheets.resource.ko.".SPREADJS_VAR.".min.js";
						$rgJavaScript[] = SPREADJS_PATH."license_tc.js";
						$rgJavaScript[] = ADMIN_JS_PATH."jquery-ui.js";
						$rgJavaScript[] = JS_PATH."document/doc_com.js";

						$rgJavaScript[] = JS_PATH."document/".$method.".js";
						
					break;
					default :
						$rgJavaScript[] = JS_PATH."document/".$method.".js";
					break;
				}
				$rgHeader = array(
					"h_Title"			=> 'TeemCell',
					"h_StyleSheet"		=> $rgStyleSheet,
					"user_data"			=> $userinfo
				);

				

				$rgFooter = array(
					"f_JavaScript"		=> $rgJavaScript
				);

				$this->load->view('include/'.$strHeadType, $rgHeader);
				switch($method){
					case 'view' : case 'views' : case 'write' :
						$this->load->view('include/header_doc.php', ['method' => $method, 'doc_edit' => $doc_edit]);
					break;
					case 'template' :
						$cate_data = $this->document_lib->get_template_category();
						$this->load->view('include/header_doc_tem.php', ['method' => $method, 'cate_date' => $cate_data]);
					break;
				}
				$this->{$method}();
				$this->load->view('include/'.$strTailType, $rgFooter);
			}
		} else  {
			show_404();
		}
	}
	
	/* Document ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	/********* write **********/
	// 새문서 작성 폼
	public function write(){
		$doc_type = trim(urldecode($this->uri->segment(3)));
		$tem_id = trim(urldecode($this->uri->segment(4)));
		$data = array(
			'doc_type' => $doc_type,
			'tem_id' => $tem_id
		);		
		$this->load->view("document/doc_write", $data);
	}

	// 문서 신규 저장 처리
	public function add_doc_write_prc(){
		set_time_limit(300); 
		$doc_type	= trim($this->input->post('doc_type', true));
		$tem_id		= trim($this->input->post('tem_id', true));
		$doc_title	= trim($this->input->post('doc_title', true));
		$doc_color	= trim($this->input->post('doc_color', true));
		$doc_data	= trim($this->input->post('doc_data'));
		$doc_memo	= trim($this->input->post('doc_memo', true));

		if(empty($doc_title)) $doc_title = '내 문서 타이틀 명';
		if(empty($doc_color)) $doc_color = 'red';	
		$param = array(
			"doc_type"	=> $doc_type,
			"tem_id"	=> $tem_id,
			"doc_title" => $doc_title,
			"doc_color" => $doc_color,
			"doc_data"	=> $doc_data,
			"doc_memo"	=> $doc_memo	
		);		
		$reData = $this->document_lib->add_user_document($param);
		echo JSON_ENCODE($reData, JSON_UNESCAPED_UNICODE);
	}
	
	/********* view **********/
	// 문서 상세 보기 
	public function view(){
		$doc_id = trim(urldecode($this->uri->segment(3)));;
		$data['doc_id'] = $doc_id;
		$this->load->view("document/doc_view", $data);
	}

	// 공유 문서 상세 보기
	public function views(){
		$share_id = trim(urldecode($this->uri->segment(3)));
		$reData = $this->share_lib->get_share_data_de(['share_decode' => $share_id]);

		// 문서 상세 데이터
		$data['share_id'] = $share_id;
		$data['doc_id'] = $reData['data']['doc_id'];

		if($reData['data']['doc_edit'] == 'M'){
			$this->load->view("document/doc_views_m", $data);
		} else {
			$this->load->view("document/doc_views", $data);
		}
	}

	// 문서 상세 데이터
	public function get_doc_detail_prc(){
		$doc_id = trim($this->input->post("doc_id", true));
		$reData = $this->document_lib->get_document_detail(array('doc_id'=> $doc_id));
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 문서 상세 데이터
	public function get_doc_detail_by_id_prc(){
		$doc_id = trim($this->input->post("doc_id", true));
		$reData = $this->document_lib->get_document_detail_by_id(array('doc_id'=> $doc_id));
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 공유 문서 상세 데이터
	public function get_doc_share_detail_prc(){
		$doc_id = trim($this->input->post("doc_id", true));
		$share_id = trim($this->input->post("share_id", true));
		$reData = $this->document_lib->get_doc_share_detail(array('doc_id'=> $doc_id, 'share_id'=> $share_id));
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 공유 URL 생성
	public function add_share_url_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$reData = $this->document_lib->add_share_url_data(['doc_id' => $doc_id]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);

	}


	/********* modify **********/
	// 선택한 문서 삭제 
	public function delete_doc_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$reData = $this->document_lib->delete_document(['doc_id' => $doc_id]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 문서 메모 변경
	public function up_doc_memo_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$doc_memo = trim($this->input->post('doc_memo', true));
		$param = array(
			'doc_id' => $doc_id,
			'doc_memo' => $doc_memo
		);
		$reData = $this->document_lib->modify_document_memo($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 문서 수정 처리 
	public function modify_doc_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$doc_title = trim($this->input->post('doc_title', true));
		$doc_data = trim($this->input->post('doc_data'));
		$doc_color = trim($this->input->post('doc_color', true));
		if(empty($doc_title)) $doc_title = '내 문서 타이틀 명';
		if(empty($doc_color)) $doc_color = 'red';
		$param = array(
			'doc_id' => $doc_id,
			'doc_title' => $doc_title,
			'doc_data' => $doc_data,			
			'doc_color' => $doc_color,
		);
		$reData = $this->document_lib->modify_user_document($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 편집 권한자 문서 수정 처리 
	public function modify_doc_share_prc(){
		// 공유 코드 문서 코드 확인 
		$share_id = trim($this->input->post('share_id', true));
		$doc_id = trim($this->input->post('doc_id', true));
		$doc_data = trim($this->input->post('doc_data'));
		$param = array(
			'share_code' => $share_id,
			'doc_id' => $doc_id,
			'doc_data' => $doc_data
		);
		$reData = $this->document_lib->modify_user_share_document($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	/* Document ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */

	/* Document Share ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */

	// 문서 공유 멤버 데이터 
	public function get_doc_mem_share_data_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$page_num = (int)$this->input->post('page_nm');
		$reData = $this->document_lib->get_doc_mem_share_data(['doc_id'=>$doc_id, 'page_num'=>$page_num]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 선택 멤버 공유하기 
	public function doc_mem_share_prc(){		
		$doc_id = trim($this->input->post('docId', true));
		$edit_type = trim($this->input->post('editType', true));
		$share_type = trim($this->input->post('shareType', true));
		$sheet_list = $this->input->post('sheetList', true);
		$member_list = $this->input->post('memList', true);
		$param = array(
			'doc_id' => $doc_id,
			'edit_type' => $edit_type,
			'share_type' => $share_type,
			'sheet_list' => $sheet_list,
			'member_list' => $member_list
		);
		$reData = $this->document_lib->doc_member_share($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	

	// 문서 공유 멤버 시트 리스트 
	public function get_user_mem_share_sheet_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$share_code = trim($this->input->post('sh_code', true));
		$reData = $this->share_lib->get_user_mem_share_sheet_data(['doc_id'=>$doc_id,'share_code'=>$share_code]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}
	
	// 문서 공유 시트별 상태 변환
	public function set_user_mem_share_sheet_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$share_code = trim($this->input->post('sh_code', true));
		$sheet_id = trim($this->input->post('set_id', true));
		$sheet_type = trim($this->input->post('set_type', true));
		$param = array(
			'doc_id' => $doc_id,
			'share_code' => $share_code,
			'sheet_id' => $sheet_id,
			'sheet_type' => $sheet_type
		);
		$reData = $this->share_lib->set_user_mem_share_sheet($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);

	}

	// 공유 멤버 삭제 
	public function delete_user_mem_share_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$share_id = trim($this->input->post('share_id', true));
		$reData = $this->document_lib->delete_user_mem_share([
			'doc_id' => $doc_id, 
			'share_id'=>$share_id
		]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);		
	}

	// 주소로 리스트 불러 오기 
	public function mem_modal_pop_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$reData = $this->document_lib->get_modal_pop_data(['doc_id'=>$doc_id]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	/* Document Share ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* MY Document ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	// 내 문서
	public function my_doc(){
		$this->load->view("document/my_doc_list");
	}
	
	// 내문서 리스트 
	public function my_doc_list_prc(){
		$my_doc_page = (int)$this->input->post('page');
		$doc_type = trim($this->input->post('type', true));
		$doc_order = trim($this->input->post('ord', true));
		$doc_color = trim($this->input->post('cor', true));
	
		$param = array(
			"my_doc_page" => $my_doc_page,
			"doc_type" => $doc_type,
			"doc_order" => $doc_order,
			"doc_color" => $doc_color			
		);		
		$reData = $this->document_lib->get_my_document_list($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 문서 제목만 변경 처리 
	public function modify_doc_title_prc(){
		$doc_id = trim($this->input->post('docId', true));
		$doc_title = trim($this->input->post('dcoTitle', true));
	
		$param = array(
			"doc_id" => $doc_id,
			"doc_title" => $doc_title			
		);
		$reData = $this->document_lib->modify_user_document_title($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 문서 사본 생성 
	public function copy_doc_prc(){
		$code = trim($this->input->post('code', true));
		$doc_type = trim($this->input->post('dtype', true));
		$reData = $this->document_lib->copy_user_document(['code' => $code, 'doc_type' => $doc_type]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}
	/* MY Document ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* History ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	// 문서 history
	public function history(){
		$doc_id = trim(urldecode($this->uri->segment(3)));;
		$data['doc_id'] = $doc_id;
		$this->load->view("document/doc_history", $data);
	}

	// 문서 히스토리 리스트 
	public function get_doc_history_list_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$reData = $this->document_lib->get_doc_history_list(['doc_id' => $doc_id]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	public function get_doc_history_data_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$his_id = (int)$this->input->post('his_id');
		$reData = $this->document_lib->get_doc_history_data(['doc_id' => $doc_id, 'his_id' => $his_id]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 선택한 문서로 복원
	public function restore_doc_prc(){
		$doc_id = trim($this->input->post('doc_id', true));
		$his_id = (int)$this->input->post('his_id');
		$reData = $this->document_lib->restory_doc_history(['doc_id' => $doc_id, 'his_id' => $his_id]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	/* History ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */

	/* Template ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */

	// 템플릿 리스트
	public function template(){
		$this->load->view("document/template");
	}

	// 템플릿 카테고리 리스트 
	public function template_category_prc(){
		$reData = $this->document_lib->template_category_list();
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 템플릿 리스트 
	public function template_list_prc(){
		$tem_page = (int)$this->input->post('page');
		$tem_search = trim($this->input->post('search', true));
		$tem_order = trim($this->input->post('ord', true));
		$l_cate = (int)$this->input->post('lcate');
		$m_cate = (int)$this->input->post('mcate');
		$s_cate = (int)$this->input->post('scate');

		$param = array(
			'tem_page' => $tem_page,
			'tem_search' => $tem_search,
			'tem_order' => $tem_order,
			'lCate' => $l_cate,
			'mCate' => $m_cate,
			'sCate' => $s_cate
		);
		$reData = $this->document_lib->get_template_list($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}	

	// 템플릿 선택시 해당 템플릿 적용
	public function add_doc_write_tem_prc(){
		$doc_type = trim($this->input->post('doc_type', true));
		$tem_id = trim($this->input->post('tem_id', true));
		$reData = $this->document_lib->get_template_data(['tem_id' => $tem_id]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	/* Template ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
}