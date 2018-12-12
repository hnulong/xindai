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


            <?php if($install_status == 1): ?><div class="warning">您还没有删除 install 文件夹，出于安全的考虑，我们建议您删除 install 文件夹。</div><?php endif; ?>

<div id="douApi"></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="indexBoxTwo">
    <tr>
        <td width="65%" valign="top" class="pr">
            <div class="indexBox">
                <div class="boxTitle">系统基本信息-本源码来自资源e站（Zye.cc）</div>
                <ul>
                    <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic">
                        <tr>
                            <td width="120">PHP 版本：</td>
                            <td><strong> <?php echo PHP_VERSION; ?> </strong></td>
                            <td width="100">Base版本：</td>
                            <td><strong> v<?php echo THINK_VERSION; ?> </strong></td>
                        </tr>
                        <tr>
                            <td>缓存目录：</td>
                            <td><strong> <?php echo TEMP_PATH; ?> </strong></td>
                            <td>系统语言：</td>
                            <td><strong>zh_cn</strong></td>
                        </tr>
                        <tr>
                            <td>调试模式：</td>
                            <td><strong> <?php if(APP_DEBUG)echo '是';else echo '否'; ?> </strong></td>
                            <td>当前IP：</td>
                            <td><strong> <?php echo get_client_ip(); ?> </strong></td>
                        </tr>
                        <tr>
                            <td>内存统计支持：</td>
                            <td><strong> <?php echo MEMORY_LIMIT_ON; ?> </strong></td>
                            <td>编码：</td>
                            <td><strong>UTF-8</strong></td>
                        </tr>
                        <tr>
                            <td>SomCNS版本：</td>
                            <td><strong>v<?php echo C('install_vis');?></strong></td>
                            <td>安装日期：</td>
                            <td><strong> <?php echo C('install_time');?> </strong></td>
                        </tr>
                    </table>
                </ul>
            </div>
        </td>
        <td valign="top" class="pl">
            <div class="indexBox">
                <div class="boxTitle">登录记录</div>
                <ul>
                    <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic">
                        <tr>
                            <th width="45%">IP地址</th>
                            <th width="55%">登录时间</th>
                        </tr>
                        <?php if(is_array($loginData)): foreach($loginData as $key=>$vo): ?><tr>
                                <td align="center"><?php echo ($vo["loginip"]); ?></td>
                                <td align="center"><?php echo (date('Y/m/d H:i:s',$vo["logintime"])); ?></td>
                            </tr><?php endforeach; endif; ?>
                    </table>
                </ul>
            </div>
        </td>
    </tr>
</table>
<div class="indexBox">
    <div class="boxTitle">服务器信息</div>
    <ul>
        <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic">
            <tr>
                <td width="120" valign="top">PHP 版本：</td>
                <td valign="top"> <?php echo PHP_VERSION; ?> </td>
                <td width="100" valign="top">MySQL 版本：</td>
                <td valign="top"> <?php echo mysql_get_server_info(); ?> </td>
                <td width="100" valign="top">服务器操作系统：</td>
                <td valign="top"> <?php echo PHP_OS; ?> </td>
            </tr>
            <tr>
                <td valign="top">文件上传限制：</td>
                <td valign="top">2M</td>
                <td valign="top">GD 库支持：</td>
                <td valign="top"> <?php if(function_exists('imagecreate')){echo '是';}else{echo '否';} ?> </td>
                <td valign="top">Web 服务器：</td>
                <td valign="top"> <?php echo php_uname(); ?> </td>
            </tr>
        </table>
    </ul>
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