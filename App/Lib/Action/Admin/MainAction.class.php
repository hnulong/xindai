<?php
class MainAction extends CommonAction{

	public function index(){
		$this->title = '管理中心';
		//判断install.php是否存在
        $install_status = 0;
        if(file_exists('./install')){
            $install_status = 1;
        }
        $this->install_status = $install_status;
        //获取4条登录记录
        $Admin_login = D("admin_login");
        $loginData = $Admin_login->order('logintime Desc')->where(array('username' => $this->getlogin() ))->limit(4)->select();
        $this->loginData = $loginData;

		$this->display();
	}


	public function clearcache(){
		$this->title = '清除缓存';
		//清除缓存
		delDir(RUNTIME_PATH);
		$this->success('清理完成!',U(GROUP_NAME.'/Main/index'));
	}

}