<?php
namespace Admin\Controller;

class MessageController extends AdminController{
	protected $obj_msg;
	protected $obj_msg_reply;
	
	function _initialize() {
		parent::_initialize();
		$this->obj_msg=M('message');
		$this->obj_msg_reply=M('message_reply');
	}
	/*
	*list the message
	*/
	function index()
	{
		$this->_list();
		$this->display();
	}

	protected function _list()
	{
		$msg_collection = $this->obj_msg->order('listorder asc,id desc')->select();
		$this->assign('msg',$msg_collection);
	}
	/*
	*留言回复，修改
	*/
	function edit()
	{
		//留言内容
		$msg_id=$_GET['id'];
		$msg_collection = $this->obj_msg->where("id=$msg_id")->find();
		//回复内容
		$msg_reply_collection = $this->obj_msg_reply->where("msg_id=".$msg_id)->find();
		$this->assign('msg',$msg_collection);
		$this->assign('reply',$msg_reply_collection);
		$this->display();
	}
	/*
	*留言删除
	*/
	function delete()
	{
		//留言内容
		if(isset($_GET['id'])){
			$msg_collection = $this->obj_msg->where("id =".$_GET['id'])->delete();
			//回复内容
			if($msg_collection){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
		if(I('request.ids')){
			$tids=join(",",I('request.ids'));
			if ($this->obj_msg->where("id in ($tids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error($this->obj_msg->getlastsql());
				$this->error("删除失败！");
			}
		}
	}
	/*
	*留言回复处理
	*/
	function editPost()
	{
		if (IS_POST) {
			$msg_update = $_POST['msg'];
			$reply_update = $_POST['reply'];
		}
		//留言内容处理
		if($msg_update){
			if(empty($msg_update['date'])){
				$msg_update['date'] = date('Y-m-d h:m:s',time());
			}
			if($reply_update['content']){
				$msg_update['reply']='1';
			}
			$msg_collection = $this->obj_msg->where("id=".$reply_update['msg_id'])->data($msg_update)->save();
		}
		//回复内容处理
		if($reply_update){
			$reply_exist = $this->obj_msg_reply->where("msg_id=".$reply_update['msg_id'])->find();

			if($reply_update['content']){
				$name = session('user_auth');
				$reply_update['rname'] = $name['uid'];
				if(empty($reply_update['date'])){
					$reply_update['date'] = date('Y-m-d h:m:s',time());
				}
			}
			if(!$reply_exist && $reply_update){
				//add
				if($this->obj_msg_reply->add($reply_update)){
					$this->success('留言回复成功');
				}else{
					$this->error('留言回复失败');
				}
			}else{
				//update
				if($this->obj_msg_reply->where("msg_id=".$reply_update['msg_id'])->save($reply_update)!==false){
					$this->success('留言修改成功');
				}else{
					$this->error('留言修改失败！');
				}
			}
		}
	}

	//排序
	public function listorders() {
		$status = parent::listorders($this->obj_msg);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}

	public function setStatus($model='Message'){
        return parent::setStatus('Message');
    }

}