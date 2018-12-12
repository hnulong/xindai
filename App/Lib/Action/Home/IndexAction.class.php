<?php
class IndexAction extends CommonAction{
	
    public function index(){
        //获取服务费率
    	//随机生成一批借款成功的
    	$phonestr = "13,15,17,18";
    	$phonearr = explode(",",$phonestr);
    	$redaydata = array();
		for($i=0;$i<30;$i++){
			$tmp = rand(0,count($phonearr)-1);
			$phone = $phonearr[$tmp].rand(0,9)."****".rand(0,9).rand(0,9).rand(0,9).rand(0,9);
			$money = rand(5,300)*100;
			$redaydata[] = array(
				'phone' => $phone,
				'money' => $money
			);
		}
		//var_dump($redaydata);exit;
		$this->redaydata = $redaydata;
    	$user = $this->getLoginUser();
    	if(!$user) $user = 0;
		$this->user = $user;
        $this->display();
    }
}