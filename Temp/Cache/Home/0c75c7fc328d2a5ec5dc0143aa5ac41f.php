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
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/feiqi-ee5401a8e6.css">
<style>
	.mui-input-group .mui-input-row {
	    height: 45px;
	}
	.lgfrm .mui-input-row label~input {
	    width: 82%;
	    font-size: 16px;
	    height: 45px;
	}
	.mui-input-row label {
	    padding: 12px 15px;
	}
	.gswitch {
	    bottom: 8px;
	}
	.mui-input-row:last-child:after {
	    height: 0px;
	}
	.log label {
	    padding: 4px 20px 0 10px;
	    height: 45px;
	    line-height: 20px;
    	border-bottom: none;

	}
	.log {
	    border-top: 1px solid #e5e5e5;
	    border-bottom: 1px solid #e5e5e5;
	}
	.borbottom {
	    border-bottom: 1px solid rgba(239, 239, 239, 0.8)!important;
	}
	 .log .ckbtn,.log .ckbtnOff{
	    top: 100px;
	}
	.log label input {
	    height: 38px;
	    line-height: 20px;
	    padding-left: 12%;
	}
	.log label .phopwd {
	    width: 100%;
	}
</style>

</head>
<body>
	<header class="mui-bar mui-bar-nav hnav lognav">
		<a class="back" href="<?php echo U('Index/index');?>" ></a>
		<h1 class="mui-title">登录</h1>

	</header>
	<div class="mui-content">
	    <!-- adv -->
	    <div class="mui-log">
	    	<img src="__PUBLIC__/home/imgs/log.png" alt="">
	    </div>
	    <!-- adv end-->
	    <article id="tabs" class="logtabs">
			<ul>
				<li><a class="cur" href="javascript:;">手机号快捷登录</a></li>
				<li><a href="javascript:;">账号密码登录</a></li>	
			</ul>

	<section class="allpic" style="display:block;">
		<!-- form -->
			<form method='post' onsubmit="return false" action='' id='form2' autocomplete="off">
				<div class="log">
					<label class="pr borbottom" style="border-bottom: 1px solid #e5e5e5">
						<input class="phico phopwd" id="perpho" name="mobile" type="number" placeholder="请输入手机号" data-empty="用户名不能为空" required data-flag="1"/>
						<input type='hidden' value='' name='mobile1' id='bei1' >
					</label>
					<label class="pr borbottom" style="border-bottom: 1px solid #e5e5e5">
						<input class="phico phopwd picimg" id="verifycode" name="yzm" type="text" placeholder="请输入图片验证码" data-empty="用户名不能为空" required data-flag="1"/>
						<img id="verifycode_img" class="chkimg" style="position:absolute;right:15px;top:9px;height: 28px;" src='<?php echo U("Common/verify");?>' onclick="change_img(this)" onclick="change_img(this)" >
					</label>
					<label for="">
						<input class="pwd" type="number" id="inp1" name='code' placeholder="请输入短信验证码" required data-flag="1"  />
						<button id="count" type="button" class="mui-btn mui-btn-warning mui-btn-outlined ckbtnOff" disabled="disabled">	
							获取验证码
						</button>
					</label>
				</div>
				<article class="msub">
				 	<input class="submit" id="logBtn2" type="submit" value="登录" >
				 </article>
			</form>
				<article class="msub" style="padding: 0px 15px;">
				 	<input class="submit" onclick="window.location.href='<?php echo U('User/signup');?>';" type="submit" value="注册" >
				 </article>
	</section>
	<div class="allpic">
	<form id="login-form" onsubmit="return false">
	    <div class="mui-input-group lgfrm">
			<div class="mui-input-row">
				<label for="account"><span class="phone"></span></label>
				<input id="account"  name="account" type="number" class="mui-input-clear mui-input" placeholder="请输入手机号" data-input-clear="2" data-flag="1"><span class="mui-icon mui-icon-clear mui-hidden"></span>
			</div>
			<div class="mui-input-row pr">
				<label for="password"><span class="pwds"></span></label>
				<input id="password" name="password"  type="password" class="mui-input-clear mui-input" placeholder="请输入密码" data-input-clear="3" data-flag="1">
				<span class="mui-icon mui-icon-clear mui-hidden"></span>
			<i class="seltarr password_icon_off pab" id='switch'></i>
			</div>
		</div> 
		<article class="msub">
		 	<input id="btn" class="submit" type="submit" value="登录" >
		 </article>
	</form>
	<div class="fst">
		<a class="fr pwtxt" href="<?php echo U('User/backpwd');?>">忘记密码？</a>
	</div>	
	</div>
			<!-- form end-->
	<!-- 提示 -->
		<div style="display: none;top:45%" class="errdeo" id="messageBox">
			
		</div>
 </div>

<!-- 提示 -->
	<div style="display: none;position: absolute;" class="errdeo" id="messageBox">
			sfsfsdfds
	</div>
<script src="__PUBLIC__/home/js/jquery.js"></script>
<script src="__PUBLIC__/home/js/fontsizeset.js"></script>
<script src="__PUBLIC__/home/js/mui.min.js"></script>
<script src="__PUBLIC__/home/js/newcheck.js"></script>
<script src="__PUBLIC__/home/js/tabs.js"></script>

<script>
   	function tishi(str){
   		$('#messageBox').text(str);
   		$('#messageBox').show();
		setTimeout(function(){
			$('#messageBox').hide();
		},2200);
	}
   tabs();
var on = true;
$().ready(function(){
	//密码开关
	$('#switch').click(function(){
	    if(on == true){
	    	$('#password')[0].type = "text";
		    $('#switch').removeClass('password_icon_off');
		    $('#switch').addClass('password_icon_on');
		    on = false;
		}else{
			//$('#password').attr('type','password');
			$('#password')[0].type = "password";
		    $('#switch').removeClass('password_icon_on');
		    $('#switch').addClass('password_icon_off');
		    on = true;
		}
	});
});
  // input获得光标 浮框隐藏
	$('input').focus(function(){
		$(this).attr("data-flag","0");
		$('.dnapp').css('display','none');
		$('.footmask').css('display','none');
	})
	$('input').blur(function(){
		$(this).attr("data-flag","1");
		setTimeout(function(){
			var flag1 = $("#account").attr("data-flag")
			var flag2 = $("#password").attr("data-flag")
			var flag3 = $("#inp1").attr("data-flag")
			var flag4 = $("#perpho").attr("data-flag")
			var flag5 = $("#verifycode").attr("data-flag")
			if(flag1==1 && flag2==1&& flag3==1 && flag4==1 && flag5==1){	
				$('.dnapp').css('display','block');
				$('.footmask').css('display','block');
			}
		},500)
	
	});



var oIput = document.getElementById('perpho');
var oCount = document.getElementById('count');
oIput.onkeyup = function(){
	var reg =/^1\d{10}$/;
	if(!reg.test(oIput.value)){
		$(".remind").css("display","block");
	}else{
		$(".remind").css("display","none");
	}
	tagClass(this);
}

function tagClass(tag){
	var oIput = document.getElementById(tag);
	if(tag.value.length == 11){ 
		oCount.className ="mui-btn mui-btn-warning mui-btn-outlined ckbtn";
		$('#count').removeAttr("disabled");
		$('#count').click(function(){
		 	$('#perpho').blur();
		 	$('#perpho').attr("disabled","disabled");
			$('#bei1').val($('#perpho').val());
			$('#checkwin').css('display', 'block');
			$('#verifycode').focus();
			$('#mask4').css('display','block');
		});
	}else{
		oCount.className ="mui-btn mui-btn-warning mui-btn-outlined ckbtnOff";
		$('#count').click(function(){
			$("#checkwin").css('display','none');
			$("#mask").css('display','none');
	});
	} 
} 

function checkpwd(){
	var password=$('#password').val();
	if (password.length==0) {
		tishi('请输入密码');
		return false;
	}
}

$("#btn").click(function() {
	var mobile=$('#account').val();
	var password=$('#password').val();
	var reg1 =/^1\d{10}$/;
	if(!reg1.test(mobile))
	{
		tishi('手机格式不对');
		return false;
	}
	if (password.length==0) {
		tishi('请输入密码');
		return false;
	}
	$.post(
		"<?php echo U('User/login');?>",
		{
			phone:mobile,
			password:password
		},
		function (data,state){
			if(state != "success"){
				tishi('网络请求失败,请重试');
				return false;
			}else if(data.status != 1){
				tishi(data.msg);
				return false;
			}else{
				//登录成功
				window.location.href = "<?php echo U('Index/index');?>";
			}
		}
	);
});

function change_img(obj){
		var rand = "login-"+Date.parse(new Date());
		var url = '<?php echo U("Common/verify");?>';
		$("#rand1").val(rand);
		$(obj).attr("src", url+"&capKey="+rand);
}
var reg1 =/^1[3|4|5|7|8][0-9]\d{8}$/;
var reg2=/^\d{6}$/;
$("#count").click(function(){
	var mobile = $("#perpho").val();
	var verifycode = $("#verifycode").val();
	if(verifycode.length < 4 || !verifycode){
		tishi('请输入图片验证码');
		return false;
	}else if(!reg1.test(mobile)){
		tishi('手机格式不对');
		return false;
	}else{
		//请求发送验证码
		$.post(
			"<?php echo U('User/sendsmscode');?>",
			{phone:mobile,verifycode:verifycode,type:"login"},
			function (data,state){
				$("#checkwin").hide();
				$("#mask").hide();
				$('#mask4').hide();
				if(state != "success"){
					tishi("网络请求失败,请重试");
				}else if(data.status != 1){
					tishi(data.msg);
				}else{
					tishi("发送成功");
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
				}
			}
		);
		return false;
	}
});

$('#logBtn2').click(function(){
	var mobile1=$('#perpho').val();
	var code=$('#inp1').val();
	if(!reg1.test(mobile1)){
		tishi('手机格式不对');
		return false;
	}
	if(!reg2.test(code)){
		tishi('请输入短信验证码');
		return false;
	}
	$.post(
		"<?php echo U('User/login');?>",
		{
			phone:mobile1,
			code:code,
			type:"login"
		},
		function (data,state){
			if(state != "success"){
				tishi("请求失败,请稍后重试!");
			}else if(data.status != 1){
				tishi(data.msg);
			}else{
				window.location.href = "<?php echo U('Index/index');?>";
			}
			return false;
		}
	);
});
$('.cls').click(function(){
		$('.dnapp').css('display','none');
		$('.footmask').css('display','none');
});
</script>
<div style="display: none;">
	<?php
 $name = "cfg_sitecode"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?>
</div>
</body>
</html>