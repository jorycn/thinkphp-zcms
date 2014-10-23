<?php

// +----------------------------------------------------------------------
// | Author: Jroy 
// +----------------------------------------------------------------------

/**
 * 前台公共库文件
 * 主要定义前台公共函数库
 */

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
 * 获取列表总行数
 * @param  string  $category 分类ID
 * @param  integer $status   数据状态
 * @author Jroy
 */
function get_list_count($category, $status = 1){
    static $count;
    if(!isset($count[$category])){
        $count[$category] = D('Document')->listCount($category, $status);
    }
    return $count[$category];
}

/**
 * 获取段落总数
 * @param  string $id 文档ID
 * @return integer    段落总数
 * @author Jroy
 */
function get_part_count($id){
    static $count;
    if(!isset($count[$id])){
        $count[$id] = D('Document')->partCount($id);
    }
    return $count[$id];
}

/**
 * 获取导航URL
 * @param  string $url 导航URL
 * @return string      解析或的url
 * @author Jroy
 */
function get_nav_url($url){
    switch ($url) {
        case 'http://' === substr($url, 0, 7):
        case '#' === substr($url, 0, 1):
            break;        
        default:
            $url = U($url);
            break;
    }
    return $url;
}
// 获取数据的状态操作
function show_status_op($status) {
    switch ($status){
        case 0  : return    '禁用';     break;
        case 1  : return    '启用';     break;
        case 2  : return    '审核';       break;
        default : return    false;      break;
    }
}
//获取栏目名称
function get_shopcategory_name($catid){
    $info = D('shopCatalog')->info($catid,'title');
    return $info['title'];
}
function get_user_name($uid)
{   
    $info = D('Admin/member')->info($uid,'nickname');
    return $info['nickname'];
}
function get_shipping_name($id)
{   
    $info = D('ShopShipping')->info($id,'name');
    return $info['name'];
}

function get_datetime($time)
{
    return date('Y-m-d H:i',$time);
}
