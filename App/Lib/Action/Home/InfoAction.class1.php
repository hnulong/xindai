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
