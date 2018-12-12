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
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/feiqi-ee5401a8e6.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/mui.min.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/newpay-bb7fcb5546.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/pay-2b02ca7987.css">
<style>
.close_span{
    float: right;
    font-size: 35px;
    top: 10px;
    right: 10%;
    position: absolute;
    color: red;
}
.item_div{
	position: relative;
}
.tiptitle{
    line-height: 1.5em;
    font-size: 15px;
    width: 85%;
    left: 7.5%;
    text-align: center;
    position: relative;
    height: 60px;
    color: #8f8f94;
    margin-top: 12px;
}
</style>
</head>
<body class="whitebg">
     <!-- header -->
	<header class="header">
	<a class="back" id='back' href="<?php echo U('Info/index');?>"></a>
		补充资料
	</header>
	<div class="tiptitle">
		<?php
 $name = "补充资料提示"; $Block = D("block"); $blockinfo = $Block->where(array('name' => $name))->find(); if(empty($blockinfo)){ echo ""; }else{ echo $blockinfo['cont']; } ?>
	</div>
<section>
	<div class="sfzwrap prel" style="text-align: center;height: auto;" id="infoitems">
		<?php if(is_array($data)): foreach($data as $key=>$vo): ?><div id="item_<?php echo ($vo["sid"]); ?>" class="item_div">
				<img src="<?php echo ($vo["imgurl"]); ?>" width="85%" alt="">
				<a href="javascript:delitem(<?php echo ($vo["sid"]); ?>);">
					<span class="close_span">
						<img src="__PUBLIC__/home/imgs/close_info.png" width="40px" />
					</span>
				</a>
			</div><?php endforeach; endif; ?>
	</div>
	<div class="mt10 pa10 btnbg" style="margin-bottom:70px">
		<form method="post" id="info_form">
			<?php if(is_array($data)): foreach($data as $key=>$vo): ?><input type="hidden" name="otherinfo[]" value="<?php echo ($vo["imgurl"]); ?>" id="info_val_<?php echo ($vo["sid"]); ?>" /><?php endforeach; endif; ?>
		</form>
		<div style="display: none;">
			<input type="file" id="Upload_img_file" onchange="addItem();" />
		</div>
		<a href="javascript:$('#Upload_img_file').click();" class="logBtn hgray" id='logBtn' type="submit">添加资料</a>
		<hr />
		<a class="logBtn hgray" onclick="Saveinfo();">提交</a>
	</div>
</section>
<!-- pop end-->
</div>
</div>
<div id="tips" class="ban" style="display:none"></div>
<script src="__PUBLIC__/home/js/jquery-1-fe84a54bc0.11.1.min.js"></script>
<script src="__PUBLIC__/home/js/fontsizeset.js"></script>
<script>
var isload = false;
var item = <?php echo count($data)+1; ?>;
function showtips(msg){
	$("#tips").html(msg);
	$("#tips").show();
	setTimeout(function(){
		$("#tips").html('');
		$("#tips").hide();
	},3000);
}
function delitem(itemid){
	$("#item_"+itemid).remove();
	$("#info_val_"+itemid).remove();
}
function addItem(){
	if(isload == true){
		showtips("正在上传其他文件...");
	}else{
		isload = true;
		var tmp_path = $("#Upload_img_file").val();
		if(tmp_path != '' && tmp_path != null){
		    var pic = $('#Upload_img_file')[0].files[0];
            var fd = new FormData();
            fd.append('imgFile', pic);
            $.ajax({
                url:"__PUBLIC__/main/js/kindeditor/php/upload_json.php",
                type:"post",
                dataType:'json',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){
                    if(data && data.error == '0'){
                    	var imgurl = data.url;
                    	var html = '<div id="item_'+item+'" class="item_div"><img src="'+imgurl+'" width="85%" alt=""><a href="javascript:delitem('+item+');"><span class="close_span"><img src="__PUBLIC__/home/imgs/close_info.png" width="40px" /></span></a></div>';
                        $("#infoitems").append(html);
                        var html = '<input type="hidden" name="otherinfo[]" value="'+imgurl+'" id="info_val_'+item+'" />';
                        $("#info_form").append(html);
                        item ++;
                        showtips("上传成功!");
                    }else{
						showtips("上传出错了...");
                    }
                },
                error:function (){
                    showtips("上传出错了...");
                }
            });
		}
		isload = false;
	}
}

function Saveinfo(){
	jQuery.ajax({
		url: "<?php echo U('Info/otherinfo');?>",
		data: $('#info_form').serialize(),
		type: "POST",
		success: function(){
			showtips("保存成功!");
			setTimeout(function(){
				window.location.href = window.location.href;
			},3000);
		}
	});
}
</script>
<div style="display: none;">
	<?php
 $name = "cfg_sitecode"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?>
</div>
</body>
</html>