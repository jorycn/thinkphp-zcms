<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo C('WEB_SITE_TITLE');?></title>
<link href="/Public/Home/css/ban.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="/Public/Home/css/bootstrap.css">
<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="/Public/Home/css/bootstrap-theme.min.css">
<link href="/Public/Home/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/Public/Home/css/font-awesome.css" />
<link href="/Public/Home/css/css.css" rel="stylesheet" type="text/css" />
<script src="/Public/Home/js/jquery-1.9.1.js"></script>  
<script  src="/Public/Home/js/jquery.SuperSlide.2.1.js"></script> 
<!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond./Public/Home/js/1.3.0/respond.min.js"></script>
<![endif]-->
</head>

<body id="index">
        <div class="devider"></div>
  
    <div class="container1">
      <div id="content" class="content">
          
    <a href="/admin">admin</a><br/>
    welcome to zcms!

      </div>
    </div>
    
    <script type="text/javascript">
    (function(){
      var ThinkPHP = window.Think = {
        "ROOT"   : "", //当前网站地址
        "APP"    : "", //当前项目地址
        "PUBLIC" : "/Public", //项目公共目录地址
        "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
        "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
        "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
      }
    })();
    </script>
    <script type="text/javascript" src="/Public/static/think.js"></script>
    <script type="text/javascript" src="/Public/Home/js/common.js"></script>
    <!-- 代码end -->
    <script src="/Public/Home/js/youce.js"></script>
    <script type="text/javascript">
        jQuery(".fullSlide").slide({ titCell:".hd ul", mainCell:".bd ul", effect:"topLoop",  autoPlay:true, autoPage:true, trigger:"click" });
    </script>
    
</body>
</html>