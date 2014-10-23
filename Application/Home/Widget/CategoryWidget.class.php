<?php

// +----------------------------------------------------------------------
// | Author: Jroy 
// +----------------------------------------------------------------------

namespace Home\Widget;
use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */

class CategoryWidget extends Action{
	
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($cate, $child = false, $display = ''){
		$field = 'id,name,pid,title,link_id,type,url,model';

		if($child){
			$category = D('Category')->getTree($cate, $field);
			$category = $category['_'];
		} else {
			$category = D('Category')->getSameLevel($cate, $field);
		}

		if(!$display){
			$tpl = 'Widget/menu';
		}else{
			$tpl = $display;
		}

		$this->assign('category', $category);
		$this->display($tpl);
	}
}
