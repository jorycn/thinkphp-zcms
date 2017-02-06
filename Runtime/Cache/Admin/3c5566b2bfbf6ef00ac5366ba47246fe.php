<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>系统后台</title>
        <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge" />
        <meta name="robots" content="noindex,nofollow">
        <link href="/Public/Admin/css/admin_login.css" rel="stylesheet" />
    </head>
<body class="login-wrap">
    <div class="wrap">
        <h1><a href="">ZCMS 后台管理中心</a></h1>
        <form action="<?php echo U('login');?>" method="post" class="login-form">
            <div class="login">
                <ul>
                    <li>
                        <input class="input" id="J_admin_name" required name="username" type="text" placeholder="帐号名" title="帐号名" />
                    </li>
                    <li>
                        <input class="input" id="admin_pwd" type="password" required name="password" placeholder="密码" title="密码" />
                    </li>
                    <li>
                        <div id="J_verify_code">
                            <img class="verifyimg reloadverify" alt="点击切换" src="<?php echo U('Public/verify');?>">
                        </div>
                    </li>
                    <li>
                        <input type="text" name="verify" placeholder="请填写验证码" autocomplete="off">
                        <a class="reloadverify" title="换一张" href="javascript:void(0)">换一张？</a>
                    </li>
                </ul>
                <div id="login_btn_wraper">
                    <button type="submit" name="submit" class="btn btn_submit">登录</button>
                    <div class="check-tips"></div>
                </div>
            </div>
        </form>
    </div>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]-->
    <!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <!--<![endif]-->
    <script type="text/javascript">
        /* 登陆表单获取焦点变色 */
        $(".login-form").on("focus", "input", function(){
            $(this).closest('.item').addClass('focus');
        }).on("blur","input",function(){
            $(this).closest('.item').removeClass('focus');
        });

        //表单提交
        $(document)
            .ajaxStart(function(){
                $("button:submit").addClass("log-in").attr("disabled", true);
            })
            .ajaxStop(function(){
                $("button:submit").removeClass("log-in").attr("disabled", false);
            });

        $("form").submit(function(){
            var self = $(this);
            $.post(self.attr("action"), self.serialize(), success, "json");
            return false;

            function success(data){
                if(data.status){
                    self.find(".check-tips").text('登陆成功');
                    window.location.href = data.url;
                } else {
                    self.find(".check-tips").text(data.info);
                    //刷新验证码
                    $(".reloadverify").click();
                }
            }
        });

        $(function(){
            //初始化选中用户名输入框
            $("#itemBox").find("input[name=username]").focus();
            //刷新验证码
            var verifyimg = $(".verifyimg").attr("src");
            $(".reloadverify").click(function(){
                if( verifyimg.indexOf('?')>0){
                    $(".verifyimg").attr("src", verifyimg+'&random='+Math.random());
                }else{
                    $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                }
            });

            //placeholder兼容性
                //如果支持 
            function isPlaceholer(){
                var input = document.createElement('input');
                return "placeholder" in input;
            }
                //如果不支持
            if(!isPlaceholer()){
                $(".placeholder_copy").css({
                    display:'block'
                })
                $("#itemBox input").keydown(function(){
                    $(this).parents(".item").next(".placeholder_copy").css({
                        display:'none'
                    })                    
                })
                $("#itemBox input").blur(function(){
                    if($(this).val()==""){
                        $(this).parents(".item").next(".placeholder_copy").css({
                            display:'block'
                        })                      
                    }
                })
            }
        });
    </script>
</body>
</html>