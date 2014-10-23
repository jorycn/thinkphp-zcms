<?php
namespace Shop\Controller;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class ShopCatalogController extends AshopController {

	//系统首页
    public function index(){
        $tree = D('ShopCatalog')->get_level_tree();
        $this->assign("catalog", $tree);
        $this->meta_title = '商品分类管理';
        $this->display();
    }

    public function add($pid=0){
    	$Catalog = D('ShopCatalog');

        if(IS_POST){ //提交表单
            if(false !== $Catalog->update()){
                $this->success('新增成功！', U('index'));
            } else {
                $error = $Catalog->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $cate = array();
            if($pid){
                /* 获取上级分类信息 */
                $cate = $Catalog->info($pid, 'id,name,title,status');
                if(!($cate && 1 == $cate['status'])){
                    $this->error('指定的上级分类不存在或被禁用！');
                }
            }
            /* 获取分类信息 */
            $this->assign('catalog', $cate);
            $this->meta_title = '新增分类';
            $this->display('edit');
        }
    }
    /* 编辑分类 */
    public function edit($id = null, $pid = 0){
        $Catalog = D('ShopCatalog');

        if(IS_POST){ //提交表单
            if(false !== $Catalog->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Catalog->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $cate = '';
            if($pid){
                /* 获取上级分类信息 */
                $cate = $Catalog->info($pid, 'id,name,title,status');
                if(!($cate && 1 == $cate['status'])){
                    $this->error('指定的上级分类不存在或被禁用！');
                }
            }

            /* 获取分类信息 */
            $info = $id ? $Catalog->info($id) : '';

            $this->assign('info',       $info);
            $this->assign('catalog',   $cate);
            $this->meta_title = '编辑分类';
            $this->display();
        }
    }
    /**
     * 删除一个分类
     * @author huajie <banhuajie@163.com>
     */
    public function remove(){
        $cate_id = I('id');
        if(empty($cate_id)){
            $this->error('参数错误!');
        }

        //判断该分类下有没有子分类，有则不允许删除
        $child = M('ShopCatalog')->where(array('pid'=>$cate_id))->field('id')->select();
        if(!empty($child)){
            $this->error('请先删除该分类下的子分类');
        }

        //判断该分类下有没有内容
        $document_list = M('ShopProduct')->where(array('cid'=>$cate_id))->field('id')->select();
        if(!empty($document_list)){
            $this->error('请先删除该分类下的文章（包含回收站）');
        }

        //删除该分类信息
        $res = M('ShopCatalog')->delete($cate_id);
        if($res !== false){
            //记录行为
            action_log('update_shopCatalog', 'shopCatalog', $cate_id, UID);
            $this->success('删除分类成功！');
        }else{
            $this->error('删除分类失败！');
        }
    }

    /**
     * 操作分类初始化
     * @param string $type
     * @author huajie <banhuajie@163.com>
     */
    public function operate($type = 'move'){
        //检查操作参数
        if(strcmp($type, 'move') == 0){
            $operate = '移动';
        }elseif(strcmp($type, 'merge') == 0){
            $operate = '合并';
        }else{
            $this->error('参数错误！');
        }
        $from = intval(I('get.from'));
        empty($from) && $this->error('参数错误！');

        //获取分类
        $map = array('status'=>1, 'id'=>array('neq', $from));
        $list = M('ShopCatalog')->where($map)->field('id,title')->select();

        $this->assign('type', $type);
        $this->assign('operate', $operate);
        $this->assign('from', $from);
        $this->assign('list', $list);
        $this->meta_title = $operate.'分类';
        $this->display();
    }

    /**
     * 移动分类
     * @author huajie <banhuajie@163.com>
     */
    public function move(){
        $to = I('post.to');
        $from = I('post.from');
        $res = M('ShopCatalog')->where(array('id'=>$from))->setField('pid', $to);
        if($res !== false){
            $this->success('分类移动成功！', U('index'));
        }else{
            $this->error('分类移动失败！');
        }
    }

    /**
     * 合并分类
     * @author huajie <banhuajie@163.com>
     */
    public function merge(){
        $to = I('post.to');
        $from = I('post.from');
        $Model = M('Catalog');

        //检查分类绑定的模型
        $from_models = explode(',', $Model->getFieldById($from, 'model'));
        $to_models = explode(',', $Model->getFieldById($to, 'model'));
        foreach ($from_models as $value){
            if(!in_array($value, $to_models)){
                $this->error('请给目标分类绑定' . get_model($value, 'title') . '模型');
            }
        }

        //检查分类选择的文档类型
        $from_types = explode(',', $Model->getFieldById($from, 'type'));
        $to_types = explode(',', $Model->getFieldById($to, 'type'));
        foreach ($from_types as $value){
            if(!in_array($value, $to_types)){
                $types = C('DOCUMENT_MODEL_TYPE');
                $this->error('请给目标分类绑定文档类型：' . $types[$value]);
            }
        }

        //合并产品
        $res = M('ShopProduct')->where(array('cid'=>$from))->setField('cid', $to);

        if($res){
            //删除被合并的分类
            $Model->delete($from);
            $this->success('合并分类成功！', U('index'));
        }else{
            $this->error('合并分类失败！');
        }

    }

}