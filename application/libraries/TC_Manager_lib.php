<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class TC_Manager_lib {
	var $CI;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('UserFunction');
		$this->CI->load->model('TC_Manager_model');
	}
	/* COMMON ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	public function menu_list(){
		$returnData = array();
		$res_m = $this->CI->TC_Manager_model->get_admin_menu_main();
		foreach($res_m as $row){
			$returnData[$row['idx']] = array(
				"idx"=>$row['idx'], 
				"menu"=>$row['menu_name'], 
				"icon"=>$row['icon_txt'], 
				"active"=>$row['active_code'], 
				"url_link"=>$row['url_link']
			);
			$param = array("cate" => $row['idx']);			
			$res_s = $this->CI->TC_Manager_model->get_admin_menu_sub($param);
			if(count($res_s) > 0){
				$i = 0;
				foreach($res_s as $row_s){
					$returnData[$row['idx']]['sub'][$i] = array(
						"menu"=>$row_s['menu_name'], 
						"active"=>$row_s['active_code'], 
						"url_link"=>$row_s['url_link']
					);
					$i++;
				}
			} else {
				$returnData[$row['idx']]['sub'] = array();
			}
		}
		return $returnData;
	}
	/* COMMON ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* 회원 관리 ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	public function member_list($param){
		if ( empty($param['tabledata']['order']) ) $param['tabledata']['order'] = 'idx';
		if ( empty($param['tabledata']['order_dir']) ) $param['tabledata']['order_dir'] = 'DESC';
		
		$memdata = $this->CI->TC_Manager_model->get_member_list($param); 
		$cnttmp = $this->CI->TC_Manager_model->get_member_list_cnt($param);

		$page = ($cnttmp['cnt'] > 0) ? (int)($cnttmp['cnt'] / $param['tabledata']['length']) + 1 : 1;
		$ret['page'] = $page;
		$ret['draw'] = $param['draw'];
		$ret['ordering'] = $param['tabledata']['order']." ".$param['tabledata']['order_dir'];
		$ret['recordsFiltered'] =$ret['recordsTotal'] = $data['data']['totalRecord'] = (int)$cnttmp['cnt'];
		$ret['data'] = $memdata;
		return $ret;
	}

	// 주소록 리스트
	public function user_mem_list($param){
		if ( empty($param['tabledata']['order']) ) $param['tabledata']['order'] = 'a.idx';
		if ( empty($param['tabledata']['order_dir']) ) $param['tabledata']['order_dir'] = 'DESC';
		
		$memdata = $this->CI->TC_Manager_model->get_user_mem_list($param); 
		$cnttmp = $this->CI->TC_Manager_model->get_user_mem_list_cnt($param);

		$page = ($cnttmp['cnt'] > 0) ? (int)($cnttmp['cnt'] / $param['tabledata']['length']) + 1 : 1;
		$ret['page'] = $page;
		$ret['draw'] = $param['draw'];
		$ret['ordering'] = $param['tabledata']['order']." ".$param['tabledata']['order_dir'];
		$ret['recordsFiltered'] =$ret['recordsTotal'] = $data['data']['totalRecord'] = (int)$cnttmp['cnt'];
		$ret['data'] = $memdata;
		return $ret;
	}
	/* 회원 관리 ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* 게시판 관리 ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	public function notice_list($param){
		if ( empty($param['tabledata']['order']) ) $param['tabledata']['order'] = 'idx';
		if ( empty($param['tabledata']['order_dir']) ) $param['tabledata']['order_dir'] = 'DESC';
		
		$memdata = $this->CI->TC_Manager_model->get_notice_list($param); 
		$cnttmp = $this->CI->TC_Manager_model->get_notice_list_cnt($param);

		$page = ($cnttmp['cnt'] > 0) ? (int)($cnttmp['cnt'] / $param['tabledata']['length']) + 1 : 1;
		$ret['page'] = $page;
		$ret['draw'] = $param['draw'];
		$ret['ordering'] = $param['tabledata']['order']." ".$param['tabledata']['order_dir'];
		$ret['recordsFiltered'] =$ret['recordsTotal'] = $data['data']['totalRecord'] = (int)$cnttmp['cnt'];
		$ret['data'] = $memdata;
		return $ret;
	}

	public function get_notice_detail($param){
		$getCon = $this->CI->TC_Manager_model->get_board_content($param);        
        $ret = array(
            'content'=> $getCon
        );
		return $ret;
	}

	public function add_notice_prd($param){
		$ret = $this->CI->TC_Manager_model->add_notice_prc($param);
		if($ret === true){
			return array('code'=>200, 'msg'=>"success");
        }else{
			return array('code'=>500, 'msg'=>"fail");
        }		
	}
	/* 게시판 관리 ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
	/* 문서 관리 ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	public function document_user_list($param){

		if ( empty($param['tabledata']['order']) ) $param['tabledata']['order'] = 'idx';
		if ( empty($param['tabledata']['order_dir']) ) $param['tabledata']['order_dir'] = 'DESC';
		
		$memdata = $this->CI->TC_Manager_model->get_doc_user_list($param); 
		$cnttmp = $this->CI->TC_Manager_model->get_doc_user_list_cnt($param);

		$page = ($cnttmp['cnt'] > 0) ? (int)($cnttmp['cnt'] / $param['tabledata']['length']) + 1 : 1;
		$ret['page'] = $page;
		$ret['draw'] = $param['draw'];
		$ret['ordering'] = $param['tabledata']['order']." ".$param['tabledata']['order_dir'];
		$ret['recordsFiltered'] =$ret['recordsTotal'] = $data['data']['totalRecord'] = (int)$cnttmp['cnt'];
		$ret['data'] = $memdata;
		return $ret;
	}

	public function get_document_detail($param){
		$res = $this->CI->TC_Manager_model->get_document_info($param);

		if($res){
			$array_doc_data = json_decode($res['doc_data'], true);
			$res2 = $this->CI->TC_Manager_model->get_document_user_sheet(array('doc_id' => $res['doc_id']));
			if($res2){
				$i = 1;
				foreach($res2 as $row){					
					$arr_sheet_data = json_decode($row['sheet_data'], true);
					$json_sheet_data = json_encode($arr_sheet_data);
					$array_doc_data['sheets']["Sheet".$i] = json_decode($json_sheet_data, true);
					$i++;
				}
				$res['doc_data'] = $array_doc_data;				
				return array('code'=>200, 'data'=>$res);
			}
			else {
				return array('code'=>402, 'msg'=>"처리 오류");
			}			
		} else {
			return array('code'=>401, 'msg'=>"처리 오류");
		}	
	}
	
	// 템플릿 리스트 
	public function get_template_list($param){

		$reData = $this->CI->TC_Manager_model->get_template_list($param);
		if($reData){
			return array('code'=>200, 'data'=>$reData);
		}else{
			return array('code'=>400, 'msg'=>"not List Data");
		}
	}

	public function up_template_sort($param){
		$reData = $this->CI->TC_Manager_model->up_template_sort($param);
		if($reData){
			return array('code'=>200);
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}

	}


	public function get_template_data($param){
		if(empty($param['idx'])) {
			return array('code'=>500, 'msg'=>"not file idx");
		}
		$reData = $this->CI->TC_Manager_model->get_template_detail(['idx' => $param['idx']]);
		$reData['doc_data'] = json_decode($reData['tem_data'], true);

		if($reData){
			return array('code'=>200, 'data'=>$reData);
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}
	}
	
	// 선택 분류 정보 
	public function get_category_by_idx($param){
		$reData = $this->CI->TC_Manager_model->get_template_category_by_idx(['idx' => $param['idx']]);
		$m_Data = $this->CI->TC_Manager_model->get_category_list([ 'cate_idx' => $reData['l_cate']]);
		$s_Data = $this->CI->TC_Manager_model->get_category_list([ 'cate_idx' => $reData['m_cate']]);
		$reData['m_cate_list'] = $m_Data;
		$reData['s_cate_list'] = $s_Data;
		if($reData){
			return array('code'=>200, 'data'=>$reData);
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}
	}


	public function add_template($param){
		// Array ( [tem_img] => Array ( [name] => 20220511_627b8c9b7bd6c.jpg [type] => image/jpeg [tmp_name] => C:\Windows\Temp\php6BD9.tmp [error] => 0 [size] => 109794 ) )
		// 썸네일 이미지 등록 
		$target_dir = $_SERVER['DOCUMENT_ROOT']."/tc_file/_tc_image/";
		$thumbnail_path = 'tem_'.date('Y');
		$dest = $target_dir.$thumbnail_path;
        if(!is_dir($dest)) {
            mkdir($dest, 0755);
            chmod($dest, 0755);
        }

		
		$fileTypeExt = explode("/", $param['FILES']['tem_img']['type']);		
		$fileType = $fileTypeExt[0];
		$fileExt = $fileTypeExt[1];		
		$file_name = $this->CI->userfunction->fnStrUniqId('thumb').'.'.$fileExt;

		$target_file = $dest .'/'.$file_name; // 원본 파일 
		$target_th_file = $dest .'/s_'.$file_name; // 썸네일 파일 

		if ($param['FILES']['tem_img']['error']) {
			echo array('code' => 602, 'msg' => "파일업로드 중 에러가 발생했습니다!");
			return;
		} else if ($param['FILES']['tem_img']['size'] / 1024 / 1024 > 4) {
			echo array('code' => 604, 'msg' => "최대 4M까지만 업로드가 가능합니다.");
			return;
		}

		$arr_img_type = array("image/gif", "image/jpeg", "image/png", "image/bmp"); 
		if (!in_array($param['FILES']['tem_img']['type'], $arr_img_type)) {
			echo array('code' => 605, 'msg' => "이미지만 업로드 가능 합니다.");
			return;
		}

		if (move_uploaded_file($param['FILES']['tem_img']['tmp_name'], $target_file)){
			$img_info = getImageSize($target_file);
			$original_path = $target_file;
			switch($img_info['mime']){
				case "image/gif";
					$new_image=imagecreatefromgif($target_file);
				break;
				case "image/jpeg";
					$new_image=imagecreatefromjpeg($target_file);
				break;
				case "image/png";
					$new_image=imagecreatefrompng($target_file);
				break;
				case "image/bmp";
					$new_image=imagecreatefromwbmp($target_file);
				break;
			}
			$max_width = 256;
			$max_height = 256;
			$img_width = $img_info[0];
			$img_height = $img_info[1];
			$source_aspect_ratio = $img_width / $img_height;
			$desired_aspect_ratio = $max_width / $max_height;			
			if ($source_aspect_ratio > $desired_aspect_ratio) {				
				$temp_height = $max_height;
				$temp_width = (int)($max_height * $source_aspect_ratio);
			} else {				
				$temp_width = $max_width;
				$temp_height = (int)($max_width / $source_aspect_ratio);
			}		
			$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
			imagecopyresampled($temp_gdim, $new_image, 0, 0, 0, 0, $temp_width, $temp_height, $img_width, $img_height);
			
			$x0 = ($temp_width - $max_width) / 2;
			$y0 = ($temp_height - $max_height) / 2;
			$desired_gdim = imagecreatetruecolor($max_width, $max_height);
			imagecopy($desired_gdim, $temp_gdim, 0, 0, 0, 0, $max_width, $max_height);			
			
			$extArr = array("image/jpeg"=>'jpg', "image/gif"=>'gif', "image/png"=>'png', "image/bmp"=>'bmp');
			$ext = isset($extArr[$img_info['mime']]) ? $extArr[$img_info['mime']] : '';

			if(strtolower($ext) == "jpg" || strtolower($ext) == "jpeg") imagejpeg($desired_gdim, $target_th_file);
			else if(strtolower($ext) == "gif") imagegif($desired_gdim, $target_th_file);
			else if(strtolower($ext) == "bmp") imagewbmp($desired_gdim, $target_th_file);
			else if(strtolower($ext) == "png") imagejpeg($desired_gdim, $target_th_file);

			// sheet 별 처리 
			$tem_data = json_decode($param['temData'], true);
			$tem_param = array(
				"tem_title" => $param['temTitle'],				
				"tem_data" => json_encode($tem_data, JSON_UNESCAPED_UNICODE),
				"tem_memo" => $param['temMemo'],
				"img_path" => '/tc_file/_tc_image/'.$thumbnail_path,
				"img_name" => $file_name
			);
			$ret = $this->CI->TC_Manager_model->add_template_document($tem_param);	
			if($ret){
				// 카테고리 등록
				$cate_param = array(
					"tem_idx" => $ret,
					"l_cate" => $param['lCate'],
					"m_cate" => $param['mCate'],
					"s_cate" => $param['sCate'],
					"use_yn" => 'Y'
				);
				$this->CI->TC_Manager_model->add_template_cate($cate_param);

				return array('code' => '200', "idx" => $ret);
			} else {
				return array('code' => '401', 'msg' => '등록오류');
			}
		}
		else {
			return array('code' => '201', 'msg' => '이미지가 올바르지 않습니다.');
		}
	}

	// 템플릿 수정 
	public function modify_template($param){

		$tem_param = $param;
		$tem_param['img_path'] = '';
		$tem_param['img_name'] = '';

		// 등록 파일 존재 시 처리 
		if($param['files_data']['tem_img']['tmp_name']){

			$target_dir = $_SERVER['DOCUMENT_ROOT']."/tc_file/_tc_image/";
			$thumbnail_path = 'tem_'.date('Y');
			$dest = $target_dir.$thumbnail_path;
			if(!is_dir($dest)) {
				mkdir($dest, 0755);
				chmod($dest, 0755);
			}			
			$fileTypeExt = explode("/", $param['files_data']['tem_img']['type']);		
			$fileType = $fileTypeExt[0];
			$fileExt = $fileTypeExt[1];		
			$file_name = $this->CI->userfunction->fnStrUniqId('thumb').'.'.$fileExt;

			$target_file = $dest .'/'.$file_name; // 원본 파일 
			$target_th_file = $dest .'/s_'.$file_name; // 썸네일 파일 

			if ($param['files_data']['tem_img']['error']) {
				echo array('code' => 602, 'msg' => "파일업로드 중 에러가 발생했습니다!");
				return;
			} else if ($param['files_data']['tem_img']['size'] / 1024 / 1024 > 4) {
				echo array('code' => 604, 'msg' => "최대 4M까지만 업로드가 가능합니다.");
				return;
			}

			$arr_img_type = array("image/gif", "image/jpeg", "image/png", "image/bmp"); 
			if (!in_array($param['files_data']['tem_img']['type'], $arr_img_type)) {
				echo array('code' => 605, 'msg' => "이미지만 업로드 가능 합니다.");
				return;
			}

			if (move_uploaded_file($param['files_data']['tem_img']['tmp_name'], $target_file)){
				$img_info = getImageSize($target_file);
				$original_path = $target_file;
				switch($img_info['mime']){
					case "image/gif";
						$new_image=imagecreatefromgif($target_file);
					break;
					case "image/jpeg";
						$new_image=imagecreatefromjpeg($target_file);
					break;
					case "image/png";
						$new_image=imagecreatefrompng($target_file);
					break;
					case "image/bmp";
						$new_image=imagecreatefromwbmp($target_file);
					break;
				}
				$max_width = 256;
				$max_height = 256;
				$img_width = $img_info[0];
				$img_height = $img_info[1];
				$source_aspect_ratio = $img_width / $img_height;
				$desired_aspect_ratio = $max_width / $max_height;			
				if ($source_aspect_ratio > $desired_aspect_ratio) {				
					$temp_height = $max_height;
					$temp_width = (int)($max_height * $source_aspect_ratio);
				} else {				
					$temp_width = $max_width;
					$temp_height = (int)($max_width / $source_aspect_ratio);
				}		
				$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
				imagecopyresampled($temp_gdim, $new_image, 0, 0, 0, 0, $temp_width, $temp_height, $img_width, $img_height);
				
				$x0 = ($temp_width - $max_width) / 2;
				$y0 = ($temp_height - $max_height) / 2;
				$desired_gdim = imagecreatetruecolor($max_width, $max_height);
				imagecopy($desired_gdim, $temp_gdim, 0, 0, 0, 0, $max_width, $max_height);			
				
				$extArr = array("image/jpeg"=>'jpg', "image/gif"=>'gif', "image/png"=>'png', "image/bmp"=>'bmp');
				$ext = isset($extArr[$img_info['mime']]) ? $extArr[$img_info['mime']] : '';

				if(strtolower($ext) == "jpg" || strtolower($ext) == "jpeg") imagejpeg($desired_gdim, $target_th_file);
				else if(strtolower($ext) == "gif") imagegif($desired_gdim, $target_th_file);
				else if(strtolower($ext) == "bmp") imagewbmp($desired_gdim, $target_th_file);
				else if(strtolower($ext) == "png") imagejpeg($desired_gdim, $target_th_file);
				$tem_param['img_path'] = '/tc_file/_tc_image/'.$thumbnail_path;
				$tem_param['img_name'] = $file_name;
			}			
		}

		$ret = $this->CI->TC_Manager_model->modify_template_document($tem_param);	
		if($ret){
			return array('code' => '200', "idx" => $ret);
		} else {
			return array('code' => '401', 'msg' => '등록오류');
		}
	}

	// 템플릿 삭제 
	public function delete_template($param){
		$up_param = array(
				'idx' => $param['idx'],
				'use_yn' => 'N'
			);
		$reData = $this->CI->TC_Manager_model->up_template_use($up_param);
		if($reData){
			return array('code'=>200, 'msg'=>'success');
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}
	}
	
	// 템플릿 카테고리 추가 
	public function add_doc_templay_category($param){
		$reData = $this->CI->TC_Manager_model->add_doc_templay_category($param);
		if($reData){
			return array('code'=>200, 'msg'=>'success');
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}
	}

	// 템플릿 카테고리 수정 
	public function up_doc_templay_category($param){
		$reData = $this->CI->TC_Manager_model->up_doc_templay_category($param);
		if($reData){
			return array('code'=>200, 'msg'=>'success');
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}
	}

	// 템플릿 카테고리 리스트
	public function get_doc_template_category_list($param){
		$reData = $this->CI->TC_Manager_model->get_template_detail_category($param);
		if($reData){
			return array('code'=>200, 'data'=>$reData);
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}
	}


	//----------------- 템플릿 카테고리 관리 -----------------

	public function get_template_category_dt($param){
		$reData = $this->CI->TC_Manager_model->get_category_detail($param);
		if($reData){
			return array('code'=>200, 'data'=>$reData);
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}
	}

	public function get_category_list($param){
		$reData = $this->CI->TC_Manager_model->get_category_list($param);
		if($reData){
			return array('code'=>200, 'data'=>$reData);
		}else{
			return array('code'=>400, 'data'=>array(), 'msg'=>"not data");
		}		
	}	

	public function change_template_cate_name($param){
		$data = array();
		if(empty($param['idx'])) {
			return array('code'=>500, 'msg'=>"not file idx");
		}
		$caData = $this->CI->TC_Manager_model->get_category_detail(array("idx"=>$param['idx']));		
		if(!$caData){
			return array('code'=>501, 'msg'=>"not file idx");
		}

		$data['idx'] = $caData["idx"];
		$data['cate_name'] = $param["cate_name"];
		$data['cate_type'] = $caData["cate_type"];
		$data['active_code'] = $caData["active_code"];

		$reData = $this->CI->TC_Manager_model->change_template_cate_name($param);
		if($reData){
			return array('code'=>200, 'data'=>$data);
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}

	}

	public function del_template_category($param){
		$data = array();
		if(empty($param['idx'])) {
			return array('code'=>500, 'msg'=>"not file idx");
		}
		$caData = $this->CI->TC_Manager_model->get_category_detail(array("idx"=>$param['idx']));		
		if(!$caData){
			return array('code'=>501, 'msg'=>"not file idx");
		}

		$data['idx'] = $caData["idx"];		
		$data['cate_type'] = $caData["cate_type"];
		$data['active_code'] = $caData["active_code"];

		$reData = $this->CI->TC_Manager_model->del_template_cate($param);
		if($reData){
			return array('code'=>200, 'data'=>$data);
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}
	}

	// 템플릿 카테고리 추가 
	public function add_template_category($param){
		$cate_param = array(
			"cate" => $param["cate_idx"],
			"cate_type" => $param["cate_type"],
			"cate_name" => $param["cate_name"],
			"active_code" => $this->CI->userfunction->fnStrUniqId($param["cate_type"])
		);
		$reData = $this->CI->TC_Manager_model->add_template_category($cate_param);
		$data = $cate_param;		
		if($reData){
			$data["idx"] = $reData;
			return array('code'=>200, 'data'=>$data);
		}else{
			return array('code'=>400, 'msg'=>"False");
		}
	}

	public function up_template_category_sort($param){
		$reData = $this->CI->TC_Manager_model->up_template_category_main_sort($param);
		if($reData){
			return array('code'=>200);
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}
	}

	public function del_doc_template_category($param){
		$reData = $this->CI->TC_Manager_model->del_doc_template_category($param);
		if($reData){
			return array('code'=>200);
		}else{
			return array('code'=>400, 'msg'=>"not data");
		}
	}
	/* 문서 관리 ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
}
