<?php

// +----------------------------------------------------------------------
// | Author: Jroy 
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 后台分类管理控制器
 * @author Jroy
 */
class FlinkController extends AdminController {

    /**
     * 分类管理列表
     * @author Jroy
     */
    public function index(){
        $lists = D('Flink')->lists();
        $this->assign("lists", $lists);
        $this->display();
    }


    /* 编辑友链 */
    public function edit($id = null, $pid = 0){
        $Category = D('Flink');

        if(IS_POST){ //提交表单
            if(false !== $Category->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Category->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $id = I('get.id');
            if(!$id){
                $this->error('参数错误');
            }
            //分组
            $group = M('flink_group')->select();
            $info = D('Flink')->info($id);

            $this->assign('flink_group',$group);
            $this->assign('info',$info);
            $this->display();
        }
    }

    /* 新增友链 */
    public function add($pid = 0){
        $Flink = D('Flink');

        if(IS_POST){ //提交表单
            if(false !== $Flink->update()){
                $this->success('新增成功！', U('index'));
            } else {
                $error = $Flink->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $group = M('flink_group')->select();
            $this->assign('flink_group',$group);
            $this->display('edit');
        }
    }

    public function setOrder()
    {
        $order = I('post.listorders');
        foreach ($order as $k => $v) {
            $data['sort'] = $v;
            D('Flink')->where('id='.$k)->save($data);
        }
        $this->success('排序完成');
    }

    //友链分组
    public function type()
    {
        $lists = M('flink_group')->order('id asc')->select();
        $this->assign('lists',$lists);
        $this->display();
    }

    //添加分组
    public function addType()
    {
        if(IS_POST){
            $_validate = array(
                array('title','require','请输入标题'),
            );
            $flink_type_obj = M('flink_group');
            if(!$flink_type_obj->validate($_validate)->create()){
                $this->error($flink_type_obj->getError());
            }else{
                $data = I('post.');
                $data['create_time'] = time();
                if(!$flink_type_obj->add($data)){
                    $this->error('添加分组失败！');
                }else{
                    $this->success('添加分组成功');
                }
            }
        }else{
            $this->display('editType');
        }
    }

    //修改分组
    public function editType()
    {
        if(IS_POST){
            $_validate = array(
                array('title','require','请输入标题'),
            );
            $flink_type_obj = M('flink_group');
            if(!$flink_type_obj->validate($_validate)->create()){
                $this->error($flink_type_obj->getError());
            }else{
                $data = I('post.');
                $data['create_time'] = time();
                if(!$flink_type_obj->where('id='.$data['id'])->save($data)){
                    $this->error('修改分组失败！');
                }else{
                    $this->success('修改分组成功');
                }
            }
        }else{
            $id = I('get.id');
            if(!$id){
                $this->error('参数错误，请重试!');
            }
            $info = M('flink_group')->find($id);
            $this->assign('info',$info);
            $this->display();
        }
    }

    //删除分组
    public function deleteType()
    {
        $id = I('get.id');
        if(!$id){
            $this->error('参数错误,请重试!');
        }
        if(!M('flink_group')->delete($id)){
            $this->error('删除失败');
        }else{
            $this->success('删除成功!');
        }
    }

    //删除友情链接
    public function delete($id)
    {
        $id = I('get.id');
        $res = M('Flink')->delete($id);
        if(false!==$res){
            $this->success('友情链接删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}
