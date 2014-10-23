<?php

// +----------------------------------------------------------------------
// | Author: Jroy 
// +----------------------------------------------------------------------

namespace Admin\Logic;

/**
 * 文档模型子模型 - 文章模型
 */
class ArticleLogic extends BaseLogic{
	/* 自动验证规则 */
	protected $_validate = array(
		array('content', 'getContent', '内容不能为空！', self::MUST_VALIDATE , 'callback', self::MODEL_BOTH),
	);

	/* 自动完成规则 */
	protected $_auto = array();

	/**
	 * 新增或添加一条文章详情
	 * @param  number $id 文章ID
	 * @return boolean    true-操作成功，false-操作失败
	 * @author Jroy
	 */
	public function update($id = null,$info = null){
		/* 获取文章数据 */
		$data = $info?$info:$this->create();
		if($data === false){
			return false;
		}
		foreach ($data as $k=>$v) {
			if(is_array($v)){
				$data[$k] = implode(',', $v);
			}
		}
		/* 添加或更新数据 */
		if(empty($data['id'])){//新增数据
			$data['id'] = $id;
			$id = $this->add($data);
			if(!$id){
				$this->error = '新增详细内容失败！';
				return false;
			}
		} else { //更新数据
			$status = $this->save($data);
			if(false === $status){
				$this->error = '更新详细内容失败！';
				return false;
			}
		}

		return true;
	}

	/**
	 * 获取文章的详细内容
	 * @return boolean
	 * @author huajie <banhuajie@163.com>
	 */
	protected function getContent(){
		$type = I('post.type');
		$content = I('post.content');
		if($type > 1){	//主题和段落必须有内容
			if(empty($content)){
				return false;
			}
		}else{			//目录没内容则生成空字符串
			if(empty($content)){
				$_POST['content'] = ' ';
			}
		}
		return true;
	}
}
