<?php

class ArticleAction extends CommonAction{

    //分类列表
    public function catlist(){
        $this->title='文章分类';
        $Cat = D("cat");
        $list = $Cat->order("id Asc")
                    ->select();
        if($list){
            for($i=0;$i < count($list);$i++){
                if($list[$i]['pid']){
                    $tmp = $Cat->where(array('id'=>$list[$i]['pid']))->find();
                    $list[$i]['lastname'] = empty($tmp['name']) ? "无" : $tmp['name'];
                }else{
                    $list[$i]['lastname'] = "无";
                }
            }
        }
        $this->data = $list;
        $this->display();
    }

    //添加分类
    public function addcat(){
        $this->title='添加分类';
        $pid = I("get.pid",0,'trim');
        $this->pid = $pid;
        $Cat = D("cat");
        $catlist = $Cat->field("id,name,pid")->select();
        $this->catlist = $catlist;
        if(IS_POST){
            $name = I("name",'','htmlspecialchars');
            if(empty($name)){
                $this->error("栏目名称不能为空!");
            }
            $sort = I("sort",99,'trim');
            $cont = I("cont",'','htmlspecialchars');
            $_POST['sort'] = $sort;
            $_POST['cont'] = $cont;
            $_POST['name'] = $name;
            $_POST['addtime'] = time();
            $status = $Cat->add($_POST);
            if(!$status){
                $this->error("添加失败!");
            }
            $this->success("成功添加栏目:".$name);
            exit;
        }
        $this->display();
    }

    //编辑分类
    public function editcat(){
        $this->title='编辑分类';
        $Cat = D("cat");
        $cid = I("get.cid",0,'trim');
        if(!$cid){
            $this->error("参数有误!");
        }
        $this->cid = $cid;
        $info = $Cat->where(array('id'=>$cid))->find();
        if(!$info){
            $this->error("栏目不存在!");
        }
        $this->pid = $info['pid'];
        $this->info = $info;
        $catlist = $Cat->field("id,name,pid")->select();
        $this->catlist = $catlist;
        if(IS_POST){
            $name = I("name",'','htmlspecialchars');
            if(empty($name)){
                $this->error("栏目名称不能为空!");
            }
            $sort = I("sort",99,'trim');
            $cont = I("cont",'','htmlspecialchars');
            $_POST['sort'] = $sort;
            $_POST['cont'] = $cont;
            $_POST['name'] = $name;
            $status = $Cat->where(array('id'=>$cid))->save($_POST);
            if(!$status){
                $this->error("修改失败!");
            }
            $this->success("成功修改栏目:".$name);
            exit;
        }
        $this->display();
    }

    //删除分类
    public function delcat(){
        $this->title = "删除分类";
        $cid = I('get.cid',0,'trim');
        if(!$cid){
            $this->error('参数错误!');
        }
        $Cat = D("cat");
        $status = $Cat->where(array('id'=>$cid))->delete();
        if(!$status){
            $this->error("删除失败!");
        }
        $this->success("删除分类成功!");
    }



    //文章列表
    public function index(){
        $this->title='文章列表';
        //获取文章分类列表
        $Cat = D("cat");
        $catlist = $Cat->select();
        $this->catlist = $catlist;
        $Article = D("article");
        $cid = I("get.cid",0,'trim');
        $cat_id = I("cat_id",0,'trim');
        $keyword = I("keyword",'','trim');
        $where = array();
        if(!empty($cid)){
            $cat_id = $cid;
        }
        if(!empty($cat_id)){
            $where['cid'] = $cat_id;
        }
        if(!empty($keyword)){
            $where['title'] = array('LIKE',"%{$keyword}%");
        }
        $this->cat_id = $cat_id;
        $this->keyword = $keyword;
        import('ORG.Util.Page');
        $count = $Article->where($where)->count();
        $Page  = new Page($count,25);
        $Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
        $show  = $Page->show();
        $list = $Article->where($where)->order('addtime Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        //绑定文章分类
        for($i=0;$i<count($list);$i++){
            $tmp_cid = $list[$i]['cid'];
            $tmp_arr = $Cat->where(array('id'=>$tmp_cid))->find();
            $list[$i]['catname'] = $tmp_arr['name'];
        }
        $this->list = $list;
        $this->page = $show;
        $this->display();
    }

    //删除文章
    public function del(){
        $this->title='删除文章';
        $aid = I('id',0,'trim');
        if(!$aid){
            $this->error("参数有误!");
        }
        $Article = D("article");
        $status = $Article->where(array('id' => $aid))->delete();
        if(!$status){
            $this->error("删除失败!");
        }
        $this->success("删除文章成功!");
    }

    //添加文章
    public function add(){
        $this->title='添加文章';
        //获取文章分类列表
        $Cat = D("cat");
        $catlist = $Cat->select();
        $this->catlist = $catlist;
        $Article = D("article");
        if(IS_POST){
            $title = I("title",'','trim');
            $cid = I('cid',0,'trim');
            if(!$title){
                $this->error("文章标题不能为空!");
            }
            if(!$cid){
                $this->error("请选择文章分类!");
            }
            $arr = $_POST;
            $arr['addtime'] = time();
            $status = $Article->add($arr);
            if(!$status){
                $this->error("添加文章失败!");
            }
            $this->success("添加成功!");
            exit;
        }
        $this->display();
    }

    //编辑文章
    public function edit(){
        $this->title = '编辑文章';
        $aid = I("get.id",0,'trim');
        if(!$aid){
            $this->error("参数有误!");
        }
        $this->aid = $aid;
        //获取文章分类列表
        $Cat = D("cat");
        $catlist = $Cat->select();
        $this->catlist = $catlist;
        $Article = D("article");
        if(IS_POST){
            $title = I("title",'','trim');
            $cid = I('cid',0,'trim');
            if(!$title){
                $this->error("文章标题不能为空!");
            }
            if(!$cid){
                $this->error("请选择文章分类!");
            }
            $arr = $_POST;
            $status = $Article->where(array('id'=>$aid))->save($arr);
            if(!$status){
                $this->error("编辑文章失败!");
            }
            $this->success("编辑成功!");
            exit;
        }
        $data = $Article->where(array('id'=>$aid))->find();
        $this->data = $data;
        $this->display();
    }


}