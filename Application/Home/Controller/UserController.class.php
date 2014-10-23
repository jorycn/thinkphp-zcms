<?php

// +----------------------------------------------------------------------
// | Author: Jroy 
// +----------------------------------------------------------------------

namespace Home\Controller;
use User\Api\UserApi;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class UserController extends HomeController {

	/* 用户中心首页 */
	public function index(){
		
	}

	/* 注册页面 */
	public function register($username = '', $password = '', $repassword = '', $email = '', $verify = ''){
        if(!C('USER_ALLOW_REGISTER')){
            $this->error('注册已关闭');
        }
		if(IS_POST){ //注册用户
			/* 检测验证码 */
			if(!check_verify($verify)){
				$this->error('验证码输入错误！');
			}

			/* 检测密码 */
			if($password != $repassword){
				$this->error('密码和重复密码不一致！');
			}			

			/* 调用注册接口注册用户 */
            $User = new UserApi;
			$uid = $User->register($username, $password, $email);
			if(0 < $uid){ //注册成功
				//TODO: 发送验证邮件
				$this->success('注册成功！',U('login'));
			} else { //注册失败，显示错误信息
				$this->error($this->showRegError($uid));
			}

		} else { //显示注册表单
			$this->display();
		}
	}

	/* 登录页面 */
	public function login($username = '', $password = '', $verify = ''){
		if(IS_POST){ //登录验证
			/* 检测验证码 */
			if(!check_verify($verify)){
				$this->error('验证码输入错误！');
			}

			/* 调用UC登录接口登录 */
			$user = new UserApi;
			$uid = $user->login($username, $password);
			if(0 < $uid){ //UC登录成功
				/* 登录用户 */
				$Member = D('Member');
				if($Member->login($uid)){ //登录用户
					//TODO:跳转到登录前页面
					$this->success('登录成功！',U('Home/Index/index'));
				} else {
					$this->error($Member->getError());
				}

			} else { //登录失败
				switch($uid) {
					case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
					case -2: $error = '密码错误！'; break;
					default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
				}
				$this->error($error);
			}

		} else { //显示登录表单
			$this->display();
		}
	}

	/* 退出登录 */
	public function logout(){
		if(is_login()){
			D('Member')->logout();
			$this->success('退出成功！', U('User/login'));
		} else {
			$this->redirect('User/login');
		}
	}

	/* 验证码，用于登录和注册 */
	public function verify(){
		$verify = new \Think\Verify();
		$verify->entry(1);
	}

	/**
	 * 获取用户注册错误信息
	 * @param  integer $code 错误编码
	 * @return string        错误信息
	 */
	private function showRegError($code = 0){
		switch ($code) {
			case -1:  $error = '用户名长度必须在16个字符以内！'; break;
			case -2:  $error = '用户名被禁止注册！'; break;
			case -3:  $error = '用户名被占用！'; break;
			case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
			case -5:  $error = '邮箱格式不正确！'; break;
			case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
			case -7:  $error = '邮箱被禁止注册！'; break;
			case -8:  $error = '邮箱被占用！'; break;
			case -9:  $error = '手机格式不正确！'; break;
			case -10: $error = '手机被禁止注册！'; break;
			case -11: $error = '手机号被占用！'; break;
			default:  $error = '未知错误';
		}
		return $error;
	}


    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function profile(){
		if ( !is_login() ) {
			$this->error( '您还没有登陆',U('User/login') );
		}
        if ( IS_POST ) {
            //获取参数
            $uid        =   is_login();
            $password   =   I('post.old');
            $repassword = I('post.repassword');
            $data['password'] = I('post.password');
            empty($password) && $this->error('请输入原密码');
            empty($data['password']) && $this->error('请输入新密码');
            empty($repassword) && $this->error('请输入确认密码');

            if($data['password'] !== $repassword){
                $this->error('您输入的新密码与确认密码不一致');
            }

            $Api = new UserApi();
            $res = $Api->updateInfo($uid, $password, $data);
            if($res['status']){
                $this->success('修改密码成功！');
            }else{
                $this->error($res['info']);
            }
        }else{
            $this->display();
        }
    }

    /*
	*用户中心
    */
    public function center()
    {
    	$this->display();
    }

    public function address()
    {
    	$user = session('user_auth');
    	if(IS_POST){
    		$address_obj = M('address');
	        $rules = array(
	            array('email','email','请输入正确的邮箱地址'),
	            array('email','require','请输入邮箱地址'),
	            array('country','require','请输入国家'),
	            array('province','require','请输入省会'),
	            array('district','require','请输入县市'),
	            array('zipcode','require','请输入邮政编码'),
	        );
	        if(!$address_obj->validate($rules)->auto($auto_rule)->create()){
	        	$this->error($address_obj->getError());
	        }else{
	        	$address = I('post.');
	        	if(!$address['id']){
	        		$address['create_time'] = time();
	        		$address['uid'] = $user['uid'];
	        		$res = $address_obj->add($address);
	        		//更新用户真实姓名
	        		M('Member')->where('uid='.$user['uid'])->save(array('name'=>$address['name']));   	
	        	}else{
	        		$res =$address_obj->where('id='.$address['id'])->save();
	        	}
	        }
    		if(!$res){
    			$this->error('地址操作错误');
    		}else{
    			$this->success('地址操作成功');
    		}
    	}else{
    		$id = I('get.id');
    		if($id){
    			$address = M('address')->find($id);
    			$this->assign('address',$address);
    		}
    		$lists = M('address')->where('uid='.$user['uid'])->select();
    		$address = D('Member')->info($user['uid'],'address');
    		$this->assign('address',$address);
    		$this->assign('lists',$lists);

    		$this->display();
    	}
    }

    public function deleteAddress()
    {	
    	$user = session('user_auth');
    	$id = I('get.id');
    	if(!$id){
    		$this->error('参数错误');
    	}
    	$res = M('address')->delete($id);
    	//删除用户地址信息
    	$user_res = M('Member')->where('uid='.$user['id'])->save('address=0');
    	if(!$res){
    		$this->error('地址删除失败!');
    	}else{
    		$this->success('地址删除成功!');
    	}
    }

    public function addSet()
    {
    	$user = session('user_auth');
    	$id = I('get.id');
    	if(!$id){
    		$this->error('参数错误');
    	}
    	$res = M('Member')->where('uid='.$user['uid'])->save(array('address'=>$id));

    	if($res !== false){
    		$this->success('设置成功!');
    	}else{
    		$this->error('设置失败!');
    	}
    }
}
