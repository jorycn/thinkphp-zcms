<?php
namespace Home\Controller;

class MessageController extends HomeController{
	
	public function add()
	{
		if(IS_POST){
			$msg=$_POST;
			$data['name']=$msg['name'];
			$data['email']=$msg['email'];
			$data['phone']=$msg['call'];
			$data['ip'] = get_client_ip();
			$data['content']=$msg['content'];
			$data['listorder']='0';
			$data['date']=date('Y-m-d h:m:s',time());

			
			$mssage = M("message");
			$msg_collection=$mssage->add($data);

			if($msg_collection){
				$this->success('留言成功');
			}else{
				$this->error('留言失败，请重试');
			}
		}
	}
	
}