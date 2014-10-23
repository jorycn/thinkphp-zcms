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

class BreadcrumbWidget extends Action{
	
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($cate,$title = ''){
		$cate = D('Category')->getCrumb($cate);
		$crumb = array_reverse($cate);
		foreach ($crumb as $v) {
			$str .= "　=>　<a href='".$v['url']."'>".$v['title']."</a>";
		}
		if($title){
			$bradCrumb = "<a href='".U('index/index')."'>首页</a>".$str."　=>　".$title;
		}else{
			$bradCrumb = "<a href='".U('index/index')."'>首页</a>".$str;
		}
		$this->show($bradCrumb);
	}
	
}
