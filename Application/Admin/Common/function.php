<?php

// +----------------------------------------------------------------------
// | Author: Jroy 
// +----------------------------------------------------------------------

/**
 * 后台公共文件
 * 主要定义后台公共函数库
 */

/* 解析列表定义规则*/

function get_list_field($data, $grid,$model){

	// 获取当前字段数据
    foreach($grid['field'] as $field){
        $array  =   explode('|',$field);
        $temp  =	$data[$array[0]];
        // 函数支持
        if(isset($array[1])){
            $temp = call_user_func($array[1], $temp);
        }
        $data2[$array[0]]    =   $temp;
    }
    if(!empty($grid['format'])){
        $value  =   preg_replace_callback('/\[([a-z_]+)\]/', function($match) use($data2){return $data2[$match[1]];}, $grid['format']);
    }else{
        $value  =   implode(' ',$data2);
    }

	// 链接支持
	if(!empty($grid['href'])){
		$links  =   explode(',',$grid['href']);
        foreach($links as $link){
            $array  =   explode('|',$link);
            $href   =   $array[0];
            if(preg_match('/^\[([a-z_]+)\]$/',$href,$matches)){
                $val[]  =   $data2[$matches[1]];
            }else{
                $show   =   isset($array[1])?$array[1]:$value;
                // 替换系统特殊字符串
                $href	=	str_replace(
                    array('[DELETE]','[EDIT]','[MODEL]'),
                    array('del?ids=[id]&model=[MODEL]','edit?id=[id]&model=[MODEL]',$model['id']),
                    $href);

                // 替换数据变量
                $href	=	preg_replace_callback('/\[([a-z_]+)\]/', function($match) use($data){return $data[$match[1]];}, $href);

                $val[]	=	'<a href="'.U($href).'">'.$show.'</a>';
            }
        }
        $value  =   implode(' ',$val);
	}
    return $value;
}



// 获取属性类型信息
function get_attribute_type($type=''){
    // TODO 可以加入系统配置
    static $_type = array(
        'num'       =>  array('数字','int(10) UNSIGNED NOT NULL'),
        'string'    =>  array('字符串','varchar(255) NOT NULL'),
        'textarea'  =>  array('文本框','text NOT NULL'),
        'datetime'  =>  array('时间','int(10) NOT NULL'),
        'bool'      =>  array('布尔','tinyint(2) NOT NULL'),
        'select'    =>  array('枚举','char(50) NOT NULL'),
    	'radio'		=>	array('单选','char(10) NOT NULL'),
    	'checkbox'	=>	array('多选','varchar(100) NOT NULL'),
    	'editor'    =>  array('编辑器','text NOT NULL'),
    	'picture'   =>  array('上传图片','int(10) UNSIGNED NOT NULL'),
    	'file'    	=>  array('上传附件','int(10) UNSIGNED NOT NULL'),
        'gallery'   =>  array('多图上传','varchar(100) NOT NULL'),
        'array'  =>  array('相关','varchar(225) NOT NULL'),
    );
    return $type?$_type[$type][0]:$_type;
}

/**
 * 获取对应状态的文字信息
 * @param int $status
 * @return string 状态文字 ，false 未获取到
 * @author huajie <banhuajie@163.com>
 */
function get_status_title($status = null){
    if(!isset($status)){
        return false;
    }
    switch ($status){
        case -1 : return    '已删除';   break;
        case 0  : return    '<font color=red>禁用</font>';     break;
        case 1  : return    '<font color=green>正常</font>';     break;
        case 2  : return    '待审核';   break;
        default : return    false;      break;
    }
}

// 获取数据的状态操作
function show_status_op($status) {
    switch ($status){
        case 0  : return    '启用';     break;
        case 1  : return    '禁用';     break;
        case 2  : return    '审核';		break;
        default : return    false;      break;
    }
}


/**
 * 获取配置的类型
 * @param string $type 配置类型
 * @return string
 */
function get_config_type($type=0){
    $list = C('CONFIG_TYPE_LIST');
    return $list[$type];
}

/**
 * 获取配置的分组
 * @param string $group 配置分组
 * @return string
 */
function get_config_group($group=0){
    $list = C('CONFIG_GROUP_LIST');
    return $group?$list[$group]:'';
}

/**
 * select返回的数组进行整数映射转换
 *
 * @param array $map  映射关系二维数组  array(
 *                                          '字段名1'=>array(映射关系数组),
 *                                          '字段名2'=>array(映射关系数组),
 *                                           ......
 *                                       )
 * @author 朱亚杰 <zhuyajie@topthink.net>
 * @return array
 *
 *  array(
 *      array('id'=>1,'title'=>'标题','status'=>'1','status_text'=>'正常')
 *      ....
 *  )
 *
 */
function int_to_string(&$data,$map=array('status'=>array(1=>'正常',-1=>'删除',0=>'禁用',2=>'未审核',3=>'草稿'))) {
    if($data === false || $data === null ){
        return $data;
    }
    $data = (array)$data;
    foreach ($data as $key => $row){
        foreach ($map as $col=>$pair){
            if(isset($row[$col]) && isset($pair[$row[$col]])){
                $data[$key][$col.'_text'] = $pair[$row[$col]];
            }
        }
    }
    return $data;
}

/**
 * 动态扩展左侧菜单,base.html里用到
 * @author 朱亚杰 <zhuyajie@topthink.net>
 */
function extra_menu($extra_menu,&$base_menu){
    foreach ($extra_menu as $key=>$group){
        if( isset($base_menu['child'][$key]) ){
            $base_menu['child'][$key] = array_merge( $base_menu['child'][$key], $group);
        }else{
            $base_menu['child'][$key] = $group;
        }
    }
}



/**
 * 获取参数的所有父级分类
 * @param int $cid 分类id
 * @return array 参数分类和父类的信息集合
 * @author huajie <banhuajie@163.com>
 */
function get_parent_category($cid){
    if(empty($cid)){
        return false;
    }
    $cates  =   M('Category')->where(array('status'=>1))->field('id,title,pid')->order('sort')->select();
    $child  =   get_category($cid);	//获取参数分类的信息
    $pid    =   $child['pid'];
    $temp   =   array();
    $res[]  =   $child;
    while(true){
        foreach ($cates as $key=>$cate){
            if($cate['id'] == $pid){
                $pid = $cate['pid'];
                array_unshift($res, $cate);	//将父分类插入到数组第一个元素前
            }
        }
        if($pid == 0){
            break;
        }
    }
    return $res;
}

/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author Jroy
 */
function check_verify($code, $id = 1){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}



/**
 * 获取当前文档的分类
 * @param int $id
 * @return array 文档类型数组
 * @author huajie <banhuajie@163.com>
 */
function get_cate($cate_id = null){
    if(empty($cate_id)){
        return false;
    }
    $cate   =   M('Category')->where('id='.$cate_id)->getField('title');
    return $cate;
}



// 获取子文档数目
function get_subdocument_count($id=0){
    return  M('Document')->where('pid='.$id)->count();
}

/**
 * 获取行为数据
 * @param string $id 行为id
 * @param string $field 需要获取的字段
 * @author huajie <banhuajie@163.com>
 */
function get_action($id = null, $field = null){
	if(empty($id) && !is_numeric($id)){
		return false;
	}
	$list = S('action_list');
	if(empty($list[$id])){
		$map = array('status'=>array('gt', -1), 'id'=>$id);
		$list[$id] = M('Action')->where($map)->field(true)->find();
	}
	return empty($field) ? $list[$id] : $list[$id][$field];
}

/**
 * 根据条件字段获取数据
 * @param mixed $value 条件，可用常量或者数组
 * @param string $condition 条件字段
 * @param string $field 需要返回的字段，不传则返回整个数据
 * @author huajie <banhuajie@163.com>
 */
function get_document_field($value = null, $condition = 'id', $field = null){
	if(empty($value)){
		return false;
	}

	//拼接参数
	$map[$condition] = $value;
	$info = M('Model')->where($map);
	if(empty($field)){
		$info = $info->field(true)->find();
	}else{
		$info = $info->getField($field);
	}
	return $info;
}

/**
 * 获取行为类型
 * @param intger $type 类型
 * @param bool $all 是否返回全部类型
 * @author huajie <banhuajie@163.com>
 */
function get_action_type($type, $all = false){
	$list = array(
		1=>'系统',
		2=>'用户',
	);
	if($all){
		return $list;
	}
	return $list[$type];
}
/**
 * 清空缓存
 */
function sp_clear_cache(){
    import ( "Org.Util.Dir" );
    $dirs = array ();
    // runtime/
    $rootdirs = scandir ( RUNTIME_PATH );
    //$noneed_clear=array(".","..","Data");
    $noneed_clear=array(".","..");
    $rootdirs=array_diff($rootdirs, $noneed_clear);
    foreach ( $rootdirs as $dir ) {
        if ($dir != "." && $dir != "..") {
            $dir = RUNTIME_PATH . $dir;
            if (is_dir ( $dir )) {
                array_push ( $dirs, $dir );
                $tmprootdirs = scandir ( $dir );
                foreach ( $tmprootdirs as $tdir ) {
                    if ($tdir != "." && $tdir != "..") {
                        $tdir = $dir . '/' . $tdir;
                        if (is_dir ( $tdir )) {
                            array_push ( $dirs, $tdir );
                        }
                    }
                }
            }else{
                @unlink($dir);
            }
        }
    }
    $dirtool=new \Org\Util\Dir;
    foreach ( $dirs as $dir ) {
        $dirtool->del ( $dir );
    }
    return true;
}
/**
 * 获取文档模型信息
 * @param  integer $id    模型ID
 * @param  string  $field 模型字段
 * @return array
 */
function get_document_model($id = null, $field = null){
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
        $map   = array('status' => 1,'id'=>array('gt','1'));
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

//获取友情链接分组title
function get_flink_group($id){
    $info = M('flink_group')->find($id);
    return $info['title'];
}

function get_config($name)
{   
    $map['name'] = $name;
    $res = M('config')->field('id,name,value')->where($map)->find();
    return $res['value'];
}
/**
 * 获取首页的模板
 * param string $tpl 栏目分类：category/list/show
 * @return array
 */
function get_template($template = 'category'){
    $template_path=APP_PATH.C('HOME_TPL')."/Article/";
    $files=scandir($template_path);
    $tpl_files=array();
    foreach ($files as $f){
        if($f!="." || $f!=".."){
            if(is_file($template_path.$f)){
                $suffix=C("TMPL_TEMPLATE_SUFFIX");
                $result=0;
                $result=preg_match("/^$template/", $f);
                if($result){
                    $tpl=str_replace($suffix, "", $f);
                    $tpl_files[$tpl]=$f;
                }
            }
        }
    }
    return $tpl_files;
}

/**
 * 获取父栏目的模型
 * param int $pid
 * @return int
 */
function get_parent_model($pid = 0){
    $model = M('Category')->field('model')->where("id=$pid")->find();
    return $model?$model['model']:0;
}

/**
 * 获取模型名称
 * param int $pid
 * @return int
 */
function get_model_title($model_id = 1){
    $model = M('Model')->field('title')->where("id=$model_id")->find();
    return $model['title'];
}
/**
 * 获取文档的类型文字
 * @param string $type
 * @return string 状态文字 ，false 未获取到
 * @author huajie <banhuajie@163.com>
 */
function get_document_type($type = null){
    if(!isset($type)){
        return false;
    }
    switch ($type){
        case 1  : return    '目录'; break;
        case 2  : return    '主题'; break;
        case 3  : return    '段落'; break;
        default : return    false;  break;
    }
}