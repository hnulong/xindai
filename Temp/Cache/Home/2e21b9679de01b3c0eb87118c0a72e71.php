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
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/feiqi-ee5401a8e6.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/newpay-bb7fcb5546.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/pay-2b02ca7987.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/newindex-09d04b32f3.css">
</head>
<body class="bg">
	<!-- header -->
 	<header class="mui-bar mui-bar-nav hnav" style="box-shadow:none;">
		<a href="<?php echo U('Index/index');?>" class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		<h1 class="mui-title">客服</h1>
	</header>
	
	<!-- header end-->
<div class="mui-content padb60">
	<ul class="cf glist">
		<li>
			<a class="cur" href="http://wpa.qq.com/msgrd?V=1&Uin=<?php
 $name = "客服QQ"; $Block = D("block"); $blockinfo = $Block->where(array('name' => $name))->find(); if(empty($blockinfo)){ echo ""; }else{ echo $blockinfo['cont']; } ?>">
				<div><img src="__PUBLIC__/home/imgs/help_06.png" alt=""></div>
				<p class="f14"><?php
 $name = "客服QQ"; $Block = D("block"); $blockinfo = $Block->where(array('name' => $name))->find(); if(empty($blockinfo)){ echo ""; }else{ echo $blockinfo['cont']; } ?></p>
			</a>
		</li>
		<li>
			<a class="cur" href="wtai://wp//mc;<?php
 $name = "客服电话"; $Block = D("block"); $blockinfo = $Block->where(array('name' => $name))->find(); if(empty($blockinfo)){ echo ""; }else{ echo $blockinfo['cont']; } ?>">
				<div><img src="__PUBLIC__/home/imgs/help_03.png" alt=""></div>
				<p class="f14"><?php
 $name = "客服电话"; $Block = D("block"); $blockinfo = $Block->where(array('name' => $name))->find(); if(empty($blockinfo)){ echo ""; }else{ echo $blockinfo['cont']; } ?></p>
			</a>
		</li>
	</ul>
	<div class="newjobtime">
		<?php
 $name = "客服页咨询说明"; $Block = D("block"); $blockinfo = $Block->where(array('name' => $name))->find(); if(empty($blockinfo)){ echo ""; }else{ echo $blockinfo['cont']; } ?>
	</div>
	
<?php if(is_array($article)): foreach($article as $key=>$vo): ?><section class="cf newquelist">
		<a class="quetype" href="javascript:;">
			<img src="<?php echo ($vo["img"]); ?>" alt="">
			<p class="reque"><?php echo ($vo["catname"]); ?></p>
			<p class="newmor" onClick="jumpMore('<?php echo U('List/index',array('id' => $vo['id']));?>');">更多</p>
		</a>
		<?php $artlist = $vo['arts']; ?>
		<ul class="newans">
			<?php if(is_array($artlist)): foreach($artlist as $key=>$art): ?><li>
				<a href="<?php echo U('List/index',array('id' => $vo['id'],'aid' => $art['id']));?>"> <?php echo ($art["title"]); ?></a>
			</li><?php endforeach; endif; ?>
		</ul>
	</section><?php endforeach; endif; ?>

    <nav class="mui-bar mui-bar-tab bottom-bar">
        <a class="mui-tab-item" href="<?php echo U('Index/index');?>">
                <span class="mui-icon mui-icon-home home">
        </span>
            <span class="mui-tab-label">首页</span>
        </a>
        <a class="mui-tab-item cur" href="<?php echo U('Help/index');?>">
            <span class="mui-icon mui-icon-contact muihelp cur"></span>
            <span class="mui-tab-label">客服</span>
        </a>
        <a class="mui-tab-item" href="<?php echo U('User/index');?>">
            <span class="mui-icon mui-icon-email myself"></span>
            <span class="mui-tab-label">我</span>
        </a>
    </nav>
  	<!-- 底部固定栏 end-->
</div>
<script src="__PUBLIC__/home/js/jquery.js"></script>
<script src="__PUBLIC__/home/js/fontsizeset.js"></script>
<script src="__PUBLIC__/home/js/fukuang.js"></script>
<script>
	$('.bottom-bar a').click(function(){
		
		$('.bottom-bar a').removeClass('cur');
		$('.bottom-bar a span').removeClass('cur');
		$(this).addClass('cur');
		$(this).find('span').eq(0).addClass('cur');
	});
	function jumpMore (url){
		window.location.href = url;
	}
</script>
<div style="display: none;">
	<?php
 $name = "cfg_sitecode"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?>
</div>
</body>
</html>