<?php
/*	后台权限验证方法	*/
class CommonAction extends Action{
	
	public function _initialize(){
		//判断登录
		if(MODULE_NAME != "Index" && !$this->islogin()){
			$this->redirect(GROUP_NAME.'/Index/login');
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
		
	}
	
	
	protected function islogin(){
		if(!session('admin_user') ){
			return false;
		}
		return true;
	}
	
	protected function setlogin($name = ''){
		if(empty($name)){
			session('admin_user',null);
		}else{
			session('admin_user',$name);
		}
	}
	
	protected function getlogin(){
		return session('admin_user');
	}
	
	protected function getpass($pass){
		return md5( C('cfg_adminkey').md5($pass) );
	}
	
}