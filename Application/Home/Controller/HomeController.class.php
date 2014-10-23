<?php

// +----------------------------------------------------------------------
// | Author: Jroy 
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends Controller {

	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect('Index/index');
	}


    protected function _initialize(){
        /* 读取站点配置和rewrite信息 */
        $config = api('Config/lists');
        C($config); //添加配置
        //加载rewrite
        //$this->loadRewrite();

        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }
    }

	/* 用户登录检测 */
	protected function login(){
		/* 用户登录检测 */
		is_login() || $this->error('您还没有登录，请先登录！', U('User/login'));
	}

	protected function loadRewrite(){
		//加载rewrite信息
        $url = M('Url')->where($map)->field('url,short')->select();
        foreach ($url as $v) {
            $rewrite[$v['short']] = $v['url'];
        }
        $rewrite_config = array('URL_ROUTE_RULES'=>$rewrite);
        $config_file = APP_PATH.'\Home\conf\config.php';
        $this->sp_set_config($config_file,$rewrite_config);
    }

    /*
	 * 作用：修改配置文件
	 * 参数: $file, string, 配置文件文职
	 *       $config_array, array, 需要修改的参数
	 */
	function sp_set_config($file,$config_array){
		if (is_writable($file)) {
			$config = require $file;
			$config_content = array_merge($config, $config_array);
			file_put_contents($file, "<?php \nreturn " . stripslashes(var_export($config_content, true)) . ";", LOCK_EX);
		}
	}
}
