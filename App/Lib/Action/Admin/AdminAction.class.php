<?php
/**
 * Created by PhpStorm.
 * User: Somnus
 * Date: 2016/11/9
 * Time: 17:57
 */

class AdminAction extends CommonAction{

    //管理员列表
    public function index(){
        $this->title = '管理员列表';
        $this->seach_name = '';
        $Admin = D("admin");
        import('ORG.Util.Page');
        $where = array();
        if(IS_POST){
            $uname = I('username','','trim');
            if($uname){
                $where['username'] = array('like',"%{$uname}%");
                $this->seach_name = $uname;
            }
        }
        $count = $Admin->where($where)->count();
        $Page  = new Page($count,25);
        $Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
        $show  = $Page->show();
        $list  = $Admin->order('addtime')
                       ->limit($Page->firstRow.','.$Page->listRows)
                       ->where($where)
                       ->select();
        $this->data = $list;
        $this->page = $show;
        $this->display();
    }


    //添加管理员
    public function add(){
        $Admin = D("admin");
        $this->title = '添加管理员';
        if(IS_POST){
            //添加
            $validate = array(
                array('username','require','管理员名称不能为空!'),
                array('username','','管理员名称已经存在！',0,'unique',1),
                array('password','require','管理员密码不能为空!'),
                array('password_confirm','password','两次密码输入不一致!',0,'confirm'),
            );
            $Admin->setProperty("_validate",$validate);
            if(!$Admin->create()){
                $this->error($Admin->getError());
            }
            $_POST['addtime'] = time();
            $_POST['lastlogin'] = 0;
            $_POST['gid'] = 1;//管理组预留
            $_POST['password'] = $this->getpass($_POST['password']);
            $status = $Admin->add($_POST);
            if(!$status){
                $this->error('添加失败!');
            }
            $this->success('添加成功!');
            exit;
        }
        $this->display();
    }


    //修改管理信息
    public function edit(){
        $this->title = '修改管理信息';
        $Admin = D("admin");
        if(IS_POST){
            $editId = I('editId',0,'trim');
            $username = I('username','','trim');
            $password = I('password','','trim');
            $password_confirm = I('password_confirm','','trim');
            $data = $Admin->where(array('id'=>$editId))->find();
            if(!$data){
                $this->error('管理员ID不存在!');
            }
            $status = I('status',1,'trim');
            //判断是否为唯一未禁用管理且操作将禁用
            $num = $Admin->where(array('status' => 1))->count();
            if($num == 1 && $data['status'] == 1 && $status == 0){
                $this->error('禁用所有管理员将无法管理系统!');
            }
            //验证用户名是否存在
            $data = $Admin->where(array('username' => $username))->find();
            if(!$data || $data['id'] == $editId){
                $arr = array(
                    'username' => $username,
                    'status'   => $status
                );
                $Admin->where(array('id' => $editId))->save($arr);
                //验证密码
                if(!empty($password) && $password != $password_confirm){
                    $this->error('两次密码输入不一致!');
                }else{
                    $Admin->where(array('id' => $editId))->save(array('password' => $this->getpass($password)));
                }
                $this->success('修改成功!');
            }else{
                $this->error('管理名称已存在!');
            }
        }
        $editId = I('get.editid',0,'trim');
        $data = $Admin->where(array('id' => $editId))->find();
        if(!$data){
            $this->error('管理员ID不存在!');
        }
        $this->data = $data;
        $this->display();
    }

    //删除管理员
    public function del(){
        $this->title='删除管理员';
        $id = I('get.id',0,'trim');
        $Admin = D("admin");
        //判断是否为唯一未禁用管理员
        $num = $Admin->where(array('status' => 1))->count();
        if($num == 1){
            $this->error('必须保留一个未禁用管理员!');
        }
        $status = $Admin->delete($id);
        if(!$status){
            $this->error('删除失败!');
        }
        $this->success('删除成功!');
    }


    //修改自己信息
    public function chagemypass(){
        $username = $this->getlogin();
        $Admin = D("admin");
        $data = $Admin->where(array('username' => $username))->find();
        if(!$data){
            $this->setlogin('');
            $this->error('非法操作!',U(GROUP_NAME.'/Index/login'));
        }
        $this->redirect(U(GROUP_NAME.'/Admin/edit',array('editid'=>$data['id'])));
    }


}