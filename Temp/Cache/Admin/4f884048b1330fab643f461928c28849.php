<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo ($title); ?> - <?php
 $name = "cfg_sitetitle"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?> </title>
    <link href="__PUBLIC__/main/css/public.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/main/js/jquery.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/main/js/global.js"></script>
    <script type="text/javascript" src="__PUBLIC__/main/js/jquery.tab.js"></script>
    <script src="__PUBLIC__/layer/layer.js"></script>
</head>
<body>
<div id="dcWrap">

    <div id="dcHead">
    <div id="head">
        <div class="logo">
          <a href="<?php echo U(GROUP_NAME.'/Main/index');?>">
            <div style="width: 178px;height: 40px;background-image: url('__PUBLIC__/main/images/logo.png');background-size:cover;"></div>
          </a>
        </div>
        <div class="nav">
            <ul>
                <li class="M">
                    <a href="JavaScript:void(0);" class="topAdd">新建</a>
                    <div class="drop mTopad">
                        <a href="<?php echo U(GROUP_NAME.'/Article/add');?>">文章</a>
                        <a href="<?php echo U(GROUP_NAME.'/Article/addcat');?>">文章分类</a>
                        <!--<a href="<?php echo U(GROUP_NAME.'/link/add');?>">友情链接</a>-->
                        <a href="<?php echo U(GROUP_NAME.'/Admin/add');?>">管理员</a>
                    </div>
                </li>
                <li><a href="<?php
 $name = "cfg_siteurl"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?>" target="_blank">查看站点</a></li>
                <li><a href="<?php echo U(GROUP_NAME.'/Main/clearcache');?>">清除缓存</a></li>
                
            </ul>

            <ul class="navRight">
              <li class="M noLeft">
                  <a href="JavaScript:void(0);">您好，<?php echo session('admin_user');?> </a>
                  <div class="drop mUser">
                      <a href="<?php echo U(GROUP_NAME.'/Admin/chagemypass');?>">修改密码</a>
                  </div>
              </li>
              <li class="noRight">
                  <a href="<?php echo U(GROUP_NAME.'/Index/logout');?>">退出</a>
              </li>
          </ul>
        </div>
    </div>
</div>
    <!-- dcHead 结束 -->
    <div id="dcLeft">
	<div id="menu">
		<ul class="top">
            <li>
                <a href="<?php echo U(GROUP_NAME.'/Main/index');?>">
                    <i class="home"></i>
                    <em>管理首页</em>
                </a>
            </li>
        </ul>
        <ul>
            <li id="nav_System_index">
                <a href="<?php echo U(GROUP_NAME.'/System/index');?>">
                    <i class="system"></i>
                    <em>系统设置</em>
                </a>
            </li>
            <li id="nav_Admin_index">
                <a href="<?php echo U(GROUP_NAME.'/Admin/index');?>">
                    <i class="manager"></i>
                    <em>网站管理员</em>
                </a>
            </li>
            <li id="nav_Block_index">
            	<a href="<?php echo U(GROUP_NAME.'/Block/index');?>">
            		<i class="theme"></i>
            		<em>自由块</em>
            	</a>
            </li>
        </ul>
        <ul>
            <li id="nav_Article_catlist">
                <a href="<?php echo U(GROUP_NAME.'/Article/catlist');?>">
                    <i class="articleCat"></i>
                    <em>文章分类</em>
                </a>
            </li>
            <li id="nav_Article_index">
                <a href="<?php echo U(GROUP_NAME.'/Article/index');?>">
                    <i class="article"></i>
                    <em>文章列表</em>
                </a>
            </li>
        </ul>
        <ul>
        	<li id="nav_User_index">
        		<a href="<?php echo U('User/index');?>">
        			<i class="user"></i>
        			<em>用户管理</em>
        		</a>
        	</li>
        	<li id="nav_Daikuan_index">
        		<a href="<?php echo U(GROUP_NAME.'/Daikuan/index');?>">
        			<i class="product"></i>
        			<em>借款列表</em>
        		</a>
        	</li>
            <li id="nav_Daikuan_index1">
                <a href="<?php echo U(GROUP_NAME.'/Daikuan/index1',array('isYuqi'=>1));?>">
                    <i class="product"></i>
                    <em>逾期借款列表</em>
                </a>
            </li>
        	<li id="nav_Huankuan_index">
        		<a href="<?php echo U(GROUP_NAME.'/Bills/index');?>">
        			<i class="guestbook"></i>
        			<em>还款列表</em>
        		</a>
        	</li>

        	<li id="nav_Payorder_index">
        		<a href="<?php echo U(GROUP_NAME.'/Payorder/index');?>">
        			<i class="order"></i>
        			<em>订单列表</em>
        		</a>
        	</li>
           
        </ul>
        <ul>
        	<li id="nav_User_xybg">
        		<a href="<?php echo U('User/xybg');?>">
        			<i class="user"></i>
        			<em>信用报告</em>
        		</a>
        	</li>
        </ul>


	</div>
</div>
<script>
    //设置cur效果
    var MODULE_NAME = "<?php echo MODULE_NAME;?>";
    var ACTION_NAME = "<?php echo ACTION_NAME;?>";
    if(MODULE_NAME != "Main"){
        $("#nav_"+MODULE_NAME+"_"+ACTION_NAME).addClass("cur");
    }
</script>


    <div id="dcMain"> <!-- 当前位置 -->
        <div id="urHere">
            <?php echo ($title); ?>
        </div>
        <div id="index" class="mainBox" style="padding-top:18px;height:auto!important;height:550px;min-height:550px;">


            <h3>
    <?php echo ($title); ?>
</h3>
<?php if(isset($yuqi)): else: ?>
<div class="filter">
    <form action="<?php echo U(GROUP_NAME.'/Daikuan/index');?>" method="post">
        <input name="keyword" type="text" class="inpMain" value="<?php echo ($keyword); ?>" size="20" />
        <input name="submit" class="btnGray" type="submit" value="筛选" />
    </form>
</div><?php endif; ?>
<div id="list">
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <?php if(isset($yuqi)): ?><th width="50" align="center">ID</th>
                    <th width="120" align="center">订单号</th>
                    <th width="80" align="center">用户名</th>
                    <th width="70">借款金额</th>
                    <th width="70">逾期手续费</th>
                    <th width="70">借款期限</th>
                    <th width="150" align="center">创建日期</th>
                    <th width="150" align="center">还款日期</th>
                    <th width="80">逾期天数</th>
                    <th width="120">个人资料</th>
                    <?php else: ?>
                    <th width="50" align="center">ID</th>
                    <th width="120" align="center">订单号</th>
                    <th width="80" align="center">用户名</th>
                    <th width="70">借款金额</th>
                    <th width="70">借款期限</th>
                    <th width="150" align="center">创建日期</th>
                    <th width="80">状态</th>
                    <th width="120">个人资料</th>
                    <th align="center">操作</th><?php endif; ?>

            </tr>
                <?php if(isset($yuqi)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td align="center"><?php echo ($vo["id"]); ?></td>
                    <td align="center"><?php echo ($vo["ordernum"]); ?></td>
                    <td align="center"><?php echo ($vo["user"]); ?></td>
                    <td align="center"><?php echo ($vo["money"]); ?>元</td>
                    <td align="center"><?php echo ($vo["yuqi"]); ?>元</td>
                    <td align="center"><?php echo ($vo["months"]); ?>周</td>
                    <td align="center"><?php echo (date('Y-m-d H:i:s',$vo["addtime"])); ?></td>
                    <td align="center"><?php echo ($vo["time"]); ?></td>
                    <td><?php echo ($vo["days"]); ?>天</td>
                    <th align="center" width="120"><a onmouseover="this.style.color='red'" onmouseout="this.style.color='#626262'" href="<?php echo U(GROUP_NAME.'/User/userinfo',array('user' => $vo['user']));?>">查看资料</a></th></tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php else: ?>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                        <td align="center"><?php echo ($vo["id"]); ?></td>
                        <td align="center"><?php echo ($vo["ordernum"]); ?></td>
                        <td align="center"><?php echo ($vo["user"]); ?></td>
                        <td align="center"><?php echo ($vo["money"]); ?>元</td>
                        <td align="center"><?php echo ($vo["months"]); ?>周</td>
                        <td align="center"><?php echo (date('Y-m-d H:i:s',$vo["addtime"])); ?></td>
                        <!-- <td align="center">
                            <?php if($vo['status'] == 0)echo "支付失败"; if($vo['status'] == 1)echo "正在审核订单"; if($vo['status'] == 2)echo "订单打款成功"; if($vo['status'] == '-1')echo "审核不通过"; ?>
                        </td> -->
                        <?php if($vo['status'] == 0 ): ?><td align="center" style="color:red">支付失败</td>
                            <?php elseif($vo['status'] == 1): ?>
                            <td align="center">正在审核订单</td>
                            <?php elseif($vo['status'] == 2): ?>
                            <td align="center" style="color:green">订单打款成功</td>
                            <?php elseif($vo['status'] == -1): ?>
                            <td align="center" style="color:red">审核不通过</td><?php endif; ?>
                        <th align="center" width="120"><a onmouseover="this.style.color='red'" onmouseout="this.style.color='#626262'" href="<?php echo U(GROUP_NAME.'/User/userinfo',array('user' => $vo['user']));?>">查看资料</a></th>
                        <td align="center">
                            <a href="javascript:changestatus('<?php echo ($vo["ordernum"]); ?>','<?php echo ($vo["id"]); ?>');">修改订单状态</a> |
                            <a href="javascript:showbank('<?php echo ($vo["bank"]); ?>','<?php echo ($vo["banknum"]); ?>');">查看打款信息</a> |
                            <a href="javascript:del('<?php echo ($vo["ordernum"]); ?>','<?php echo U(GROUP_NAME.'/Daikuan/del',array('id'=>$vo['id']));?>');">删除订单</a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>


        </table>
</div>
<div class="clear"></div>
<div class="pager">
    <?php echo ($page); ?>
</div>
</div>
<script>
    function del(num,jumpurl){
        layer.confirm(
                '确定要删除借款订单:'+num+'吗?',
                function (){
                    window.location.href = jumpurl;
                }
        );
    }
    function showbank(bankname,banknum){
  		layer.alert(
  			'打款银行:' + bankname + "<br>" + '银行卡号:' + banknum,
  			{
	    		skin: 'layui-layer-lan',
	    		closeBtn: 0,
	    		anim: 4
  			}
  		);
    }
    function changestatus(ordernum,oid){
    	$("#changestatus_span").html(ordernum);
    	$("#orderid").val(oid);
		layer.open({
		  	type: 1,
		  	skin: 'layui-layer-rim', //加上边框
		  	area: ['420px', '165px'], //宽高
		  	content: $("#changestatus_div").html()
		});
    }
    function savestatus(){
    	var id = $("#orderid").val();
    	var status = $('input:radio[name="status"]:checked').val();
    	if(status != 'undefined' && status != '' && status != null){
    		$.post(
    			"<?php echo U(GROUP_NAME.'/Daikuan/changestatus');?>",
    			{id:id,status:status},
    			function(data,state){
    				if(state != "success"){
    					layer.msg("请求数据失败!");
    				}else if(data.status == 1){
    					layer.msg("保存成功!");
    					setTimeout(function(){
    						window.location.href = window.location.href;
    					},2000);
    				}else{
    					layer.msg(data.msg);
    				}
    			}
    		);
    	}else{
    		layer.msg("请选择订单状态!");
    	}
    }
</script>
<div style="display: none;" id="changestatus_div">
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tr>
            <td width="100" align="right">订单号</td>
            <td>
                <span id="changestatus_span"></span>
                <input type="hidden" id="orderid" value="" />
            </td>
        </tr>
        <tr>
            <td align="right">状态</td>
            <td>
                <label>
                    <input type="radio" name="status" value="0"  >
					支付失败
                </label>
                <label>
                    <input type="radio" name="status" value="1"  >
					正在审核
                </label>
                <label>
                    <input type="radio" name="status" value="2"  >
					打款成功
                </label>
                <label>
                    <input type="radio" name="status" value="-1"  >
					审核不通过
                </label>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" onclick="savestatus();" class="btn" value="提交" />
            </td>
        </tr>
    </table>
</div>


        </div>
    </div>
    <div class="clear"></div>
    	<div id="dcFooter">
		 <div id="footer">
		  <div class="line"></div>
			  <ul>
			 
			  </ul>
		 </div>
	</div>
    <!-- dcFooter 结束 -->
    <div class="clear"></div>
</div>
</body>
</html>