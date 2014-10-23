<?php
namespace Shop\Controller;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class ShopProductController extends AshopController {

	//系统首页
    public function index(){
        $cid = I('get.cate_id');
        if(!I('get.menuId')){
            if(strcmp($cid, 0) != 0){
                if(!$cid){
                    $cid = session('shop_category_id');
                }else{
                    session('shop_category_id',$cid);
                }
            }
        }else{
            session('shop_category_id',null);
        }

        $map['status'] = array('gt','-1');
        $lists = D('ShopProduct')->lists('','','','','',$map);
        $this->assign('list',$lists);
        $this->meta_title = '商品管理';
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display();
    }
    /**
     * 文档新增页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function add(){
        //获取左边菜单
        $cate_id    =   I('get.cate_id',0);
        $model_id    =   4;
        empty($cate_id) && $this->error('参数不能为空！');
        empty($model_id) && $this->error('参数不能为空！');

        //检查该分类是否允许发布
        $allow_publish = D('ShopProduct')->checkCategory($cate_id);
        !$allow_publish && $this->error('该分类不允许发布内容！');

        /* 获取要编辑的扩展模型模板 */
        $model      =   get_model($model_id);

        //处理结果
        $info['pid']            =   $_GET['pid']?$_GET['pid']:0;
        $info['model_id']       =   $model_id;
        $info['cid']    =   $cate_id;
        if($info['pid']){
            // 获取上级文档
            $article            =   M('ShopProduct')->field('id,title,type')->find($info['pid']);
            $this->assign('article',$article);
        }

        //获取表单字段排序
        $fields = get_model_attribute($model['id']);
        $this->assign('info',       $info);
        $this->assign('fields',     $fields);
        $this->assign('type_list',  get_type_bycate($cate_id));
        $this->assign('model',      $model);
        $this->meta_title = '新增'.$model['title'];
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
        $ShopProduct = D('ShopProduct');
        $data = $ShopProduct->detail($id);

        if(!$data){
            $this->error($ShopProduct->getError());
        }

        $this->assign('data', $data);
        $this->assign('model_id', 4);

        /* 获取要编辑的扩展模型模板 */
        $model      =   $this->getModel(4);
        $this->assign('model',      $model);

        //获取表单字段排序
        $fields = get_model_attribute(4);
        $this->assign('fields',     $fields);

        //获取当前分类的文档类型
        $this->assign('type_list', get_type_bycate($data['cid']));
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $this->display();
    }

    /**
     * 更新一条数据
     * @author huajie <banhuajie@163.com>
     */
    public function update(){
        $res = D('ShopProduct')->update(I('post.'));
        if(!$res){
            $this->error(D('ShopProduct')->getError());
        }else{
            $this->success($res['id']?'更新成功':'新增成功', Cookie('__forward__'));
        }
    }

    /**
     * 设置一条或者多条数据的状态
     * @author huajie <banhuajie@163.com>
     */
    public function setStatus($model='ShopProduct'){
        return parent::setStatus('ShopProduct');
    }
     /**
     * 写文章时自动保存至草稿箱
     * @author huajie <banhuajie@163.com>
     */
    public function autoSave(){
        $res = D('ShopProduct')->autoSave();
        if($res !== false){
            $return['data']     =   $res;
            $return['info']     =   '保存草稿成功';
            $return['status']   =   1;
            $this->ajaxReturn($return);
        }else{
            $this->error('保存草稿失败：'.D('ShopProduct')->getError());
        }
    }

    public function getModel($id = null, $field = null)
    {
        static $list;

        /* 非法分类ID */
        if(!(is_numeric($id) || is_null($id))){
            return '';
        }

        /* 读取缓存数据 */
        if(empty($list)){
            $list = S('DOCUMENT_MODEL_LIST');
        }

        /* 获取模型名称 */
        if(empty($list)){
            $map   = array('status' => 1);
            $model = M('Model')->where($map)->field(true)->select();
            foreach ($model as $value) {
                $list[$value['id']] = $value;
            }
            S('DOCUMENT_MODEL_LIST', $list); //更新缓存
        }

        /* 根据条件返回数据 */
        if(is_null($id)){
            return $list;
        } elseif(is_null($field)){
            return $list[$id];
        } else {
            return $list[$id][$field];
        }

    }
}