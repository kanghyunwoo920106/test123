<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Member_lib {
	var $CI;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('UserFunction');
		$this->CI->load->model('Member_model');	
		
		$this->userinfo = $this->CI->session->userdata('userinfo');
	}

	// 주소록 리스트 
	public function get_user_member_list($param){
		if(empty($param['pg_num'])){
			$param['pg_num'] = 1;
		}

		$total_cnt = $this->CI->Member_model->get_user_member_cnt(['user_idx'=>$this->userinfo['idx']]);
		$st_num = (int)(($param['pg_num'] - 1) * 10);

		if($param['mem_order'] == 2){
			$order_target = 'um.mem_name';
			$order_type = 'ASC';
		} else {
			$order_target = 'um.up_date';
			$order_type = 'DESC';
		}

		$reData = $this->CI->Member_model->get_user_member_list(
			array(
				's_num'			=> $st_num, 
				'user_idx'		=> $this->userinfo['idx'],
				'order_tar'		=> $order_target,
				'order_type'	=> $order_type
			)
		);	
		if($reData){
			if($total_cnt['cnt'] > 10) $pg_num = (int)($param['pg_num'] + 1);
			else $pg_num = 'E';
			return array('code' => 200, 'data' => $reData, 't_cnt'=> $total_cnt['cnt'], 'pg_num' => $pg_num);
		}else{
			return array('code' => 425, 'msg' => 'No Data', 'pg_num' => 'E');
		}
	}

	// 주소록 추가
	public function add_user_member($param){
		$ck_user = $this->CI->Member_model->check_user_data(['user_id' => $param['mem_email']]);

		$mem_user_idx = $ck_user ? $ck_user['idx'] : '0';

		$add_param = array(
			'user_idx' => $this->userinfo['idx'],
			'user_check' => $mem_user_idx,
			'mem_name' => $param['mem_name'],
			'mem_email' => $param['mem_email'],
			'mem_memo' => '',
			'use_yn' => 'Y'
		);
		$ret = $this->CI->Member_model->add_user_member($add_param);
		if($ret ){
			return array("code"=>200, "msg"=>"success");
        }else{
			return array("code"=>425, "msg"=>"Fail");
        }	
	}
	
	// 주소록 이름 변경
	public function up_user_member($param){
		$up_param = [
			'user_idx' => $this->userinfo['idx'],
			'mem_idx' => $param['mem_idx'],
			'up_data' => ['mem_name' => $param['mem_name']]
		];
		$ret = $this->CI->Member_model->up_user_member($up_param);
		if($ret ){
			return array("code"=>200, "msg"=>"success", "data" => ['idx' => $param['mem_idx'], 'mem_name' => $param['mem_name']]);
        }else{
			return array("code"=>425, "msg"=>"fail");
        }
	}

	// 주소록 삭제
	public function del_user_member($param){
		$up_param = [
			'user_idx' => $this->userinfo['idx'],
			'mem_idx' => $param['mem_idx'],
			'use_yn' => 'N'
		];
		$ret = $this->CI->Member_model->del_user_member($up_param);
		if($ret){
			return array("code"=>200, "msg"=>"success");
        }else{
			return array("code"=>425, "msg"=>"fail");
        }
	}

	// 선택 주소록 삭제
	public function del_chval_user_member($param){
		$mem_ch_txt = '';
		if(count($param['mem_ch_idx']) > 0){
			$i = 0;
			foreach($param['mem_ch_idx'] as $row){
				if($i > 0){$mem_ch_txt .= ', ';}
				$mem_ch_txt .= $row;
				$i++;
			}
		}
		$up_param = [
			'user_idx' => $this->userinfo['idx'],
			'mem_idx_txt' => $mem_ch_txt,
			'use_yn' => 'N'
		];
		$ret = $this->CI->Member_model->del_chval_user_member($up_param);
		if($ret){
			return array("code"=>200, "msg"=>"success");
        }else{
			return array("code"=>425, "msg"=>"fail");
        }
	}

	/* Document View ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */	

	// modal 주소록 리스트 
	public function get_modal_user_member_list($param){
		$rlt = $this->CI->Member_model->get_modal_user_member_list(
			array(
				'doc_id' => $param['doc_id'], 
				'user_idx' => $this->userinfo['idx']
			)
		);
		if($rlt){
			return array('code'=>200, 'data' => $rlt);
        }else{
			return array('code'=>425, 'msg' => 'fail');
        }
	}

	/* Document View ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */

	/* Common ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ */
	

	/* Common ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ */
}