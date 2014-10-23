<?php
namespace Shop\Controller;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class ShopShippingController extends AshopController {

	//系统首页
    public function index(){
        $lists = D('ShopShipping')->lists();
        $this->assign('list',$lists);
        $this->display();
    }
    /**
     * 文档新增页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function add(){
        $this->display();
    }

    /**
     * 文档编辑页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function edit(){
        //获取左边菜单

        $id     =   I('get.id','');
        if(empty($id)){
            $this->error('参数不能为空！');
        }

        /*获取一条记录的详细数据*/
        $ShopShipping = D('ShopShipping');
        $data = $ShopShipping->detail($id);

        $this->assign('data', $data);
        $this->display('add');
    }

    /**
     * 更新一条数据
     * @author huajie <banhuajie@163.com>
     */
    public function update(){
        $res = D('ShopShipping')->update(I('post.'));
        if(!$res){
            $this->error(D('ShopShipping')->getError());
        }else{
            $this->success($res['id']?'更新成功':'新增成功', Cookie('__forward__'));
        }
    }

    /**
     * 删除
     * @author huajie <banhuajie@163.com>
     */
    public function delete(){
        $res = D('ShopShipping')->delete();
        if(!$res){
            $this->error(D('ShopShipping')->getError());
        }else{
            $this->success('删除成功');
        }
    }
    


}