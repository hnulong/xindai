<?php
class OrderAction extends CommonAction{
	
	public function checkorder(){
		$data = array('status' => 0,'msg' => '未知错误!');
		if(!$this->getLoginUser()){
			$data['status'] = 1;
		}else{
			$day = $this->yesdaikuan($this->getLoginUser());
			if(!$day){
				$data['status'] = 1;
			}else{
                $data['status'] = 1;
				// $data['msg'] = "您最近一次订单审核失败,请".$day."天后再次提交!";
			}
		}
		$this->ajaxReturn($data);
	}
	
	private function yesdaikuan($user){
		//先查找最近一次失败订单
		$Order = D("order");
		$info = $Order->where(array('user' => $this->getLoginUser()))->order("addtime Desc")->find();
		if(!$info){
			return 0;
		}
		if($info['status'] != '-1'){
			return 0;
		}
		$tmptime = $info['addtime'];
		$tmptime = time()-$tmptime;
		$tmptime = $tmptime/(24*60*60);
		$disdkdleyday = C("cfg_disdkdleyday");
		if(!$disdkdleyday) $disdkdleyday = 30;
		if($tmptime > $disdkdleyday){
			return 0;
		}
		return ceil($disdkdleyday-$tmptime);
	}
	
	public function daikuan(){
		if(!$this->getLoginUser()){
			$this->redirect('User/login');
		}
		$Userinfo = D("userinfo");
		$info = $Userinfo->where(array('user' => $this->getLoginUser()))->find();
		if(!$info){
			$this->redirect('Info/index');
		}
		if($info['personname_1']==''){
			$this->redirect('Info/index');
		}
		if($info['bankcard']==''){
			$this->redirect('Info/index');
		}
		//判断用户最近一次失败订单是否超过预期时间
		// $yesdaikuan = $this->yesdaikuan($this->getLoginUser());
		// if($yesdaikuan){
		// 	$this->redirect('Index/index');
		// }
		$money = I("money",0,'trim');
		$month = I("month",0,'trim');
		$money = (float)$money;
		$month = (int)$month;
		$dismonths = C("cfg_dkmonths");
		$dismonths = explode(",",$dismonths);
		$fuwufei = C('cfg_fuwufei');
		$fuwufei = explode(",",$fuwufei);
		if($money > C('cfg_maxmoney') || $money < C('cfg_minmoney')){
			//借款金额不允许
			$this->redirect('Index/index');
		}
		if(!in_array($month,$dismonths)){
			//不允许的分期月
			$this->redirect('Index/index');
		}
		$rixi = round($fuwufei[$month-1] / 30,2);
		$fuwufei = $fuwufei[$month-1] * $money / 100;
		$order = array(
			'money'   => $money,
			'fuwufei' => ceil((float)($money/$month)*$month-$fuwufei), //实际放款
			'month'   => $month,
			'huankuan'=> ceil((float)($money)),
			'bank'	  => $info['bankname'],
			'banknum' => $info['bankcard'],
			'rixi'	  => $fuwufei  //利息
		);
		$addorder = I("get.trueorder",0,'trim');
		if($addorder){
			$data = array('status' => 0,'msg' => '未知错误','payurl' => '');
			//创建订单
			$ordernum = neworderNum();
			$arr = array(
				'ordernum' => $ordernum,
				'type'	   => '审核费',
				'money'	   => C('cfg_shenhefei'),
				'addtime'  => time(),
				'status'   => 0,
				'user'	   => $this->getLoginUser()
			);
			$Payorder = D("payorder");
			$status = $Payorder->add($arr);
			if(!$status){
				$data['msg'] = '创建订单失败!';
			}else{
				$Order = D("order");
				$arr = array(
					'user' => $this->getLoginUser(),
					'money' => $money,
					'months' => $month,
					'monthmoney' => ceil($order['huankuan']/$month),
					'donemonth' => 0,
					'addtime' => time(),
					'status' => 1,  //正在审核订单
					'pid' => $status,
					'bank' => $info['bankname'],
					'banknum' => $info['bankcard'],
					'ordernum' => $ordernum
				);
				$status = $Order->add($arr);
				if(!$status){
					$data['msg'] = '创建订单失败!';
				}else{
					$data['status'] = 1;
                    $data['msg'] = "提交成功";
					$data['payurl'] = U('Order/lists');
				}
			}
			$this->ajaxReturn($data);
			exit;
		}else{
			$this->order = $order;
			$this->display();
		}
	}
	
	public function lists(){
		$Order = D("order");
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('User/login');
		}
		$this->data = $Order->where(array('user' => $user))->order("addtime Desc")->select();
		$this->display();
	}
	
	public function info(){
		$oid = I("oid",0,"trim");
		if(!$oid){
			$this->redirect('Order/lists');
		}
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('User/login');
		}
		$Order = D("order");
		$order = $Order->where(array('id' => $oid,'user' => $user))->find();
		if(!$order){
			$this->redirect('Order/lists');
		}
		$this->data = $order;
		$this->display();
	}
	
	//我的还款
	public function bills(){
	
				
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('User/login');
		}
		$hkr = C("cfg_huankuanri");
		if(!$hkr) $hkr = 10; //每月10号还款
		$data = array();
		//遍历已借款订单
		$Order = D("order");
        $tmp = $Order->where(array('user' => $user,'status' => 2))->select();
		for($i=0;$i<count($tmp);$i++){
			//判断是否已还清
			if($tmp[$i]['months'] > $tmp[$i]['donemonth']){
				$tmp_ordernum = $tmp[$i]['ordernum'];
				//从还款记录查找本月是否已还款
				$Bills = D("bills");
                $data[] = array(
                    'ordernum' => $tmp_ordernum,
                    'money'    => $tmp[$i]['monthmoney'],
                    'days'	   => round((time()-$tmp[$i]['updateTime'])/ 86400)-(7*($tmp[$i]['donemonth'] + 1)),  //判断预期天数
                    'qishu'	   => $tmp[$i]['donemonth'] + 1,
                    'time'     => date('Y-m-d',strtotime(date("Y-m-d",strtotime("+".($tmp[$i]['donemonth'] + 1)." week",$tmp[$i]['updateTime']))))
                );
                if($data[$i]['days']>0){
                    //计算预期金额
                    $data[$i]['yuqimouney'] =  round($data[$i]['days']*$tmp[$i]['monthmoney']*(C('cfg_yuqifuwufei')/100),2);
                }
			}
		}
		$this->data = $data;
		$this->display();
	}

	//还款
	public function billinfo(){
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('User/login');
		}
		$ordernum = I("ordernum",'','trim');
		if(!$ordernum){
			$this->redirect('Order/bills');
		}
		$Order = D("order");
		$order = $Order->where(array('ordernum' => $ordernum,'user' => $user))->find();
		//判断是否已还完
        //var_dump($order);exit;
		if($order['months'] == $order['donemonth']){
			$this->redirect('Order/bills');
		}
		//判断是否预期
        $days = round((time()-$order['updateTime'])/ 86400)-(7*($order['donemonth'] + 1));
        if($days>0){
            $order['monthmoney'] = $order['monthmoney'] + round($days*$order['monthmoney']*(C('cfg_yuqifuwufei')/100),2);
        }

		//创建支付订单
		$payordernum = neworderNum();
		$arr = array(
			'ordernum' => $payordernum,
			'user'     => $user,
			'type'	   => "还款费",
			'money'	   => $order['monthmoney'],
			'addtime'  => time(),
			'status'   => 0,
			'jkorder'  => $ordernum
		);
		$Payorder = D("payorder");
		$status = $Payorder->add($arr);
		if(!$status){
			$this->redirect('Order/bills');
		}
		//跳转支付
		$this->redirect('Pay/Index/index',array('ordernum' => $payordernum));
	}
	
}
