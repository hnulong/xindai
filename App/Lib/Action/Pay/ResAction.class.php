<?php
class ResAction extends Action{

	//判断订单是否支付
	public function ispay(){
		$data = array('status' => 0);
		$ordernum = I("get.ordernum",'','trim');
		if(!$ordernum){
			$data['status'] = 1;
		}else{
			$Payorder = D("payorder");
			$info = $Payorder->where(array('ordernum' => $ordernum))->find();
			if(!$info){
				$data['status'] = 1;
			}else{
				if($info['status']){
					$data['status'] = 1;
				}else{
					$data['status'] = 0;
				}
			}
		}
		$this->ajaxReturn($data);
	}


	//支付返回异步通知
	public function notifyurl(){
	    /*$aa='"{\"merchant_order_sn\":\"G620587079747949|1497961534\",\"total_fee\":0.01}"';
	    var_dump(json_decode(json_decode($aa,true),true));
	    exit;
	    file_put_contents('./aaa.txt',json_encode($_REQUEST['data']));
        exit;*/
        file_put_contents('./aaaa.txt',"支付回调开始\r\n",FILE_APPEND);
        $data=json_decode($_REQUEST['data'],true);
        $out_trade_no = $data['merchant_order_sn'];
        $total_fee=$data['total_fee'];
//        file_put_contents('./ccc1.txt',json_encode($_REQUEST['data']));
        Vendor('paySdk.vendor.autoload');
        Vendor('paySdk.test.index');
        $obj=new shq\openapi\test\payDaikuan();
        $re=$obj->orderQuery( ['merchant_order_sn'=>$out_trade_no]);
        $res=json_decode($re,true);
      //  file_put_contents('./aaaa.txt',$re,FILE_APPEND);
        if($res['result_code']==200){
            file_put_contents('./aaaa.txt',">>>OK\r\n",FILE_APPEND);
            $merchant_order_sn=explode('|',$out_trade_no)[0]; //订单号
            $total_fee=$res['data']['total_fee']; //支付总金额
            $fee=$res['data']['fee']; //手续费
            $net_money=$res['data']['net_money']; //商家实际收入
            $pay_time=$res['data']['pay_time']; //支付时间戳
            $trade_state=$res['data']['trade_state']; //支付状态 USERPAYING 支付中  SUCCESS 支付成功
            if($trade_state=='SUCCESS'){
                file_put_contents('./aaaa.txt',$out_trade_no."开始处理业务逻辑\r\n",FILE_APPEND);
                $this->paydo($merchant_order_sn,$total_fee);
               // file_put_contents('./ccc.txt',$re);
            }else{
                //支付中
            }
        }else{
            //查询失败
            file_put_contents('./aaaa.txt',">>>".$out_trade_no."支付失败：".$res['result_message']."\r\n",FILE_APPEND);
            $msg=$res['result_message'];//失败原因
        }
        //file_put_contents('./bbb.txt',json_encode($res)."\r\n",FILE_APPEND);
		//$this->paydo(false);
	}
//    public function test(){
//        file_put_contents('./aaa.txt',$_REQUEST['data'].'======'.gettype($_REQUEST['data']));
//        $str=(string)$_REQUEST['data'];
//        $data=json_encode($str,true);
//        var_dump(json_decode("{\"merchant_order_sn\":\"G621077418283612|1498007744\",\"total_fee\":0.01}"));
//        $out_trade_no = $data['merchant_order_sn'];
//        Vendor('paySdk.vendor.autoload');
//        Vendor('paySdk.test.index');
//        $obj=new shq\openapi\test\payDaikuan();
//        $re=$obj->orderQuery( ['merchant_order_sn'=>$out_trade_no]);
//        $res=json_decode($re,true);
//        if($res['result_code']==200){
//            $merchant_order_sn=explode('|',$out_trade_no)[0]; //订单号
//            $total_fee=$res['data']['total_fee']; //支付总金额
//            $fee=$res['data']['fee']; //手续费
//            $net_money=$res['data']['net_money']; //商家实际收入
//            $pay_time=$res['data']['pay_time']; //支付时间戳
//            $trade_state=$res['data']['trade_state']; //支付状态 USERPAYING 支付中  SUCCESS 支付成功
//            if($trade_state=='SUCCESS'){
//               // $this->paydo($merchant_order_sn,$total_fee);
//                // file_put_contents('./ccc.txt',$re);
//            }else{
//                //支付中
//            }
//        }else{
//            //查询失败
//            $msg=$res['result_message'];//失败原因
//        }
//        dump($res);
//    }
	//支付返回同步通知
	public function returnurl(){
		$this->paydo();
	}

	//支付成功处理
	function paydo($out_trade_no,$money,$jump = true){
        file_put_contents('./aaaa.txt',">>>".$out_trade_no.'已进入回调>>>'.date('Y-m-d H:i:s',time())."\r\n",FILE_APPEND);
	/*	$out_trade_no = $_REQUEST['order_no'];
		$money = $_REQUEST['amount'];*/
		$Payorder = D("payorder");
		$info = $Payorder->where(array('ordernum' => $out_trade_no))->find();
		if(!$info){
            file_put_contents('./aaaa.txt',$out_trade_no.'订单不存在~\r\n',FILE_APPEND);
			//订单不存在
			if($jump) $this->redirect('Home/Index/index');
		}else{
			if($info['status'] == 1){
			    echo  'success';
                file_put_contents('./aaaa.txt',$out_trade_no.'订单已经处理======~'.date('Y-m-d H:i:s',time())."\r\n",FILE_APPEND);
				//已经处理，跳过
				if($jump) $this->redirect('Home/Index/index');
			}
			$Payorder->where(array('ordernum' => $out_trade_no))->save(array('status' => 1));
			if($info['type'] == "审核费"){
				$Order = D("order");
				$order = $Order->where(array('pid' => $info['id']))->find();
				//将借款订单设置为已支付
				if($order && $order['status'] == 0){
					$res1=$Order->where(array('pid' => $info['id']))->save(array('status' => 1));
				}
				if($jump) $this->redirect('Home/Order/info',array('oid' => $order['id']));
			}elseif($info['type'] == "还款费"){
				//写入还款记录
				$Bills = D("bills");
				$arr = array(
					'user'     => $info['user'],
					'addtime'  => time(),
					'money'    => $money,
					'ordernum' => $out_trade_no
				);
				if(!$Bills->add($arr)){
                    file_put_contents('./aaaa.txt',$out_trade_no.'写入还款记录失败~\r\n',FILE_APPEND);
                };
				//订单信息更改已还款期数
				$Order = D("order");
				$res2=$Order->where(array('ordernum' => $info['jkorder'],'user' => $info['user']))->setInc('donemonth',1);
				if($res2){
                    echo  "success";
                }
				file_put_contents('./aaaa.txt',$out_trade_no."还款成功~\r\n",FILE_APPEND);
				if($jump) $this->redirect('Home/Order/bills');
			}else{
				//未知类型支付
				if($jump) $this->redirect('Home/Index/index');
			}
		}
	}


}