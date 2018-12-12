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
<?php if(!$show): ?><div class="filter">
    <form action="<?php echo U(GROUP_NAME.'/User/xybg');?>" method="post">
        <input name="keyword" type="text" class="inpMain" placeholder="用户名" size="20" />
        <input name="submit" class="btnGray" type="submit" value="筛选" />
    </form>
</div><?php endif; ?>
<div id="list">
        
        	<?php if(!$show): ?><table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th width="80" align="center">ID</th>
                <th width="150" align="left">用户名</th>
                <th width="150" align="left">手机号</th>
                <th width="120">查询时间</th>
                <th align="center">操作</th>
            </tr>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td align="center"><?php echo ($vo["id"]); ?></td>
                    <td><?php echo ($vo["user"]); ?></td>
                    <td><?php echo ($vo["mobile"]); ?></td>
                    <td align="center"><?php echo ($vo["date"]); ?></td>
                    <td align="center">
                    	<a href="<?php echo U(GROUP_NAME.'/User/xybg');?>&id=<?php echo ($vo["id"]); ?>">详情</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
           </table><?php endif; ?>
            <?php if($renlian): ?><table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            		<tr>
		                <th width="80" align="left" colspan="2" >人脸特征</th>
		            </tr>
		            <tr>
		            	<td>
		            		人脸数量
		            	</td>
		            	<td>
		            		<?php echo ($renlian["number"]); ?>
		            	</td>
		            </tr>
		            <tr>
		            	<td>
		            		人脸矩阵
		            	</td>
		            	<td>
		            		X:<?php echo ($renlian["rect"]["0"]); ?>;Y:<?php echo ($renlian["rect"]["1"]); ?>;width:<?php echo ($renlian["rect"]["2"]); ?>;height:<?php echo ($renlian["rect"]["3"]); ?>
		            	</td>
		            </tr>
		            <tr>
		            	<td>
		            		人脸五官坐标点
		            	</td>
		            	<td>
		            		<?php echo ($renlian["landmark"]); ?>
		            	</td>
		            </tr>
            	</table>
            	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            		<tr>
		                <th width="80" align="left" colspan="2" >身份证信息</th>
		            </tr>
		            <tr>
		                <th width="80" align="center" colspan="2">正面</th>
		            </tr>
		            <tr><td>地址</td><td><?php echo ($sfzzm["address"]); ?></td></tr>
		            <tr><td>姓名</td><td><?php echo ($sfzzm["name"]); ?></td></tr>
		            <tr><td>民族</td><td><?php echo ($sfzzm["nationality"]); ?></td></tr>
		            <tr><td>身份证号码</td><td><?php echo ($sfzzm["num"]); ?></td></tr>
		            <tr><td>人脸位置</td><td>X:<?php echo ($sfzzm["face_rect"]["center"]["x"]); ?>;Y:<?php echo ($sfzzm["face_rect"]["center"]["y"]); ?></td></tr>
		            <tr><td>人脸矩形</td><td>height:<?php echo ($sfzzm["face_rect"]["size"]["height"]); ?>;width:<?php echo ($sfzzm["face_rect"]["size"]["width"]); ?></td></tr>
		            <tr><td>人脸顺时针角度</td><td><?php echo ($sfzzm["face_rect"]["angle"]); ?></td></tr>
		            <tr>
		                <th width="80" align="center" colspan="2">反面</th>
		            </tr>
		            <tr><td>有效期开始时间</td><td><?php echo ($sfzfm["start_date"]); ?></td></tr>
		            <tr><td>有效期结束时间</td><td><?php echo ($sfzfm["end_date"]); ?></td></tr>
		            <tr><td>签发机关</td><td><?php echo ($sfzfm["issue"]); ?></td></tr>
            	</table><?php endif; ?>
            <?php if($show): ?><table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th width="80" align="left" colspan="2" >基本信息</th>
            </tr>
           
                <tr>
                    <td>姓名</td>
                    <td><?php echo ($show["data"]["realName"]); ?></td>
                </tr>
                <tr>
                    <td>本机号码</td>
                    <td><?php echo ($show["data"]["basicInfo"]["mobileNo"]); ?></td>
                </tr>
                <tr>
                    <td>入网时间</td>
                    <td><?php echo ($show["data"]["basicInfo"]["registerDate"]); ?></td>
                </tr>
                <tr>
                    <td>身份证号码</td>
                    <td><?php echo ($show["data"]["basicInfo"]["idCard"]); ?></td>
                </tr>
                <tr>
                    <td>地址</td>
                    <td><?php echo ($show["data"]["basicInfo"]["address"]); ?></td>
                </tr>
                <tr>
                    <td>星级</td>
                    <td><?php echo ($show["data"]["basicInfo"]["vipLevelstr"]); ?></td>
                </tr>
                <tr>
                    <td>邮箱</td>
                    <td><?php echo ($show["data"]["basicInfo"]["email"]); ?></td>
                </tr>
                <tr>
                    <td>可用积分</td>
                    <td><?php echo ($show["data"]["basicInfo"]["pointsValuestr"]); ?></td>
                </tr>
                <tr>
                    <td>可用余额</td>
                    <td><?php echo ($show["data"]["basicInfo"]["amount"]); ?></td>
                </tr>
            </table>
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th colspan="4" align="left">前10次通话记录</th>
            </tr>
            <?php if(is_array($show["data"]["stati"])): $i = 0; $__LIST__ = $show["data"]["stati"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>与本机通话手机号码</td>
                    <td><?php echo ($vo["mobileNo"]); ?></td>
                    <td>与本机通话次数</td>
                    <td><?php echo ($vo["callCount"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th colspan="5" align="left">最近6个月通话详单</th>
            </tr>
            <tr>
            	<td>通话地点</td>
            	<td>通话时间</td>
            	<td>通话时长</td>
            	<td>通话类型</td>
            	<td>与本机通话手机号码</td>
            </tr>
            <?php if(is_array($show["data"]["callRecordInfo"])): $i = 0; $__LIST__ = $show["data"]["callRecordInfo"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo["callAddress"]); ?></td>
                    <td><?php echo ($vo["callDateTime"]); ?></td>
                    <td><?php echo ($vo["callTimeLength"]); ?></td>
                    <td><?php echo ($vo["callType"]); ?></td>
                    <td><?php echo ($vo["mobileNo"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th colspan="5" align="left">近 6 个月账单信息</th>
            </tr>
            <tr>
            	<td>本机号码</td>
            	<td>账单月份</td>
            	<td>套餐消费</td>
            	<td>总金额</td>
            	<td>实际费用</td>
            </tr>
            <?php if(is_array($show["data"]["bill"])): $i = 0; $__LIST__ = $show["data"]["bill"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo["mobileNo"]); ?></td>
                    <td><?php echo ($vo["startTime"]); ?></td>
                    <td><?php echo ($vo["comboCost"]); ?></td>
                    <td><?php echo ($vo["sumCost"]); ?></td>
                    <td><?php echo ($vo["realCost"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th colspan="5" align="left">近 6 个月短信信息</th>
            </tr>
            <tr>
            	<td>本机号码</td>
            	<td>与本机通话手机号码</td>
            	<td>发送地</td>
            	<td>发送时间</td>
            	<td>发送类型</td>
            </tr>
            <?php if(is_array($show["data"]["smsInfo"])): $i = 0; $__LIST__ = $show["data"]["smsInfo"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo["mobileNo"]); ?></td>
                    <td><?php echo ($vo["sendSmsToTelCode"]); ?></td>
                    <td><?php echo ($vo["sendSmsAddress"]); ?></td>
                    <td><?php echo ($vo["sendSmsTime"]); ?></td>
                    <td><?php echo ($vo["sendType"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th colspan="5" align="left">近 6 个月上网信息</th>
            </tr>
            <tr>
            	<td>本机号码</td>
            	<td>上网地点</td>
            	<td>上网时间</td>
            	<td>上网时长</td>
            	<td>上网类型</td>
            </tr>
            <?php if(is_array($show["data"]["netInfo"])): $i = 0; $__LIST__ = $show["data"]["netInfo"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo["mobileNo"]); ?></td>
                    <td><?php echo ($vo["place"]); ?></td>
                    <td><?php echo ($vo["netTime"]); ?></td>
                    <td><?php echo ($vo["onlineTime"]); ?></td>
                    <td><?php echo ($vo["netType"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th colspan="4" align="left">近 6 个月办理业务信息</th>
            </tr>
            <tr>
            	<td>本机号码</td>
            	<td>业务名称</td>
            	<td>业务开始时间</td>
            	<td>业务消费</td>
            </tr>
            <?php if(is_array($show["data"]["businessInfo"])): $i = 0; $__LIST__ = $show["data"]["businessInfo"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo["mobileNo"]); ?></td>
                    <td><?php echo ($vo["businessName"]); ?></td>
                    <td><?php echo ($vo["beginTime"]); ?></td>
                    <td><?php echo ($vo["cost"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table><?php endif; ?>
        
</div>
<div class="clear"></div>
<div class="pager">
    <?php echo ($page); ?>
</div>
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