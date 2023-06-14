<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Document_lib {
	var $CI;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library('UserFunction');
		$this->CI->load->library('Common_lib');

		$this->CI->load->model('Document_model');
		$this->CI->load->model('Share_model');
		$this->CI->load->model('Member_model');

		$this->userinfo = $this->CI->session->userdata('userinfo');
	}
	/* Document ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	/****** write ******/
	public function add_user_document($param){		
		// sheet 별 처리 
		$doc_data = JSON_DECODE($param['doc_data'], true);
		
		// sheets 별도 분리
		$doc_data_sheets = $doc_data['sheets'];

		// 원본 문서에서 sheets 정보 삭제
		unset($doc_data['sheets']);	

		// 문서 고유 ID 생성
		$doc_id = $this->CI->userfunction->fnStrUniqId('udc');
		$now_date = date('Y-m-d H:i:s');		

		// color code 정보
		$color_data = $this->CI->common_lib->array_doc_color_code();

		// 문서 기본정보 저장
		$doc_param = array(
			'doc_id'		=> $doc_id,
			'user_idx'		=> $this->userinfo['idx'],
			'doc_title'		=> $param['doc_title'],			
			'doc_type'		=> $param['doc_type'],
			'tem_id'		=> $param['tem_id'],			
			'doc_color'		=> $color_data[$param['doc_color']],
			'doc_share_cnt' => 0,
			'use_yn'		=> 'Y',
			'reg_date'		=> $now_date
		);
		$res_doc = $this->CI->Document_model->add_document_info($doc_param);

		if($res_doc === false) {
			return array('code'=>425 ,'msg'=>'처리중 오류가 발생 하였습니다.');
			exit;
		}

		
		$doc_param_dt = array(
			'doc_id'		=> $doc_id,				
			'doc_data'		=> JSON_ENCODE($doc_data, JSON_UNESCAPED_UNICODE),
			'use_yn'		=> 'Y',
			'reg_date'		=> $now_date
		);
		$res_doc_dt = $this->CI->Document_model->add_document_data($doc_param_dt);

		if($res_doc_dt === false) {
			return array('code'=>425 ,'msg'=>'처리중 오류가 발생 하였습니다.');
			exit;
		}

		$doc_param_dt = array(
			'doc_id'		=> $doc_id,				
			'user_idx'		=> $this->userinfo['idx'],
			'doc_memo'		=> $param['doc_memo'],
			'use_yn'		=> 'Y',
			'reg_date'		=> $now_date
		);
		$res_doc_dt = $this->CI->Document_model->add_document_memo($doc_param_dt);
		if($res_doc_dt === false) {
			return array('code'=>425 ,'msg'=>'처리중 오류가 발생 하였습니다.');
			exit;
		}

		// 분리된 시트를 시트별로 저장 처리
		if(count($doc_data_sheets) > 0){
			foreach($doc_data_sheets as $row){
				$sheet_value_data = array();
				$sheet_id = $this->CI->userfunction->fnStrUniqId('ush');
				$sheet_name = $row['name'];
				$row['data']['defaultDataNode']['tag'] = $sheet_id;
				$sheet_value_data = $row['data']['dataTable'];
				unset($row['data']['dataTable']);
				$sheet_data = array(
					'doc_id'		=> $doc_id,
					'sheet_id'		=> $sheet_id,
					'sheet_name'	=> $sheet_name,
					'sheet_data'	=> JSON_ENCODE($row, JSON_UNESCAPED_UNICODE),
					'use_yn'		=> 'Y'
				);
				$this->CI->Document_model->add_document_sheet_data($sheet_data);
				// 데이터 디비 저장 처리 
				foreach($sheet_value_data as $x_idx => $x_row){						
					foreach($x_row as $y_idx => $val){
						$this->CI->Document_model->add_document_sheet_dt_data(
							[
								'sheet_id'		=> $sheet_id,
								'dt_x'			=> $x_idx,
								'dt_y'			=> $y_idx ,
								'dt_data'		=> JSON_ENCODE($val, JSON_UNESCAPED_UNICODE),
							]
						);
					}						
				}					
			}
		}
		$re_data = ["id" => $doc_id];
		return array('code'=>200, "data"=>$re_data);
		
	}
	
	/****** view ******/
	// 문서 상제 정보
	public function get_document_detail($param){
		$doc = $this->CI->Document_model->get_document_info(array('doc_id' => $param['doc_id'], 'user_idx'=>$this->userinfo['idx']));
		if(empty($doc)){
			return array('code' => 425, 'msg' => '문서 정보가 존재 하지 않습니다.');
			exit;
		}
		
		// memo
		$doc_memo = $this->CI->Document_model->get_document_memo(array('doc_id' => $doc['doc_id'], 'user_idx'=>$this->userinfo['idx']));
		$doc['doc_memo'] = !empty($doc_memo['doc_memo']) ? $doc_memo['doc_memo'] : '';

		//usl share
		$doc_url_share = $this->CI->Share_model->get_docment_share_url(['doc_id' => $doc['doc_id']]);
		if(empty($doc_url_share['share_code'])) $doc['url_share'] = "";
		else $doc['url_share'] = $this->CI->userfunction->fnSimpleCrypt($doc_url_share['share_code'], 'e');

		$array_doc_data = json_decode($doc['doc_data'], true);

		$doc_sheet = $this->CI->Document_model->get_document_sheet(array('doc_id' => $doc['doc_id']));

		if(!empty($doc_sheet)){

			$i = 0;
			foreach($doc_sheet as $row){
				if($doc['doc_id'] == 'udc_6476ef3a2c91d78' && $i == 0 ){					
					$target_url = WEB_URL."tc_file/mr_status.json";
					$arHeaders = array();
					$arParams = array();
					$redata = $this->CI->userfunction->fnCurlExec($target_url, 'GET', $arHeaders, $arParams);
					if($redata['code'] == 200){
						$data_table = array();
						$x_cnt = 0;
						foreach($redata['data'] as $key_s => $row_s){							
							$data_table[0][$x_cnt] = array("value" => $key_s);
							$ii = 2;
							foreach($row_s as $key_t => $row_t){
								foreach($row_t as $key_f => $row_f){
									if($ii == 2){
										$data_table[$ii-1][] = array("value" => $key_f);
										$data_table[$ii][] = array("value" => $row_f);										
									} else {
										$data_table[$ii][] = array("value" => $row_f);
									}
								}								
								$ii++;
							}
							$x_cnt = $x_cnt + count($row_s[0]);
						}
					}
					$n_sheet_data = JSON_DECODE($row['sheet_data'], true);
					unset($n_sheet_data['data']['dataTable']);
					$n_sheet_data['data']['dataTable'] = $data_table;
					$row['sheet_data'] = JSON_ENCODE($n_sheet_data, JSON_UNESCAPED_UNICODE);
				}

				if(in_array($doc['doc_id'], array('udc_647e7a2105cda13', 'udc_647e69b345a6f18')) && $i == 0 ){
					$target_url = WEB_URL."tc_file/mr_list_all.json";
					$arHeaders = array();
					$arParams = array();
					$redata = $this->CI->userfunction->fnCurlExec($target_url, 'GET', $arHeaders, $arParams);
					if($redata['code'] == 200){
						$data_table = array();
						$x_cnt = 1;
						$y_cnt = 4;
						foreach($redata['data']['rows'] as $key_s => $row_s){
							$x_cnt = 1;
							foreach($row_s as $key_t => $row_t){
								$data_table[$y_cnt][0] =  array("value" => $y_cnt - 3);
								$data_table[$y_cnt][$x_cnt] =  array("value" => $row_t);
								$x_cnt++;
							}							
							$y_cnt++;
						}
						$n_sheet_data = JSON_DECODE($row['sheet_data'], true);
						unset($n_sheet_data['data']['dataTable']);
						$n_sheet_data['data']['dataTable'] = $data_table;
						$row['sheet_data'] = JSON_ENCODE($n_sheet_data, JSON_UNESCAPED_UNICODE);
					}
				}

				$sheet_dt = $this->CI->Document_model->get_document_sheet_dt(['sheet_id' => $row['sheet_id']]);
				if($sheet_dt){
					$sheet_detail_data = array();
					foreach($sheet_dt as $dt_row){
						$sheet_detail_data[$dt_row['dt_x']][$dt_row['dt_y']] = JSON_DECODE($dt_row['dt_data'], true);
					}
					$sheet_data =  JSON_DECODE($row['sheet_data'], true);
					$sheet_data['data']['dataTable'] = $sheet_detail_data;
				} 
				else {
					$sheet_data =  JSON_DECODE($row['sheet_data'], true);
				}
				$array_doc_data['sheets'][$row['sheet_name']] = $sheet_data;
				$array_doc_data['sheets'][$row['sheet_name']]['index'] = $i;
				$i++;
			}
			$doc['doc_data'] = $array_doc_data;
			return array('code' => 200, 'data' => $doc);
		} else {
			return array('code' => 425, 'msg' => '문서 상세 정보가 존재 하지 않습니다.');
		}	
		
	}

	// 문서 상제 정보
	public function get_document_detail_by_id($param){
		$doc = $this->CI->Document_model->get_document_doc_id(array('doc_id' => $param['doc_id']));
		if($doc){
			// memo
			$doc_memo = $this->CI->Document_model->get_document_memo(array('doc_id' => $param['doc_id'], 'user_idx'=>$this->userinfo['idx']));
			$doc['doc_memo'] = !empty($doc_memo['doc_memo']) ? $doc_memo['doc_memo'] : '';		

			$array_doc_data = json_decode($doc['doc_data'], true);

			$doc_sheet = $this->CI->Document_model->get_document_sheet(array('doc_id' => $doc['doc_id']));

			if(!empty($doc_sheet)){
				$i = 0;
				foreach($doc_sheet as $row){
					$array_doc_data['sheets'][$row['sheet_name']] = json_decode($row['sheet_data'], true);
					$array_doc_data['sheets'][$row['sheet_name']]['index'] = $i;
					$i++;
				}
				$doc['doc_data'] = $array_doc_data;
				return array('code' => 200, 'data' => $doc);
			} else {
				return array('code' => 425, 'msg' => '문서 상세 정보가 존재 하지 않습니다.');
			}	
		} else {
			return array('code' => 425, 'msg' => '문서 정보가 존재 하지 않습니다.');
		}	
	}

	// 공유 문서 상세 정보 
	public function get_doc_share_detail($param){
		// 공유 데이터 가져 오기 
		$share_data = $this->CI->Share_model->get_share_docment(array('share_code'=>$param['share_id']));
		if(empty($share_data)){
			return array('code'=>425, 'msg'=>'정보가 올바르지 않습니다.');			
			exit;
		}

		//타입에 타른 문서 호출 
		$sheet_id_data = json_decode($share_data['sheet_id'], true);		

		// 문서 호출 		
		$doc_data = $this->CI->Document_model->get_document_doc_id(array('doc_id' => $share_data['doc_id']));
		if(empty($doc_data)){
			return array('code'=>425, 'msg'=>'정보가 올바르지 않습니다.');	
			exit;
		}

		$doc_data['shd'] = JSON_DECODE($share_data['sheet_id'], true);
		$doc_data['shd']['list_dt'] = array();

		$array_doc_data = JSON_DECODE($doc_data['doc_data'], true);

		// memo
		$doc_memo = $this->CI->Document_model->get_document_memo(array('doc_id' => $share_data['doc_id'], 'user_idx'=>$this->userinfo['idx']));
		$doc_data['doc_memo'] = !empty($doc_memo['doc_memo']) ? $doc_memo['doc_memo'] : '';

		// 전채 문서 
		if($sheet_id_data['stype'] == 'all'){
			/* 전채 문서 ********************************/
			$sheet_data = $this->CI->Document_model->get_document_user_sheet(array('doc_id' => $doc_data['doc_id']));			
			if($sheet_data){				
				$tp = $sheet_id_data['ptype'] == 'M' ? 'M' : 'V'; //편집 권한인지 확인
				foreach($sheet_data as $row){
					$arr_sheet_data = json_decode($row['sheet_data'], true);
					$array_doc_data['sheets'][$row['sheet_name']] = $arr_sheet_data;					
				}
				$doc_data['doc_data'] = $array_doc_data;
				return array('code' => 200, 'data' => $doc_data, 'type' => $tp);
				exit;
			}
			else {
				return array('code'=>425, 'msg'=>'정보가 올바르지 않습니다.');	
				exit;
			}
		}
		else {
			$array_doc_data['activeSheetIndex'] = 0;
			/* 시트 지정  ********************************/
			if(count($sheet_id_data['list']) > 0) {
				$i = 0;
				$tp = 'V';  // 저장 버튼을 위해 현제를 편집 권한 없음
				foreach($sheet_id_data['list'] as $row){					
					$arr_sheet_data = $this->CI->Document_model->get_documet_sheet_detail(array('doc_id' => $doc_data['doc_id'], 'sheet_id' => $row[0]));					
					if($arr_sheet_data) {
						$array_doc_data['sheets'][$arr_sheet_data['sheet_name']] = JSON_DECODE($arr_sheet_data['sheet_data'],true);
						$array_doc_data['sheets'][$arr_sheet_data['sheet_name']]['index'] = $i;
						$doc_data['shd']['sh_name'][$arr_sheet_data['sheet_id']] = $arr_sheet_data['sheet_name'];
						$i++;
					}
					if($row[1] == 'M') $tp = 'M'; // 편집 권한이 하나라도 있으면 저장 버튼 노출
				}
				$array_doc_data['sheetCount'] = $i;
				$doc_data['doc_data'] = $array_doc_data;
				return array('code' => 200, 'data' => $doc_data, 'type' => $tp);
			}
			else {
				return array('code'=>425, 'msg'=>'정보가 올바르지 않습니다.');	
				exit;
			}
		}
	}

	// 공유 URL 생성
	public function add_share_url_data($param){
		$share_code = $this->CI->userfunction->fnStrUniqId('sae');
		$share_param = array(
			'share_code' => $share_code,
			'share_type' => 'U',
			'user_idx' => $this->userinfo['idx'],
			'user_mem_idx' => '0',
			'doc_id' => $param['doc_id'],
			'doc_edit' => 'V',
			'sheet_id' => json_encode(['stype' => 'all', 'ptype' => 'V'], JSON_UNESCAPED_UNICODE),
			'limit_date' => date("Y-m-d H:i:s", strtotime("+1 years"))
		);
		$reData = $this->CI->Share_model->add_document_share_data($share_param);
		if($reData){
			return array("code"=>200, "data"=>['share_url_val' => $this->CI->userfunction->fnSimpleCrypt($share_code, 'e')]);
		}
		else {
			return array("code"=>402, "msg"=>"처리 오류");
		}
	}	

	/****** modify ******/
	// 문서 삭제 
	public function delete_document($param){
		$param['user_idx'] = $this->userinfo['idx'];
		
		$reData = $this->CI->Document_model->delete_document($param);
		if($reData){
			return array('code'=>200, 'msg'=>"Success");
		}else{
			return array('code'=>400, 'msg'=>"Failed");
		}
	}

	// 메모 수정 
	public function modify_document_memo($param){
		$u_param = array(
			'doc_id'	=> $param['doc_id'],
			'user_idx'	=> $this->userinfo['idx'],			
			'doc_memo'	=> $param['doc_memo'], 
			'use_yn'	=> 'Y'
		);
		$reData = $this->CI->Document_model->add_document_memo($u_param);
		if($reData){
			return array('code'=>200, 'data' => $param['doc_id']);
		}else{
			return array('code'=>425, 'msg' => '처리중 오류가 발행 하였습니다.');
		}
	}

	// 문서 수정 처리
	public function modify_user_document($param){
		//현재 문서 정보 호출
		$doc = $this->CI->Document_model->get_document_info(array('doc_id' => $param['doc_id'], 'user_idx'=>$this->userinfo['idx']));
		if(empty($doc)){
			return array('code' => 425, 'msg' => '문서 정보가 존재 하지 않습니다.');
			exit;
		}		
		// doc add_document_history_data
		$res_doc_his = $this->CI->Document_model->add_document_history_data(
			array(
				'user_idx'	=> $this->userinfo['idx'],
				'his_info'	=> $this->userinfo['user_name'].'님이 수정 하셧습니다.',
				'doc_id'	=> $doc['doc_id'],
				'doc_data'	=> $doc['doc_data']			
			)
		);

		// sheet add_document_history_sheet_data
		if($res_doc_his){
			$doc_sheet = $this->CI->Document_model->get_document_sheet(['doc_id' => $doc['doc_id']]);
			if($doc_sheet){
				foreach($doc_sheet as $row){
					$this->CI->Document_model->add_document_history_sheet_data(
						array(
							'his_idx'	=> $res_doc_his,
							'doc_id'	=> $doc['doc_id'],
							'sheet_id'	=> $row['sheet_id'],
							'sheet_name' => $row['sheet_name'],
							'sheet_data' => $row['sheet_data'],
						)
					);
				}
			}
		}

		// 수정된 문서 저장 처리 
		// sheet 별 처리 
		$n_doc_data = JSON_DECODE($param['doc_data'], true);		
		
		// sheets 별도 분리
		$n_doc_data_sheets = $n_doc_data['sheets'];

		// 원본 문서에서 sheets 정보 삭제
		unset($n_doc_data['sheets']);

		// color code 정보
		$color_data = $this->CI->common_lib->array_doc_color_code();
		
		// 문서 기본 정보 수정
		$this->CI->Document_model->modify_document_info(
			array(
				'doc_id'	=> $doc['doc_id'],
				'user_idx'	=> $this->userinfo['idx'],
				'doc_title' => $param['doc_title'],
				'doc_color' => $color_data[$param['doc_color']],
			)
		);	

		$this->CI->Document_model->modify_document_data(
			array(
				'doc_id'	=> $doc['doc_id'],					
				'doc_data'	=> JSON_ENCODE($n_doc_data, JSON_UNESCAPED_UNICODE),
			)
		);	

		// 시트 사용 불가 상태로 변경
		$this->CI->Document_model->change_sheet_all_yn(
			array(
				'doc_id' => $doc['doc_id'],
				'use_yn' => 'N'
			)
		);

		if(count($n_doc_data_sheets) > 0){
			foreach($n_doc_data_sheets as $row){
				if(!empty($row['data']['defaultDataNode']['tag'])) {
					$this->CI->Document_model->modify_document_sheet(
						array(
							'sheet_id' => $row['data']['defaultDataNode']['tag'],
							'data' => array(
								'sheet_name'	=> $row['name'],
								'sheet_data'	=> JSON_ENCODE($row, JSON_UNESCAPED_UNICODE),
								'use_yn'		=> 'Y',
								'up_date'		=> date('Y-m-d H:i:s')
							)
						)
					);					
				} else {
					$sheet_id = $this->CI->userfunction->fnStrUniqId('ush');
					$sheet_name = $row['name'];	
					$row['data']['defaultDataNode']['tag'] = $sheet_id;		
					$sheet_data = array(
						'doc_id'		=> $doc['doc_id'],
						'sheet_id'		=> $sheet_id,
						'sheet_name'	=> $sheet_name,
						'sheet_data'	=> JSON_ENCODE($row, JSON_UNESCAPED_UNICODE),
						'use_yn'		=> 'Y'
					);
					$this->CI->Document_model->add_document_sheet_data($sheet_data);
				}				
			}
		}
		return array('code'=>200);
	}

	// 문서 편집 권한자 수정
	public function modify_user_share_document($param){
		// 권한 확인 
		// 공유 정보 확인 
		$share_data = $this->CI->Share_model->get_share_docment(array('share_code'=>$param['share_code']));
		if(empty($share_data)){
			return array('code'=>425, 'msg'=>'정보가 올바르지 않습니다.!!');			
			exit;
		}
		if($share_data['share_type'] != 'M' || $share_data['doc_edit'] != 'M' || empty($share_data['user_mem_idx'])){
			return array('code'=>425, 'msg'=>'문서 수정 권한이 없습니다.');
			exit;
		}
		// 공유한 회읜의 주소록에서 현제 회원 정보와 일치 하는지 확인 
		$share_mem = $this->CI->Member_model->get_user_member_detail(
			array('mem_idx' => $share_data['user_mem_idx'], 'user_idx' => $share_data['user_idx'])
		);

		if($share_mem['user_check'] != $this->userinfo['idx']){
			return array('code'=>425, 'msg'=>'문서 수정 권한이 없습니다.');
			exit;
		}
		//데이터 자장 

		//현재 문서 정보 호출
		$doc = $this->CI->Document_model->get_document_doc_id(array('doc_id' => $param['doc_id']));
		if(empty($doc)){
			return array('code' => 425, 'msg' => '문서 정보가 존재 하지 않습니다.');
			exit;
		}

		// 현재 데이터 저장 
		// doc add_document_history_data
		$res_doc_his = $this->CI->Document_model->add_document_history_data(
			array(
				'user_idx'	=> $this->userinfo['idx'],
				'his_info'	=> $this->userinfo['user_name'].'님이 수정 하셧습니다.',
				'doc_id'	=> $doc['doc_id'],
				'doc_data'	=> $doc['doc_data']			
			)
		);

		// sheet add_document_history_sheet_data
		if($res_doc_his){
			$doc_sheet = $this->CI->Document_model->get_document_sheet(['doc_id' => $doc['doc_id']]);
			if($doc_sheet){
				foreach($doc_sheet as $row){
					$this->CI->Document_model->add_document_history_sheet_data(
						array(
							'his_idx'	=> $res_doc_his,
							'doc_id'	=> $doc['doc_id'],
							'sheet_id'	=> $row['sheet_id'],
							'sheet_name' => $row['sheet_name'],
							'sheet_data' => $row['sheet_data'],
						)
					);
				}
			}
		}

		/* 수정된 문서 가공 처리 */
		$n_doc_data = JSON_DECODE($param['doc_data'], true);		
		
		// sheets 별도 분리
		$n_doc_data_sheets = $n_doc_data['sheets'];

		// 원본 문서에서 sheets 정보 삭제
		unset($n_doc_data['sheets']);

		/* 공유 상황별 처리 */
		$share_sheet_data = JSON_DECODE($share_data['sheet_id'], true);	
		
		if($share_sheet_data['stype'] == 'all'){
			/* 문서 공유 전체 */
			// 문서 데이터 저장 
			$this->CI->Document_model->modify_document_data(
				array(
					'doc_id'	=> $doc['doc_id'],					
					'doc_data'	=> JSON_ENCODE($n_doc_data, JSON_UNESCAPED_UNICODE),
				)
			);
			
			// 시트 사용 불가 상태로 변경
			$this->CI->Document_model->change_sheet_all_yn(
				array(
					'doc_id' => $doc['doc_id'],
					'use_yn' => 'N'
				)
			);

			if(count($n_doc_data_sheets) > 0){
				foreach($n_doc_data_sheets as $row){
					if(!empty($row['data']['defaultDataNode']['tag'])) {
						$this->CI->Document_model->modify_document_sheet(
							array(
								'sheet_id' => $row['data']['defaultDataNode']['tag'],
								'data' => array(
									'sheet_name'	=> $row['name'],
									'sheet_data'	=> JSON_ENCODE($row, JSON_UNESCAPED_UNICODE),
									'use_yn'		=> 'Y',
									'up_date'		=> date('Y-m-d H:i:s')
								)
							)
						);
					}
					else {				
						$sheet_id = $this->CI->userfunction->fnStrUniqId('ush');
						$sheet_name = $row['name'];	
						$row['data']['defaultDataNode']['tag'] = $sheet_id;		
						$sheet_data = array(
							'doc_id'		=> $doc['doc_id'],
							'sheet_id'		=> $sheet_id,
							'sheet_name'	=> $sheet_name,
							'sheet_data'	=> JSON_ENCODE($row, JSON_UNESCAPED_UNICODE),
							'use_yn'		=> 'Y'
						);
						$this->CI->Document_model->add_document_sheet_data($sheet_data);
					}					
				}
			}
		}
		else {			
			$sheet_type = array();
			if(count($share_sheet_data['list']) > 0){
				foreach($share_sheet_data['list'] as $row){					
					$sheet_type[$row[0]] = $row[1] ;
				}
			}

			/* 문서 공유 시트별 */
			if(count($n_doc_data_sheets) > 0){
				foreach($n_doc_data_sheets as $row){
					if(!empty($row['data']['defaultDataNode']['tag']) && $sheet_type[$row['data']['defaultDataNode']['tag']] == 'M') {
						// sheet 데이터 저장		
						$this->CI->Document_model->modify_document_sheet(
							array(
								'sheet_id' => $row['data']['defaultDataNode']['tag'],
								'data' => array(
									'sheet_name'	=> $row['name'],
									'sheet_data'	=> JSON_ENCODE($row, JSON_UNESCAPED_UNICODE),
									'use_yn'		=> 'Y',
									'up_date'		=> date('Y-m-d H:i:s')
								)
							)
						);
					}					
				}
			}
		}
		return array('code'=>200);
	}

	public function get_document_by_doc_id($param){
		$doc_data = $this->CI->Document_model->get_document_doc_id(['doc_id'=>$param['doc_id']]);
		return array('code' => 200, 'data' => $doc_data);
	}

	/* Document ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* Document share ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	// 공유 멤버 리스트 
	public function get_doc_mem_share_data($param){
		// 문서 코드 확인
		$this->userinfo = $this->CI->session->userdata('userinfo');

		$total_cnt = $this->get_doc_user_member_share_cnt(array('doc_id' => $param['doc_id'], 'user_idx' => $this->userinfo['idx']));

		$rlt_doc = $this->CI->Document_model->get_document_info(array('doc_id' => $param['doc_id'], 'user_idx' => $this->userinfo['idx']));
		if(empty($rlt_doc)){
			return array('code'=>425, 'msg'=>'문서 정보가 올바르지 않습니다.');
			exit;
		}

		$rlt_share = $this->CI->Share_model->get_doc_user_member_data(
			array(
				'share_type' => 'M',
				'doc_id' => $param['doc_id'],
				'user_idx' => $this->userinfo['idx'],
				's_num'	=> ($param['page_num'] * 10),
			)
		);
		if($rlt_share){
			return array('code'=>200, 'data' => $rlt_share, 'cnt'=>$total_cnt);
		}
		else return array('code'=>425, 'msg'=>'ERROR', 'cnt'=>$total_cnt);
	}

	public function get_doc_user_member_share_cnt($param){
		$total_cnt = $this->CI->Share_model->get_doc_user_member_share_cnt(['doc_id' => $param['doc_id'], 'user_idx' => $this->userinfo['idx']]);
		return $total_cnt[0]['Cnt'];
	}
	public function delete_user_mem_share($param){
		$rlt_up = $this->CI->Share_model->delete_user_mem_share(array('share_code' => $param['share_id'], 'doc_id' => $param['doc_id']));
		if($rlt_up){
			$this->CI->Share_model->subtract_document_share_cnt(['doc_id' => $param['doc_id']]);
			$total_cnt = $this->get_doc_user_member_share_cnt(array('doc_id' => $param['doc_id'], 'user_idx' => $this->userinfo['idx']));
			return array('code'=>200, 'data'=>$param, 'cnt'=>$total_cnt);
		}
		else return array('code'=>425, 'msg'=>'ERROR');
	}

	// 주소로 리스트 불러 오기 
	public function get_modal_pop_data($param){
		$this->userinfo = $this->CI->session->userdata('userinfo');
		$data = array();
		$rlt_doc = $this->CI->Document_model->get_document_info(array('doc_id' => $param['doc_id'], 'user_idx' => $this->userinfo['idx']));
		if($rlt_doc){		
			$rlt_sheet = $this->CI->Document_model->get_document_user_sheet(['doc_id' => $param['doc_id']]);
			$data['sheet'] = $rlt_sheet;
			$rlt_mem = $this->CI->Member_model->get_modal_user_member_list(
				array(
					'doc_id' => $param['doc_id'], 
					'user_idx' => $this->userinfo['idx']
				)
			);
			$data['mem'] = $rlt_mem;
			return array('code'=>200, 'data' => $data);
		}
		else return array('code'=>425, 'msg'=>'문서 정보가 올바르지 않습니다.');
	}

	// 선택 멤버 공유
	public function doc_member_share($param){
		$doc_purview = $param['edit_type'] == 'E' ? 'M' : 'V';
		// 문서 코드 확인
		$this->userinfo = $this->CI->session->userdata('userinfo');

		$rlt_doc = $this->CI->Document_model->get_document_info(array('doc_id' => $param['doc_id'], 'user_idx' => $this->userinfo['idx']));
		if(empty($rlt_doc)){
			return array('code'=>425, 'msg'=>'문서 정보가 올바르지 않습니다.');
			exit;
		}

		$sheet_data = '';

		// 공유 sheet 확인
		if($param['share_type'] != 'A'){
			// 전체 공유가 아닐 경우 시트 정보 호출 
			if(count($param['sheet_list']) > 0){
				$arr_sheet_data = array();
				foreach($param['sheet_list'] as $row){
					 $rlt_sheet = $this->CI->Document_model->get_documet_sheet_detail(['doc_id' => $param['doc_id'], 'sheet_id' => $row]);
					 if($rlt_sheet){
						 array_push($arr_sheet_data, array($rlt_sheet['sheet_id'],$doc_purview));
					 }
				}
				$sheet_data =  array('stype' => 'part', 'ptype' => $doc_purview, 'list'=>$arr_sheet_data);
			}
			else $sheet_data = array('stype' => 'all', 'ptype' => $doc_purview, 'list'=>'');
		} else $sheet_data = array('stype' => 'all', 'ptype' => $doc_purview, 'list'=>'');
		

		//회원 멤버 IDX 확인 
		if(count($param['member_list']) < 1){
			return array('code'=>421, 'msg'=>'공유 멤버를 선택해 주세요.');
			exit;
		}

		// 공유 멤버 확인
		$mem_data = array();
		foreach($param['member_list'] as $row){
			$rlt_mem = $this->CI->Member_model->get_user_member_detail(['mem_idx' => $row, 'user_idx' => $this->userinfo['idx']]);
			if($rlt_mem){
				array_push($mem_data, $rlt_mem);
			}
		}		

		// 
		if(count($mem_data) > 0){
			$ac_prc = true;

			// 공유 멤버가 있을 경우 처리 
			foreach($mem_data as $row){
				$share_code = $this->CI->userfunction->fnStrUniqId('sae');
				$code_str_encode = $this->CI->userfunction->fnSimpleCrypt($share_code,"e");
				// 공유 정보 저장 
				$share_param = array(
					'share_code' => $share_code,
					'share_type' => 'M',
					'user_idx' => $this->userinfo['idx'],
					'user_mem_idx' => $row['idx'],
					'doc_id' => $param['doc_id'],
					'doc_edit' => $doc_purview,
					'sheet_id' => json_encode($sheet_data, JSON_UNESCAPED_UNICODE),
					'limit_date' => date("Y-m-d H:i:s", strtotime("+1 years"))
				);
				$rlt_share = $this->CI->Share_model->add_document_share_data($share_param);
				$this->CI->Share_model->add_document_share_cnt(['doc_id' => $param['doc_id']]);
				if($rlt_share){
					// 메일 발송
					/* ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
					
					// 인증 코드 
					$api_auth = $this->CI->common_lib->tw_api_sign_prc();
					if(!$api_auth){
						$returnOjb = array('code'=>423, 'rlt'=>false, 'msg'=>'인증 메일 발송 오류');					
					}
					else {
						$target_url = APP_URL."email";
						$arHeaders = array('accept: application/json', 'Content-Type: application/json', 'Authorization: Bearer '.$api_auth['accessToken']);
						$arParams = array(
							"from" => SEND_FROM_MAIL,
							"to" => [$row['mem_email']],
							"templateName" => "Teemcell_share",
							"templateDataKeyValues" => [
								array("key" => "site-url", "value" => WEB_URL),
								array("key" => "user-name", "value" => $this->userinfo['user_name']), 
								array("key" => "doc-title", "value" => $rlt_doc['doc_title']), 
								array("key" => "share-code", "value" => $code_str_encode),
								array("key" => "customer-url", "value" => CUSTOMER_URL)
							]
						);
						$send_mail = $this->CI->userfunction->fnCurlExec($target_url, 'POST', $arHeaders, $arParams);
						if($send_mail['code'] == 200 && $send_mail['data']['success'] == 'true'){
							$this->CI->Common_model->add_send_mail_log(
									array(
										'send_mail' => $row['mem_email'],
										'send_type' => 'SA',
										'success_yn' => 'Y',
										'rlt_data' => $send_mail
									)
								);
							$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=>'선택된 이메일 주소로 공유 URL를 발송 하였습니다.');
						} else {
							$this->CI->Common_model->add_send_mail_log(
									array(
										'send_mail' => $row['mem_email'],
										'send_type' => 'SA',
										'success_yn' => 'N',
										'rlt_data' => $send_mail
									)
								);
							$returnOjb = array('code'=>423, 'rlt'=>false, 'msg'=>'공유 메일 발송 오류.');
						}						
					}
				/* ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */	

				} else $ac_prc = false;
			}
			
			if($ac_prc === true){
				return array('code'=>200, 'msg'=>'공유 메일이 발송 되었습니다. ');
			}
			else return array('code'=>200, 'msg'=>'일부 정보 등록이 누락 되었습니다. 다시 한번 확인 해 주시기 바랍니다.');
		}
		else {
			return array('code'=>425, 'msg'=>'공유 멤버를 선택해 주세요.');
			exit;
		}
	}
	/* Document share ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* MY DOCUMENT ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */

	public function get_my_document_list($param){

		$color_data = $this->CI->common_lib->array_doc_color_code();
		$doc_order = $param['doc_order'] == 'D' ? 'DESC' : 'ASC'; 
		$doc_color = empty($color_data[$param['doc_color']]) ? 'all' : $color_data[$param['doc_color']];		

		$l_param = array(
			'doc_type' => $param['doc_type'],
			's_num'	=> ($param['my_doc_page'] * 10),
			'user_idx' => $this->userinfo['idx'],
			'doc_color' => $doc_color,
			'doc_order' => $doc_order
		);

		$ret = $this->CI->Document_model->get_my_document_list($l_param);		
		if($ret) {
			if(count($ret) < 10) $page = 'E'; 
			else $page = $param['my_doc_page'] + 1;
			return array('code'=>200, 'data'=>$ret, 'page' => $page);
		}
		else return array('code'=>400 ,'msg'=>"데이터가 존재 하지 않습니다.");

	}


	// 사본 생성 
	public function copy_user_document($param){
		if($param['doc_type'] == 'S'){
			// 공유 문서 일 경우			
			$share_data = $this->CI->Share_model->get_share_docment(array('share_code'=>$param['code']));
			if(empty($share_data)){
				return array('code'=>425, 'msg'=>'정보가 올바르지 않습니다.');			
				exit;
			}

			if(empty($share_data['user_check']) || $share_data['user_check'] != $this->userinfo['idx']){
				// 내 문서가 아니면 공유 받은 문서 인지 확인
				return array('code'=>425, 'msg'=>'이 문서에 대해서 사번 생성 권한이 없습니다.');
				exit;
			}

			$o_doc_data = $this->CI->Document_model->get_document_doc_id(array('doc_id' => $share_data['doc_id']));
			if(!$o_doc_data){
				// 내 문서가 아니면 공유 받은 문서 인지 확인
				return array('code'=>425, 'msg'=>'값이 올바르지 않습니다.');
				exit;
			}

			$share_sheet_data = JSON_DECODE($share_data['sheet_id'], JSON_UNESCAPED_UNICODE);
		}
		else {
			// 내 문서 일 경우 처리 
			$o_doc_data = $this->CI->Document_model->get_document_info(array('doc_id' => $param['code'], 'user_idx'=>$this->userinfo['idx']));
			if(!$o_doc_data){
				// 내 문서가 아니면 공유 받은 문서 인지 확인
				return array('code'=>425, 'msg'=>'값이 올바르지 않습니다.');
				exit;
			}

			$share_sheet_data = '';
		}

		$n_doc_id = $this->CI->userfunction->fnStrUniqId('udc');
		$now_date = date('Y-m-d H:i:s');
		
		// 신규 문서 등록		
		$doc_param = array(
			'doc_id' => $n_doc_id,
			'user_idx' => $this->userinfo['idx'],
			'doc_title' => '[사본] '.$o_doc_data['doc_title'],		
			'doc_type' => $o_doc_data['doc_type'],
			'tem_id' => $o_doc_data['tem_id'],
			'doc_color' => $o_doc_data['doc_color'],
			'doc_share_cnt' => 0,
			'use_yn' => 'Y',
			'reg_date' => $now_date,
			'up_date' => $now_date
		);
		$ret = $this->CI->Document_model->add_document_info($doc_param);
		if($ret){		
			$this->CI->Document_model->add_document_data(
				array(
					'doc_id'		=> $n_doc_id,				
					'doc_data'		=> $o_doc_data['doc_data'],
					'use_yn'		=> 'Y',
					'reg_date'		=> $now_date,
				)
			);
		} else {
			return array('code' => 425, 'msg' => '처리중 오류가 발생 하였습니다.');
			exit;
		}

		$o_doc_memo = $this->CI->Document_model->get_document_memo(array('doc_id' => $o_doc_data['doc_id'], 'user_idx'=>$this->userinfo['idx']));
		if($o_doc_memo){
			$this->CI->Document_model->add_document_memo(
				array(
					'doc_id'		=> $n_doc_id,
					'user_idx'		=> $this->userinfo['idx'],
					'doc_memo'		=> $o_doc_memo['doc_memo'],
					'use_yn'		=> 'Y',
				)
			);
		}

		

		if($param['doc_type'] == 'S' && $share_sheet_data['stype'] == 'part'){
			$doc_data_sheets = array();
			foreach($share_sheet_data['list'] as $row){
				$arr_sheet_data = $this->CI->Document_model->get_documet_sheet_detail(array('doc_id' => $o_doc_data['doc_id'], 'sheet_id' => $row[0]));
				if(!empty($arr_sheet_data)){
					array_push( $doc_data_sheets, $arr_sheet_data);
				}
			}
		}
		else {
			// 문서 sheet 불러 신규 문서 ID로 sheet 등록		
			$doc_data_sheets = $this->CI->Document_model->get_document_user_sheet(array('doc_id' => $o_doc_data['doc_id']));
		}

		if(count($doc_data_sheets) > 0 ){
			foreach($doc_data_sheets as $row){
				$n_sheet_id = $this->CI->userfunction->fnStrUniqId('ush');
				$sheet_data = JSON_DECODE($row['sheet_data'], JSON_UNESCAPED_UNICODE);
				$sheet_data['data']['defaultDataNode']['tag'] = $n_sheet_id;
				$sheet_param = array(
					"doc_id" => $n_doc_id,
					"sheet_id" => $n_sheet_id,
					"sheet_name" => $row['sheet_name'],
					"sheet_data" => JSON_ENCODE($sheet_data, JSON_UNESCAPED_UNICODE),
					"use_yn" => "Y"
				);
				$this->CI->Document_model->add_document_sheet_data($sheet_param);
			}
		}
		return array('code'=>200);
	}

	

	// 제목 수정 
	public function modify_user_document_title($param){
		$u_param = array(
			'user_idx' => $this->userinfo['idx'],
			'doc_id' => $param['doc_id'],
			'data' => array('doc_title' => $param['doc_title'], 'up_date' => date('Y-m-d H:i:s'))
		);
		$reData = $this->CI->Document_model->modify_user_document($u_param);
		if($reData){
			return array('code'=>200, 'data'=>array('doc_id' => $param['doc_id'], 'up_date' => date('Y-m-d')));
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}
	}

	/* MY Document ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* History ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	public function get_doc_history_list($param){	
		$param['user_idx'] = $this->userinfo['idx'];
		$reData = $this->CI->Document_model->get_doc_history_list($param);
		if($reData){
			return array('code'=>200, 'data' => $reData);
		}else{
			return array('code'=>425, 'msg' => '이전 수정 기록 데이터가 없습니다.');
		}
	}
	
	// 저장되어 있는 문서 Data
	public function get_doc_history_data($param){
		$param['user_idx'] = $this->userinfo['idx'];
		$hdoc = $this->CI->Document_model->get_doc_history_data($param);
		if($hdoc){
			$array_doc_data = json_decode($hdoc['doc_data'], true);
			$hsheet = $this->CI->Document_model->get_doc_history_sheet(array('his_id' => $param['his_id'], 'doc_id' => $hdoc['doc_id']));
			if($hsheet){
				$i = 1;
				foreach($hsheet as $row){					
					$arr_sheet_data = json_decode($row['sheet_data'], true);
					$array_doc_data['sheets']['Sheet'.$i] = $arr_sheet_data;
					$i++;
				}
				$hdoc['doc_data'] = $array_doc_data;
			}			
			return array('code'=>200, 'data' => $hdoc);
		}else{
			return array('code'=>425, 'msg' => '이전 수정 내역이 없습니다.');
		}
	}

	// 선택한 문서로 복원 
	public function restory_doc_history($param){
		if(empty($param['his_id'])){
			return array('code'=>421, 'msg' =>"not data");
			exit;
		}
		$param['user_idx'] = $this->userinfo['idx'];

		// 현재 저장되어 있는 문서 불러 오기 
		$doc_data = $this->CI->Document_model->get_document_info(['doc_id' => $param['doc_id'], 'user_idx' => $this->userinfo['idx']]);
		if(empty($doc_data)){
			return array('code'=>425, 'msg'=>'문서 정보가 없습니다.');
			exit;
		}
		
		// 저장 되어 있는 문서 정보 호출 
		$res_his = $this->CI->Document_model->get_doc_history_data(['his_id' => $param['his_id'], 'doc_id' => $doc_data['doc_id'], 'user_idx'=> $this->userinfo['idx']]);
		if(empty($res_his)){
			return array('code'=>425, 'msg'=>'문서 정보가 없습니다.');
			exit;
		}

		$this->CI->Document_model->modify_document_data(
			array(
				'doc_id'	=> $doc_data['doc_id'],					
				'doc_data'	=> $res_his['doc_data'],
			)
		);	

		// 시트 사용 불가 상태로 변경
		$this->CI->Document_model->change_sheet_all_yn(
			array(
				'doc_id' => $doc_data['doc_id'],
				'use_yn' => 'N'
			)
		);
		$res_his_sheet = $this->CI->Document_model->get_doc_history_sheet(['his_id' => $param['his_id'], 'doc_id' => $doc_data['doc_id']]);
		if(count($res_his_sheet) > 0){
			foreach($res_his_sheet as $row){				
				$sheet_data = array(
					'doc_id'		=> $doc_data['doc_id'],
					'sheet_id'		=> $row['sheet_id'],
					'sheet_name'	=> $row['sheet_name'],
					'sheet_data'	=> $row['sheet_data'],
					'use_yn'		=> 'Y'
				);
				$this->CI->Document_model->add_document_sheet_data($sheet_data);						
			}
		}
		return array('code'=>200, 'data'=>array('doc_id' => $doc_data['doc_id']));		
	}
	/* History ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */

	/* Template ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */

	// 템플릿 카테고리 분류
	public function get_template_category(){
		$returnData = array();
		$res_l = $this->CI->Document_model->get_template_category(array('cate_num' => 0, 'cate_type' => 'L'));
		$ri = 0;
		foreach($res_l as $row_l){
			$returnData[$ri] = array(
				'l_cate_num' => $row_l['idx'],
				'menu' => $row_l['cate_name'],
				'active' => $row_l['active_code']
			);

			$res_m = $this->CI->Document_model->get_template_category(array('cate_num' => $row_l['idx'], 'cate_type' => 'M'));
			if(count($res_m) > 0){
				$i = 0;
				foreach($res_m as $row_m){
					$returnData[$ri]['M'][$i] = array(
						'm_cate_num' => $row_m['idx'],
						'menu' => $row_m['cate_name'],
						'active' => $row_m['active_code']
					);
					
					$res_s = $this->CI->Document_model->get_template_category(array('cate_num' => $row_m['idx'], 'cate_type' => 'S'));
					if(count($res_s) > 0){
						$ii = 0;
						foreach($res_s as $row_s){
							$returnData[$ri]['M'][$i]['S'][$ii] = array(
								's_cate_num' => $row_s['idx'],
								'menu' => $row_s['cate_name'], 
								'active' => $row_s['active_code']
							);
						$ii++;
						}
					}
					$i++;
				}
			} else {
				$returnData[$ri]['M'] = array();
			}
			$ri++;
		}
		return $returnData;		
	}

	// 템플릿 리스트 
	public function get_template_list($param){		
		$doc_order = $param['tem_order'] == 'D' ? 'DESC' : 'ASC'; 

		$l_param = array(
			'search_title'	=> $param['tem_search'],
			's_num'	=> ($param['tem_page'] * 10),
			'doc_order' => $doc_order,
			'lcate' => $param['lCate'],
			'mcate' => $param['mCate'],
			'scate' => $param['sCate']
		);		
		$ret = $this->CI->Document_model->get_template_list($l_param);		
		if($ret) {
			return array('code'=>200, 'data'=>$ret, 'page'=>$param['tem_page'] + 1);
		}
		else return array('code'=>400 ,"msg"=>"잠시 후에 다시 시도해 주세요" );
	}

	// 해당 템플릿 불러 오기 
	public function get_template_data($param){
		$reData = $this->CI->Document_model->get_template_data($param);
		if($reData){
			return array("code"=>200, "data"=> json_decode($reData['tem_data'], true));
		}
		else {
			return array("code"=>402, "msg"=>"처리 오류");
		}
	}

	/* TEMPLATE ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	
}