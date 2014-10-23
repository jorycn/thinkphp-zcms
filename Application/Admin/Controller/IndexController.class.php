<?php

// +----------------------------------------------------------------------
// | Author: Jroy 
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi as UserApi;

/**
 * 后台首页控制器
 * @author Jroy
 */
class IndexController extends AdminController {

    /**
     * 后台首页
     * @author Jroy
     */
    public function index(){
        if(UID){
            $this->meta_title = '管理首页';
            $this->display();
        } else {
            $this->redirect('Public/login');
        }
    }

    //清楚缓存
    public function clean()
    {
        if(sp_clear_cache()){
            $this->success('缓存已清除');
        }else{
            $this->error('缓存清楚失败!');
        }
    }

    public function setKey($cid = null,$title = null)
    {
        if(!$title){
            $this->error('只支持主栏目快捷');
        }
        $url = $_SERVER['HTTP_REFERER'];

        $hotkey = array();
        if(cookie('Admin_hotkey')){
            $hotkey = cookie('Admin_hotkey');
            $hotkey = json_decode($hotkey,true);
            $hotkey[$title] = array(
                'title' => $title,
                'url'   => $url,
            );
            cookie('Admin_hotkey',json_encode($hotkey));
        }else{
            $hotkey[$title] = array(
                'title' => $title,
                'url'   => $url,
            );
            cookie('Admin_hotkey',json_encode($hotkey));
        }
        $this->success('快捷导航添加成功！');
    }

    public function cutKey($title = ''){
        if(!$title){
            $this->error('参数错误');
        }
        $hotkey = json_decode(cookie('Admin_hotkey'),true);
        unset($hotkey[$title]);
        cookie('Admin_hotkey',json_encode($hotkey));
        $this->success('快捷导航已删除');
    }
}
