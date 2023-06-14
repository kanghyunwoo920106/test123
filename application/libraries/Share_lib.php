<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Share_lib {
	var $CI;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('UserFunction');
		$this->CI->load->model('Document_model');
		$this->CI->load->model('Share_model');
		$this->CI->load->model('Member_model');			
	}

	// 공유 상태 확인 U:URL 공유, M:회원 공유
	public function get_url_share_document($param){
		// 공유 데이터 가져 오기 
		$share_data = $this->CI->Share_model->get_share_docment(array('doc_id'=>$param['doc_id'], 'share_type' => 'U'));
		if($share_data){
			return array('code' => 200, 'data' => $share_data);			
		}
		else {
			return array('code' => 425, 'msg' =>'정보가 올바르지 않습니다.');
		}
	}

	public function get_share_data_de($param){
		$ac_prc = true;		

		// 공유 데이터 가져 오기 
		$share_data = $this->CI->Share_model->get_share_docment(array('share_code'=>$param['share_decode']));
		if(empty($share_data)){
			return array('code' => 425, 'msg' => '정보가 올바르지 않습니다.');
			exit;
		}
		else {
			return array('code' => 200, 'data' => $share_data);
		}
	}

	public function get_share_data($param){
		$ac_prc = true;

		// 코드 복호화
		$share_decode = $this->CI->userfunction->fnSimpleCrypt($param['share_en'], 'd');
		if(empty($share_decode)){
			return array('code' => 421, 'msg' => '정보가 올바르지 않습니다.');
			exit;
		}

		// 공유 데이터 가져 오기 
		$share_data = $this->CI->Share_model->get_share_docment(array('share_code'=>$share_decode));
		if(empty($share_data)){
			return array('code' => 425, 'msg' => '정보가 올바르지 않습니다.');
			exit;
		}
		else {
			return array('code' => 200, 'data' => $share_data);
		}
	}

	// 공유 anstj ghkrdls 
	public function get_share_document($param){
		$ac_prc = true;

		// 코드 복호화
		$share_decode = $this->CI->userfunction->fnSimpleCrypt($param['share_en'], 'd');
		if(empty($share_decode)){
			return array('code'=>421, 'msg'=>'정보가 올바르지 않습니다.');			
			exit;
		}

		// 공유 데이터 가져 오기 
		$share_data = $this->CI->Share_model->get_share_docment(array('share_code'=>$share_decode));
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
		// 전채 문서 
		if($sheet_id_data['stype'] == 'all'){
			/* 전채 문서 ********************************/
			$sheet_data = $this->CI->Document_model->get_document_user_sheet(array('doc_id' => $doc_data['doc_id']));			
			if($sheet_data){
				$i = 0;
				$tp = $sheet_id_data['ptype'] == 'M' ? 'M' : 'V'; //편집 권한인지 확인
				foreach($sheet_data as $row){
					$arr_sheet_data = json_decode($row['sheet_data'], true);
					$array_doc_data['sheets'][$row['sheet_name']] = $arr_sheet_data;
					$array_doc_data['sheets'][$row['sheet_name']]['index'] = $i;
					$i++;					
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

	// 공유 문서 편집권한 있는 문서 저장 처리 
	public function modify_share_document($param){
		// 코드 복호화
		$share_decode = $this->CI->userfunction->fnSimpleCrypt($param['share_en'], 'd');
		if(empty($share_decode)){
			return array('code'=>425, 'msg'=>'정보가 올바르지 않습니다.');			
			exit;
		}

		// 공유 데이터 가져 오기 
		$share_data = $this->CI->Share_model->get_share_docment(array('share_code'=>$share_decode));
		if(empty($share_data)){
			return array('code'=>425, 'msg'=>'정보가 올바르지 않습니다.');			
			exit;
		}

		if($share_data['doc_edit'] != 'M'){
			return array('code'=>425, 'msg'=>'문서 수정 권한이 없습니다.');
			exit;
		}

		//현재 문서 정보 호출
		$doc_data = $this->CI->Document_model->get_document_doc_id(array('doc_id' => $share_data['doc_id']));
		if(empty($doc_data)){
			return array('code'=>425, 'msg'=>'정보가 올바르지 않습니다.');	
			exit;
		}

		// history 에 저장할 이름 불러 오기 
		$mem_dt = $this->CI->Member_model->get_user_member_detail(
			array(
				'mem_idx' => $share_data['user_mem_idx'],
				'user_idx' => $share_data['user_idx']
			)
		);

		// doc add_document_history_data
		$res_doc_his = $this->CI->Document_model->add_document_history_data(
			array(
				'user_idx' => '0',
				'his_info'	=> '"'.$mem_dt['mem_name'].'" 님이 수정 하셧습니다.',
				'doc_id'	=> $doc_data['doc_id'],
				'doc_data'	=> $doc_data['doc_data']			
			)
		);
		
		// sheet add_document_history_sheet_data
		if($res_doc_his){
			$res_sheet = $this->CI->Document_model->get_document_user_sheet(array('doc_id' => $doc_data['doc_id']));
			if($res_sheet){
				foreach($res_sheet as $row){
					$this->CI->Document_model->add_document_history_sheet_data(
						array(
							'his_idx'		=> $res_doc_his,
							'doc_id'		=> $doc_data['doc_id'],
							'sheet_id'		=> $row['sheet_id'],
							'sheet_name'	=> $row['sheet_name'],
							'sheet_data'	=> $row['sheet_data'],
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

		// 전채 문서 
		if($share_sheet_data['stype'] == 'all'){

			// 문서 데이터 저장 
			$this->CI->Document_model->modify_document_data(
				array(
					'doc_id'	=> $doc_data['doc_id'],					
					'doc_data'	=> JSON_ENCODE($n_doc_data, JSON_UNESCAPED_UNICODE),
				)
			);

			/* 전채 문서 ********************************/	
			// 시트 사용 불가 상태로 변경
			$this->CI->Document_model->change_sheet_all_yn(
				array(
					'doc_id' => $doc_data['doc_id'],
					'use_yn' => 'N'
				)
			);
				
			if(count($n_doc_data_sheets) > 0){
				foreach($n_doc_data_sheets as $row){
					if(!empty($row['data']['defaultDataNode']['tag'])){
						$this->CI->Document_model->modify_document_sheet(
							array(
								'sheet_id'	=> $row['data']['defaultDataNode']['tag'],
								'data'		=> array(
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
							'doc_id'		=> $doc_data['doc_id'],
							'sheet_id'		=> $sheet_id,
							'sheet_name'	=> $sheet_name,
							'sheet_data'	=> JSON_ENCODE($row, JSON_UNESCAPED_UNICODE),
							'use_yn'		=> 'Y'
						);
						$this->CI->Document_model->add_document_sheet_data($sheet_data);
					}
				}
				return array('code' => 200);
			} 
			else return array('code' => 425, 'msg'=>'정보가 올바르지 않습니다.');	
		} else {
			/* 시트 지정 ********************************/
			
			$sheet_type = array();
			if(count($share_sheet_data['list']) > 0){
				foreach($share_sheet_data['list'] as $row){
					$sheet_type[$row[0]] = $row[1] ;
				}
			}

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
				return array('code' => 200);
			} else return array('code' => 425, 'msg'=>'정보가 올바르지 않습니다.');	
		}
	}
}