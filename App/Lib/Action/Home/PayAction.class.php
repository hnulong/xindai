<?php
class PayAction extends CommonAction{
	
	public function index(){
		$ordernum = I("ordernum",'','trim');
		if(!$ordernum){
			$this->redirect('Index/index');
		}
		$Payorder = D("payorder");
		$orderinfo = $Payorder->where(array('ordernum' => $ordernum))->find();
		if(!$orderinfo){
			$this->redirect('Index/index');
		}
		//require_once(BASE_PATH."/shanpay/lib/shanpayfunction.php");
		$out_order_no = $ordernum;//商户网站订单系统中唯一订单号，必填
		$subject = "订单:".$ordernum;//必填
		$total_fee = ceil($orderinfo['money']);//必填 需为整数
		$body = "用户:".$orderinfo['user']."的".$orderinfo['type'];
		$notify_url = C('cfg_siteurl')."/index.php/Pay/notifyurl/";
		$return_url = C('cfg_siteurl')."/index.php/Pay/returnurl/";
		$parameter = array(
			"partner" 		=> C('cfg_paypartner'),
	        "user_seller"   => C('cfg_payuserseller'),
			"out_order_no"	=> $out_order_no,
			"subject"		=> $subject,
			"total_fee"		=> $total_fee,
			"body"			=> $body,
			"notify_url"	=> $notify_url,
			"return_url"	=> $return_url
		);
		$html_text = buildRequestFormShan($parameter,C('cfg_paykey'));
		echo $html_text;
		exit;
	}


	//同步通知
	public function returnurl(){
		$shanNotify = md5VerifyShan($_REQUEST['out_order_no'],$_REQUEST['total_fee'],$_REQUEST['trade_status'],$_REQUEST['sign'],C('cfg_paykey'),C('cfg_paypartner'));
		if(!$shanNotify){
			//验证失败
			$this->redirect('Index/index');
		}else{
			if($_REQUEST['trade_status']!='TRADE_SUCCESS'){
				//支付失败
				$this->redirect('Index/index');
			}else{
				$this->paydo();
			}
		}
	}
	
	//异步通知
	public function notifyurl(){
		$shanNotify = md5VerifyShan($_REQUEST['out_order_no'],$_REQUEST['total_fee'],$_REQUEST['trade_status'],$_REQUEST['sign'],C('cfg_paykey'),C('cfg_paypartner'));
		if(!$shanNotify){
			echo "fail";
		}else{
			if($_REQUEST['trade_status']=='TRADE_SUCCESS'){
				$this->paydo(false);
			}
			echo 'success';
		}
	}
	
	
	//支付成功处理
	function paydo($jump = true){
		$out_trade_no = $_REQUEST['out_order_no'];
		$money = $_REQUEST['total_fee'];
		$Payorder = D("payorder");
		$info = $Payorder->where(array('ordernum' => $out_trade_no))->find();
		if(!$info){
			//订单不存在
			if($jump) $this->redirect('Index/index');
		}else{
			if($info['status'] == 1){
				//已经处理，跳过
				if($jump) $this->redirect('Index/index');
			}
			$Payorder->where(array('ordernum' => $out_trade_no))->save(array('status' => 1));
			if($info['type'] == "审核费"){
				$Order = D("order");
				$order = $Order->where(array('pid' => $info['id']))->find();
				//将借款订单设置为已支付
				if($order && $order['status'] == 0){
					$Order->where(array('pid' => $info['id']))->save(array('status' => 1));
				}
				if($jump) $this->redirect('Order/info',array('oid' => $order['id']));
			}elseif($info['type'] == "还款费"){
				//写入还款记录
				$Bills = D("bills");
				$arr = array(
					'user'     => $info['user'],
					'addtime'  => time(),
					'money'    => $money,
					'ordernum' => $out_trade_no
				);
				$Bills->add($arr);
				//订单信息更改已还款期数
				$Order = D("order");
				$Order->where(array('ordernum' => $info['jkorder'],'user' => $info['user']))->setInc('donemonth',1);
				if($jump) $this->redirect('Order/bills');
			}else{
				//未知类型支付
				if($jump) $this->redirect('Index/index');
			}
		}
	}
	
}
