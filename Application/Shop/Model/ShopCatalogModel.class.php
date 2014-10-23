<?php
namespace Shop\Model;
/**
 * 分类模型
 */
class ShopCatalogModel extends ShopModel{

	protected $_validate = array(
		array('name', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
		array('name', '', '标识已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
		array('title', 'require', '名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
	);

	protected $_auto = array(
		array('model', 'arr2str', self::MODEL_BOTH, 'function'),
		array('model', null, self::MODEL_BOTH, 'ignore'),
		array('extend', 'json_encode', self::MODEL_BOTH, 'function'),
		array('extend', null, self::MODEL_BOTH, 'ignore'),
		array('create_time', NOW_TIME, self::MODEL_INSERT),
		array('update_time', NOW_TIME, self::MODEL_BOTH),
		array('status', '1', self::MODEL_BOTH),
	);
	/**
	 * 获取分类树，指定分类则返回指定分类极其子分类，不指定则返回所有分类树
	 * @param  integer $id    分类ID
	 * @param  boolean $field 查询字段
	 * @return array          分类树
	 * @author Jroy
	 */
	public function getTree($id = 0, $field = true){
		/* 获取当前分类信息 */
		if($id){
			$info = $this->info($id);
			$id   = $info['id'];
		}

		/* 获取所有分类 */
		$map  = array('status' => 1);
		$list = $this->field($field)->where($map)->order('sort')->select();
		$list = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_', $root = $id);
		
		/* 获取返回数据 */
		if(isset($info)){ //指定分类则返回当前分类极其子分类
			$info['_'] = $list;
		} else { //否则返回所有分类
			$info = $list;
		}

		return $info;
	}

	/**
	 * 获取指定分类的同级分类
	 * @param  integer $id    分类ID
	 * @param  boolean $field 查询字段
	 * @return array
	 * @author Jroy         
	 */
	public function getSameLevel($id, $field = true){
		$info = $this->info($id, 'pid');
		$map = array('pid' => $info['pid'], 'status' => 1);
		return $this->field($field)->where($map)->order('sort')->select();
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
		return empty($data['id']) ? $this->add() : $this->save();
	}

	/**
	 * 获取指定分类子分类ID
	 * @param  string $cate 分类ID
	 * @return string       id列表
	 * @author Jroy
	 */
	public function getChildrenId($cate){
		$field = 'id,name,pid,title,link_id';
		$category = D('Category')->getTree($cate, $field);
		$ids = array();
		foreach ($category['_'] as $key => $value) {
			$ids[] = $value['id'];
		}
		return implode(',', $ids);
	}

	/**
	 * 查询后解析扩展信息
	 * @param  array $data 分类数据
	 * @author Jroy
	 */
	protected function _after_find(&$data, $options){
		/* 分割模型 */
        if(!empty($data['model'])){
            $data['model'] = explode(',', $data['model']);
        }

        /* 分割文档类型 */
        if(!empty($data['type'])){
            $data['type'] = explode(',', $data['type']);
        }

        /* 分割模型 */
        if(!empty($data['reply_model'])){
            $data['reply_model'] = explode(',', $data['reply_model']);
        }

        /* 分割文档类型 */
        if(!empty($data['reply_type'])){
            $data['reply_type'] = explode(',', $data['reply_type']);
        }

        /* 还原扩展数据 */
        if(!empty($data['extend'])){
            $data['extend'] = json_decode($data['extend'], true);
        }
	}
	/**
	 * 按照自定义规律获取分类树
	 * @param  integer $id    分类ID
	 * @param  boolean $field 查询字段
	 * @return array          分类树
	 * @author Jroy
	 */
	public function get_level_tree()
	{
		$tree = new \Org\Util\Tree;
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $result = $this->order(array("sort"=>"asc"))->select();

        foreach ($result as $r) {
            $r['str_manage'] = '<a href="' . U("ShopProduct/index", array("cate_id" => $r['id'])) . '">产品</a> | <a href="' . U("shopCatalog/add", array("pid" => $r['id'])) . '">添加子分类</a> | <a href="' . U("shopCatalog/edit", array("id" => $r['id'])) . '">修改</a> | <a class="confirm J_ajax_get" href="' . U("shopCatalog/remove", array("id" => $r['id'])) . '">删除</a> | <a href="' . U("ShopCategory/operate", array("type"=>"move","from" => $r['id'])) . '">移动</a> | <a href="' . U("ShopCategory/operate", array("type"=>"merge","from" => $r['id'])) . '">合并</a>';
            $r['id']=$r['id'];
            $r['parentid']=$r['pid'];
            $r['name']=$r['title'];
            $r['listorder'] = $r['sort'];
            $r['display'] = ($r['display']!=0)?'显示':'<span class=grey>隐藏</span>';
            $array[] = $r;
        }
        $tree->init($array);
        $str = "<tr data-parentid='\$parentid' data-id='\$id'>
                    <td><input name='listorders[\$id]' type='text' value='\$listorder' class='input input-xsmall'></td>
                    <td>\$id</td>
                    <td>\$spacer <a href='\$content_url' title='点击添加内容'>\$name</a></td>
                    <td>\$display</td>
                    <td>\$str_manage</td>
                </tr>";
        return $tree->get_tree(0, $str);
	}
}
