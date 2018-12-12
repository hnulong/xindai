<?php
class WechatModel extends Model{
    protected $tableName = 'wechat';
	
	private function getToken(){
		$info = $this->where(array('type' => 0))->find();
		if(!$info){
			$status = $this->setToken();
			if($status == 0){
				$info = $this->where(array('type' => 0))->find();
			}else{
				return $status;
			}
		}
		if($info['token'] == "__"){
			$status = $this->setToken();
			$info = $this->where(array('type' => 0))->find();
		}
		if(time()-$info['addtime'] >= 7200){
			$status = $this->setToken();
			$info = $this->where(array('type' => 0))->find();
		}
		return $info['token'];
	}
	
	
	private function setToken(){
		$token = $this->where(array('type' => 0))->find();
		if(!$token){
			$token = array(
				'token' => '__',
				'addtime' => time(),
				'type' => 0
			);
			$id = $this->add($token);
			$token['id'] = $id;
		}
		//调用接口获取token
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET";
		$info = getHTTPS($url);
		$info = json_decode($info);
		if($info['errcode']){
			return $info['errcode'];
		}else{
			$token_ = $info['access_token'];
			$addtime_ = time();
			$arr = array(
				'token' => $token_,
				'addtime' => $addtime_
			);
			$status = $this->where(array('id' => $token['id']))->save($arr);
			if($status){
				return 0;
			}else{
				return "-1";
			}
		}
	}
	
	public function getTicket(){
		$info = $this->where(array('type' => 1))->find();
		if(!$info){
			$status = $this->setTicket();
			if($status == 0){
				$info = $this->where(array('type' => 1))->find();
			}else{
				return $status;
			}
		}
		if($info['token'] == "__"){
			$status = $this->setTicket();
			$info = $this->where(array('type' => 1))->find();
		}
		if(time()-$info['addtime'] >= 7200){
			$status = $this->setTicket();
			$info = $this->where(array('type' => 1))->find();
		}
		return $info['token'];
	}
	
	private function setTicket(){
		$ticket = $this->where(array('type' => 1))->find();
		if(!$ticket){
			$ticket = array(
				'token' => '__',
				'addtime' => time(),
				'type' => 1
			);
			$id = $this->add($token);
			$token['id'] = $id;
		}
		$token = $this->getToken();
		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$token}&type=jsapi";
		$info = getHTTPS($url);
		$info = json_decode($info);
		if($info['errcode'] != 0){
			return $info['errcode'];
		}else{
			$ticket_ = $info['ticket'];
			$addtime_ = time();
			$arr = array(
				'token' => $ticket_,
				'addtime' => $addtime_
			);
			$status = $this->where(array('id' => $ticket['id']))->save($arr);
			if($status){
				return 0;
			}else{
				return "-1";
			}
		}
	}
	
	
	
	private function postHTTPS($url,$post_data) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_HEADER, false);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
	}
	
	private function getHTTPS($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	
	
}
