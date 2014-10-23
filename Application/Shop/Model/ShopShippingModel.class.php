<?php
namespace Shop\Model;

/**
 * 文档基础模型
 */
class ShopShippingModel extends ShopModel{

    /* 自动验证规则 */
    protected $_validate = array(
        array('name', 'require', '名称不能为空'),
        array('price', '/^\d+(\.\d+)?$/', '价格只能填数字', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
        );

    /* 自动完成规则 */
    protected $_auto = array(
        array('name', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
        array('des', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
        array('orders', 0, self::MODEL_BOTH),
    );

    /**
     * 获取文档列表
     * @param  integer  $category 分类ID
     * @param  string   $order    排序规则
     * @param  integer  $status   状态
     * @param  boolean  $count    是否返回总数
     * @param  string   $field    字段 true-所有字段
     * @param  string   $limit    分页参数
     * @param  array    $map      查询条件参数
     * @return array              文档列表
     * @author huajie <banhuajie@163.com>
     */
    public function lists($category, $order = '`id` DESC', $status = 1, $field = true, $limit = '10', $map = array()){
        if($status){
            $map = array_merge($this->listMap($category, $status), $map);
        }else{
            $map = array_merge($this->listMap($category), $map);
        }
        return $this->field($field)->where($map)->order($order)->limit($limit)->select();
    }

    /**
     * 获取详情页数据
     * @param  integer $id 文档ID
     * @return array       详细数据
     */
    public function detail($id,$field=true){
        /* 获取基础数据 */
        $info = $this->field($field)->find($id);
        return $info;
    }
    /**
     * 新增或更新一个文档
     * @param array  $data 手动传入的数据
     * @return boolean fasle 失败 ， int  成功 返回完整的数据
     * @author huajie <banhuajie@163.com>
     */
    public function update($data = null){
        /* 获取数据对象 */
        $data = $this->create($data);
        if(empty($data)){
            return false;
        }

        /* 添加或新增基础内容 */
        if(empty($data['id'])){ //新增数据
            $id = $this->add(); //添加基础内容
            if(!$id){
                $this->error = '新增基础内容出错！';
                return false;
            }
        } else { //更新数据
            $status = $this->save(); //更新基础内容
            if(false === $status){
                $this->error = '更新基础内容出错！';
                return false;
            }
        }
        //行为记录
        if($id){
            action_log('update_shipping', 'shipping', $id, UID);
        }

        //内容添加或更新完成
        return $data;
    }

    public function delete()
    {
        $ids    =   I('request.ids');
        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }
        $map['id'] = array('in',$ids);
        if(M('ShopShipping')->where($map)->delete()!==false){
            $this->success = '删除成功!';
            return true;
        }else{
            $this->error = '删除失败!';
            return false;
        }   
    }

    /**
     * 设置where查询条件
     * @param  number  $category 分类ID
     * @param  number  $pos      推荐位
     * @param  integer $status   状态
     * @return array             查询条件
     */
    private function listMap($category, $status = '', $pos = null){
        /* 设置状态 */
        if($status){
            $map = array('status' => $status);
        }
       
        /* 设置分类 */
        if(!is_null($category)){
            if(is_numeric($category)){
                $map['category_id'] = $category;
            } else {
                $map['category_id'] = array('in', str2arr($category));
            }
        }

        /* 设置推荐位 */
        if(is_numeric($pos)){
            $map[] = "position & {$pos} = {$pos}";
        }

        return $map;
    }

}
