<?php

function is_wchat(){
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(strpos($agent, 'micromessenger') === false){
		return false;
	}else{
		return true;
	}
}


function is_alipay(){
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(strpos($agent, 'aliApp') === false){
		return false;
	}else{
		return true;
	}
}


function is_iphone(){
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$type = 'other';
	if(strpos($agent, 'iphone') || strpos($agent, 'ipad')){
		return true;
	}
	return false;
}