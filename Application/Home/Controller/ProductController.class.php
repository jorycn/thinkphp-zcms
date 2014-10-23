<?php
namespace Home\Controller;

/**
 * 文档模型控制器
 * 文档模型列表和详情
 */
class ProductController extends HomeController {
	/*加入购物车*/
	public function addCart()
	{
		$this->login();
		$id = I('get.id');
		//判断是否是加入购物车
		$action = IS_AJAX;
		if(!id){
			$this->error('产品不存在!');
		}
		$shopping_cart = session('shop_cart');
		$Product_collection = D('Shop/ShopProduct')->detail($id,array('id','title','thumb','mrsp','price'));
		$product = $this->addinfo($Product_collection);

		if(!$shopping_cart){
			session('shop_cart',array($id=>$product));
			if(!$action){
				$this->redirect('Product/Cart');
			}else{
				$this->success('商品加入购物车成功！');
			}
		}else{
			if($shopping_cart[$id]){
				if(!$action){
					$this->redirect('Product/Cart');
				}else{
					$this->error('该商品已经加入到购物车了哦!');
				}
			}
			//添加附加信息
			$shopping_cart[$id] = $product;
			session('shop_cart',$shopping_cart);
			if(!$action){
				$this->success('商品已成功加入购物车！');
			}else{
				$this->redirect('Product/Cart');
			}
		}
	}

	/*购物车*/
	public function cart()
	{	
		$this->login();
		$lists = session('shop_cart');
		$globalTotals = get_global_totals();

		$this->assign('globalTotals',$globalTotals);
		$this->assign('lists',$lists);

		$this->display();
	}

	/*删除购物车购物车*/
	public function delete()
	{
		$id = I('get.id');
		if(!$id){
			$this->error('参数错误，请重试');
		}
		$shopping_cart = session('shop_cart');
		//销毁当前
		unset($shopping_cart[$id]);
		session('shop_cart',$shopping_cart);
		$this->success('删除成功！');
	}

	/*添加购物车信息*/
	public function addinfo($product)
	{
		$qty = I('post.qty');
		$add['qty'] = $qty;
		$add['subTotal'] = $qty*$product['price'];
		return array_merge($product,$add);
	}

}
