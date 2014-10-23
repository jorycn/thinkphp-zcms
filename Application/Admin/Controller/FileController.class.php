<?php

// +----------------------------------------------------------------------
// | Author: Jroy 
// +----------------------------------------------------------------------
namespace Admin\Controller;
/**
 * 文件控制器
 * 主要用于下载模型的文件上传和下载
 */
class FileController extends AdminController {

    /* 文件上传 */
    public function upload(){
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
        /* 调用文件上传组件上传文件 */
        $File = D('File');
        $file_driver = C('DOWNLOAD_UPLOAD_DRIVER');
        $info = $File->upload(
            $_FILES,
            C('DOWNLOAD_UPLOAD'),
            C('DOWNLOAD_UPLOAD_DRIVER'),
            C("UPLOAD_{$file_driver}_CONFIG")
        );

        /* 记录附件信息 */
        if($info){
            $return['data'] = think_encrypt(json_encode($info['download']));
            $return['info'] = $info['download']['name'];
        } else {
            $return['status'] = 0;
            $return['info']   = $File->getError();
        }

        /* 返回JSON数据 */
        $this->ajaxReturn($return);
    }

    /* 下载文件 */
    public function download($id = null){
        if(empty($id) || !is_numeric($id)){
            $this->error('参数错误！');
        }

        $logic = D('Download', 'Logic');
        if(!$logic->download($id)){
            $this->error($logic->getError());
        }

    }

    /**
     * 上传图片
     * @author huajie <banhuajie@163.com>
     */
    public function uploadPicture(){
        
        /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');

        /* 调用文件上传组件上传文件 */
        $Picture = D('Picture');
        $pic_driver = C('PICTURE_UPLOAD_DRIVER');
        $info = $Picture->upload(
            $_FILES,
            C('PICTURE_UPLOAD'),
            C('PICTURE_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        ); //TODO:上传到远程服务器

        /* 记录图片信息 */
        if($info){
            $return['status'] = 1;
            $return = array_merge($info['download'], $return);
        } else {
            $return['status'] = 0;
            $return['info']   = $Picture->getError();
        }
        //如果开启水印
        if($config['img_water_on'] == 2){
            /*添加水印*/
            $config['img_water_on'] = get_config('IMG_WATER_ON');
            $config['img_water'] = get_product_image(get_config('IMG_WATER'));
            $config['img_water_postion'] = get_config('IMG_WATER_POSTION');
            $img_path = '.'.$info['download']['path'];

            $image = new \Think\Image();
            $image->open($img_path)->water('.'.$config['img_water'],$config['img_water_postion'])->save($img_path); 
        }
        $this->ajaxReturn($return);
    }

    /*
    * 多图上传删除图片操作
    * @param $id 操作对象id
    * @param $image_id 图片id  
    * @param $model
    */
    public function deletePic($id,$image_id){
        $_obj = D('Document');
        $info = $_obj->detail($id);
        if(!$info){
            $this->error('参数错误，请重试！');
        }
        $gallery = explode(',', $info['gallery']);
        foreach ($gallery as $k=>$v) {
            if($v == $image_id){unset($gallery[$k]);}
        }
        $data['id'] = $id;
        $data['gallery'] = implode(',', $gallery);
        /* 添加或新增扩展内容 */
        $res = M('Document')->save($data);
        if(!$res){
            $this->error($_obj->getError());
        }else{
            $this->success('删除成功', Cookie('__forward__'));
        }
    }
}
