<?php
namespace Home\Controller;

/**
 * 文档模型控制器
 * 文档模型列表和详情
 */
class OrdersController extends HomeController {
	protected $user;

	protected function _initialize(){
        $this->user = session('user_auth');
    }

    /*
	*订单列表
    */
    public function index()
    {
    	$uid = $this->user['uid'];
    	$lists = D('Shop/ShopOrders')->lists($uid);
    	$this->assign('lists',$lists);
    	$this->display();
    }
	/*下订单*/
	public function makeOrder()
	{
		if(!session('shop_cart')){
            $this->error('购物车还是空的喔!');
        }
		//添加用户id
		if(IS_POST){
			$res = D('Shop/ShopOrders')->makeOrder();
			if($res !== false){
				$this->success('下单成功!','Product/cart');
			}else{
				$this->error(D('ShopOrders')->getError());
			}
		}else{
			$lists = session('shop_cart');
			$shipping_method = D('Shop/ShopShipping')->lists();
			//地址
			$address = M('Member')->where('uid='.$this->user['uid'])->getField('address');
			$add = M('address')->find($address);

			$this->assign('uid',$this->$user['uid']);
			$this->assign('shipping_method',$shipping_method);
			$this->assign('lists',$lists);
			$this->assign('address',$add);
			$this->display();
		}
	}

	public function pay()
	{
		$id = I('get.id');
		if(!$id){
			$this->error('参数错误，请重试');
		}
		$info = D('Shop/ShopOrders')->info($id);
		$this->assign('info',$info);
		$this->display();
	}
}
