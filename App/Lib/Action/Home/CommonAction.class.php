<?php
class CommonAction extends Action{
	public function _initialize(){
		//是否关闭网站
		if( C("cfg_siteclosed") ){
			exit(C("cfg_siteclosemsg"));
		}
		
		//自动拒绝审核到期订单
		if( C("cfg_autodisdk") ){
			$day = C("cfg_autodisdkday");
			if(!$day) $day = 3;
			$Order = D("order");
			$arr = $Order->where(array('status' => 1))->select();
			for($i=0;$i<count($arr);$i++){
				$tmptime = $arr[$i]['addtime'];
				if((time()-$tmptime)/(24*60*60) >= $day){
					$Order->where(array('id' => $arr[$i]['id']))->save(array('status' => '-1'));
				}
			}
		}
		
		//判断Cookie获取用户名
		$phone = $_COOKIE['user'];
		if(!empty($phone)){
			$this->setLoginUser($phone);
		}
		
	}
	
	
	//生成验证码方法
	Public function verify(){
	    import('ORG.Util.Image');
	    Image::buildImageVerify();
	}
	
	//设置前台登录的用户
	protected function setLoginUser($phone = ''){
		if(!$phone){
			$_SESSION['user'] = NULL;
			setcookie("user",NULL,time()-3600);
		}else{
			$_SESSION['user'] = $phone;
			setcookie("user",$phone,180*24*60*60);
		}
	}
	
	//获取当前登录的用户手机号
	protected function getLoginUser(){
		$phone = $_SESSION['user'];
		if(empty($phone)){
			return 0;
		}else{
			return $phone;
		}
	}

}
