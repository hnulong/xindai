<?php
class BlockAction extends CommonAction{
	
	//自由块列表
	public function index(){
		$this->title = "自由块";
		$Block = D("block");
		$this->data = $Block->order("addtime Desc")->select();
		$this->display();
	}
	
	//添加自由块
	public function add(){
		$this->title = "添加自由块";
		$Block = D("block");
		if(IS_POST){
			$name = I("name",'','trim');
			if(!$name){
				$this->error("调用名称不能为空!");
			}
			$count = $Block->where(array('name' => $name))->count();
			if($count){
				$this->error("调用名称不能重复!");
			}
			$_POST['addtime'] = time();
			$status = $Block->add($_POST);
			if(!$status){
				$this->error("添加失败!");
			}
			$this->success("添加成功!");
			exit;
		}
		$this->display();
	}
	
	//删除自由块
	public function del(){
		$this->title = "删除自由块";
		$id = I("id",0,'trim');
		if(!$id){
			$this->error("参数错误!");
		}
		$Block = D("block");
		$status = $Block->where(array('id' => $id))->delete();
		if(!$status){
			$this->error("操作失败!");
		}
		$this->success("删除成功!");
	}
	
	//编辑自由块
	public function edit(){
		$this->title = "修改自由块";
		$id = I("get.id",0,'trim');
		if(!$id){
			$this->error("参数错误!");
		}
		$Block = D("block");
		if(IS_POST){
			//判断新名称是否重复
			$name = I("name",'','trim');
			if(!$name){
				$this->error("调用名称不能为空!");
			}
			$info = $Block->where(array('name' => $name))->find();
			if($info && $info['id'] != $id){
				$this->error("调用名称不能重复!");
			}
			$status = $Block->where(array('id' => $id))->save(array(
				'name' => $name,
				'cont' => I("cont",'','')
			));
			if(!$status){
				$this->error("操作失败!");
			}
			$this->success("修改成功!");
			exit;
		}
		$data = $Block->where(array('id' => $id))->find();
		$this->data = $data;
		$this->display();
	}
	
}
