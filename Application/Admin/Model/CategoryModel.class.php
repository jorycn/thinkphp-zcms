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
class CategoryModel extends Model{

    protected $_validate = array(
        array('name', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', '', '标识已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
        array('title', 'require', '名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    	array('meta_title', '1,50', '网页标题不能超过50个字符', self::VALUE_VALIDATE , 'length', self::MODEL_BOTH),
    	array('keywords', '1,255', '网页关键字不能超过255个字符', self::VALUE_VALIDATE , 'length', self::MODEL_BOTH),
    	array('meta_title', '1,255', '网页描述不能超过255个字符', self::VALUE_VALIDATE , 'length', self::MODEL_BOTH),
    );

    protected $_auto = array(
        array('reply_model', 'arr2str', self::MODEL_BOTH, 'function'),
        array('reply_model', null, self::MODEL_BOTH, 'ignore'),
        array('extend', 'json_encode', self::MODEL_BOTH, 'function'),
        array('extend', null, self::MODEL_BOTH, 'ignore'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_BOTH),
    );


    /**
     * 获取分类详细信息
     * @param  milit   $id 分类ID或标识
     * @param  boolean $field 查询字段
     * @return array     分类信息
     * @author Jroy
     */
    public function info($id, $field = true){
        /* 获取分类信息 */
        $map = array();
        if(is_numeric($id)){ //通过ID查询
            $map['id'] = $id;
        } else { //通过标识查询
            $map['name'] = $id;
        }
        $info = $this->field($field)->where($map)->find();
        //拓展表中的内容
        $info2 = M('CategoryContent')->where("id=$id")->find();
        if($info2){
            $info = array_merge($info2,$info);
        }
        return $info;
    }

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
        $map  = array('status' => array('gt', -1));
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
        $cate_content_obj = M('CategoryContent');
        $data_content = $cate_content_obj->create();
        $data_content['content'] = htmlentities($data_content['content']);
        /* 添加或更新数据 */
        if(empty($data['id'])){
            $res = $this->add();
            $data_content['id'] = $res;
            $res_content = $cate_content_obj->add($data_content);
        }else{
            $res = $this->save();
            $res_content = $cate_content_obj->save($data_content);
        }

        //更新url
        $this->updateUrl($data,$res);
        //更新分类缓存
        S('sys_category_list', null);
        //记录行为
        action_log('update_category', 'category', $data['id'] ? $data['id'] : $res, UID);

        return $res;
    }
    /**
     * 查询后解析扩展信息
     * @param  array $data 分类数据
     * @author Jroy
     */
    protected function _after_find(&$data, $options){
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
     * 获取自定义分类树
     * @param  integer $id    分类ID
     * @param  boolean $field 查询字段
     * @return array          分类树
     * @author Jroy
     */
    public function getLevelTree($id = 0, $field = true){
        $tree = new \Org\Util\Tree;
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $result = $this->order(array("sort"=>"asc",'id'=>'asc'))->select();

        foreach ($result as $r) {
            $r['str_manage'] = '<a href="' . U("article/mydocument", array("cate_id" => $r['id'],"model_id"=>$r['model'])) . '">内容</a> | <a href="' . U("category/add", array("pid" => $r['id'])) . '">添加子分类</a> | <a href="' . U("category/edit", array("id" => $r['id'])) . '">修改</a> | <a class="confirm J_ajax_get" href="' . U("category/remove", array("id" => $r['id'])) . '">删除</a> | <a href="' . U("category/operate", array("type"=>"move","from" => $r['id'])) . '">移动</a> | <a href="' . U("category/operate", array("type"=>"merge","from" => $r['id'])) . '">合并</a>';
            $r['id']=$r['id'];
            $r['parentid']=$r['pid'];
            $r['name']=$r['title'];
            $r['listorder'] = $r['sort'];
            $r['display'] = ($r['display']!=0)?'显示':'<span class=grey>隐藏</span>';
            $r['model'] = D('model')->getModelName($r['model']);

            $type = C('DOCUMENT_MODEL_TYPE');
            $r['type'] = $type[$r['type']];
            $array[] = $r;
        }
        $tree->init($array);
        $str = "<tr data-parentid='\$parentid' data-id='\$id'>
                    <td><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input input-xsmall'></td>
                    <td>\$id</td>
                    <td>\$spacer\$name</td>
                    <td>\$model</td>
                    <td>\$type</td>
                    <td>\$display</td>
                    <td>\$str_manage</td>
                </tr>";
        return $tree->get_tree(0, $str);
    }

    /**
     * 获取option分类
     * @param  integer $id    分类ID
     * @param  boolean $field 查询字段
     * @return array          分类树
     * @author Jroy
     */
    public function getCategory()
    {
        $tree = new \Org\Util\Tree;
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $result = $this->order(array("sort"=>"asc"))->select();

        $cid = $_GET['pid']?$_GET['pid']:session('admin_category_id');
        foreach ($result as $r) {
            $r['id']=$r['id'];
            $r['parentid']=$r['pid'];
            $r['name']=$r['title'];
            $r['listorder'] = $r['sort'];
            $r['selected'] = (strcmp($r['id'], $cid) == 0)?"selected=selected":"";
            $array[] = $r;
        }
        $tree->init($array);
        $str = "<option value='\$id' \$selected>\$spacer\$name</option>";
        return $tree->get_tree(0, $str);
    }

    /*
    * 更新url
    * @param $data 更新数据
    * @param $Res  操作句柄
    * return none 
    */
    public function updateUrl($data,$res)
    {
        $url_obj = M('Url');
        $add = false;
        if(!$data['id']){
            $data['cid'] = $res;
            $add = true;
        }else{
            $data['cid'] = $data['id'];
        }
        unset($data['id']);
        $data['short'] = $data['name'];
        $data['url'] = get_cate_url($data['cid']);
        $data = $url_obj->create($data);
        
        if($add){
            $res = $url_obj->add($data);
        }else{
            $res = $url_obj->where("cid=$data[cid]")->save($data);
        }
    }
}
