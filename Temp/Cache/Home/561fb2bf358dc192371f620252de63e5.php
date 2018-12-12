<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> <?php
 $name = "cfg_sitetitle"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?> </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="description" content=" <?php
 $name = "cfg_sitedescription"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?> ">
	<meta name="Keywords" content=" <?php
 $name = "cfg_sitekeywords"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?> ">
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/mui.min.css">
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/newpay-bb7fcb5546.css">
	<style>
		.mui-input-group .mui-input-row {
		    height: 45px;
		}
		.mui-input-row label {
		    padding: 13px 15px;
		}
		.regfrm .mui-input-row input {
		    height: 45px;
		}
		.mui-input-row:last-child:after{
		    height: 0;
		}
		.mui-input-row .ckbtn, .mui-input-row .ckbtnOff {
		    top: 12px;
		}
		@media screen and (max-width: 348px){
			.regfrm .mui-input-row label {
			    font-size: 14px;
			}
			.mui-input-row label {
			    padding: 15px 15px;
			}
		}
	</style>
</head>
<body>
		<header class="header">
		<a class="back" href="<?php echo U('User/login');?>"></a>
			找回密码
		</header>
	<div class="mui-content">
	<form id="back-form" onsubmit="return false">
	    <div class="mui-input-group regfrm">
			<div class="mui-input-row">
				<label for="account">手机号</label>
				<input id="account" name="mobile" type="text" class="mui-input-clear mui-input" placeholder="请输入手机号" data-input-clear="2"><span class="mui-icon mui-icon-clear mui-hidden"></span>
			</div>
			<div class="mui-input-row pr">
				<label for="account">图片验证码</label>
				<input id="verifycode" name="verifycode" type="text" class="mui-input-clear mui-input" placeholder="请输入图片验证码" data-input-clear="2">
				
				<img id="yzm" class="chkimg" style="position:absolute;right:20px;top:9px;height: 28px;" onclick="change_img(this)" >
				
			</div>
			<div class="mui-input-row pr">
				<label for="checkma">短信验证码</label>
				<input id="checkma" name="checkma" type="text" class="mui-input-clear mui-input" placeholder="请输入验证码" data-input-clear="2"><span class="mui-icon mui-icon-clear mui-hidden"></span>
				<button id="count" type="button" class="mui-btn mui-btn-warning mui-btn-outlined ckbtn">
					获取验证码
				</button>
			</div>
			<div class="mui-input-row pr">
				<label for="password">新密码</label>
				<input id="password" name="password1" type="password" class="mui-input-clear mui-input" placeholder="请设置6-16位密码" data-input-clear="3"><span class="mui-icon mui-icon-clear mui-hidden"></span>
				<i class="seltarr password_icon_off pab" id='switch'></i>
			</div>
		</div> 
		<article class="msub">
		 	<input id="btn" class="submit" type="submit" value="完成" >
		 </article>
		<!-- 提示 -->
		<div style="display: none;top:45%;" class="errdeo" id="messageBox">
			
		</div>	
		</form>	
   </div>
<script src="__PUBLIC__/home/js/jquery.js"></script>
<script src="__PUBLIC__/home/js/mui.min.js"></script>
<script>
var capKey='';
var oRemind=document.getElementById('messageBox');
var on = true;
function close1() {
	oRemind.style.display='none';
}
$(function(){
	capKey='h5-'+Date.parse(new Date());
	$('#yzm').attr("src", "__APP__/Common/verify?capKey="+capKey);
	//密码开关
	$('#switch').click(function(){
	    if(on == true){
	    	$('#password')[0].type = "text";
		    $('#switch').removeClass('password_icon_off');
		    $('#switch').addClass('password_icon_on');
		    on = false;
		}else{
			$('#password')[0].type = "password";
		    $('#switch').removeClass('password_icon_on');
		    $('#switch').addClass('password_icon_off');
		    on = true;
		}
	});
	$("#count").click(function (){
		var mobile=$("#account").val();
		var verifycode = $.trim($("#verifycode").val());
		if(!(/^1\d{10}$/.test(mobile))){
		    salert("手机格式不正确");
			return false;
		}
		if(verifycode == ''){
			salert("请输入图片验证码");
			return false;
		}
		if(verifycode.length != 4){
			salert("请输入正确的图片验证码");
			return false;
		}
		//检查用户是否存在
		$.post(
			"<?php echo U('User/checkuser');?>",{phone:mobile},
			function (data,state){
				if(state != "success"){
					salert("网络请求失败");
					return false;
				}
				if(data.status != 1){
					salert("用户不存在,请先注册!");
					return false;
				}else{
					//请求发送短信
					$.post(
						"<?php echo U('User/sendsmscode');?>",
						{
							phone:mobile,
							type:"backpwd",
							verifycode:verifycode
						},
						function (data,state){
							if(state != "success"){
								salert("网络请求失败,请重试!");
								return false;
							}else if(data.status == 1){
								var index = 60;
								var stime = setInterval(function(){
									if(index > 0){
										$("#count").html(index+'s');
										$("#count").attr("disabled", true);
										index--;
									}else if(index == 0){
										$("#count").html("重新获取");
										$("#count").className = "mui-btn mui-btn-warning mui-btn-outlined ckbtn";
										$("#count").removeAttr("disabled");
										$('#perpho').removeAttr("disabled");
										clearInterval(stime);
									}					
								},1000);
							}else{
								salert(data.msg);
								return false;
							}
						}
					);
				}
			}
		);
		return false;
	});
	$('#btn').click(function(){
		var verifycode=$('#verifycode').val();
		var code = $('#checkma').val();
		var oInp1 = document.getElementById("password");
		var str = oInp1.value;
		var reg = new RegExp(/[a-zA-Z0-9_]{6,16}/);
		var mobile=$("#account").val();
		if(!(/^1\d{10}$/.test(mobile))){
		    salert("手机格式不正确");
			return false;
		}
		if(code.length!=6){
			salert("请输入6位短信证码");
			return false;
		}
		if(str.length == 0){
			salert("密码不能为空，请入密码");
			return false;
		}
		if(!reg.test(oInp1.value)){
			salert("请输入6-16位密码!");
			return false;
		}
		//请求修改密码
		$.post(
			"<?php echo U('User/backpwd');?>",
			{
				phone:mobile,
				code:code,
				password:oInp1.value
			},
			function (data,state){
				if(state != "success"){
					salert("网络请求失败,请重试");
					return false;
				}else if(data.status == 1){
					salert("密码修改成功,请登录!");
					setTimeout(function(){
						window.location.href = "<?php echo U('User/login');?>";
					},2000);
				}else{
					salert(data.msg);
					return false;
				}
			}
		);
	});
});
function salert(msg){
	oRemind.innerHTML = msg;
	oRemind.style.display = "block";
	setTimeout('close1()',2000);
}
//刷新验证码
function change_img(obj){
	var url = $(obj).attr("src");
	var arr = url.split("?");
	capKey='h5-'+Date.parse(new Date());
	$(obj).attr("src", arr[0]+"?capKey="+capKey);
}
</script>
<div style="display: none;">
	<?php
 $name = "cfg_sitecode"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?>
</div>
</body>
</html>