<?php
class ListAction extends CommonAction{
	
	public function index(){
		$Cat = D("cat");
		$cid = I("id",0,'trim');
		$aid = I("aid",0,'trim');
		$cat = $Cat->where(array('id' => $cid))->find();
		if(!$cat){
			$this->redirect('Help/index');
		}
		$Article = D("article");
		$list = $Article->where(array('cid' => $cid))->order("sort Desc")->select();
		$this->cat = $cat;
		$this->list = $list;
		$this->aid = $aid;
		$this->display();
	}
	
}
