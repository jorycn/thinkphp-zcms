<?php
namespace Shop\Model;

/**
 * 文档基础模型
 */
class ShopOrdersModel extends ShopModel{
    protected $shopping_cart;

    public function _initialize()
    {
        $this->shopping_cart = session('shop_cart');
    }
    /* 自动验证规则 */
    protected $_validate = array(
        array('address', 'require', '请填写送货地址'),
        array('shipping', 'require', '请选择货运方式'),
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('address', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
        array('create_time', 'time', self::MODEL_BOTH,'function'),
        array('ip', 'get_client_ip', self::MODEL_BOTH,'function'),
        array('status', 1, self::MODEL_INSERT),
    );

    /**
     * 获取文档列表
     * @param  integer  $category 分类ID
     * @param  string   $order    排序规则
     * @param  integer  $status   状态
     * @param  boolean  $count    是否返回总数
     * @param  string   $field    字段 true-所有字段
     * @param  string   $limit    分页参数
     * @param  array    $map      查询条件参数
     * @return array              文档列表
     * @author huajie <banhuajie@163.com>
     */
    public function lists($uid, $order = '`id` DESC', $status = 1, $field = true, $limit = '10', $map = array()){
        if($status){
            $map = array_merge($this->listMap($uid, $status), $map);
        }else{
            $map = array_merge($this->listMap($uid), $map);
        }
        return $this->field($field)->where($map)->order($order)->limit($limit)->select();
    }

    public function info(){
        /* 获取基础数据 */
        $order = $this->find($id);

        $info['user'] = D('Admin/Member')->info($order['uid']);
        //商品列表
        $map['id'] = array('in',explode(',', $order['product']));
        $info['product'] = D('Shop/ShopProduct')->lists('','','','','',$map);

        //货运信息
        $info['shipping'] = D('Shop/ShopShipping')->info($order['shipping']);
        $order['globalTotal'] = is_null($shipping)?$order['price']:$order['price']+$shipping['price'];
        $info['order'] = $order;
        return $info;
    }
    /**
     * 获取详情页数据
     * @param  integer $id 文档ID
     * @return array       详细数据
     */
    public function detail($id,$field=true){
        return $this->field($field)->find($id);
    }
    /**
     * 新增或更新一个文档
     * @param array  $data 手动传入的数据
     * @return boolean fasle 失败 ， int  成功 返回完整的数据
     * @author huajie <banhuajie@163.com>
     */
    public function update($data = null){
        /* 获取数据对象 */
        $data = $this->create($data);
        if(empty($data)){
            return false;
        }

        /* 添加或新增基础内容 */
        if(empty($data['id'])){ //新增数据
            $id = $this->add(); //添加基础内容
            if(!$id){
                $this->error = '新增基础内容出错！';
                return false;
            }
        } else { //更新数据
            $status = $this->save(); //更新基础内容
            if(false === $status){
                $this->error = '更新基础内容出错！';
                return false;
            }
        }
        //行为记录
        if($id){
            action_log('update_shipping', 'shipping', $id, UID);
        }

        //内容添加或更新完成
        return $data;
    }

    public function delete()
    {
        $ids    =   I('request.ids');
        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }
        $map['id'] = array('in',$ids);
        if(M('ShopOrders')->where($map)->delete()!==false){
            $this->success = '删除成功!';
            return true;
        }else{
            $this->error = '删除失败!';
            return false;
        }   
    }

    /**
     * 设置where查询条件
     * @param  number  $category 分类ID
     * @param  number  $pos      推荐位
     * @param  integer $status   状态
     * @return array             查询条件
     */
    private function listMap($uid, $status = '', $pos = null){
        /* 设置状态 */
        if($status){
            $map = array('status' => $status);
        }
        
        /* 设置分类 */
        if(!is_null($uid)){
            if(is_numeric($uid)){
                $map['uid'] = $uid;
            } else {
                $map['uid'] = array('in', str2arr($uid));
            }
        }
        /* 设置推荐位 */
        if(is_numeric($pos)){
            $map[] = "position & {$pos} = {$pos}";
        }
        return $map;
    }

    /**
     * 添加订单
     * @return bool
     */
    public function makeOrder()
    {
        $data = $this->create();
        $user = session('user_auth');
        if(empty($data)){
            return false;
        }
        if(!$user){
            $this->error = '系统错误!';
            return false;
        }
        $data['product'] = $this->_get_product();
        $data['mrsp'] = $this->_get_sum('mrsp'); //订单市场总价
        $data['price'] = $this->_get_sum('price'); //订单现价总价
        $data['cartcount'] = count($this->shopping_cart);
        $data['oid'] = $this->_get_order_sn();
        $data['uid'] = $user['uid'];
        $data['total'] = $data['price']+$this->_get_shipping_price($data['shipping']);
        
        if($this->add($data) !== false){
            session('shop_cart',null);
            $this->success = '下单成功';
        }else{
            $this->error = '下单失败';
        }

    }

    protected function _get_product()
    {
        $product = array_keys($this->shopping_cart);
        return implode(',', $product);
    }
    protected function _get_sum($key)
    {
        $sum_array = array_column($this->shopping_cart,$key);
        return array_sum($sum_array);
    }

    protected function _get_order_sn()
    {
        $user = session('user_auth');
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J','K','L','M','N');
        $orderSn = $yCode[intval(date('m'))-1]; //月份
        $rand = strtoupper(dechex(date('d'))) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99)).$user['uid'];
        return $orderSn.$rand;
    }

    protected function _get_shipping_price($id)
    {
        $price = D('Shop/ShopShipping')->info($id,'price');
        return $price['price'];
    }
}
