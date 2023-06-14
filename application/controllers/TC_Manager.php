<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class TC_Manager extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("UserFunction");
        $this->load->library("Common_lib");
        $this->common_lib->admin_login_check();
		
		$this->load->library("TC_Manager_lib");
		$this->load->library("User_lib");
    }
    
    public function _remap($method)	{
        if(method_exists($this, $method)) {     
            if(strpos($method, "_prc") == TRUE) {
                $this->{$method}();
            } else {
                $admininfo = $this->session->userdata("admininfo");

				$rgStyleSheet = array();
				$rgJavaScript = array();

				$strHeadType = "head_manager";
				$strTailType = "footer_manager";

				// 관리자 메뉴
				$menuData = $this->tc_manager_lib->menu_list();
				$act = $this->uri->segment(3,"");

				$menu_m = $method;
				$menu_s = $act;

				switch($method){
					case "member" :

						$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-bs/css/dataTables.bootstrap.min.css";
						$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-buttons-bs/css/buttons.bootstrap.min.css";
						$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css";
						$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-responsive-bs/css/responsive.bootstrap.min.css";
						$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-scroller-bs/css/scroller.bootstrap.min.css";
						$rgStyleSheet[] = ADMIN_CSS_PATH."member_list.css";
					
						$rgJavaScript[] = ADMIN_TEMPLATE_PATH."datatables.net/js/jquery.dataTables.min.js";
						$rgJavaScript[] = ADMIN_TEMPLATE_PATH."pdfmake/build/pdfmake.min.js";
						$rgJavaScript[] = ADMIN_JS_PATH.$method."/list.js";
					break;
					case "notice":
						switch($act){
							case "list" :
						
								$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-bs/css/dataTables.bootstrap.min.css";
								$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-buttons-bs/css/buttons.bootstrap.min.css";
								$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css";
								$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-responsive-bs/css/responsive.bootstrap.min.css";
								$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-scroller-bs/css/scroller.bootstrap.min.css";

								$rgJavaScript[] = ADMIN_TEMPLATE_PATH."datatables.net/js/jquery.dataTables.min.js";						
								$rgJavaScript[] = ADMIN_JS_PATH.$method."/".$act.".js";
							break;
							case "view" :
							break;
						}
					break;
					case "document" :
						
						$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-bs/css/dataTables.bootstrap.min.css";
						$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-buttons-bs/css/buttons.bootstrap.min.css";
						$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css";
						$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-responsive-bs/css/responsive.bootstrap.min.css";
						$rgStyleSheet[] = ADMIN_TEMPLATE_PATH."datatables.net-scroller-bs/css/scroller.bootstrap.min.css";

						$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.".SPREADJS_VAR.".css";
						$rgStyleSheet[] = SPREADJS_PATH."css/gc.spread.sheets.excel2013white.".SPREADJS_VAR.".css";
						$rgStyleSheet[] = DESIGNER_PATH."css/gc.spread.sheets.designer.".SPREADJS_VAR.".min.css";
						
						$rgJavaScript[] = ADMIN_TEMPLATE_PATH."datatables.net/js/jquery.dataTables.min.js";

						switch($act){
							case "user" :
								$rgJavaScript[] = SPREADJS_PATH."scripts/gc.spread.sheets.all.".SPREADJS_VAR.".min.js";
								$rgJavaScript[] = SPREADJS_PATH."scripts/FileSaver.min.js";
								$rgJavaScript[] = SPREADJS_PATH."license_tc.js";
								$rgJavaScript[] = ADMIN_JS_PATH.$method."/".$act.".js";
							break;
							case "template" :
								$act_dt = $this->uri->segment(4,"") ? $this->uri->segment(4,"") : "list";
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
								$rgJavaScript[] = ADMIN_JS_PATH.$method."/".$act."_common.js";
								$rgJavaScript[] = ADMIN_JS_PATH.$method."/".$act."_".$act_dt.".js";
							
							break;
							case "cate_template" :
								$rgJavaScript[] = ADMIN_JS_PATH."jquery-ui.js";								
								$rgJavaScript[] = ADMIN_JS_PATH.$method."/".$act.".js";
							break;
						}
					break;
					case 'user_mem' :						
						$rgJavaScript[] = ADMIN_JS_PATH.$method."/list.js";
					break;					
				}

				$rgHeader = array(
					"h_Title"			=> "TeemCell Admin",
					"h_StyleSheet"		=> $rgStyleSheet,					
					"admin_data"		=> $admininfo,
					"menu_list"			=> $menuData,
					"menu_m" 			=> $menu_m,
					"menu_s" 			=> $menu_s
				);

				$rgFooter = array(
					"h_JavaScript" 		=> $rgJavaScript
				);				

				$this->load->view("include/".$strHeadType, $rgHeader);			
				$this->{$method}();
				$this->load->view("include/".$strTailType, $rgFooter);
			}
		} else  {
			show_404();
		}
	}

	private function datatableparse(){
		$order = $this->input->get("order");
		$columns = $this->input->get("columns");
		$length = (int)$this->input->get("length");
		$start = (int)$this->input->get("start");
		$search = $this->input->get("search");
		if(isset ($search["value"]) && trim($search["value"])  !=""){
			$data["search"] = trim($search["value"]);
		}else $data["search"] ="";
		$data["order"] = ($order =="")?'': $columns[ $order[0]["column"] ]["data"];
		$data["order_dir"] =  $order[0]["dir"];
		$data["length"] = ($length < 1) ? 10 :(int)$length;
		$data["start"] = ($start < 1) ? 0 :(int)$start;
		return $data;
	}

    public function index(){
       $this->load->view("manager/main/main");
    }

	/* 회원 관리 ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */	
    public function member(){
		$rltCode = $this->common_lib->member_status_code();
		if($rltCode) {
			$data["cb_code"] = $rltCode;
			foreach( $rltCode as $row ){
				$jsoncode[$row["code_detail"]] = $row["code_name"];
			}
		}
		else $data["cb_code"] = array();
		$data["jsoncode"] = $jsoncode;
		$this->load->view("manager/member/list", $data);
    }

	public function member_list_prc(){		
		$param = array(
			"tabledata" => $this->datatableparse(),
			"draw" => $this->input->get("draw")
		);
		$reData = $this->tc_manager_lib->member_list($param);		
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	public function member_changeStatus_prc(){
		$user_idx = (int)$this->input->post("idx");
		$user_status = trim($this->input->post("changestatus", true));
		$prc = trim($this->input->post("prc", true));

		$param = array(
				"idx" => $user_idx,
				"status" => $user_status,
				"prc" => $prc
			);
		$reData = $this->user_lib->member_change_status($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);

	}

	// 회원 이름 변경
	public function member_changeName_prc(){
		$idx = (int)$this->input->post("idx");
		$name = trim($this->input->post("changeName"));

		$param = array(
				"idx"=> $idx,
				"name"=> $name
			);

		$reData = $this->user_lib->member_change_name($param);		
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 회원 비밀 번호 변경
	public function member_changePw_prc(){
		$idx = (int)$this->input->post("idx");
		$pw = trim($this->input->post("changepw"));

		$params = array(
				"idx"=> $idx,
				"pw"=> $pw
			);
		$reData = $this->user_lib->member_change_pw($params);		
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 주소록 관리
	public function user_mem(){
		$this->load->view("manager/user_mem/list");
	}

	// 주소록 리스트 
	public function user_mem_list_prc(){		
		$param = array(
			"tabledata" => $this->datatableparse(),
			"draw" => $this->input->get("draw")
		);
		$reData = $this->tc_manager_lib->user_mem_list($param);		
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	/* 회원 관리 ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* 문서 관리 ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */	
	public function document(){
		$act = $this->uri->segment(3,"");
		switch($act){
			// 회원 등록 문서 관리 
			case 'user' :
				$this->load->view("manager/document/".$act);
				break;

			//  템블릿 관리
			case 'template' :
				$act_dt = $this->uri->segment(4,"");
				switch($act_dt){
					case "list" :
					default :
						$main_cate = $this->tc_manager_lib->get_category_list(array("cate_idx"=>'0'));
						$data['cate'] = $main_cate['data'];
						$this->load->view("manager/document/template_list", $data);
					break;
					// 템플릿 작성
					case "write" :
						$main_cate = $this->tc_manager_lib->get_category_list(array("cate_idx"=>'0'));
						$data['cate'] = $main_cate['data'];
						$this->load->view("manager/document/template_write", $data);
					break;
					// 템플릿 상세 보기
					case "view" :
						$tem_idx = (int)$this->input->get("idx");
						if(empty($tem_idx)){
							echo "<script>alert('삭제된 게시물 입니다.'); window.location.href = '/TC_Manager/document/template'</script>";
							exit;
						}
						$data["idx"] = $tem_idx;
						$this->load->view("manager/document/template_view", $data);
					break;
					// 템플릿 수정
					case "modify" :
						$tem_idx = (int)$this->input->get("idx");
						if(empty($tem_idx)){
							echo "<script>alert('삭제된 게시물 입니다.'); window.location.href = '/TC_Manager/document/template'</script>";
							exit;
						}
						$main_cate = $this->tc_manager_lib->get_category_list(array("cate_idx"=>'0'));
						$data['cate'] = $main_cate['data'];
						$data["idx"] = $tem_idx;
						$this->load->view("manager/document/template_modify", $data);
					break;
				}
				break;
			// 템플릿 카테고리 관리
			case "cate_template" :
					$main_cate = $this->tc_manager_lib->get_category_list(array("cate_idx"=>'0'));
					$data['cate'] = $main_cate['data'];
					$this->load->view("manager/document/".$act, $data);
				break;
			default :
				break;
		}
	}

	public function doc_user_list_prc(){
		$tabledata = $this->datatableparse();
		$param = array(
			"tabledata" => $tabledata,
			"draw" => $this->input->get("draw")
		);
		$reData = $this->tc_manager_lib->document_user_list($param);		
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);		
	}

	public function get_document_detail_prc(){
		$doc_idx = (int)$this->input->post("doc_idx");
		$param = array(
            'doc_idx'=> $doc_idx
        );
        $reData = $this->tc_manager_lib->get_document_detail($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}
	
	////////////// TEMPLAATE 관리 //////////////////////////////////////////////////////////
	public function get_template_list_prc(){

		$lcate = (int)$this->input->post("lcate");
		$mcate = (int)$this->input->post("mcate");
		$scate = (int)$this->input->post("scate");
		$search = $this->input->post("searchtxt", true);
		$param = array(
			"lcate" => $lcate,
			"mcate" => $mcate,
			"scate" => $scate,
			"search" => $search
		);
		$reData = $this->tc_manager_lib->get_template_list($param);		
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);		
	}
	
	
	// 템플릿 추가
	public function add_template_prc(){
		$l_cate = (int)$this->input->post("l_cate");
		$m_cate = (int)$this->input->post("m_cate");
		$s_cate = (int)$this->input->post("s_cate");
		$tem_title = trim($this->input->post("tem_title", true));
		$tem_memo = trim($this->input->post("tem_memo", true));
		$tem_data = $this->input->post("tem_data");
		$param = array(
			"lCate" => $l_cate,
			"mCate" => $m_cate,
			"sCate" => $s_cate,
			"temTitle" => $tem_title,
			"temMemo" => $tem_memo,
			"temData" => $tem_data,
			"FILES" => $_FILES
		);		
		$reData = $this->tc_manager_lib->add_template($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 템블릿 수정 
	public function modify_template_prc(){
		$tem_idx = (int)$this->input->post("template_idx");
		$l_cate = (int)$this->input->post("l_cate");
		$m_cate = (int)$this->input->post("m_cate");
		$s_cate = (int)$this->input->post("s_cate");
		$tem_title = trim($this->input->post("tem_title", true));
		$tem_memo = trim($this->input->post("tem_memo", true));
		$tem_data = $this->input->post("tem_data");
		$param = array(
			"template_idx" => $tem_idx,
			"lage_category" => $l_cate,
			"middle_category" => $m_cate,
			"small_category" => $s_cate,
			"template_title" => $tem_title,
			"template_memo" => $tem_memo,
			"template_data" => $tem_data,
			"files_data" => $_FILES
		);
		//print_r($param);
		$reData = $this->tc_manager_lib->modify_template($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 템블릿 상세
	public function get_template_detail_prc(){
		$idx = (int)$this->input->post("idx");
		$reData = $this->tc_manager_lib->get_template_data(['idx'=>$idx]);		
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 템플릿 삭제 
	public function del_template_prc(){
		$idx = (int)$this->input->post("idx");
		$reData = $this->tc_manager_lib->delete_template(['idx'=>$idx]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);	
	}

	// 템플릿 순서 변경 처리
	public function up_template_sort_prc(){
		$idx = (int)$this->input->post("idx");
		$sort = (int)$this->input->post("sort_num");
		$param = array(
			"idx" => $idx,
			"sort" => $sort
		);		
		$reData = $this->tc_manager_lib->up_template_sort($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 선택 분류 정보 
	public function get_category_by_idx_prc(){
		$idx = (int)$this->input->post("idx");

		$reData = $this->tc_manager_lib->get_category_by_idx(['idx'=>$idx]);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 템플릿 분류 추가 
	public function add_doc_templay_category_prc(){
		$tem_idx = (int)$this->input->post("tem_idx");
		$l_cate = (int)$this->input->post("l_cate");
		$m_cate = (int)$this->input->post("m_cate");
		$s_cate = (int)$this->input->post("s_cate");

		$param = array(
			"tem_idx" => $tem_idx,
			"l_cate" => $l_cate,
			"m_cate" => $m_cate,
			"s_cate" => $s_cate,
		);
		$reData = $this->tc_manager_lib->add_doc_templay_category($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 템플릿 분류 수정
	public function modify_doc_templay_category_prc(){
		$cate_idx = (int)$this->input->post("cate_idx");
		$l_cate = (int)$this->input->post("l_cate");
		$m_cate = (int)$this->input->post("m_cate");
		$s_cate = (int)$this->input->post("s_cate");
		$param = array(
			"idx" => $cate_idx,
			"l_cate" => $l_cate,
			"m_cate" => $m_cate,
			"s_cate" => $s_cate,
		);
		$reData = $this->tc_manager_lib->up_doc_templay_category($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	////////////// 카테고리 관리 //////////////////////////////////////////////////////////
	// 카테고리 상세
	public function get_category_dt_prc(){
		$idx = (int)$this->input->post("idx");
		$param = array(
			"idx" => $idx
		);		
		$reData = $this->tc_manager_lib->get_template_category_dt($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 카테고리명 변경
	public function change_category_name_prc(){
		$idx = (int)$this->input->post("idx");
		$cate_name = $this->input->post("cateName");		
		$param = array(
			"idx" => $idx,
			"cate_name" => $cate_name
		);		
		$reData = $this->tc_manager_lib->change_template_cate_name($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 카테고리 삭제
	public function del_category_prc(){
		$idx = (int)$this->input->post("idx");
		$param = array(
			"idx" => $idx
		);		
		$reData = $this->tc_manager_lib->del_template_category($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 카테고리 추가 
	public function add_category_prc(){		
		$cate_idx = (int)$this->input->post("cate_idx");
		$cate_type = $this->input->post("cate_type");
		$cate_name = $this->input->post("cate_name");
		$param = array(
			"cate_idx" => $cate_idx,
			"cate_type" => $cate_type,
			"cate_name" => $cate_name
		);		
		$reData = $this->tc_manager_lib->add_template_category($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 카테고리 정렬값 변경
	public function up_category_sort_prc(){
		$idx = (int)$this->input->post("cate_idx");
		$sort = (int)$this->input->post("sort_num");
		$param = array(
			"idx" => $idx,
			"sort" => $sort
		);		
		$reData = $this->tc_manager_lib->up_template_category_sort($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 카테고리 리스트
	public function get_category_list_prc(){
		$cate_idx = (int)$this->input->post("cate_idx");
		$param = array(
			"cate_idx" => $cate_idx
		);	
		$reData = $this->tc_manager_lib->get_category_list($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	public function get_doc_template_category_prc(){
		$tem_idx = (int)$this->input->post("idx");
		$param = array(
			"idx" => $tem_idx
		);	
		$reData = $this->tc_manager_lib->get_doc_template_category_list($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	// 등록된 카테고리 삭제
	public function del_doc_template_category_prc(){
		$tem_cate_idx = (int)$this->input->post("tem_cate_idx");
		$param = array(
			"idx" => $tem_cate_idx
		);	
		$reData = $this->tc_manager_lib->del_doc_template_category($param);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}
	/* 문서 관리 ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* 게시판 관리 ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */	

	// 게시판 관리 / 공지사항
	public function notice(){
		$cate = $this->uri->segment(2,""); 
		$act = $this->uri->segment(3,"");
		switch($act){
			case "write" : 
				$this->load->view("manager/".$cate."/write");
				break;
			case "view" :
				break;
			case "list" :
			default :
				$this->load->view("manager/".$cate."/list");
				break;
		}
	}

	public function notice_list_prc(){
		$tabledata = $this->datatableparse();
		$param = array(
			"tabledata" => $tabledata,
			"draw" => $this->input->get("draw")
		);
		$reData = $this->tc_manager_lib->notice_list($param);		
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	public function get_notice_detail_prc(){
		$board_idx = trim($this->input->get_post("board_idx"));
        $params = array(
            "board_idx"=> $board_idx
        );
        $reData = $this->tc_manager_lib->get_notice_detail($params);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);		
	}

	public function add_notice_prc(){
		$notice_title = trim($this->input->get_post("notice_title"));
		$notice_content = trim($this->input->get_post("notice_content"));
		$params = array(
            "notice_title"=> $notice_title,
			"notice_content"=> $notice_content
        );
		$reData = $this->tc_manager_lib->add_notice_prd($params);
		echo json_encode($reData, JSON_UNESCAPED_UNICODE);
	}

	/* 게시판 관리 ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */

	public function admin_user_login_prc(){
		$this->load->library("Login_lib");
		$user_idx = trim($this->input->post("user_idx"));			

		$res = $this->login_lib->admin_user_login_prc(['user_idx' => $user_idx]);
		if($res['code'] == 200){
			header('Location: /', TRUE, null);
		} else {
			echo("<script>alert('".$res['msg']."');self.close()</script>");
		}
	}
}