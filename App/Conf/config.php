<?php
return array(
	//'配置项'=>'配置值'
	'LOAD_EXT_CONFIG' => 'config.db,config.site,config.install', // 加载扩展配置文件
	'APP_GROUP_LIST'  => 'Home,Admin,Pay', //项目分组设定
	'DEFAULT_GROUP'   => 'Home', //默认分组
	'TMPL_FILE_DEPR'  => '_',
	'URL_MODEL'		  => 0,
	'TAGLIB_LOAD'     => true,//加载标签库打开
	'APP_AUTOLOAD_PATH' => '@.TagLib',
	'TAGLIB_PRE_LOAD' => 'Somnus',
	
);
?>