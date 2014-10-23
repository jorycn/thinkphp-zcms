<?php
namespace Shop\Model;
use Think\Model;
use Admin\Model\AuthGroupModel;

/**
 * Shop基本模型
 */
class ShopModel extends Model
{
	public function info($id, $field = true){
        /* 获取分类信息 */
		$map = array();
		if(is_numeric($id)){ //通过ID查询
			$map['id'] = $id;
		} else { //通过标识查询
			$map['name'] = $id;
		}
		return $this->field($field)->where($map)->find();
    }
}