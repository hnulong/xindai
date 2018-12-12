<?php
class IndexAction extends CommonAction {
	
	public function index(){
		if(!$this->islogin()){
			$this->redirect(GROUP_NAME.'/Index/login');
		}else{
			$this->redirect(GROUP_NAME.'/Main/index');
		}
	}
	
	public function login(){
		$this->title="登录系统";
		if(IS_POST){
			$_validate = array(
				array('username','require','用户名不能为空!'),
				array('password','require','密码不能为空!'),
			);
			$Admin = D("admin");
			$Admin-> setProperty("_validate",$validate);
			$result = $Admin->create();
			if(!$result){
				$this->error($Admin->getError());
			}
			$username = I('username','','trim');
			$password = I('password','','trim');
			$password = $this->getpass($password);
			$tmp = $Admin->where(array('username' => $username,'password' => $password))
						 ->find();
			if($tmp){
				if($tmp['status']){
					//写入登录记录
					$Admin_login = D("admin_login");
					$Admin_login->add(array(
						'username'  => $username,
						'logintime' => time(),
						'loginip'	=> get_client_ip()
					));
					//更新最近登录时间
					$this->setlogin($username);
					$Admin->where(array('username' => $username))
						  ->save(array('lastlogin' => time() ));
					$this->success('登录成功!',U(GROUP_NAME.'/Main/index'));
				}else{
					$this->error('该账户已被禁用!');
				}
			}else{
				$this->error('用户名或密码错误!');
			}
			exit;
		}
		$this->display();
		
	}

	public function logout(){
		$this->title="注销登录";
		$this->setlogin('');
		$this->redirect(U(GROUP_NAME.'/Index/login'));
	}

	
}