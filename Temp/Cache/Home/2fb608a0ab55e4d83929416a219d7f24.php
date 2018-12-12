<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
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
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/feiqi-ee5401a8e6.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/newpay-bb7fcb5546.css">
<style>
.htan,.emask {
    display: none;
}
.htan-cont{
    text-align:center;
    height:80px;
}
.htan-cont .tex{
    color: #4c4c4c;
    line-height: 60px;
    font-size:18px;
}
.hgray {
	background: #cccccc;
}
.cominfo {
    padding-right: 0px;
}
.input-group {
    padding: 10px 0;
}
</style>
<style>
#shareit {
  -webkit-user-select: none;
  display: none;
  position: absolute;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.85);
  text-align: center;
  top: 0;
  left: 0;
  z-index: 105;
}
#shareit img {
  max-width: 100%;
}
.arrow {
  position: absolute;
  right: 1%;
  top: 5%;
}
#share-text {
  margin-top: 400px;
}
</style>
</head>
<body class="bg">
    <!-- header -->
    <header class="mui-bar mui-bar-nav hnav">
    	<a href="<?php echo U('User/index');?>" class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">我的资料</h1>
	</header>
	<!-- header end-->
<div class="mui-content">
	<section class="allgrp">
		<!-- 头部提示 -->
		<article class="arhead2">
			<?php
 $name = "必要资料说明"; $Block = D("block"); $blockinfo = $Block->where(array('name' => $name))->find(); if(empty($blockinfo)){ echo ""; }else{ echo $blockinfo['cont']; } ?>
		</article>
		<!-- 头部提示1 -->
		<!-- 上 -->
		<article class="cominfo">
			<div class="container">
	    		<!-- 右箭头 -->
	    		<a href="<?php echo U('Info/baseinfo');?>" class="wrapline">
	    		<div class="inpifo">
					<div class="input-group">
						<div class="cf kuren">
							<div class="fl sma sma2">
						    	<img src="__PUBLIC__/home/imgs/g_03.png" alt="">
						    </div>
						    <div class="fl">      
						    	<p class="datatip">身份信息</p>
						    	<p class="f14 col9">*让我们了解您的基本情况</p>
						    </div>
						    <div class="fr pr">
							    <div class="selar moren">
							    	<?php if($info['baseinfo'] == 1): ?><span class="col9">已填写</span>
							    	<?php else: ?>
							    	<span class="org">不完整</span><?php endif; ?>
							    	<span class="seltarr1"></span>
							    </div>
					    	</div>
					    </div>
		    		</div>
		    	</div>
		    	</a>
	    		<!-- 右箭头 -->
	    		<!-- 右箭头 -->
	    		<a href="<?php echo U('Info/unitinfo');?>" class="wrapline" id="baseInfo1">
	    		<div class="inpifo">
					<div class="input-group">
						<div class="cf kuren">
							<div class="fl sma sma2">
						    	<img src="__PUBLIC__/home/imgs/g_08.png" alt="">
						    </div>
						    <div class="fl">      
						    	<p class="datatip">资料信息</p>
						    	<p class="f14 col9">*让我们了解您的资料信息</p>
						    </div>
						    <div class="fr pr">
							    <div class="selar moren">
							    	<?php if($info['unitinfo'] == 1): ?><span class="col9">已填写</span>
							    	<?php else: ?>
							    	<span class="org">不完整</span><?php endif; ?>
							    	<span class="seltarr1"></span>
							    </div>
					    	</div>
					    </div>
		    		</div>
		    	</div>
		    	</a>
	    		<!-- 右箭头 -->
	    		<!-- 右箭头 -->
	    		<a id='yinHangka1'  href="<?php echo U('Info/bankinfo');?>" class="wrapline"  >
	    		<div class="inpifo">
					<div class="input-group">
						<div class="cf kuren">
							<div class="fl sma sma2">
						    	<img src="__PUBLIC__/home/imgs/g_14.png" alt="">
						    </div>
						    <div class="fl">
						    	<p class="datatip">收款银行卡</p>
						    	<p class="f14 col9">*<?php
 $name = "cfg_sitename"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?>会将钱打到该卡内</p>
						    </div>
						    <div class="fr pr">
							    <div class="selar moren">
							    	<?php if($info['bankinfo'] == 1): ?><span class="col9">已填写</span>
							    	<?php else: ?>
							    	<span class="org">不完整</span><?php endif; ?>
							    	<span class="seltarr1"></span>
							    </div>
					    	</div>
					    </div>
		    		</div>
		    	</div>
		    	</a>
		    	<a id='yinHangka1'  href="<?php echo U('Info/xycx');?>" class="wrapline"  >
	    		<div class="inpifo">
					<div class="input-group">
						<div class="cf kuren">
							<div class="fl sma sma2">
						    	<img src="__PUBLIC__/home/imgs/g_14.png" alt="">
						    </div>
						    <div class="fl">
						    	<p class="datatip">信用验证</p>
						    	<p class="f14 col9">提交真实资料</p>
						    </div>
						    <div class="fr pr">
							    <div class="selar moren">
							    	<?php if($info['xyc'] == 1): ?><span class="col9">已填写</span>
							    	<?php else: ?>
							    	<span class="org">不完整</span><?php endif; ?>
							    	<span class="seltarr1"></span>
							    </div>
					    	</div>
					    </div>
		    		</div>
		    	</div>
		    	</a>
	    		<!-- 右箭头 -->
	    		<!-- 右箭头 -->
	    		<!--<a id='yinHangka1'  href="<?php echo U('Info/phoneinfo');?>" class="wrapline"  >
	    		<div class="inpifo">
					<div class="input-group">
						<div class="cf kuren">
							<div class="fl sma sma2">
						    	<img src="__PUBLIC__/home/imgs/g_12-2467ef1cf5.png" alt="">
						    </div>
						    <div class="fl">
						    	<p class="datatip">手机号认证</p>
						    	<p class="f14 col9">*认证您本人的手机号</p>
						    </div>
						    <div class="fr pr">
							    <div class="selar moren">
							    	<?php if($info['phoneinfo'] == 1): ?><span class="col9">已填写</span>
							    	<?php else: ?>
							    	<span class="org">不完整</span><?php endif; ?>
							    	<span class="seltarr1"></span>
							    </div>
					    	</div>
					    </div>
		    		</div>
		    	</div>
		    	</a>-->
	    		<!-- 右箭头 -->
			</div>
		</article>
		<article class="arhead2">
			<?php
 $name = "补充资料说明"; $Block = D("block"); $blockinfo = $Block->where(array('name' => $name))->find(); if(empty($blockinfo)){ echo ""; }else{ echo $blockinfo['cont']; } ?>
		</article>
		<article class="cominfo">
			<div class="container">
	    		<!-- 右箭头 -->
	    		<!--<a id='zhima1'  href="<?php echo U('Info/zhimastepone');?>" class="wrapline">
	    		<div class="inpifo">
					<div class="input-group">
						<div class="cf kuren">
							<div class="fl sma sma2">
						    	<img src="__PUBLIC__/home/imgs/g_10.png" alt="">
						    </div>
						    <div class="fl">
						    	<p class="datatip">芝麻信用</p>
						    	<p class="f14 col9">*测评您的信用资质</p>
						    </div>
						    <div class="fr pr">
							    <div class="selar moren">
							    	<?php if($info['zhimainfo'] == 1): ?><span class="col9">已填写</span>
							    	<?php else: ?>
							    	<span class="col9">不完整</span><?php endif; ?>
							    	<span class="seltarr1"></span>
							    </div>
					    	</div>
					    </div>
		    		</div>
		    	</div>
		    	</a>-->
	    		<!-- 右箭头 -->

	    		<!-- 右箭头 -->
	    		<a id='zhima1'  href="<?php echo U('Info/otherinfo');?>" class="wrapline"  >
	    		<div class="inpifo">
					<div class="input-group">
						<div class="cf kuren">
							<div class="fl sma sma2">
						    	<img src="__PUBLIC__/home/imgs/g_06.png" alt="">
						    </div>
						    <div class="fl">
						    	<p class="datatip">补充资料</p>
						    	<p class="f14 col9">*增加您的审核通过几率</p>
						    </div>
					    </div>
		    		</div>
		    	</div>
		    	</a>
	    		<!-- 右箭头 -->
			</div>
		</article>
		<!-- 下 -->
		<section class='msub' style="position: relative;">
			<a href="<?php echo U('Index/index');?>" class="mui-btn mui-btn-danger mui-button-pay mui-button-gry">
				立即借款
			</a>
		</section>
	</section>
</div>
<!-- step -->
<!--share-->
<div id="shareit">
  <img class="arrow" src="__PUBLIC__/home/imgs/guide1.png">
</div>
<!--share-->
<script src="__PUBLIC__/home/js/jquery.js"></script>
<script>
//分享朋友圈
function sharewechat(){
	$("#shareit").show();
}
$("#shareit").click(function(){
	$("#shareit").hide();
});
</script>
<div style="display: none;">
	<?php
 $name = "cfg_sitecode"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?>
</div>
</body>
</html>