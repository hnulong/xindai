<?php
class BillsAction extends CommonAction{
	
	public function index(){
		$this->title = "还款列表";
		$keyword = I("keyword",'','trim');
		$this->keyword = $keyword;
		$where = array();
		if($keyword){
			$where['ordernum'] = $keyword;
		}
		$Bills = D("bills");
		import('ORG.Util.Page');
		$count = $Bills->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Bills->where($where)->order('addtime Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->list = $list;
		$this->page = $show;
		$this->display();
	}
	
	public function del(){
        $this->title='删除订单';
        $id = I('id',0,'trim');
        if(!$id){
            $this->error("参数有误!");
        }
		$Bills = D("bills");
        $status = $Bills->where(array('id' => $id))->delete();
        if(!$status){
            $this->error("删除失败!");
        }
        $this->success("删除订单成功!");
	}
	
	
}
