<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh_CN">
<head>
<meta charset="utf-8">
<title><?php if(!empty($meta_title)): echo ($meta_title); ?> -<?php endif; ?>网站后台管理系统</title>
<meta name="description" content="This is page-header (.page-header &gt; h1)">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo C('ADMIN_CSS');?>/reset.css" rel="stylesheet">
<!--[if lt IE 8]>
<link rel="stylesheet" href="/Public/static/fontawesome/css/font-awesome-ie7.min.css">
<!<![endif]-->
<link rel="stylesheet" href="/Public/static/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo C('ADMIN_CSS');?>/ace.min.css">
<link rel="stylesheet" href="<?php echo C('ADMIN_CSS');?>/reset.css">
<link rel="stylesheet" href="<?php echo C('ADMIN_CSS');?>/style.css">

<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
<![endif]--><!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?php echo C('ADMIN_JS');?>/jquery.mousewheel.js"></script>
<!--<![endif]-->
<script type="text/javascript" src="/Public/static/jquery.pin.min.js"></script>

</head>
<body style="" screen_capture_injected="true">
    <?php if($_GET['menuId']){ cookie('menuid',$_GET['menuId']); } ?>
    <div class="navbar">
        <div class="container-fluid navbar-inner">
            <a href="#" class="brand">ZCMS 技术支持</a>
            <div class="user-bar j_user_bar">
                <a href="#" class="dropdown-toggle">
                    <img class="nav-user-photo" src="<?php echo C('ADMIN_IMG');?>/user.jpg" alt="admin">
                    <span class="user-info">
                        <small>欢迎,</small><?php echo session('user_auth.username');?>
                    </span>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="j_user_menu user-menu hidden">
                    <li><a href="<?php echo U('Admin/User/updatePassword');?>"><i class="fa fa-cog"></i>修改密码</a></li>
                    <li><a href="<?php echo U('Admin/User/updateNickname');?>"><i class="fa fa-user"></i>修改昵称</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo U('Admin/Public/logout');?>">退出</a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="main-container container-fluid">
        <a class="menu-toggler" id="menu-toggler"
            href="#">
            <span class="menu-text"></span>
        </a>
        <div class="sidebar" id="sidebar">
            <div class="j_pin">
                <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                        <a class="u-btn-index u-btn-small u-btn-success" href="/" title="前台首页" target="_blank">
                            <i class="fa fa-home"></i>
                        </a>
                        <a class="u-btn-index u-btn-small u-btn-warning" href="<?php echo U('Admin/Category/index?id=80');?>" title="分类管理">
                            <i class="fa fa-sitemap"></i>
                        </a>
                        <a class="u-btn-index u-btn-small u-btn-info" href="<?php echo U('Admin/article/mydocument?id=3');?>" title="文章管理">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a class="u-btn-index u-btn-small u-btn-danger" href="<?php echo U('Admin/index/clean');?>" title="清除缓存">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </div>

                    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                        <span class="u-btn u-btn-success"></span> <span class="u-btn u-btn-info"></span>

                        <span class="u-btn u-btn-warning"></span> <span class="u-btn u-btn-danger"></span>
                    </div>
                </div>
                <div class="sidebar-collapse">
                    <i class="fa fa-angle-double-left"></i>
                </div>
                <div id="nav_wraper">
                    <ul class="nav nav-list">
                        <input type="hidden" name="menuid" id="j_menuid" value="<?php echo cookie('menuid');?>">
                        <?php if(empty($Menu)): ?><p class="red p10">管理员尚未分组，请联系超级管理员分配权限！</p><?php endif; ?>
                        <?php if(is_array($Menu)): $i = 0; $__LIST__ = $Menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i; if($menu['child']): ?>
                            <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="fa <?php echo ($menu["ico"]); ?>"></i>
                                    <span class="menu-text"><?php echo ($menu["title"]); ?></span>
                                    <b class="arrow fa fa-angle-down"></b>
                                </a>
                                <ul class="submenu" id="submenu_<?php echo ($menu["id"]); ?>">
                                    <?php if(is_array($menu["child"])): $i = 0; $__LIST__ = $menu["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$second_menu): $mod = ($i % 2 );++$i; $third_cate = get_child_category($second_menu['id']) ?>
                                        <?php if($third_cate): ?>
                                            <li id="submenu_<?php echo ($second_menu["id"]); ?>">
                                                <a href="#" class="dropdown-toggle">
                                                    <i class="fa <?php echo ($second_menu["ico"]); ?>"></i>
                                                    <span class="menu-text"><?php echo ($second_menu["title"]); ?></span>
                                                    <b class="arrow fa fa-angle-down"></b>
                                                </a>
                                                <ul class="submenu" id="submenu_<?php echo ($second_menu["id"]); ?>">
                                                    <?php if(is_array($third_cate)): $i = 0; $__LIST__ = $third_cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$third_menu): $mod = ($i % 2 );++$i;?><li id="submenu_<?php echo ($third_menu["id"]); ?>">
                                                            <a href="<?php echo U($third_menu['module'].'/'.$third_menu['url'],array('menuId'=>$third_menu['id']));?>">
                                                                <i class="fa <?php echo ($third_menu["ico"]); ?>"></i>
                                                                <span class="menu-text"><?php echo ($third_menu["title"]); ?></span>
                                                            </a>
                                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li id="submenu_<?php echo ($second_menu["id"]); ?>">
                                                <a href="<?php echo U($second_menu['module'].'/'.$second_menu['url'],array('menuId'=>$second_menu['id']));?>">
                                                    <i class="fa <?php echo ($second_menu["ico"]); ?>"></i>
                                                    <span class="menu-text"><?php echo ($second_menu["title"]); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </li>
                            <?php else: ?>
                            <li>
                                <a href="javascript:openapp('<?php echo (u($menu["url"])); ?>','<?php echo ($menu["id"]); ?>','<?php echo ($menu["title"]); ?>');">
                                    <i class="fa <?php echo ($menu["ico"]); ?>"></i>
                                    <span class="menu-text"><?php echo ($menu["title"]); ?></span>
                                </a>
                            </li>
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="breadcrumbs j_pin" id="breadcrumbs">
                <a id="task-pre" class="task-changebt">←</a>
                <div id="task-content">
                <?php $hotkey = json_decode(cookie('Admin_hotkey'),true);?>
                <ul class="macro-component-tab" id="task-content-inner">
                    <li class="macro-component-tabitem noclose" app-id="0" app-url="<?php echo u('main/index');?>" app-name="首页">
                        <a href="<?php echo U('Index/index');?>"><span class="macro-tabs-item-text">首页</span></a>
                    </li>
                    <?php if(is_array($hotkey)): $i = 0; $__LIST__ = $hotkey;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="macro-component-tabitem noclose">
                            <a href="<?php echo U('Index/cutkey',array('title'=>$key));?>" class="J_ajax_get"><i class="fa fa-times-circle u-close"></i></a>
                            <a href="<?php echo ($vo["url"]); ?>"><span class="macro-tabs-item-text"><?php echo ($vo["title"]); ?></span></a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <div style="clear:both;"></div>
                </div>
                <a id="task-next" class="task-changebt">→</a>
            </div>
            <div id="top-alert" class="fixed alert g-message" style="display: none;">
                <i class="fa fa-times-circle close"></i>
                <div class="alert-content">这是内容</div>
            </div>
            
	<script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
	<div class="g-wrap">
		<ul class="u-tab">
			<?php if(is_array(C("CONFIG_GROUP_LIST"))): $i = 0; $__LIST__ = C("CONFIG_GROUP_LIST");if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><li <?php if(($id) == $key): ?>class="current"<?php endif; ?>><a href="<?php echo U('?id='.$key);?>"><?php echo ($group); ?>配置</a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<div class="tab-content">
			<form action="<?php echo U('save');?>" method="post" class="form-horizontal">
			<div class="table_list">
			<table cellpadding="0" cellspacing="0" class="table_form"
			width="100%">
			<tbody>
			<?php if(empty($img)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$config): $mod = ($i % 2 );++$i;?><tr>
							<td width="12%"><label class="item-label"><?php echo ($config["title"]); ?></label></td>
						
							<?php switch($config["type"]): case "0": ?><td width="88%"><input type="text" class="input input-large" name="config[<?php echo ($config["name"]); ?>]" value="<?php echo ($config["value"]); ?>"><span class="check-tips"><?php echo ($config["remark"]); ?></span> </td><?php break;?>
								<?php case "1": ?><td width="88%"><input type="text" class="input input-large" name="config[<?php echo ($config["name"]); ?>]" value="<?php echo ($config["value"]); ?>"><span class="check-tips"><?php echo ($config["remark"]); ?></span> </td><?php break;?>
								<?php case "2": ?><td width="88%"><label class="inputarea input-large">
										<textarea name="config[<?php echo ($config["name"]); ?>]"><?php echo ($config["value"]); ?></textarea>
									</label><span class="check-tips"><?php echo ($config["remark"]); ?></span> </td><?php break;?>
								<?php case "3": ?><td width="88%"><label class="inputarea input-xxxlarge">
										<textarea name="config[<?php echo ($config["name"]); ?>]"><?php echo ($config["value"]); ?></textarea>
									</label><span class="check-tips"><?php echo ($config["remark"]); ?></span> </td><?php break;?>
								<?php case "4": ?><td width="88%"><select name="config[<?php echo ($config["name"]); ?>]">
										<?php $_result=parse_config_attr($config['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($config["value"]) == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
									</select><span class="check-tips"><?php echo ($config["remark"]); ?></span> </td><?php break;?>
								<?php case "5": ?><td width="88%">
										<div class="controls">
												<input type="file" id="upload_picture_<?php echo ($config["name"]); ?>">
												<input type="hidden" name="config[<?php echo ($config["name"]); ?>]" id="cover_id_<?php echo ($config["name"]); ?>" value="<?php echo ($config["value"]); ?>"/>
												<div class="upload-img-box">
												<?php if(!empty($config["value"])): ?><div class="upload-pre-item"><img src="<?php echo (get_product_image($config["value"])); ?>" width="120
													" height="75"/></div><?php endif; ?>
												</div>
											</div>
											<script type="text/javascript">
											//上传图片
										    /* 初始化上传插件 */
											$("#upload_picture_<?php echo ($config["name"]); ?>").uploadify({
										        "height"          : 30,
										        "swf"             : "/Public/static/uploadify/uploadify.swf",
										        "fileObjName"     : "download",
										        "buttonText"      : "上传图片",
										        "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
										        "width"           : 120,
										        'removeTimeout'	  : 1,
										        'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
										        "onUploadSuccess" : uploadPicture<?php echo ($config["name"]); ?>,
										        'onFallback' : function() {
										            alert('未检测到兼容版本的Flash.');
										        }
										    });
											function uploadPicture<?php echo ($config["name"]); ?>(file, data){
										    	var data = $.parseJSON(data);
										    	var src = '';
										        if(data.status){
										        	$("#cover_id_<?php echo ($config["name"]); ?>").val(data.id);
										        	src = data.url || '' + data.path
										        	$("#cover_id_<?php echo ($config["name"]); ?>").parent().find('.upload-img-box').html(
										        		'<div class="upload-pre-item"><img src="' + src + '" width="120" height="75"/></div>'
										        	);
										        } else {
										        	updateAlert(data.info);
										        	setTimeout(function(){
										                $('#top-alert').find('button').click();
										                $(that).removeClass('disabled').prop('disabled',false);
										            },1500);
										        }
										    }
										</script> 
									</td><?php break; endswitch;?>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			<?php else: ?>
				<tr>
					<td>aa</td>
				</tr><?php endif; ?>
			</tbody>
			</table>
				<div class="btn_wrap">
		          <div class="btn_wrap_pd">
		          		<a class="btn btn_small J_ajax_get" href="<?php echo U('Index/setKey',array('cid'=>$_GET['menuId'],'title'=>$meta_title));?>"><i class="fa fa-heart"></i></a>
						<?php if(empty($list)): ?><button type="submit" disabled class="btn_submit disabled" target-form="form-horizontal">确 定</button><?php else: ?><button type="submit" class="btn submit-btn J_ajax_post" target-form="form-horizontal">确 定</button><?php endif; ?>
						
						<button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
						<a href="<?php echo U('Admin/Config/add');?>" class="btn">添加配置</a>
		          </div>
		        </div>
			</form>
		</div>
	</div>

        </div>
    </div>

    <script src="<?php echo C('ADMIN_JS');?>/ace-elements.min.js"></script>
    <script src="<?php echo C('ADMIN_JS');?>/ace.min.js"></script>
    
    <script type="text/javascript">
        $(".j_pin").pin({containerSelector: ".main-container"});
        $(function() {
            window.prettyPrint && prettyPrint();
            $('#id-check-horizontal')
                .removeAttr('checked')
                .on(
                    'click',
                    function() {
                    $('#dt-list-1')
                    .toggleClass('dl-horizontal')
                    .prev()
                    .html(
                    this.checked ? '&lt;dl class="dl-horizontal"&gt;'
                            : '&lt;dl&gt;');
                    });

            //鼠标滑过显示选项
            $('.j_user_bar').on('mouseenter',function(){
                $(this).find(".j_user_menu").show();
            });
            $('.j_user_bar').on('mouseleave',function(){
                $(this).find(".j_user_menu").hide();
            });

        })
    </script>
    <!-- /内容区 -->
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
    <script type="text/javascript" src="<?php echo C('ADMIN_JS');?>/common.js"></script>
    


</body>
</html>