<?php
class HelpAction extends CommonAction{
	
	public function index(){
		$Article = D("article");
		$Cat = D("cat");
		$catlist = $Cat->order("sort Desc")->select();
		//每个分类筛选3条文章
		$arr = array();
		for($i=0;$i<count($catlist);$i++){
			$tmparr = array();
			$tmparr = $Article->where(array('cid' => $catlist[$i]['id']))
							 ->order("sort Desc")
							 ->limit(3)
							 ->select();
			$arr[] = array(
				'catname' => $catlist[$i]['name'],
				'arts'	  => $tmparr,
				'id'	  => $catlist[$i]['id'],
				'img'	  => $catlist[$i]['thumbnail']
			);
		}
		$this->article = $arr;
		$this->display();
	}
	
	
}
