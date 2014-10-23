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

function get_global_totals(){
    $shopping_cart = session('shop_cart');
    $subtotal = array_column($shopping_cart,'subTotal');
    session('shop_cart_globalTotals'.array_sum($subtotal));
    return array_sum($subtotal);
}
/**
 * 获取用户信息
 * @param  string $uid 用户id
 * @param  string $colum 想要获取的参数
 * @return string     参数值
 * @author Jroy
 */
function get_user_info($uid,$colum){
    return D('Member')->info($uid,$colum);
}

function get_address_info($id,$colum = ''){
    $address = M('Address')->find($id);
    if(!$colum){
        $add = $address['country']. $address['province'].$address['city'].$address['district'].'·'.$address['address'];
    }else{
        $add = $address[$colum];
    }
    return $add;
}

/*
 * 获取面包屑
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author Jroy
 */
function get_parent_pid($cid) {
    $pid = M('category')->field('id,pid,title,model,url,type')->find($cid);
    return $pid;
}

/*获取栏目内容
 * @param string $cid 栏目id
 * @param string $num 截取字段数
 * @return content
 * @author Jroy
*/
function get_content($cid,$num,$suffix=true){
    $info = M('category')->find($cid);
    $content = htmltotext($info['content']);
    return msubstr($content,0,$num,'utf-8',$suffix);
}

/*html转text*/
function htmltotext($str)
{
     $str = preg_replace("/<sty(.*)\/style>|<scr(.*)\/script>|<!--(.*)-->/isU","",$str);
     $alltext = "";
     $start = 1;
     for($i=0;$i<strlen($str);$i++)
     {
          if($start==0 && $str[$i]==">"){
            $start = 1;
          }else if($start==1){
               if($str[$i]=="<"){
                    $start = 0;
                    $alltext .= " ";
               }else if(ord($str[$i])>31){
                    $alltext .= $str[$i];
               }
          }
     }
     $alltext = str_replace("　"," ",$alltext);
     $alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
     $alltext = preg_replace("/[ ]+/s"," ",$alltext);
     return $alltext;
}

/*获取栏目内容
 * @param string $cid 栏目id
 * @param string $num 获取信息条数
 * @return content
 * @author Jroy
*/
function get_lists($cid,$num){
    $lists = M('Document')->where('category_id='.$cid)->limit($num)->select();
    return $lists;
}
/*获取友情链接
 * @param string $gid 分类
  * @param string $type 友链属性
 * @param string $num 获取信息条数
 * @return lists
 * @author Jroy
*/
function get_flink($gid,$type,$num = 20){
  $map = array(
     'gid' => $gid,
     'type' => $type,
  );
  return M('flink')->where($map)->limit($num)->select();
}
/*获取可下载文件*/
function get_file($id)
{
  $file = M('file')->field('id,savename,savepath,ext')->find($id);
  $conf = C('DOWNLOAD_UPLOAD');
  $conf = substr($conf['rootPath'],1);
  
  return $f = $conf.$file['savepath'].$file['savename'];
}