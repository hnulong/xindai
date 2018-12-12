<?php
/**
 * Created by PhpStorm.
 * User: Somnus
 * Date: 2016/11/9
 * Time: 17:07
 */

class SystemAction extends CommonAction{

    public function index(){
        $this->title = '系统设置';
        if(IS_POST){
            $sitename = I('sitename','','trim');
            $sitetitle = I('sitetitle','','trim');
            if(empty($sitename) || empty($sitetitle)){
                $this->error('网站标题、网站名称不能为空!');
            }
            $file = CONF_PATH.'/config.site.php';
            $arr = array_keys($_POST);
            $siteConfig = array();
            for($i=0;$i<count($arr);$i++){
                $siteConfig['cfg_'.$arr[$i]] = htmlspecialchars($_POST[$arr[$i]]);
            }
            if(!writeArr($siteConfig,$file)){
                $this->error('保存失败!');
            }
            $this->success('保存成功!');
            exit;
        }
        $this->display();
    }


}