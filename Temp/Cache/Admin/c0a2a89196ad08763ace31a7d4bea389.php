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
    <a href="<?php echo U(GROUP_NAME.'/User/index');?>" class="actionBtn">返回列表</a>
 	基本资料
</h3>
<style>
	.check_button{margin-left:20px;width: 80px;height:30px;line-height:30px;background-color:#2e8ded;color:#fff;}
	.check_button_ok{margin-left:20px;width: 80px;height:30px;line-height:30px;background-color:#2e8ded;color:#fff;}
	.check_button_no{margin-left:20px;width: 80px;height:30px;line-height:30px;background-color:#b1b1b1;color:#fff;}
</style>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tr>
            <td width="100" align="right">手机号/用户名</td>
            <td>
                <span><?php echo ($baseinfo["user"]); ?></span>
            </td>
        </tr>
        <tr>
            <td width="100" align="right">姓名/身份证号</td>
            <td>
				<span><?php echo ($baseinfo["name"]); ?> | <?php echo ($baseinfo["usercard"]); if($baseinfo['name'] && $baseinfo.usercard): if($baseinfo['is_check'] == 0): ?><button class="check_button">验证</button><?php elseif($baseinfo['is_check'] == 1): ?>
						<button class="check_button_ok">认证通过</button><?php else: ?>
						<button class="check_button_no">认证未通过</button><button class="check_button">重新认证</button><?php endif; endif; ?>
				</span>
            </td>
        </tr>
         <tr>
            <td width="100" align="right">芝麻信用评分</td>
            <td>
                <span><?php echo ($baseinfo["zhimaxinyong"]); ?> </span>
            </td>
        </tr>
        <tr>
            <td width="100" align="right">身份证拍照</td>
            <td>
            	<span>
            		身份证正面:<a href="<?php echo ($baseinfo["cardphoto_1"]); ?>" target="_blank">点击查看</a>
            	</span>
            	<br />
            	<span>
            		身份证反面:<a href="<?php echo ($baseinfo["cardphoto_2"]); ?>" target="_blank">点击查看</a>
            	</span>
            	<br />
            	<span>
            		手持身份证:<a href="<?php echo ($baseinfo["cardphoto_3"]); ?>" target="_blank">点击查看</a>
            	</span>
            </td>
        </tr>
        <tr>
            <td width="100" align="right">现居住地</td>
            <td>
                <span><?php echo ($baseinfo["addess_ssq"]); ?> <?php echo ($baseinfo["addess_more"]); ?></span>
            </td>
        </tr>
        <tr>
            <td width="100" align="right">单位信息</td>
            <td>
            	<span>
            		单位名称: <?php echo ($baseinfo["dwname"]); ?>
            	</span>
            	<br />
            	<span>
            		单位地址: <?php echo ($baseinfo["dwaddess_ssq"]); ?> <?php echo ($baseinfo["dwaddess_more"]); ?>
            	</span>
            	<br />
            	<span>
            		职位: <?php echo ($baseinfo["position"]); ?>
            	</span>
            	<br />
            	<span>
            		工龄: <?php echo ($baseinfo["workyears"]); ?> 年
            	</span>
            	<br />
            	<span>
            		单位电话: <?php echo ($baseinfo["dwphone"]); ?>
            	</span>
            	<br />
            	<span>
            		月收入: <?php echo ($baseinfo["dwysr"]); ?>
            	</span>
            	<br />
            	<span>
            		联系人1: <?php echo ($baseinfo["persongx_1"]); ?> : <?php echo ($baseinfo["personname_1"]); ?> : <?php echo ($baseinfo["personphone_1"]); ?>
            	</span>
            	<br />
            	<span>
            		联系人2: <?php echo ($baseinfo["persongx_2"]); ?> : <?php echo ($baseinfo["personname_2"]); ?> : <?php echo ($baseinfo["personphone_2"]); ?>
            	</span>
            	
            </td>
        </tr>
        <tr>
            <td width="100" align="right">银行卡信息</td>
            <td>
            	<span>
            		银行名称: <?php echo ($baseinfo["bankname"]); ?>
            	</span>
            	<br />
            	<span>
            		银行卡号: <?php echo ($baseinfo["bankcard"]); ?>
            	</span>
            </td>
        </tr>
    </table>
    <h3>补充资料</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
    	<tr>
    		<?php if(is_array($otherinfo)): foreach($otherinfo as $key=>$vo): ?><p>
    				<?php echo ($vo); ?> | 
    				<a href="<?php echo ($vo); ?>" target="_blank">点击查看</a>
    			</p><?php endforeach; endif; ?>
    	</tr>
    </table>
	<script type="text/javascript">
		$(function () {
			$('.check_button').click(function () {
			    var url="<?php echo U('check_user',['user'=>$baseinfo['user']]);?>"
				$.ajax({
				    url:url,
					dataType:'json',
					success:function (res) {
						if(res.act==1){
						    layer.msg(res.msg,{time:800},function () {
								location='';
                            });
						}else{
						    layer.msg(res.msg,{time:1000});
						}
                    },
					error:function () {
						layer.msg('网络错误');
                    }
				});
            });
        })
	</script>


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