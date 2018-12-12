<?php
class DaikuanAction extends CommonAction{
	
	
	//借款列表
	public function index(){
	    $yuqi = I('isYuqi',0,'int');
	    if($yuqi){
            $this->title = "预期列表";
            $this->yuqi = $yuqi;
            $where = array('status'=>2);
        }else{
            $this->title = "借款列表";
            $keyword = I("keyword",'','trim');
            $this->keyword = $keyword;
            $where = array();
            if($keyword){
                $where['ordernum'] = $keyword;
                // $where['ordernum|user|money|']=array('like',$keyword);
            }
        }

		$Order = D("order");
		import('ORG.Util.Page');
		$count = $Order->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Order->where($where)->order('addtime Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        if($yuqi){
            $i=0;
            foreach ($list as $k=>$v){
                $days = round((time()-$v['updateTime'])/ 86400)-(7*($v['donemonth'] + 1));
                if($days>0){
                    $newList[$i] = $v;
                    $newList[$i]['days']=$days;
                    $newList[$i]['time']=date('Y-m-d',strtotime(date("Y-m-d",strtotime("+".($v['donemonth'] + 1)." week",$v['updateTime']))));
                    $newList[$i]['yuqi']=round($v['days']*$v['monthmoney']*(C('cfg_yuqifuwufei')/100),2);
                }
                $i++;
            }
            $list = array_slice($newList,$Page->firstRow,$Page->listRows);
        }
		$this->list = $list;
		$this->page = $show;
		$this->display();
	}
    public function index1(){
        $yuqi = I('isYuqi',0,'int');
        if($yuqi){
            $this->title = "预期列表";
            $this->yuqi = $yuqi;
            $where = array('status'=>2);
        }else{
            $this->title = "借款列表";
            $keyword = I("keyword",'','trim');
            $this->keyword = $keyword;
            $where = array();
            if($keyword){
                $where['ordernum'] = $keyword;
                // $where['ordernum|user|money|']=array('like',$keyword);
            }
        }

        $Order = D("order");
        import('ORG.Util.Page');
        $count = $Order->where($where)->count();
        $Page  = new Page($count,25);
        $Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
        $show  = $Page->show();
        $list = $Order->where($where)->order('addtime Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        if($yuqi){
            $i=0;
            foreach ($list as $k=>$v){
                $days = round((time()-$v['updateTime'])/ 86400)-(7*($v['donemonth'] + 1));
                if($days>0){
                    $newList[$i] = $v;
                    $newList[$i]['days']=$days;
                    $newList[$i]['time']=date('Y-m-d',strtotime(date("Y-m-d",strtotime("+".($v['donemonth'] + 1)." week",$v['updateTime']))));
                    $newList[$i]['yuqi']=round($days*$v['monthmoney']*(C('cfg_yuqifuwufei')/100),2);
                }
                $i++;
            }
            $list = array_slice($newList,$Page->firstRow,$Page->listRows);
        }
        $this->list = $list;
        $this->page = $show;
        $this->display('index');
    }
	
	//修改订单状态
	public function changestatus(){
		$id = I("id",0,'trim');
		$status = I("status",'','trim');
		$data = array('status' => 0,'msg' => '未知错误');
		if(!$id || $status == ''){
			$data['msg'] = "参数错误!";
		}else{
			$Order = D("order");
			$count = $Order->where(array('id' => $id))->count();
			if(!$count){
				$data['msg'] = "订单不存在!";
			}else{
				$status = $Order->where(array('id' => $id))->save(array('status' => $status,'updateTime'=>time()));
				if(!$status){
					$data['msg'] = "操作失败!";
				}else{
					$data['status'] = 1;
				}
			}
		}
		$this->ajaxReturn($data);
	}
	
	//删除订单
	public function del(){
        $this->title='删除订单';
        $id = I('id',0,'trim');
        if(!$id){
            $this->error("参数有误!");
        }
        $Order = D("order");
        $status = $Order->where(array('id' => $id))->delete();
        if(!$status){
            $this->error("删除失败!");
        }
        $this->success("删除订单成功!");
	}
	
	
	
}
