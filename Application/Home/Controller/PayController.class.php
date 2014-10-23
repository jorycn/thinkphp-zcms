<?php
namespace Home\Controller;
use Vendor\Alipay\Submit;
/*
* 支付宝接口类
*/
 class PayController extends HomeController{
       //在类初始化方法中，引入相关类库    
    public function _initialize() {
        vendor('Alipay.Corefunction');
        vendor('Alipay.Md5function');
        vendor('Alipay.Notify');
        vendor('Alipay.Submit');

        //支付宝配置参数
        $this->alipay_config = array(
            'partner' =>$this->getConfig('PAY_PARTNER'),   //这里是你在成功申请支付宝接口后获取到的PID；
            'key'=>$this->getConfig('PAY_KEY'),//这里是你在成功申请支付宝接口后获取到的Key
            'sign_type'=>strtoupper('MD5'),
            'input_charset'=> strtolower('utf-8'),
            'cacert'=> getcwd().'\\cacert.pem',
            'transport'=> 'http',
         );
            
        $this->alipay  = array(
             //这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
             'seller_email'=>$this->getConfig('PAY_SELLER_EMAIL'),
             //这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
             'notify_url'=>"U('pay/notifyurl')", 
             //这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
             'return_url'=>"U('pay/returnurl')",
             //支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
             'successpage'=>'User/myorder?ordtype=payed',   
             //支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
             'errorpage'=>'User/myorder?ordtype=unpay', 
         );
    }
    
    //doalipay方法
        /*该方法其实就是将接口文件包下alipayapi.php的内容复制过来
          然后进行相关处理
        */
    public function doalipay(){
        /*********************************************************
            把alipayapi.php中复制过来的如下两段代码去掉，
            第一段是引入配置项，
            第二段是引入submit.class.php这个类。
           为什么要去掉？？
            第一，配置项的内容已经在项目的Config.php文件中进行了配置，我们只需用C函数进行调用即可；
            第二，这里调用的submit.class.php类库我们已经在PayAction的_initialize()中已经引入；所以这里不再需要；
            *****************************************************/
       // require_once("alipay.config.php");
       // require_once("lib/alipay_submit.class.php");
       
       //这里我们通过TP的C函数把配置项参数读出，赋给$alipay_config；
       $alipay_config=$this->alipay_config; 
       $alipay = $this->alipay;
        
        $order = I('post.order');

        /**************************请求参数**************************/
        $payment_type = "1"; //支付类型 //必填，不能修改
        $notify_url = "http://zshop.co".U('pay/notifyurl'); //服务器异步通知页面路径
        $return_url = "http://zshop.co".U('pay/returnurl'); //页面跳转同步通知页面路径
        $seller_email = $alipay['seller_email'];//卖家支付宝帐户必填
        $out_trade_no = $order['trade_no'];//商户订单号 通过支付页面的表单进行传递，注意要唯一！
        $subject = $order['ordsubject'];  //订单名称 //必填 通过支付页面的表单进行传递
        $total_fee = $order['ordtotal_fee'];   //付款金额  //必填 通过支付页面的表单进行传递
        $body = $order['ordbody'];  //订单描述 通过支付页面的表单进行传递
        $show_url = $order['ordshow_url'];  //商品展示地址 通过支付页面的表单进行传递
        $anti_phishing_key = "";//防钓鱼时间戳 //若要使用请调用类文件submit中的query_timestamp函数
        $exter_invoke_ip = get_client_ip(); //客户端的IP地址 
        /************************************************************/

        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipay_config['partner']),
            "payment_type"    => $payment_type,
            "notify_url"    => $notify_url,
            "return_url"    => $return_url,
            "seller_email"    => $seller_email,
            "out_trade_no"    => $out_trade_no,
            "subject"    => $subject,
            "total_fee"    => $total_fee,
            "body"            => $body,
            "show_url"    => $show_url,
            "anti_phishing_key"    => $anti_phishing_key,
            "exter_invoke_ip"    => $exter_invoke_ip,
            "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
        );

        //建立请求
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"post", "确认");
        echo $html_text;
    }
    
        /******************************
        服务器异步通知页面方法
        其实这里就是将notify_url.php文件中的代码复制过来进行处理
        
        *******************************/
    function notifyurl(){
        /*
        同理去掉以下两句代码；
        */ 
        //require_once("alipay.config.php");
        //require_once("lib/alipay_notify.class.php");
        
        //这里还是通过C函数来读取配置项，赋值给$alipay_config
        $alipay_config=$this->alipay_config;
        //计算得出通知验证结果
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if($verify_result) {
               //验证成功
                   //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
           $out_trade_no   = $_POST['out_trade_no'];      //商户订单号
           $trade_no       = $_POST['trade_no'];          //支付宝交易号
           $trade_status   = $_POST['trade_status'];      //交易状态
           $total_fee      = $_POST['total_fee'];         //交易金额
           $notify_id      = $_POST['notify_id'];         //通知校验ID。
           $notify_time    = $_POST['notify_time'];       //通知的发送时间。格式为yyyy-MM-dd HH:mm:ss。
           $buyer_email    = $_POST['buyer_email'];       //买家支付宝帐号；
                   $parameter = array(
             "out_trade_no"     => $out_trade_no, //商户订单编号；
             "trade_no"     => $trade_no,     //支付宝交易号；
             "total_fee"     => $total_fee,    //交易金额；
             "trade_status"     => $trade_status, //交易状态
             "notify_id"     => $notify_id,    //通知校验ID。
             "notify_time"   => $notify_time,  //通知的发送时间。
             "buyer_email"   => $buyer_email,  //买家支付宝帐号；
           );
           if($_POST['trade_status'] == 'TRADE_FINISHED') {
                       //
           }else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
            if(!checkorderstatus($out_trade_no)){
               orderhandle($parameter); 
                           //进行订单处理，并传送从支付宝返回的参数；
               }
            }
                echo "success";        //请不要修改或删除
         }else {
                //验证失败
                echo "fail";
        }    
    }
    
    /*
        页面跳转处理方法；
        这里其实就是将return_url.php这个文件中的代码复制过来，进行处理； 
        */
    function returnurl(){
                //头部的处理跟上面两个方法一样，这里不罗嗦了！
        $alipay_config=$this->alipay_config;
        $alipayNotify = new \AlipayNotify($alipay_config);//计算得出通知验证结果
        $verify_result = $alipayNotify->verifyReturn();
        if($verify_result) {
            //验证成功
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
        $out_trade_no   = $_GET['out_trade_no'];      //商户订单号
        $trade_no       = $_GET['trade_no'];          //支付宝交易号
        $trade_status   = $_GET['trade_status'];      //交易状态
        $total_fee      = $_GET['total_fee'];         //交易金额
        $notify_id      = $_GET['notify_id'];         //通知校验ID。
        $notify_time    = $_GET['notify_time'];       //通知的发送时间。
        $buyer_email    = $_GET['buyer_email'];       //买家支付宝帐号；
            
        $parameter = array(
            "out_trade_no"     => $out_trade_no,      //商户订单编号；
            "trade_no"     => $trade_no,          //支付宝交易号；
            "total_fee"      => $total_fee,         //交易金额；
            "trade_status"     => $trade_status,      //交易状态
            "notify_id"      => $notify_id,         //通知校验ID。
            "notify_time"    => $notify_time,       //通知的发送时间。
            "buyer_email"    => $buyer_email,       //买家支付宝帐号
        );
        
        if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                if(!checkorderstatus($out_trade_no)){
                     orderhandle($parameter);  //进行订单处理，并传送从支付宝返回的参数；
            }
                $this->redirect(C('alipay.successpage'));//跳转到配置项中配置的支付成功页面；
            }else {
                echo "trade_status=".$_GET['trade_status'];
                $this->redirect(C('alipay.errorpage'));//跳转到配置项中配置的支付失败页面；
            }
         }else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            echo "支付失败！";
        }
    }

    public function getConfig($name)
    {
        $map['name'] = $name;
        $config = M('config')->field('id,name,value')->where($map)->find();
        return $config['value'];
    }
 }
