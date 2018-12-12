<?php
class InfoAction extends CommonAction{
	private $userinfo;
	function _initialize(){
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('User/login');
		}
		$Userinfo = D("userinfo");
		$info = $Userinfo->where(array('user' => $this->getLoginUser()))->find();
		if(!$info){
			$infoid = $Userinfo->add(array('user' => $this->getLoginUser()));
			$info = array('id' => $infoid,'user' => $this->getLoginUser());
		}
		$this->userinfo = $info;
	}
	
	public function index(){
		$Userinfo = D("userinfo");
		$xycx = D("xycx");
		$info = $Userinfo->where(array('user' => $this->getLoginUser()))->find();
		$xy = $xycx->where(array('user' => $this->getLoginUser()))->find();
		$arr = array(
			'baseinfo' => 0,
			'unitinfo' => 0,
			'bankinfo' => 0,
			'zhimainfo'=> 0,
			'wechat'   => 0,
			'phoneinfo' => 0,
			'xyc' => 0
		);
		//判断资料完整性
		if($info['name'] && $info['usercard'] && $info['cardphoto_1'] && $info['cardphoto_2'] && $info['cardphoto_3'] ){
			$arr['baseinfo'] = 1;
		}
		if($info['dwname'] && $info['dwaddess_ssq'] && $info['dwaddess_more'] && $info['position'] && $info['workyears'] && $info['addess_ssq'] && $info['addess_more'] && $info['dwysr'] && $info['personname_1'] && $info['personphone_1'] && $info['persongx_1'] && $info['personname_2'] && $info['personphone_2'] && $info['persongx_2']){
			$arr['unitinfo'] = 1;
		}
		if($info['bankcard'] && $info['bankname']){
			$arr['bankinfo'] = 1;
		}
		if($info['alipay']){
			$arr['zhimainfo'] = 1;
		}
		if($info['wechat']){
			$arr['wechat'] = 1;
		}
		if($info['phone']){
			$arr['phoneinfo'] = 1;
		}
		if($xy['mobile']){
			$arr['xyc'] = 1;
		}
		$this->info = $arr;
		$this->display();
	}
	
	//身份信息
	//姓名、身份证号码、住址
	public function baseinfo(){
		if(IS_POST){
			$data = array('status' => 0,'msg' => '未知错误');
			$Userinfo = D("userinfo");
			$status = $Userinfo->where(array('user' => $this->getLoginUser()))->save($_POST);
			if(!$status){
				$data['msg'] = "操作失败";
			}else{
				$photo1=$_POST['cardphoto_1'];
				$photo2=$_POST['cardphoto_2'];
				$photo3=$_POST['cardphoto_3'];
				$name=$_POST['name'];
				$carid=$_POST['usercard'];
				$base1=$this->base64($photo1);
				$base2=$this->base64($photo2);
				$base3=$this->base64($photo3);
				$renlian=$this->basecurl($base3);
				$sfzzm=$this->sfzzmcurl($base1);
				$sfzfm=$this->sfzfmcurl($base2);
				$user=$this->userinfo['user'];
				$xycx=M('xycx');
				$isuser=$xycx->where('user='.$user)->field('id')->select();
				//print_r($isuser);
				if($isuser){
					foreach($isuser as $k=>$v){
						$datarenlian['id']=$v['id'];
						$datarenlian['renlian']=$renlian;
						$datarenlian['sfzzm']=$sfzzm;
						$datarenlian['sfzfm']=$sfzfm;
						$xycx->save($datarenlian);
					}	
				}else{
					$dataadd['user']=$user;
					$dataadd['date']=date("Y-m-d H:i:s");
					$dataadd['renlian']=$renlian;
					$dataadd['sfzzm']=$sfzzm;
					$dataadd['sfzfm']=$sfzfm;
				}
				$data['status'] = 1;
			}
			$this->ajaxReturn($data);
			
		}
		$this->assign("userinfo",$this->userinfo);
		$this->display();
	}
	protected function base64($data){//图片转码base64
		$file = $data;
		$search="http://".$_SERVER['HTTP_HOST']."/";
		$file=str_replace($search,"",$file);
		if($fp = fopen($file,"rb", 0)) 
		{ 
		    $gambar = fread($fp,filesize($file)); 
		    fclose($fp);
		    $base64 = chunk_split(base64_encode($gambar)); 
		}
		return $base64;
	}
	protected function basecurl($base){
		 $host = "https://dm-21.data.aliyun.com";
		    $path = "/rest/160601/face/detection.json";
		    $method = "POST";
		    $appcode = "3Gpa9NZfZYYsODrNZd5YCH0PODHAxuXV";
		    $headers = array();
		    array_push($headers, "Authorization:APPCODE " . $appcode);
		    //根据API的要求，定义相对应的Content-Type
		    array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
		    $querys = "";
		    $bodys = '{"inputs":[{"image":{"dataType":50,"dataValue":"'.$base.'"}}]}';
		    $url = $host . $path;
		
		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		    curl_setopt($curl, CURLOPT_URL, $url);
		    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($curl, CURLOPT_FAILONERROR, false);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($curl, CURLOPT_HEADER, false);
		    if (1 == strpos("$".$host, "https://"))
		    {
		        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		    }
		    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
			$result=curl_exec($curl);
			return $result;
	}
	protected function sfzzmcurl($base) {
		//echo $base;
		$host = "https://dm-51.data.aliyun.com";
	    $path = "/rest/160601/ocr/ocr_idcard.json";
	    $method = "POST";
	    $appcode = "3Gpa9NZfZYYsODrNZd5YCH0PODHAxuXV";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    //根据API的要求，定义相对应的Content-Type
	    array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
	    $querys = "";
	    $bodys =  "{
					    \"inputs\": [
					        {
					            \"image\": {
					                \"dataType\": 50,
					                \"dataValue\": \"".$base."\"
					            },
					            \"configure\": {
					                \"dataType\": 50,
					                \"dataValue\": \"{\\\"side\\\":\\\"face\\\"}\"
					            }
					        }
					    ]
					}";
	    $url = $host . $path;
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER,false);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
		$result=curl_exec($curl);
	    return $result;
	}
	protected function sfzfmcurl($base) {
		//echo $base;
		$host = "https://dm-51.data.aliyun.com";
	    $path = "/rest/160601/ocr/ocr_idcard.json";
	    $method = "POST";
	    $appcode = "3Gpa9NZfZYYsODrNZd5YCH0PODHAxuXV";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    //根据API的要求，定义相对应的Content-Type
	    array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
	    $querys = "";
	    $bodys =  "{
					    \"inputs\": [
					        {
					            \"image\": {
					                \"dataType\": 50,
					                \"dataValue\": \"".$base."\"
					            },
					            \"configure\": {
					                \"dataType\": 50,
					                \"dataValue\": \"{\\\"side\\\":\\\"back\\\"}\"
					            }
					        }
					    ]
					}";
	    $url = $host . $path;
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER,false);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
		$result=curl_exec($curl);
	    return $result;
	}
	public function xycx(){
		
		$this->assign("userinfo",$this->userinfo);
		//print_r($this->userinfo);
		$this->display();
	}
	public function xycxpost(){
		
		if($_POST){
			//print_r($_POST);
			$apiKey='8113098278518924';
			$name=$_POST['name'];
			$card=$_POST['usercard'];
			$mobile=$_POST['mobile'];
			$mobilepassword=$_POST['mobilepassword'];
			$user=$_POST['user'];
			$input=$_POST['code'];
			if(!$input){
				$array=array(
					'method'=>'api.mobile.get',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'username'=>$mobile,
					'password'=>base64_encode($mobilepassword),
				);
				$data=$this->paixu($array);
				$result=$this->curl($data);
				//echo $result;
				//exit;
				$result=json_decode($result,true);
				if($result['code']!="0010"){
					print_r($result);
					//echo "错误！查看手机号码或者服务密码是否正确";
					exit;
				}
				$token=$result['token'];
				cookie("token",$token);
				$getstatus=array(
					'method'=>'api.common.getStatus',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'token'=>$token,
					'bizType'=>'mobile',
				);
				
				$status=$this->paixu($getstatus);
				$i = 1;
				while($i<=1){
					$resultstatus=$this->curl($status);
					$resultstatus=json_decode($resultstatus,true);
					if($resultstatus['code']){
						$i++;
						//print($resultstatus);
						
					}
					
				}
				//print_r($resultstatus);
				if($resultstatus['code']!="0000" and $resultstatus['code']=="0006"){
					exit("888");
				}
			}
			
			if($input){
				
				$inputarray=array(
					'method'=>'api.common.input',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'token'=>cookie('token'),
					'input'=>$input,
				);
				//print_r($inputarray);
				$inputdata=$this->paixu($inputarray);
				$inputresult=$this->curl($inputdata);
				//echo $inputresult;
				$inputarr=json_decode($inputresult,true);
				//echo $inputarr['code'];
				if($inputarr['code']!="0009"){
					exit("111");
				}
				
			}
			//echo "ttttttt";
			$get=array(
				'method'=>'api.common.getResult',
				'apiKey'=>$apiKey,
				'version'=>'1.2.0',
				'token'=>cookie('token'),
				'bizType'=>'mobile',
			);
			//print_r($get);
			$mobiledata=$this->paixu($get);
			$resultdata=$this->curl($mobiledata);
			$resultstatus=json_decode($resultdata,true);
			$xycx=D('xycx');
			if($resultstatus['code']=="0000"){
				$adddata['user']=$user;
				$adddata['date']=date("Y-m-d H:i:s");
				$adddata['text']=$resultdata;
				$adddata['mobile']=$mobile;
				$xycx->add($adddata);
				echo"999";
			}
		}
	}
	protected function paixu($array){
		$apiSecret="jJWPN3SDuFbTpsCACsObEyhRckdkA0gg";
		ksort($array);
			$i=0;
			foreach($array as $key=>$value){
				if($i==0){
					$str.=$key."=".$value;
					$i++;
				}else{
					$str.="&".$key."=".$value;	
				}
			}
			$sstr=$str.$apiSecret;
			$array['sign']=sha1($sstr);
			$data=http_build_query($array);
			return $data;
	}
	public function xycxcallback(){
		$input = file_get_contents('php://input');
		$path=date("YmdHis");
		file_put_contents($path.'.log', $input);
		file_put_contents('111.log', $_POST);
		file_put_contents('112.log', json_encode($_GET));
		
	}
	protected function curl($data){
		$url="https://api.limuzhengxin.com/api/gateway";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		$output = curl_exec($ch);
		//echo curl_error($ch);
		curl_close($ch);
		return $output;
		//print_r($output);
	}
	//单位信息
	public function unitinfo(){
		if(IS_POST){
			$data = array('status' => 0,'msg' => '未知错误');
			$Userinfo = D("userinfo");
			$status = $Userinfo->where(array('user' => $this->getLoginUser()))->save($_POST);
			if(!$status){
				$data['msg'] = "操作失败";
			}else{
				$data['status'] = 1;
			}
			$this->ajaxReturn($data);
			exit;
		}
		$this->assign("userinfo",$this->userinfo);
		$this->display();
	}

	//银行卡信息
	public function bankinfo(){
		if(IS_POST){
			$data = array('status' => 0,'msg' => '未知错误');
			$bankcard = I("bankcard",0,'trim');
			if(strlen($bankcard) < 16 || strlen($bankcard) > 20){
				$data['msg'] = "不是有效的银行卡号!";
			}else{
				$Userinfo = D("userinfo");
				$status = $Userinfo->where(array('user' => $this->getLoginUser()))->save($_POST);
				if(!$status){
					$data['msg'] = "操作失败";
				}else{
					$data['status'] = 1;
				}
			}
			$this->ajaxReturn($data);
			exit;
		}
		$this->assign("userinfo",$this->userinfo);
		$this->display();
	}
	
	//芝麻信用授权确认
	public function zhimastepone(){
		$userinfo = $this->userinfo;
		if($userinfo['alipay']){
			$this->redirect('Info/index');
		}
		$this->display();
	}
	
	//芝麻信用授权
	public function zhimasteptwo(){
		$userinfo = $this->userinfo;
		if($userinfo['alipay']){
			$this->redirect('Info/index');
		}
		if(IS_POST){
			$data = array('status' => 0,'msg' => '未知错误');
			$code = I("code",'','trim');
			if(strlen($code) != 6){
				$data['msg'] = "短信验证码输入有误";
			}else{
				//判断验证码是否正确
				$Smscode = D("smscode");
				$info = $Smscode->where(array('phone' => $userinfo['user']))->order("sendtime desc")->find();
				if(!$info || $info['code'] != $code){
					$data['msg'] = "短信验证码输入有误";
				}elseif( (time()-30*60) > $info['sendtime']){
					$data['msg'] = "验证码已过期,请重新获取!";
				}else{
					$Userinfo = D("userinfo");
					$status = $Userinfo->where(array('user' => $userinfo['user']))->save(array('alipay' => '1'));
					if($status){
						$data['status'] = 1;
						$this->testZhimaAuthInfoAuthorize($useriphone);
					}else{
						$data['msg'] = "授权失败!";
					}
				}
			}
			$this->ajaxReturn($data);
			exit;
		}
		$str = substr($userinfo['user'],0,3);
		$phone = $str;
		$str = substr($userinfo['user'],7,4);
		$phone .= '****' . $str;
		$this->phone = $phone;
		$this->assign("userinfo",$this->userinfo);
		$this->display();
		
	}
	
	
	 //芝麻信用网关地址
    public $gatewayUrl = "https://zmopenapi.zmxy.com.cn/openapi.do";
    //商户私钥文件
    public $privateKeyFile = "d:\\keys\\private_key.pem";
    //芝麻公钥文件
    public $zmPublicKeyFile = "d:\\keys\\public_key.pem";
    //数据编码格式
    public $charset = "UTF-8";
    //芝麻分配给商户的 appId
    public $appId = "501";
	//芝麻信用授权获得参数用户在商户端的身份标识ID

	 public function testZhimaAuthInfoAuthorize($useriphone){
		 import("@.Class.zmxy.ZmopSdk");
		 $Userinfo = D("userinfo");
		 $data = $Userinfo->where(array('user' => $useriphone))->find();
         $client = new ZmopClient($this->gatewayUrl,$this->appId,$this->charset,$this->privateKeyFile,$this->zmPublicKeyFile);
         $request = new ZhimaAuthInfoAuthorizeRequest();
         $request->setChannel("apppc");
         $request->setPlatform("zmop");
         $request->setIdentityType("2");// 必要参数 
         $request->setIdentityParam("{\"name\":\".$data['name'].\",\"certType\":\"IDENTITY_CARD\",\"certNo\":\".$data['usercard']."}");// 必要参数 
         $request->setBizParams("{\"auth_code\":\"M_H5\",\"channelType\":\"app\",\"state\":\"商户自定义\"}");// 
         $url = $client->generatePageRedirectInvokeUrl($request);
         $this->getResult($url);
    }
	
	//芝麻信用授权地址解密
	public function getResult($url) {
    $params = 'BFMqwAYz615BnJQIloDJw5h8mfLMTv%2FjvoitHU2PFu7E%2FdO1cTprm0jZ6N6V73BU9KIO5Lc43DrkyEJ9P7%2BDnjUfsFOfbIuV4rSL%2BMe8IEMHtGC3KR6lUn4PZ5qc3VDx5hgdc0D5sCy8v3KgYeEGuXNcNws7F2dL30ze45yps%2FkW1f%2BUbs%2BFcXMYpoZz1dfh7LF78NsjmD1d0D9doM9z8yydgPdZ%2F8kdszCKnLre0iuq%2Bv%2FBHHcDr0NyRvhJQotNJqm%2BA590wUfb%2BpcI168g81av5a9naQHech%2F1z5OF%2BjHADMw%2BSdR6jklASJTCPq0p8rHTLmH0QOnOm7G6ePrG9w%3D%3D';
    //从回调URL中获取params参数，此处为示例值
    $sign = 'YKbTxhXrEE8VmD7cdpD9FK6Wd00WwkgLn9N2zppfukIOMzQfL4WRsKcCJgHe3YFJRZB%2FVV%2BqGk7chQF5PAaVr1iJyocxGC4cp4UB7HhDnEf01OxGLsjdtqA735Tze3dJv4qzcssBj1edSx1DWECJhthecKaevUxcf2%2BLoe0cRQI%3D';
    //从回调URL中获取sign参数，此处为示例值
    // 判断串中是否有%，有则需要decode
    $params = strstr ( $params, '%' ) ? urldecode ( $params ) : $params;
    $sign = strstr ( $sign, '%' ) ? urldecode ( $sign ) : $sign;
    
    $client = new ZmopClient ( $this->gatewayUrl, $this->appId, $this->charset, $this->privateKeyFile, $this->zmPublicKeyFile );
    $result = $client->decryptAndVerifySign ( $params, $sign );
	$this->testZhimaCreditScoreGet($result);
	
    
}
	
	 public function testZhimaCreditScoreGet($result){
         $client = new ZmopClient($this->gatewayUrl,$this->appId,$this->charset,$this->privateKeyFile,$this->zmPublicKeyFile);
         $request = new ZhimaCreditScoreGetRequest();
         $request->setChannel("apppc");
         $request->setPlatform("zmop");
         $request->setTransactionId("201512100936588040000000465158");// 必要参数 
         $request->setProductCode("w1010100100000000001");// 必要参数 
         $request->setOpenId("268810000007909449496");// 必要参数 
         $response = $client->execute($request);
         echo json_encode($response);
		 $Userinfo = D("userinfo");
	 $data = $Userinfo->where(array('user' => $this->userinfo))->->save(array('zhimaxinyou' => $response));
    }

	public function otherinfo(){
		$Otherinfo = D("otherinfo");
		if(IS_POST){
			$otherinfo = $_POST['otherinfo'];
			if(empty($otherinfo)) $otherinfo = array();
			$str = json_encode($otherinfo);
			$status = $Otherinfo->where(array('user' => $this->getLoginUser()))->find();
			if(!$status){
				$Otherinfo->add(array(
					'user' => $this->getLoginUser(),
					'infojson' => $str,
					'addtime' => time()
				));
			}else{
				$Otherinfo->where(array('user' => $this->getLoginUser()))->save(array('infojson' => $str));
			}
			exit;
		}
		$tmp = $Otherinfo->where(array('user' => $this->getLoginUser()))->find();
		$tmp = json_decode($tmp['infojson']);
		$data = array();
		for($i=0;$i<count($tmp);$i++){
			$data[$i]['sid'] = $i;
			$data[$i]['imgurl'] = $tmp[$i];
		}
		$this->data = $data;
		$this->display();
	}
	
	
	public function wechat(){
		$userinfo = $this->userinfo;
		if($userinfo['alipay']){
			$this->redirect('Info/index');
		}
		$code = I("code",'','trim');
		if($code && substr($code,0,1) == 'a'){
			$Userinfo = D("userinfo");
			$Userinfo->where(array('user' => $this->getLoginUser()))->save(array('wechat' => 1));
		}
		$this->redirect('Info/index');
	}
	
	
	public function phoneinfo(){
		$userinfo = $this->userinfo;
		if($userinfo['phone']){
			$this->redirect('Info/index');
		}
		if(IS_POST){
			$data = array('status' => 0,'msg' => '未知错误');
			$code = I("code",'','trim');
			$pass = I("pass",'','trim');
			if(!$code){
				$data['msg'] = "请输入正确的验证码!";
			}else{
				if(!$pass){
					$data['msg'] = "请输入正确的服务密码!";
				}elseif(md5($code) != $_SESSION['verify']){
					$data['msg'] = "图形验证码错误!";
				}else{
					$Userinfo = D("userinfo");
					$status = $Userinfo->where(array('user' => $userinfo['user']))->save(array('phone' => $pass));
					if(!$status){
						$data['msg'] = "操作失败!";
					}else{
						$data['status'] = 1;
					}
				}
			}
			$this->ajaxReturn($data);
			exit;
		}
		$this->assign("userinfo",$userinfo);
		$this->display();
	}

	
}
