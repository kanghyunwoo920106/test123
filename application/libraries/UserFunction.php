<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UserFunction
{
	var $CI;
	public function __construct() {
		$this->CI =& get_instance();		
		$this->userinfo = $this->CI->session->userdata('userinfo');
	}

	/* ▼ CURL 실행 */
	function fnCurlExec($strHost, $strMemod='GET', $headers=array(), $rgParams=array())
	{
		$ch = curl_init();
		// SSL: 여부
		if(stripos($strHost, 'https://') !== FALSE) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		}

		// POST/GET 설정
		if(strtoupper($strMemod) == 'POST') {

			curl_setopt($ch, CURLOPT_URL, $strHost);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($rgParams));

		} else if(strtoupper($strMemod) == 'PATCH'){

			curl_setopt($ch, CURLOPT_URL, $strHost);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($rgParams));

		} else if(strtoupper($strMemod) == 'PUT'){

			curl_setopt($ch, CURLOPT_URL, $strHost);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($rgParams));

		} else {

			curl_setopt($ch, CURLOPT_URL, $strHost . ((strpos($strHost, '?') === FALSE) ? '?' : '&') . http_build_query($rgParams));
			
		}

		if(!empty($headers)){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
		}

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "spider");
		$data = curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return array("code" => $code, "data" => json_decode($data, JSON_UNESCAPED_UNICODE));
	}
	/* ▲ CURL 실행 */

	function fnBindParam(&$db, $sql, $binds) {
		if(!isset($binds)) {
			return $sql;
		}

		if ( ! is_array($binds)) {
			$binds = array($binds);
		}

		foreach($binds as $k=>$v) {
			$sql = str_replace($k, $db->escape($v), $sql);
		}

		return $sql;
	}

	/* ▼ DATABASE의 DML일부와 특수문자 띄어쓰기까지 필터(DML 쿼리 실행시 사용) */
	public function fnStringFilter($str)
	{
		$strRegExp = "/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i";
		//while(preg_match($strRegExp, $str)) { 
			$str = preg_replace($strRegExp,"",$str);	
		//}
		return $str;
	}
	/* ▲ DATABASE의 DML일부와 특수문자 띄어쓰기까지 필터(DML 쿼리 실행시 사용) */

	/* ▼ 숫자 필터 */
	public function fnIntegerFilter($str)
	{
		return preg_replace('[^0-9]','', abs($str));
	}
	/* ▲ 숫자 필터 */

	/* ▼ 페이지 이동 */
	public function fnMovePage($mess='', $goUrl='', $goCode)
	{
		$strJsText = '';
		if(!empty($mess))
		{
			$strJsText .= "alert('".$mess."');\n";
		}

		switch($goCode){
			//페이지 이동
			case 1 :
				$strJsText .= "location.href='".$goUrl."';\n";
			break;
			//뒤로
			case 2 :
				$strJsText .= "history.back();\n";
			break;

			//새창닫기
			case 3 :
				$strJsText .= "self.close();\n";
			break;

			/* ▼ 새창닫고 부모창 이동 (SSL 로케이션 허용 안됨 href로 우회때 이용) */
			case 4 :
				$strJsText .= "self.close();\n";
				$strJsText .= "opener.location.href='".$goUrl."';\n";
			break;
			/* ▲ 새창닫고 부모창 이동 (SSL 로케이션 허용 안됨 href로 우회때 이용) */

			// 부모창 닫기
			case 5 :
				$strJsText .= "parent.window.close();\n";
			break;

			// 부모창 리로딩 후 창 닫기
			case 6 :
				$strJsText .= "parent.opener.location.reload();self.close();\n";
			break;
			// 뒤로(x2)
			case 7 :
				$strJsText .= "history.go(-2);\n";
			break;
			// 부모창만 리로딩
			case 8 :
				$strJsText .= "opener.location.reload();\n";
			break;

			//부모창 리로딩후 페이지 이동 SSL에서 사용 금지
			case 9 :
				$strJsText .= "opener.location.reload();\n";
				$strJsText .= "location.href='".$goUrl."';\n";
			break;
			//메시지만 출력
			case 10 :
				$strJsText .= "";
			break;
			//페이지 이동
			case  11 :
				$strJsText .= "parent.location.href='".$goUrl."';\n";
			break;

			//메시지만 출력 후 이후는계속실행
			case 12 :
				$strJsText .= "";
			break;

			//새창이면 닫고 이동 현제창이면 그냥이동
			case 13 :
	//			$strJsText .= "alert(window.name)\n";
				$strJsText .= "try{\n";
				$strJsText .= "	var reUrl = window.opener.document.URL;\n";
				$strJsText .= "	window.opener.location.href='".$goUrl."'\n";
				$strJsText .= "	self.close();\n";
				$strJsText .= "}catch(e){\n";
				$strJsText .= "	var reUrl = window.document.URL;\n";
				$strJsText .= "	window.location.href='".$goUrl."';\n";
				$strJsText .= "}\n";
			break;			

			//메인페이지로 이동
			default :
				$strJsText .= "location.href='/';\n";
			break;
		}

		if($goCode == 17) {
			$rgResult = array(
				"message"	 => $mess,
				"url"		 => $goUrl,
			);
			echo json_encode($rgResult);
		} else if($goCode == 18) {
			$rgResult = array(
				"success"	 => $goUrl,
				"message"	 => $mess,
			);
			echo json_encode($rgResult);
		} else {
			$strJsScript = "<script type=\"text/javascript\">\n";
			$strJsScript .= $strJsText."\n";
			$strJsScript .= "</script>\n";

			echo $strJsScript;
		}

		if($goCode != 12) {
			exit;
		}
	}
	/* ▲ 페이지 이동 */

	/* ▼ 로그작성 */
	function fnWriteLog($str='', $filepath='', $logable=true)
	{
		if($logable === false) {
			return true;
		}

		$CI =& get_instance();
		$CI->load->helper('file');

		$strLogPath = (empty($filepath)) ? $_SERVER['DOCUMENT_ROOT'].'/tc_file/log/'.date('Ymd', time()).'.log' : $filepath;
		//echo $strLogPath;
		$strLog = '['.date('Y-m-d H:i:s').'] '.$str."\n";

		return write_file($strLogPath, $strLog, 'a+');
	}
	/* ▲ 로그작성 */
		
	function fnConvertPhone($p1){  //연락처 표시
		if(is_null($p1) or trim($p1) == ""){
			return "";
		}else{
			if(strlen($p1) < 12){
				return substr($p1,0,3)."-".substr($p1,3,4)."-".substr($p1,7,4);
			}
			else {
				return substr($p1,0,4)."-".substr($p1,4,4)."-".substr($p1,8,4);
			}
		}
	}	
	
	function fnConvertNumBig($num){
		$str = "";
		$BIG_ORDER = array("", "만", "억", "조");
		$num = $num*10000;
		for($i = count($BIG_ORDER) - 1; $i >= 0; --$i){
			$unit = pow(10000, $i);
			$part = floor($num / $unit);
			if($part > 0){
				$str .= $part . $BIG_ORDER[$i];
			}
			$num %= $unit;	
		}
		return $str;
	}

	function fnConvertNumSmall($num){
		$SMALL_ORDER = array("", "십", "백", "천");
		$str = "";
		for($i = count($SMALL_ORDER) - 1; $i >= 0; --$i){
			$unit = pow(10, $i);
			$part = floor($num / $unit);
			if($part > 0){
				$str .=  "$part" . $SMALL_ORDER[$i];
			}
			$num %= $unit;	
		}
		return $str;
	}

	// 암호화 
	function fnSimpleCrypt($string, $action='e') {
		// 아래값을 임의로 수정해주세요.
		$secret_key = 'skfkakfTkadl3endr346dp3k32sodlf';
		$secret_iv = 'cuip3glarudnjEjs';

		if($string == ''){
			$output = '';
		} else {		
			$output = false;
			$encrypt_method = "AES-256-CBC";
			$key = hash( 'sha256', $secret_key );
			$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
		
			if( $action == 'e' ) {
				$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
			}
			else if( $action == 'd' ){
				$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
			}
		}
		return $output;
	}

	// 고유값 생성 
	function fnStrUniqId($string=''){
		if($string == ''){
			$output = uniqid().rand(0,9).rand(0,9);
		}
		else {
			$output = uniqid($string.'_').rand(0,9).rand(0,9);
		}
		return $output;
	}
}
/* End of file UserFunction.php */
/* Location: ./application/libraries/UserFunction.php */