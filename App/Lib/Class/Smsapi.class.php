<?php
/*
 *		秒嘀验证码发送接口类
 * 		By:somnus  
 * 		Time:2016-12-15 21:33 
 * */
class Smsapi{
	protected $sendurl = "http://api.smsbao.com/";


	//发送验证码
	//成功返回0,失败返回错误代码
	public function send($number,$cont){
		$user = "xinrui"; //短信平台帐号
		$pass = md5("yang920605"); //短信平台密码
		$sendurl = $this->sendurl."sms?u=".$user."&p=".$pass."&m=".$number."&c=".urlencode($cont);
		//$sendurl = $this->sendurl."sms?u=".$user."&p=".$pass."&m=".$number."&c=".urlencode($cont);
		$result =file_get_contents($sendurl);
		return $result;
		
//		$nowdate = date("YmdHis");
//		$data = array(
//			'accountSid' => C('cfg_smssid'),
//			'smsContent' => $cont,
//			'to'		 => $number,
//			'timestamp'	 => $nowdate,
//			'sig'		 => md5(C('cfg_smssid').C('cfg_smstoken').$nowdate)
//		);
//		$res = $this->postHTTPS($this->sendurl,$data);
//		$res = json_decode($res);
//		if($res->respCode != "00000"){
//			return $res->respCode;
//		}
//		return 0;
	}
	
	
	private function postHTTPS($url,$post_data) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_HEADER, false);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    //curl_setopt($ch, CURLOPT_REFERER, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
	}
	
}
