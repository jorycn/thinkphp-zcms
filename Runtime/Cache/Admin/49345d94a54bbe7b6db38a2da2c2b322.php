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

	<link rel="stylesheet" href="/Public/admin/js/codemirror/codemirror.css">
	<link rel="stylesheet" href="/Public/admin/js/codemirror/theme/<?php echo C('codemirror_theme');?>.css">
	<style>
		.CodeMirror,#preview_window{
			width:700px;
			height:500px;
		}
		#preview_window.loading{
			background: url('/Public/static/thinkbox/skin/default/tips_loading.gif') no-repeat center;
		}

		#preview_window textarea{
			display: none;
		}
	</style>

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
            
	<div class="main-title cf">
		<h2>插件快速创建</h2>
	</div>
	<!-- 表单 -->
	<form id="form" action="<?php echo U('build');?>" method="post" class="form-horizontal doc-modal-form">
		<div class="form-item">
			<label class="item-label"><span class="must">*</span>标识名 <span class="check-tips">请输入插件标识</span></label>
			<div class="controls">
				<input type="text" class="input input-large" name="info[name]" value="Example">
			</div>
		</div>
		<div class="form-item">
			<label class="item-label">插件名<span class="check-tips">请输入插件名</span></label>
			<div class="controls">
				<input type="text" class="input input-large" name="info[title]" value="示列">
			</div>
		</div>
		<div class="form-item">
			<label class="item-label">版本<span class="check-tips">请输入插件版本</span></label>
			<div class="controls">
				<input type="text" class="input input-large" name="info[version]" value="0.1">
			</div>
		</div>
		<div class="form-item">
			<label class="item-label">作者<span class="check-tips">请输入插件作者</span></label>
			<div class="controls">
				<input type="text" class="input input-large" name="info[author]" value="无名">
			</div>
		</div>
		<div class="form-item">
			<label class="item-label">描述<span class="check-tips">请输入描述</span></label>
			<div class="controls">
				<label class="inputarea input-large">
					<textarea name="info[description]">这是一个临时描述</textarea>
				</label>
			</div>
		</div>
		<div class="form-item">
			<label class="item-label">安装后是否启用</label>
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" name="info[status]" value="1" checked />
				</label>
			</div>
		</div>
		<div class="form-item">
			<label class="item-label">是否需要配置</label>
			<div class="controls">
				<label class="checkbox"><input type="checkbox" id="has_config" name="has_config" value="1" /></label>
				<label class="inputarea input-large has_config hidden">
					<textarea class="inputarea" name="config">
&lt;?php
return array(
	'random'=>array(//配置在表单中的键名 ,这个会是config[random]
		'title'=>'是否开启随机:',//表单的文字
		'type'=>'radio',		 //表单的类型：text、textarea、checkbox、radio、select等
		'options'=>array(		 //select 和radion、checkbox的子选项
			'1'=>'开启',		 //值=>文字
			'0'=>'关闭',
		),
		'value'=>'1',			 //表单的默认值
	),
);
					</textarea>
				</label>
				<input type="text" class="input input-large has_config hidden" name="custom_config">
				<span class="check-tips has_config hidden">自定义模板,注意：自定义模板里的表单name必须为config[name]这种，获取保存后配置的值用$data.config.name</span>
			</div>
		</div>
		<div class="form-item">
			<div class="controls">
				<label class="item-label">是否需要外部访问</label>
				<input type="checkbox" class="checkbox" name="has_outurl" value="1" />
			</div>
		</div>
		<div class="form-item">
			<label class="item-label">实现的钩子方法</label>
			<div class="controls">
				<select class="select" name="hook[]" size="10" multiple required>
					<?php if(is_array($Hooks)): $i = 0; $__LIST__ = $Hooks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["name"]); ?>" title="<?php echo ($vo["description"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>
		</div>
		<div class="form-item">
			<label class="item-label">是否需要后台列表</label>
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" id="has_adminlist" name="has_adminlist" value="1" />勾选，扩展里已装插件后台列表会出现插件名的列表菜单，如系统的附件
				</label>
				<label class="inputarea input-large has_adminlist hidden">
					<textarea name="admin_list">
'model'=>'Example',		//要查的表
			'fields'=>'*',			//要查的字段
			'map'=>'',				//查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
			'order'=>'id desc',		//排序,
			'listKey'=>array( 		//这里定义的是除了id序号外的表格里字段显示的表头名
				'字段名'=>'表头显示名'
			),
					</textarea>
				</label>
				<input type="text" class="input has_adminlist hidden" name="custom_adminlist">
				<span class="check-tips block has_adminlist hidden">自定义模板,注意：自定义模板里的列表变量为$_list这种,遍历后可以用listkey可以控制表头显示,也可以完全手写，分页变量用$_page</span>
			</div>
		</div>
		<div class="form-item">
			<button class="btn btn-return" type="button" id="preview">预 览</button>
			<button class="btn J_ajax_post_custom submit-btn" target-form="form-horizontal" id="submit">确 定</button>
			<button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
		</div>
	</form>

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
    
	<script type="text/javascript" src="/Public/admin/js/codemirror/codemirror.js"></script>
	<script type="text/javascript" src="/Public/admin/js/codemirror/xml.js"></script>
	<script type="text/javascript" src="/Public/admin/js/codemirror/javascript.js"></script>
	<script type="text/javascript" src="/Public/admin/js/codemirror/clike.js"></script>
	<script type="text/javascript" src="/Public/admin/js/codemirror/php.js"></script>

	<script type="text/javascript" src="/Public/static/thinkbox/jquery.thinkbox.js"></script>

	<script type="text/javascript">
		function bindShow(radio_bind, selectors){
			$(radio_bind).click(function(){
				$(selectors).toggleClass('hidden');
			})
		}

		//配置的动态
		bindShow('#has_config','.has_config');
		bindShow('#has_adminlist','.has_adminlist');

		$('#preview').click(function(){
			var preview_url = '<?php echo U("preview");?>';
			console.log($('#form').serialize());
			$.post(preview_url, $('#form').serialize(),function(data){
				$.thinkbox('<div id="preview_window" class="loading"><textarea></textarea></div>',{
					afterShow:function(){
						var codemirror_option = {
							lineNumbers   :true,
							matchBrackets :true,
							mode          :"application/x-httpd-php",
							indentUnit    :4,
							gutter        :true,
							fixedGutter   :true,
							indentWithTabs:true,
							readOnly	  :true,
							lineWrapping  :true,
							height		  :500,
							enterMode     :"keep",
							tabMode       :"shift",
							theme: "<?php echo C('CODEMIRROR_THEME');?>"
						};
						var preview_window = $("#preview_window").removeClass(".loading").find("textarea");
						var editor = CodeMirror.fromTextArea(preview_window[0], codemirror_option);
						editor.setValue(data);
						$(window).resize();
					},

					title:'预览插件主文件',
					unload: true,
					actions:['close'],
					drag:true
				});
			});
			return false;
		});

		$('.J_ajax_post_custom').click(function(){
	        var target,query,form;
	        var target_form = $(this).attr('target-form');
	        var check_url = '<?php echo U('checkForm');?>';
			$.ajax({
			   type: "POST",
			   url: check_url,
			   dataType: 'json',
			   async: false,
			   data: $('#form').serialize(),
			   success: function(data){
			    	if(data.status){
    			        if( ($(this).attr('type')=='submit') || (target = $(this).attr('href')) || (target = $(this).attr('url')) ){
				            form = $('.'+target_form);
				            if ( form.get(0).nodeName=='FORM' ){
				                target = form.get(0).action;
				                query = form.serialize();
				            }else if( form.get(0).nodeName=='INPUT' || form.get(0).nodeName=='SELECT' || form.get(0).nodeName=='TEXTAREA') {
				                query = form.serialize();
				            }else{
				                query = form.find('input,select,textarea').serialize();
				            }
				            $.post(target,query).success(function(data){
				                if (data.status==1) {
				                    if (data.url) {
				                        updateAlert(data.info + ' 页面即将自动跳转~','alert-success');
				                    }else{
				                        updateAlert(data.info + ' 页面即将自动刷新~');
				                    }
				                    setTimeout(function(){
				                        if (data.url) {
				                            location.href=data.url;
				                        }else{
				                        	location.reload();
				                        }
				                    },1500);
				                }else{
				                    updateAlert(data.info);
				                }
				            });
				        }
			    	}else{
			    		updateAlert(data.info);
					}
			   }
			});

	        return false;
	    });

	</script>

</body>
</html>