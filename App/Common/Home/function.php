<?php
//验证手机号
function checkphone($number){
	if(preg_match("/^1\d{10}$/",$number)){  
	    return true;
	}else{  
	    return false;
	} 
}


//验证银行卡
function luhm($s){
	$n = 0;
	for ($i = strlen($s); $i >= 1; $i--){
		$index=$i-1;
		//偶数位
		if ($i % 2==0){
			$n += $s{$index};
		}else{//奇数位
			$t = $s{$index} * 2;
			if ($t > 9) {
				$t = (int)($t/10)+ $t%10;
			}
			$n += $t;
		}
	}
	return ($n % 10) == 0;
}

//生成订单号
function neworderNum(){
	$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
	$orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
	return $orderSn;
}



//支付函数部分
$GLOBALS['gateway_new'] = "http://www.passpay.net/PayOrder/payorder";
function md5VerifyShan($p1, $p2,$p3,$sign,$key,$pid) {
	$prestr = $p1.$p2.$p3.$pid.$key;
	$mysgin = md5($prestr);
	if($mysgin == $sign) {
		return true;
	}else {
		return false;
	}
}

/**
 * 建立请求，以表单HTML形式构造（默认）
 * @param $para_temp 请求参数数组
 *
 */
function buildRequestFormShan($para_temp,$key) {
	//待请求参数数组
	$para = buildRequestParaShan($para_temp,$key);
	$sHtml = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
	$sHtml .= "<form id='paysubmit' name='paysubmit' action='".$GLOBALS['gateway_new']."' accept-charset='utf-8' method='POST'>";
	while (list ($key, $val) = each ($para)) {
        $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
    }

	//submit按钮控件请不要含有name属性
    $sHtml = $sHtml."<input type='submit'  value='支付进行中...' style='display:none;'></form>";
	
	$sHtml = $sHtml."<script>document.forms['paysubmit'].submit();</script>";
	
	return $sHtml;
}
/**
 * 生成要请求给云通付的参数数组
 * @param $para_temp 请求前的参数数组
 * @return 要请求的参数数组
 */
function buildRequestParaShan($para_temp,$key) {
	//除去待签名参数数组中的空值和签名参数
	$para_filter = paraFilterShan($para_temp);
	//对待签名参数数组排序
	$para_sort = argSortShan($para_filter);
	//生成签名结果
	$mysign = buildRequestMysignShan($para_sort,$key);
	
	//签名结果与签名方式加入请求提交参数组中
	$para_sort['sign'] = $mysign;
	
	return $para_sort;
}
/**
 * 除去数组中的空值和签名参数
 * @param $para 签名参数组
 * return 去掉空值与签名参数后的新签名参数组
 */
function paraFilterShan($para) {
	$para_filter = array();
	while (list ($key, $val) = each ($para)) {
		if($key == "sign" || $val == "")continue;
		else	$para_filter[$key] = $para[$key];
	}
	return $para_filter;
}
/**
 * 对数组排序
 * @param $para 排序前的数组
 * return 排序后的数组
 */
function argSortShan($para) {
	ksort($para);
	reset($para);
	return $para;
}
/**
 * 生成签名结果
 * @param $para_sort 已排序要签名的数组
 * return 签名结果字符串
 */
function buildRequestMysignShan($para_sort,$key) {
	//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	$prestr = createLinkstringShan($para_sort);
	$mysign = md5SignShan($prestr, $key);
	return $mysign;
}
function md5SignShan($prestr, $key) {
	$prestr = $prestr . $key;
	return md5($prestr);
}
/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstringShan($para) {
	$arg  = "";
	while (list ($key, $val) = each ($para)) {
		$arg.=$key."=".$val."&";
	}
	//去掉最后一个&字符
	$arg = substr($arg,0,count($arg)-2);
	
	//如果存在转义字符，那么去掉转义
	if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
	
	return $arg;
}