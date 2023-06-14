<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_lib {
	var $CI;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('UserFunction');
		$this->CI->load->model('Common_model');

		$this->CI->load->model('Member_model');
	}

	public function login_check(){
		$this->userinfo = $this->CI->session->userdata('userinfo');
		if ($this->userinfo){			
			return true;
		} else {
			header('Location: /login?reurl='.$_SERVER['REQUEST_URI'], TRUE, null);
			exit;
		}
	}
	
	public function admin_login_check(){
		$this->admininfo = $this->CI->session->userdata('admininfo');
		if ($this->admininfo){			
			return true;
		} else {
			header('Location: /login/tc_manager?reurl='.$_SERVER['REQUEST_URI'], TRUE, null);
			exit;
		}
	}

	public function member_status_code(){
		$rlt = $this->CI->Common_model->get_code_member_status();
		if(empty($rlt)){
			return false;
		}
		else return $rlt;
	}

	// ���� ��û 
	public function tw_api_sign_prc(){
		$target_url = APP_URL.'sign';
		$arHeaders = array('accept: application/json', 'Content-Type: application/json');
		$arParams = array(
			'appId' => APP_ID,
			'appSecretKey' => APP_SECRET_KEY
		);
		$responses = $this->CI->userfunction->fnCurlExec($target_url, 'POST', $arHeaders, $arParams);
	
		$return_data = array();		
		if($responses['code'] == 200 && $responses['data']['success'] == true){
			$return_data['accessToken'] = $responses['data']['data']['accessToken'];
			return $return_data;
		} else return false;
	}

	// ȸ�� ���� ���� �ڵ� Ȯ�� 
	public function check_auth_code_prc($param){
		$this->CI->load->model('User_model');		
		// �ڵ尪 ��ȣȭ ó�� 
		$code_str_decode = $this->CI->userfunction->fnSimpleCrypt($param['en_auth_code'],'d');
		if(empty($code_str_decode)){			
			$returnOjb = array('code'=>421, 'rlt'=>false, 'msg'=>'���� �ùٸ��� �ʽ��ϴ�.');
		} else {			
			// DB ���� �ڵ� Ȯ�� -> �ӽ� ������
			$res_auth = $this->CI->Common_model->get_auth_data(array('use_yn'=>'T', 'auth_type'=>'A', 'authcode'=>$code_str_decode));

			if($res_auth){
				// ���� ���·� ���� ó�� 
				$res_up = $this->CI->Common_model->up_auth_data(array('use_yn'=>'Y', 'authcode'=>$code_str_decode));
				// ȸ�� ���� ����
				$param_user = array(
					'user_idx' => $res_auth['user_idx'],
					'user_state' => 'NM',
					'up_date' => date('Y-m-d H:i:s')
				);			
				$res_user = $this->CI->User_model->up_user_state_data($param_user);

				$this->check_user_member_data(
					array(
						'user_id' => $res_auth['user_id'],
						'up_user_idx' => $res_auth['user_idx']
					)
				);
				
				$returnOjb = array('code'=>200, 'data'=>'���� ���� �Ǿ����ϴ�.');
			}
			else {
				$returnOjb = array('code'=>425, 'rlt'=>false, 'msg'=>'���� �ùٸ��� �ʽ��ϴ�.');
			}
		}
		return $returnOjb;
	}

	public function array_doc_color_code(){
		$returnOjb = [];
		$rlt = $this->CI->Common_model->get_doc_color();
		foreach($rlt as $row){
			$returnOjb[$row['code_name']] = $row['code_detail'];
		}
		return $returnOjb;
	}

	// ���� �ڵ� ��ȿ üũ
	public function check_public_auth_code($param){
		// �ڵ尪 ��ȣȭ ó�� 
		$code_str_decode = $this->CI->userfunction->fnSimpleCrypt($param['en_auth_code'],'d');
		if(empty($code_str_decode)){			
			return array('code'=>400, 'rlt'=>false, 'msg'=>'���� �ùٸ��� �ʽ��ϴ�.');
			exit;
		} 

		// DB ���� �ڵ� Ȯ�� -> ��й�ȣ ���� �ӽ� ���� �ڵ� ���� �ִ��� Ȯ��
		$res_auth = $this->CI->Common_model->get_auth_data(array('use_yn'=>'T', 'auth_type'=>$param['auth_type'], 'authcode'=>$code_str_decode));
		if(empty($res_auth)){
			return array('code'=>400, 'rlt'=>false, 'msg'=>'���� �ùٸ��� �ʽ��ϴ�.');
			exit;
		}

		// �ð� Ȯ�� 
		$nowday = date('Y-m-d H:i:s');
		$chkday = $res_auth['reg_date'];		
		$gapMinute = (int)((strtotime($nowday) - strtotime($chkday)) / 60);		
		switch($param['auth_type']){
			case 'P': 
					// ��� ��ȣ 30�� ��ȿ
					if($gapMinute > 30){
						return array('code'=>400, 'rlt'=>false, 'msg'=>'���� �ڵ� ��ȿ �ð��� ���� �Ͽ����ϴ�. �ٽ� ��� ��ȣ ã�⸦ �õ� �� �ּ���');
						exit;
					}
				break;
			case 'A': 
					// ���� ���� 24�ð� ��ȿ
					if($gapMinute > (60 * 24)){
						return array('code'=>400, 'rlt'=>false, 'msg'=>'���� �ڵ� ��ȿ �ð��� ���� �Ͽ����ϴ�.');
						exit;
					}
				break;
		}
		return array('code'=>200, 'data'=>$res_auth);		
	}

	/* ���� ���  ���������������������������������������������������������������������������������� */ 
	// ȸ�� ���Խ� �ּҷϿ� ��� �Ǿ� ������ user ���� ������Ʈ
	public function check_user_member_data($param){
		// �ּ� ���̺��� �� ���̵�� ���� ���� �ּҰ� �ִ��� Ȯ�� 
		$check_mem_list = $this->CI->Member_model->get_user_member_email_check_data(
			array(
				'user_id' => $param['user_id']
			)
		);
		if(count($check_mem_list) > 0){
			foreach($check_mem_list as $row){
				$this->CI->Member_model->up_user_member(
					[
						'user_idx'	=> $row['user_idx'],
						'mem_idx'	=> $row['idx'],
						'up_data'	=> [
							'user_check' => $param['up_user_idx']
						]
					]
				);
			}
			return array('code'=>200);
		} else {
			return array('code'=>425);
		}		
	}
	/* ���� ���  ���������������������������������������������������������������������������������� */ 


}
