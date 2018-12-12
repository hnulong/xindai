<?php
class UserAction extends CommonAction{
	
	//用户列表
	public function index(){
		$this->title = "用户管理";
		$keyword = I("keyword",'','trim');
		$this->keyword = $keyword;
		$where = array();
		if($keyword){
			$where['phone'] = array('like',"%{$keyword}%");
		}
		$User = D("user");
		import('ORG.Util.Page');
		$count = $User->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $User->where($where)->order('addtime Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->list = $list;
		$this->page = $show;
		$this->display();
	}
	
	//允许/禁止用户登录
	public function status(){
		$this->title = "更改用户状态";
		$id = I("id",0,'trim');
		if(!$id){
			$this->error("参数错误!");
		}
		$User = D("user");
		$info = $User->where(array('id' => $id))->find();
		if(!$info){
			$this->error("用户不存在!");
		}
		$newstatus = empty($info['status'])?1:0;
		$status = $User->where(array('id' => $id))->save(array('status' => $newstatus));
		if(!$status){
			$this->error("操作失败!");
		}
		$this->success("变更用户状态成功!");
	}
	
	//删除用户
	public function del(){
        $this->title='删除用户';
        $id = I('id',0,'trim');
        if(!$id){
            $this->error("参数有误!");
        }
        $User = D("user");
        $status = $User->where(array('id' => $id))->delete();
        if(!$status){
            $this->error("删除失败!");
        }
        $this->success("删除用户成功!");
	}
	
	
	//修改用户密码
	public function changepass(){
		$data = array('status' => 0,'msg' => '未知错误');
        $id = I('post.id',0,'trim');
		$pass = I("post.pass",'','trim');
        if(!$id || !$pass){
            $data['msg'] = "参数有误!";
        }else{
        	$User = D("user");
			$pass = sha1(md5($pass));
			$status = $User->where(array('id' => $id))->save(array('password' => $pass));
			if(!$status){
				$data['msg'] = "操作失败!";
			}else{
				$data['status'] = 1;
			}
        }
		$this->ajaxReturn($data);
	}
	
	//查看用户资料
	public function userinfo(){
		$this->title = "查看用户资料";
		$user = I("user",'','trim');
		if(!$user){
			$this->error("参数错误!");
		}
		$Userinfo = D("userinfo");
		$info = $Userinfo->where(array('user' => $user))->find();
		$this->baseinfo = $info;
		$Otherinfo = D("Otherinfo");
		$info = $Otherinfo->where(array('user' => $user))->find();
		$info = json_decode($info['infojson']);
		$this->otherinfo = $info;
		$this->display();
	}
	public function xybg(){
		$xycx=D('xycx');
		$list=$xycx->field('id,date,user,mobile')->select();
		if($_POST){
			$data['user']=$_POST['keyword'];
			$list=$xycx->where($data)->select();
		}
		//print_r($list);
		if($_GET['id']){
			$id=$_GET['id'];
			$data['id']=$id;
			$sho=$xycx->where($data)->select();
			$show=$sho[0]['text'];
			$renlian=json_decode($sho[0]['renlian'],true);
			$sfzzm=json_decode($sho[0]['sfzzm'],true);
			$sfzfm=json_decode($sho[0]['sfzfm'],true);
			$renlian=$renlian['outputs'][0]['outputValue']['dataValue'];
			$renlian=json_decode($renlian,true);
			$sfzzm=$sfzzm['outputs'][0]['outputValue']['dataValue'];
			$sfzzm=json_decode($sfzzm,true);
			$sfzfm=$sfzfm['outputs'][0]['outputValue']['dataValue'];
			$sfzfm=json_decode($sfzfm,true);
			//print_r($renlian);
			$show=json_decode($show,true);
			$this->assign('show',$show);
			$this->assign('renlian',$renlian);
			$this->assign('sfzzm',$sfzzm);
			$this->assign('sfzfm',$sfzfm);
			//print_r($show);
		}
		$this->title = "信用报告查看";
		$this->assign('list',$list);
		$this->display();
	}
	public function xybgshow(){
		
	}
    //验证身份证
    public function check_user(){
        $user=I('get.user',0,'int');
        $Userinfo = D("userinfo");
        $info = $Userinfo->field('is_check,name,usercard')->where(array('user' => $user))->find();
        if(empty($info)){
            $this->ajaxReturn(['act'=>0,'msg'=>'没有查询到用户']);
        }else{
            if($info['is_check']!=1) {
                $key = 'f7be99073541c15a0a580dc1d4d157bd';//后面可以 配置
                $username = $info['name'];
                $usercard = $info['usercard'];
                $re = check_user_card($username, $usercard);
                $res = json_decode($re, true);
                if ($res['error_code'] == 0) {
                    //dump($res);
                    if ($res['result']['isok'] == 1) {
                        $res1 = $Userinfo->where(array('user' => $user))->save(['is_check' => 1]);
                    } else {
                        $res1 = $Userinfo->where(array('user' => $user))->save(['is_check' => 2]);
                    }
                    if ($res1) {
                        $this->ajaxReturn(['act' => 0, 'msg' => $res['reason']]);
                    } else {
                        $this->ajaxReturn(['act' => 0, 'msg' => $res['reason']]);
                    }
                } else {
                    $this->ajaxReturn(['act' => 0, 'msg' => $res['reason']]);
                }
            }
        }

    }
	
}
