<?php
namespace Shop\Controller;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class ShopOrdersController extends AshopController {

	//系统首页
    public function index(){
        $lists = D('ShopOrders')->lists();
        $this->assign('list',$lists);
        $this->meta_title = '订单管理';
        $this->display();
    }

    public function detail()
    {
    	$id = I('get.id');
    	if(!$id){
    		$this->error('参数错误，请重试!');
    	}
    	$order = D('ShopOrders')->detail($id);
        if(!$order){
            $this->error('订单不存在');
        }
    	$this->assign('order',$order);
    	$this->display();
    }


}