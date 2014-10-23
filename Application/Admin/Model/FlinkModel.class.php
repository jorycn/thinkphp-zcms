<?php

// +----------------------------------------------------------------------
// | Author: Jroy 
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

/**
 * 分类模型
 * @author Jroy
 */
class FlinkModel extends Model{

    protected $_validate = array(
        array('title', 'require', '名称不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('url', 'require', '链接不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );

    /*
    *获取栏目信息
    */
    public function lists()
    {
        return $this->select();
    }

    public function info($id)
    {
        return $this->find($id);
    }
    /**
     * 更新分类信息
     * @return boolean 更新状态
     * @author Jroy
     */
    public function update(){
        $data = $this->create();
        if(!$data){ //数据对象创建错误
            return false;
        }
        /* 添加或更新数据 */
        if(empty($data['id'])){
            $res = $this->add();
        }else{
            $res = $this->save();
        }

        //记录行为
        action_log('update_flink', 'flink', $data['id'] ? $data['id'] : $res, UID);

        return $res;
    }

}
