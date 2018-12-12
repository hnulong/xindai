<?php
//支付部分
class IndexAction extends Action{

	//支付确认页面
	public function index(){
		$ordernum = I("get.ordernum",'','trim');
		if(!$ordernum){
			$this->redirect('Home/Index/index');
		}
		$Payorder = D("payorder");
		$info = $Payorder->where(array('ordernum' => $ordernum))->find();
		if(!$info){
			$this->redirect('Home/Index/index');
		}
		if($info['status']){
			$this->redirect('Home/Index/index');
			//订单已支付
			//$this->error("订单不存在");exit;
		}
		$this->money = $info['money'];
		$this->ordernum = $ordernum;
		$this->paycont = "订单:".$ordernum."支付";
		$this->display();
	}
	//支付跳转页
	public function geturl(){
		$data = array('status' => 0,'msg' => '未知错误');
		$ordernum = I("ordernum",'','trim');
		$channel = I("channel",'','trim');
		if($channel=='wxpay_jsapi'){
		    $type=1;
		    $urlType = 'wxpay';
        }else{
		    $type=2;
            $urlType = 'alipay';
        }
        $Payorder = D("payorder");
        $info = $Payorder->where(array('ordernum' => $ordernum))->find();
        if(!$info){
            $data['msg'] = "订单不存在";
        }
        if(!$channel){
            $data['msg'] = "支付方式有误";
        }
        if($info['status']){
            $data['msg'] = "订单状态错误";
        }
        Vendor('paySdk.vendor.autoload');
        Vendor('paySdk.test.index');
        $obj=new shq\openapi\test\payDaikuan();
        $arr=['merchant_order_sn'=>$ordernum.'|'.time(),'type'=>$type,'total_fee'=>$info['money']];
        $re=$obj->qrcodePay($arr);
        $res=json_decode($re,true);
        if($res['result_code']==200){
            $data['url'] = $res['data']['qr_code'];
            $data['urltype'] = $urlType;
            $data['msg'] = 'success';
            $data['status'] = 1;
            //重写支付地址
            if(!empty($data['url'])){
                $data['url'] = U('Pay/Index/api',array('url' => urlencode($data['url']),'type' => $data['urltype'],'onum' => $ordernum));
            }
            $this->ajaxReturn($data);
        }else{
            $this->ajaxReturn(['status'=>0,'msg'=>$res['result_message']]);
        }
        exit;
		if(!$ordernum){
			$data['msg'] = "订单号有误";
		}elseif(!$channel){
			$data['msg'] = "支付方式有误";
		}else{
			$Payorder = D("payorder");
			$info = $Payorder->where(array('ordernum' => $ordernum))->find();
			if(!$info){
				$data['msg'] = "订单不存在";
			}elseif($info['status']){
				$data['msg'] = "订单状态错误";
			}else{
				import('@.Class.Teegon');
				$srv = new Teegon("https://api.teegon.com/");
				$notify_url = C('cfg_siteurl')."/Pay/index.php?notify=1";
				$return_url = C('cfg_siteurl')."/Pay/index.php";
			    $param['order_no'] = $ordernum; //订单号
			    $param['channel'] = $channel;
			    $param['return_url'] = $return_url;
			    $param['amount'] = $info['money'];
			    $param['subject'] = "订单:".$ordernum."支付";
			    $param['metadata'] = json_encode();
			    $param['notify_url'] = $notify_url;
			    $param['wx_openid'] = '';
				$res = json_decode($srv->pay($param,false));
				$res = $res->result;
				if(!$res){
					$data['msg'] = "支付端口返回了未知信息";
				}else{
					$data['debug'] = $res;
					if($channel == 'alipay_wap'){
						$action = $res->action;
						$pay_url = $action->url;
						if(!$action || !$pay_url){
							$data['msg'] = "发起支付失败";
						}else{
							$data['url'] = $pay_url;
							$data['urltype'] = "alipay";
							$data['msg'] = 'success';
							$data['status'] = 1;
						}
					}elseif($channel == 'wxpay_jsapi'){
						$action = $res->action;
						$pay_url = $action->params;
						if(!$action || !$pay_url){
							$data['msg'] = "发起支付失败";
						}else{
							$b= (strpos($pay_url,'location="'));
							$pay_url = substr($pay_url,$b+10);
							$c= (strpos($pay_url,'"'));
							$pay_url = substr($pay_url,0,$c-1);
							$data['url'] = $pay_url;
							$data['urltype'] = "wxpay";
							$data['msg'] = 'success';
							$data['status'] = 1;
						}
					}
					//重写支付地址
					if(!empty($data['url'])){
						$data['url'] = U('Pay/Index/api',array('url' => urlencode($data['url']),'type' => $data['urltype'],'onum' => $ordernum));
					}
				}
			}
		}
		$this->ajaxReturn($data);
	}


	//解析地址并判断用户设备
	public function api(){
		$url = I("get.url",'','');
		$url = urldecode($url);
		$onum = I("get.onum",'','');
		if(!$url){
			$this->redirect('Home/Index/index');
		}
		$type = I("get.type",'','trim');
		if(!$type){
			$this->redirect('Home/Index/index');
		}
		//微信内且为微信支付直接调整支付
		if($type == 'wxpay' && is_wchat() ){
			//header("Location: ".$url);exit;
		}
		//支付宝内且为支付宝支付直接调整支付
		if($type == 'alipay' && is_alipay() ){
			header("Location: ".$url);exit;
		}
		//非微信且为支付宝支付直接调用打开
		if($type == 'alipay' && !is_wchat() ){
			header("Location: ".$url);exit;
		}
		//其他情况提示用户用浏览器打开
		if($type == "wxpay"){
			$llqname = "";
			$this->app = "微信";
		}elseif(is_iphone()){
			$llqname = "Safari";
			$this->app = "支付宝";
		}else{
			$this->app = "支付宝";
			$llqname = "浏览器";
		}
		$this->llqname = $llqname;
		$this->url = $url;
		$this->ordernum = $onum;
		$this->display();
	}



}