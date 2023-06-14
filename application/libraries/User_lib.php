<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_lib {
	var $CI;
	public function __construct() {
		$this->CI =& get_instance();
        $this->CI->load->helper('url');
		$this->CI->load->library('UserFunction');
		$this->CI->load->model('User_model');

		$this->userinfo = $this->CI->session->userdata('userinfo');
	}
	public function create_account_prc($param){
		// 등록된 아이디 확인
		$res = $this->CI->User_model->get_user_data(array("userid"=>$param['userid']));

		if(empty($res)){
			// 회원 데이터 등록 
			$res2 = $this->CI->Common_model->add_user_data($param);
			if($res2){
				// 인증 코드 생성 
				$code_str = uniqid();
				$param_auth = array(
					"user_idx" => $res2,
					"auth_code" => $code_str,
					"userst" => 'TM',
					"reg_date" => date('Y-m-d H:i:s')
				);
				$res3 = $this->CI->Common_model->add_auth_data($param_auth);

				$code_str_encode = $this->CI->userfunction->my_simple_crypt($param_auth['user_idx'].'_'.$param_auth['auth_code'],"e");

				// 인증 이메일 발송 


				$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=>'가입된 이메일 주소로 인증 URL를 발송 하였습니다. '.$code_str_encode);
			}
			else {
				$returnOjb = array('code'=>502, 'rlt'=>false, 'msg'=>'이미 사용중인 메일 주소 입니다.22 ');
			}

		} else {
			$returnOjb = array('code'=>501, 'rlt'=>false, 'msg'=>'이미 사용중인 메일 주소 입니다. ');
		}
		return $returnOjb;
	}

	public function chech_auth_code_prc($param){
		// 코드값 복호화 처리 
		$code_str_decode = $this->CI->userfunction->my_simple_crypt($param['en_auth_code'],"d");
		
		//"_" 로 회원 idx 와 인증 코드 분리 
		$arr_code_data = explode("_", $code_str_decode);
		$user_idx = $arr_code_data[0];
		$auth_code = $arr_code_data[1];		

		// DB 인증 코드 확인
		$res = $this->CI->Common_model->get_auth_data(array("useridx"=>$this->userinfo['idx'],"authcode"=>$auth_code));

		if($res){
			// 인증 상태로 변경 처리 
			$res2 = $this->CI->Common_model->up_auth_data(array("state"=>'Y',"useridx"=>$this->userinfo['idx'],"authcode"=>$auth_code));

			// 회원 상태 벼경
			$param_user = array(
				"user_idx" => $this->userinfo['idx'],
				"state" => 'Y',
				"up_date" => date('Y-m-d H:i:s')
			);			
			$res3 = $this->CI->Common_model->up_user_data($param_user);
			
			$returnOjb = array('code'=>200, 'data'=>$res);
		}
		else {
			$returnOjb = array('code'=>501, 'rlt'=>false, 'msg'=>'값이 올바르지 않습니다.');
		}
		return $returnOjb;
	}

	// 회원 상태 변경
	public function member_change_status($param){
		if(empty($param['status'])){
			return array('code'=>421, 'msg'=>'상태를 선택해주세요');
		}

		$userdata = $this->CI->User_model->get_user_data_by_idx($param['idx']);

		if(empty($userdata)){
			return array('code'=>425, 'msg'=>'회원정보를 찾을 수 없습니다.');
		}

		if( $param['status'] == $userdata['user_state'] ) {
			return array('code'=>501, 'msg'=>'현재 ['.$userdata['user_id'].'] 회원님의 <br> 상태는 [ '.$userdata['code_name'].' ]입니다.');
		}

		$codedata = $this->CI->Common_model->get_code_name(array('code_gbn' => 'MEMBER_STATUS', 'code_detail' => $param['status']));
		if(empty($codedata)){
			return array('code'=>501, 'msg'=>'잘못된 상태 코드입니다.');
		}

		$param['code_name'] = $codedata['code_name'];

		if(empty($param['prc'])){
			return  array('code'=>200, 'msg'=>'['.$userdata['user_id'].'] 회원님의 상태를 ['.$userdata['code_name'].'] 에서 ['.$codedata['code_name'].'] 으로 변경하시겠습니까?');
		}

		$param['user_status'] = $userdata['user_state'];
		
		$rltdata = $this->CI->User_model->update_member_status($param);

		if($rltdata){
			return array('code'=>200, "msg"=>"정상 처리 되었습니다.", "data"=>$rltdata );
		} else {
			return array('code'=>500, "msg"=>"잠시 후에 다시 시도해 주세요");
		}

	}

	// 회원 이름 변경
	public function member_change_name($param){
		if(empty($param['name'])){
			return array('code'=>404, 'msg'=>'이름을 입력해주세요');
		}

		$userdata = $this->CI->User_model->get_user_data_by_idx($this->userinfo['idx']);

		if(empty($userdata)){
			return array('code'=>500, 'msg'=>'회원정보를 찾을 수 없습니다.');
		}

		if( $param['name'] == $userdata['user_name'] ) {
			return array('code'=>501, 'msg'=>'기존 이름과 동일합니다.');
		}
		$param['user_name'] = $userdata['user_name'];
		$rltdata = $this->CI->User_model->update_member_name($param);
		if($rltdata){
			return array('code'=>200, "data"=>array("name"=>$param['name']));
		} else return array('code'=>503, 'msg'=>'처리 오류.');	

	}

	// 비밀 번호 변경
	public function member_change_pw($param){
		if(empty($param['pw'])){
			return array('code'=>404, 'msg'=>'비밀번호를 입력해주세요');
		}

		$userdata = $this->CI->User_model->get_user_data_by_idx($this->userinfo['idx']);

		if(empty($userdata)){
			return array('code'=>500, 'msg'=>'회원정보를 찾을 수 없습니다.');
		}

		$param['user_pass'] = $userdata['user_pass'];

		$rltdata = $this->CI->User_model->update_member_pw($param); 

		if($rltdata){
			return array('code'=>200);
		} else return array('code'=>503, 'msg'=>'처리 오류.');	
	}

	// 회원 상세 정보 
	public function get_user_data(){
		$userdata = $this->CI->User_model->get_user_data_by_idx($this->userinfo['idx']);
		if($userdata){
			return array('code'=>200, 'data'=> $userdata);
		} else return array('code'=>500, 'msg'=>'처리 오류.');
	}

	// 회원 정보 변경
	public function modify_user_profile($param){
		$user_param = array(
			"user_idx"	=> $this->userinfo['idx'],
			"user_name" => $param['user_name'],
			"user_pass" => "",
			"user_img_path" => "",
			"user_img_name" => "",
		);

		if(!empty(trim($param['password']))){
			if(!empty(trim($param['password_ch']))){
				return array('code'=>501, 'msg'=>'비밀 번호 확인 값을 입력 해 주세요');
			}
			if(trim($param['password']) != trim($param['password_ch'])){
				return array('code'=>501, 'msg'=>'비밀 번호와 비밀 번호 확인 값이 맞지 않습니다.');
			}
			$user_param['user_pass'] = password_hash($param['password'], PASSWORD_DEFAULT);
		}

		// 등록 파일 존재 시 처리 
		if($param['FILES']['profile_img']['tmp_name']){
			$target_dir = "/var/www/html/tc_file/_tc_image/";
			$thumbnail_path = 'user_'.date('Y');
			$dest = $target_dir.$thumbnail_path;
			if(!is_dir($dest)) {
				mkdir($dest, 0755);
				chmod($dest, 0755);
			}			
			$fileTypeExt = explode("/", $param['FILES']['profile_img']['type']);		
			$fileType = $fileTypeExt[0];
			$fileExt = $fileTypeExt[1];		
			$file_name = $this->CI->userfunction->fnStrUniqId('uf').'.'.$fileExt;

			$target_file = $dest .'/'.$file_name; // 원본 파일 
			$target_th_file = $dest .'/s_'.$file_name; // 썸네일 파일 

			if ($param['FILES']['profile_img']['error']) {
				return array('code' => 602, "msg" => "파일업로드 중 에러가 발생했습니다!");
			} else if ($param['FILES']['profile_img']['size'] / 1024 / 1024 > 4) {
				return array('code' => 604, "msg" => "최대 4M까지만 업로드가 가능합니다.");
			}

			$arr_img_type = array("image/gif", "image/jpeg", "image/png", "image/bmp"); 
			if (!in_array($param['FILES']['profile_img']['type'], $arr_img_type)) {
				return array('code' => 605, "msg" => "이미지 파일만 업로드 가능 합니다.");
				return;
			}

			if (move_uploaded_file($param['FILES']['profile_img']['tmp_name'], $target_file)){
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
				/*
				$source_aspect_ratio = $img_width / $img_height;
				$desired_aspect_ratio = $max_width / $max_height;			
				if ($source_aspect_ratio > $desired_aspect_ratio) {				
					$temp_height = $max_height;
					$temp_width = (int)($max_height * $source_aspect_ratio);
				} else {				
					$temp_width = $max_width;
					$temp_height = (int)($max_width / $source_aspect_ratio);
				}		
				*/

				$temp_gdim = imagecreatetruecolor($max_width, $max_height);
				imagecopyresampled($temp_gdim, $new_image, 0, 0, 0, 0, $max_width, $max_height, $img_width, $img_height);
				
				//$x0 = ($temp_width - $max_width) / 2;
				//$y0 = ($temp_height - $max_height) / 2;
				//$desired_gdim = imagecreatetruecolor($max_width, $max_height);
				//imagecopy($desired_gdim, $temp_gdim, 0, 0, 0, 0, $max_width, $max_height);			
				
				$extArr = array("image/jpeg"=>'jpg', "image/gif"=>'gif', "image/png"=>'png', "image/bmp"=>'bmp');
				$ext = isset($extArr[$img_info['mime']]) ? $extArr[$img_info['mime']] : '';

				if(strtolower($ext) == "jpg" || strtolower($ext) == "jpeg") imagejpeg($temp_gdim, $target_th_file);
				else if(strtolower($ext) == "gif") imagegif($temp_gdim, $target_th_file);
				else if(strtolower($ext) == "bmp") imagewbmp($temp_gdim, $target_th_file);
				else if(strtolower($ext) == "png") imagejpeg($temp_gdim, $target_th_file);
				$tem_param['img_path'] = '/tc_file/_tc_image/'.$thumbnail_path;
				$tem_param['img_name'] = $file_name;

				$user_param['user_img_path'] = '/tc_file/_tc_image/'.$thumbnail_path;
				$user_param['user_img_name'] = $file_name;
			}			
		}

		$userdata = $this->CI->User_model->modify_user_profile($user_param);
		if($userdata){
			return array('code'=>200, 'data'=>$userdata);
		} else return array('code'=>500, 'msg'=>'처리 오류.');
	}

	// 프로필 이미지 변경
	public function change_profile_img($param){
		$user_param = array(
			"user_idx"	=> $this->userinfo['idx']
		);

		// 등록 파일 존재 시 처리 
		if($param['FILES']['profile_img']['tmp_name']){
			$target_dir = "/var/www/html/tc_file/_tc_image/";
			$thumbnail_path = 'user_'.date('Y');
			$dest = $target_dir.$thumbnail_path;
			if(!is_dir($dest)) {
				mkdir($dest, 0755);
				chmod($dest, 0755);
			}			
			$fileTypeExt = explode("/", $param['FILES']['profile_img']['type']);		
			$fileType = $fileTypeExt[0];
			$fileExt = $fileTypeExt[1];		
			$file_name = $this->CI->userfunction->fnStrUniqId('uf').'.'.$fileExt;

			$target_file = $dest .'/'.$file_name; // 원본 파일 
			$target_th_file = $dest .'/s_'.$file_name; // 썸네일 파일 

			if ($param['FILES']['profile_img']['error']) {
				return array('code' => 602, "msg" => "파일업로드 중 에러가 발생했습니다!");
			} else if ($param['FILES']['profile_img']['size'] / 1024 / 1024 > 4) {
				return array('code' => 604, "msg" => "최대 4M까지만 업로드가 가능합니다.");
			}

			$arr_img_type = array("image/gif", "image/jpeg", "image/png", "image/bmp"); 
			if (!in_array($param['FILES']['profile_img']['type'], $arr_img_type)) {
				return array('code' => 605, "msg" => "이미지 파일만 업로드 가능 합니다.");
				return;
			}

			if (move_uploaded_file($param['FILES']['profile_img']['tmp_name'], $target_file)){
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

				$temp_gdim = imagecreatetruecolor($max_width, $max_height);
				imagecopyresampled($temp_gdim, $new_image, 0, 0, 0, 0, $max_width, $max_height, $img_width, $img_height);
				
				$extArr = array("image/jpeg"=>'jpg', "image/gif"=>'gif', "image/png"=>'png', "image/bmp"=>'bmp');
				$ext = isset($extArr[$img_info['mime']]) ? $extArr[$img_info['mime']] : '';

				if(strtolower($ext) == "jpg" || strtolower($ext) == "jpeg") imagejpeg($temp_gdim, $target_th_file);
				else if(strtolower($ext) == "gif") imagegif($temp_gdim, $target_th_file);
				else if(strtolower($ext) == "bmp") imagewbmp($temp_gdim, $target_th_file);
				else if(strtolower($ext) == "png") imagejpeg($temp_gdim, $target_th_file);
				$tem_param['img_path'] = '/tc_file/_tc_image/'.$thumbnail_path;
				$tem_param['img_name'] = $file_name;

				$user_param['user_img_path'] = '/tc_file/_tc_image/'.$thumbnail_path;
				$user_param['user_img_name'] = $file_name;

				// 이전 이미지 확인 
				$user_data = $this->CI->User_model->get_user_data_by_idx($this->userinfo['idx']);
				// 이전 파일 확인 후 삭제
				if(!empty($user_data['user_img_path']) && !empty($user_data['user_img_name'])){
					$is_file_exist = file_exists('/var/www/html'.$user_data['user_img_path'].'/'.$user_data['user_img_name']);					
					if($is_file_exist) {					
						unlink('/var/www/html'.$user_data['user_img_path'].'/'.$user_data['user_img_name']);
						unlink('/var/www/html'.$user_data['user_img_path'].'/s_'.$user_data['user_img_name']);					
					}					
				}
				$userdata = $this->CI->User_model->modify_user_profile($user_param);
				if($userdata){
					$login_data = array(
						'idx'		=> $this->userinfo['idx'],
						'user_id'	=> $this->userinfo['user_id'],
						'user_name' => $this->userinfo['user_name'],
						'join_type' => $this->userinfo['join_type'],
						'user_img'	=> $user_param['user_img_path'].'/s_'.$user_param['user_img_name']
					);
					$this->CI->session->set_userdata(array("userinfo"=>$login_data));
					return array('code'=>200, 'data'=>array('img_url'=>$user_param['user_img_path'].'/s_'.$user_param['user_img_name']));
				} else return array('code'=>400, 'msg'=>'처리 오류.');
			}
			else return array('code'=>400, 'msg'=>'이미지 파일이 등록 되지 않았습니다.');
		} else return array('code'=>400, 'msg'=>'이미지 파일이 등록 되지 않았습니다.');
	}

	// 이름 변경
	public function change_user_name($param){
		$res_nm = $this->CI->User_model->update_member_name(
				array(
					'idx' => $this->userinfo['idx'],
					'name' => $param['user_new_name']
				)
			);
		if($res_nm){
			$login_data = array(
				'idx'		=> $this->userinfo['idx'],
				'user_id'	=> $this->userinfo['user_id'],
				'user_name' => $param['user_new_name'],
				'join_type' => $this->userinfo['join_type'],
				'user_img'	=>  $this->userinfo['user_img']
			);
			$this->CI->session->set_userdata(array("userinfo"=>$login_data));
			$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=>'이름이 변경되었습니다.');
		} else {
			$returnOjb = array('code'=>422, 'rlt'=>false, 'msg'=>'처리중 오류가 발생 하였습니다.');
		}
		return $returnOjb;
	}

	// 회원 비밀 번호 변경 
	public function change_user_password($param){
		$ac_prc = true;
		// 현재 비밀 번호 확인		
		$user_data = $this->CI->User_model->get_user_data_by_idx($this->userinfo['idx']);
		if (!password_verify($param['user_now_pwd'], $user_data['user_pass'])){
			$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'현재 비밀번호가 일치하지 않습니다.');
			$ac_prc = false;
		}
			
		// 입력값 체크 -> 비밀번호 자리수 확인 
		if(strlen($param['user_new_pwd']) < 8 || strlen($param['user_new_pwd']) > 16) {				
			$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'비밀번호는 영문, 숫자, 특수문자를 혼합하여 최소 8자리 ~ 최대 16자리 이내로 입력해주세요.');
			$ac_prc = false;
		}

		// 빈칸 확인
		if((preg_match("/\s/u", $param['user_new_pwd']) == true) && $ac_prc == true) {
			$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'비밀번호는 공백없이 입력해주세요.');
			$ac_prc = false;
		}

		// 비밀번호 확인 값
		if(($param['user_new_pwd'] != $param['re_user_new_pwd']) && $ac_prc == true){
			$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'재입력한 비밀번호가 일치하지 않습니다.');
			$ac_prc = false;
		}

		if($ac_prc == true){			
			// 비밀 번호 변경 처리 
			$res_pw = $this->CI->User_model->update_member_pw(array("idx" => $this->userinfo['idx'], "pw" => $param['user_new_pwd']));
			if($res_pw){
				$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=>'비밀번호가 변경되었습니다.');
			} else {
				$returnOjb = array('code'=>422, 'rlt'=>false, 'msg'=>'처리중 오류가 발생 하였습니다.');
			}
		}
		return $returnOjb;	
	}

	// 회원 탈퇴 처리 
	public function leave_user_prc($param){
		$ac_prc = true;
		// 비밀 번호 확인 
		$user_data = $this->CI->User_model->get_user_data_by_idx($this->userinfo['idx']);
		if (!password_verify($param['leave_pwd'], $user_data['user_pass'])){
			$returnOjb = array('code'=>400, 'rlt'=>false, 'msg'=>'현재 비밀번호가 일치하지 않습니다.');
			$ac_prc = false;
		}

		if($ac_prc === true){		
			$param_leave  = array(
				"user_idx" => $this->userinfo['idx'], 
				"user_id" => $this->userinfo['user_id'],
				"user_state" => 'SE',
				"leave_reson" => $param['leave_res'],
				"leave_note" => $param['leave_note'],				
			);
			// 탈퇴 사유 입력 
			$leave_res = $this->CI->User_model->add_user_leave_data($param_leave);
			if($leave_res){
				$returnOjb = array('code'=>200, 'rlt'=>true, 'msg'=>'회원 탈퇴 처리 되었습니다.');
			} else {
				$returnOjb = array('code'=>400, 'rlt'=>false, 'msg'=>'False');
			}
		}
		return $returnOjb;
	}
}
