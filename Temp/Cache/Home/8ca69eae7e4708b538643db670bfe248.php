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
<style>
	.mui-table-view-cell:after {
	    height: 0px;
	}
	.mui-table-view-cell.mui-collapse .mui-table-view .mui-table-view-cell {
	    font-size: 14px;
	}

</style>
</head>
<body class="whtbg">
	<header class="header">
		<a class="back" href="<?php echo U('Help/index');?>"></a>
			<?php echo ($cat["name"]); ?>
	</header>
	<!-- header end-->
<div class="mui-content helpcon">
	<div class="mui-card" style="margin-top: 0px;">
		<ul class="mui-table-view mui-table-view-chevron helpDet">
			<?php if(is_array($list)): foreach($list as $key=>$vo): ?><li  class="mui-table-view-cell mui-collapse " id="Article_Li_<?php echo ($vo["id"]); ?>">
				<a class="mui-navigate-right" href="javascript:;">
					<?php echo ($vo["title"]); ?>
				</a>
				<ul class="mui-table-view mui-table-view-chevron answ">
					<li class="mui-table-view-cell">
						<a class="mui-navigate-right"  href="javascript:;">
							<?php echo ($vo["description"]); ?>
						</a>
					</li>
				</ul>
			</li><?php endforeach; endif; ?>
		</ul>
	</div>
</div>
<script src="__PUBLIC__/home/js/jquery.js" ></script>
<script src="__PUBLIC__/home/js/mui.min.js"></script>
<script>
$(function (){
	var aid = "<?php echo ($aid); ?>";
	if(aid != "0"){
		$("#Article_Li_"+aid).removeClass("mui-table-view-cell mui-collapse");
		$("#Article_Li_"+aid).addClass("mui-table-view-cell mui-collapse mui-active");
		window.location.hash = "#Article_Li_"+aid;
	}
});
</script>
<div style="display: none;">
	<?php
 $name = "cfg_sitecode"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?>
</div>
</body>
</html>