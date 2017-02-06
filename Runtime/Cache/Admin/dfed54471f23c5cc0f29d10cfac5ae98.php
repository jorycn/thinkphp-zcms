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
            
	<!-- 标题栏 -->
		<script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
		<div class="g-wrap tab-wrap">
        <div class="u-tab">
            <ul class="cc tab-nav">
              	<li data-tab="tab1" class="current"><a href="javascript:void(0);">基本设置</a></li>
              	<li data-tab="tab2"><a href="javascript:void(0);">SEO设置</a></li>
              	<li data-tab="tab3"><a href="javascript:void(0);">模板设置</a></li>
              	<li data-tab="tab4"><a href="javascript:void(0);">栏目内容</a></li>
            </ul>
        </div>
        <div class="common-form tab-content">
		    <form action="<?php echo U();?>" method="post" class="form-horizontal">
		    	<div id="tab1" class="tab-pane in tab1 table_list">
				    <table width="100%">
			        <tbody>
			            <tr>
			              <td width="20%"><label class="item-label">上级分类:</label></td>
			              <td>
			              	<select class="select_2 select" name="pid">
					          	<option value='0' >一级分类</option>
					          	<?php echo ($catetree); ?>
					        </select>
			              </td>
			            </tr>
			            <tr>
			              <td width="20%">分类名称:</td>
			              <td><input type="text" name="title" class="input input-large" value="<?php echo ((isset($info["title"]) && ($info["title"] !== ""))?($info["title"]):''); ?>"><span class="check-tips">名称不能为空</span></td>
			            </tr>
			            <tr>
			              <td width="20%">分类标识:</td>
			              <td><input type="text" name="name" class="input input-large" value="<?php echo ((isset($info["name"]) && ($info["name"] !== ""))?($info["name"]):''); ?>"><span class="check-tips">英文字母</span></td>
			            </tr>
			            <tr>
			              <td width="20%">发布内容</td>
			              <td>
			              	<label class="inline radio"><input type="radio" name="allow_publish" value="0" <?php if($info["allow_publish"] == 0): ?>checked="checked"<?php endif; ?>>不允许</label>
							<label class="inline radio"><input type="radio" name="allow_publish" value="1" <?php if($info["allow_publish"] == 1): ?>checked="checked"<?php endif; ?> <?php if(empty($info["allow_publish"])): ?>checked="checked"<?php endif; ?>>仅允许后台</label>
							<label class="inline radio"><input type="radio" name="allow_publish" value="2" <?php if($info["allow_publish"] == 2): ?>checked="checked"<?php endif; ?>>允许前后台</label>
						  </td>
			            </tr>
			            <tr>
			              <td width="20%">是否审核</td>
			              <td><label class="inline radio"><input type="radio" name="check" value="0" <?php if($info["check"] == 0): ?>checked="checked"<?php endif; if(empty($info["check"])): ?>checked="checked"<?php endif; ?>>不需要</label>
							<label class="inline radio"><input type="radio" name="check" value="1" <?php if($info["check"] == 1): ?>checked="checked"<?php endif; ?>>需要</label></td>
			            </tr>
			            <tr>
			              	<td width="20%"><label class="item-label">栏目属性</label></td>
			              	<td>
			              		<?php if(empty($info["type"])): $_result=C('DOCUMENT_MODEL_TYPE');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><input type="radio" name="type" value="<?php echo ($key); ?>" class="j_model" <?php if($key == 1): ?>checked="checked"<?php endif; ?>><?php echo ($type); ?>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
								<?php else: ?>
									<?php $_result=C('DOCUMENT_MODEL_TYPE');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><input type="radio" name="type" value="<?php echo ($key); ?>" class="j_model" <?php if($info["type"] == $key): ?>checked="checked"<?php endif; ?>><?php echo ($type); ?>&nbsp;<?php endforeach; endif; else: echo "" ;endif; endif; ?>
							</td>
			            </tr>
			            <tr class="j-link-input dn">
			              	<td width="20%">Url:</td>
			              	<td class="j-link dn">
								<input type="text" class="input input-large" id="j-url" name="url" value="<?php echo ((isset($info["url"]) && ($info["url"] !== ""))?($info["url"]):''); ?>"><span class="must_red">*</span>&nbsp;&nbsp;&nbsp;&nbsp;
								<span>填写message/index，则实际处理为：U('message/index');或：http://www.baidu.com</span>
							</td>
			            </tr>
			            <tr>
			              	<td width="20%"><label class="item-label">内容模型</label></td>
			              	<td>
			              		<?php if(empty($info["model"])): $_result=get_document_model();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i; $pmodel = get_parent_model($_GET['pid']);?>
			              				<?php if($pmodel>0):?>
											<input type="radio" name="model" value="<?php echo ($list["id"]); ?>" <?php if($list['id'] == $pmodel): ?>checked="checked"<?php endif; ?>><?php echo ($list["title"]); ?>
										<?php else:?>
											<input type="radio" name="model" value="<?php echo ($list["id"]); ?>" <?php if($list['id'] == 2): ?>checked="checked"<?php endif; ?>><?php echo ($list["title"]); ?>
										<?php endif; endforeach; endif; else: echo "" ;endif; ?>
								<?php else: ?>
									<?php $_result=get_document_model();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><input type="radio" name="model" value="<?php echo ($list["id"]); ?>" <?php if($info["model"] == $list["id"]): ?>checked="checked"<?php endif; ?>><?php echo ($list["title"]); endforeach; endif; else: echo "" ;endif; endif; ?>
							</td>
			            </tr>
			            <tr>
			              	<td width="20%"><label class="item-label">可见性</label></td>
			              	<td>
			              		<select name="display">
									<option value="1">所有人可见</option>
									<option value="0">不可见</option>
									<option value="2">管理员可见</option>
								</select>
							</td>
			            </tr>
			            <tr>
			              	<td width="20%"><label class="item-label">回复</label></td>
			              	<td>
			              		<label class="inline radio"><input type="radio" name="reply" value="1" checked>允许</label>
								<label class="inline radio"><input type="radio" name="reply" value="0">不允许</label>
							</td>
			            </tr>
			            <tr>
			              	<td width="20%"><label class="item-label">排序</label></td>
			              	<td>
			              		<input type="text" name="sort" class="input input-small" value="<?php echo ((isset($info["sort"]) && ($info["sort"] !== ""))?($info["sort"]):0); ?>">
							</td>
			            </tr>
			            <tr>
			              	<td width="20%"><label class="item-label">每页显示数</label></td>
			              	<td>
			              		<input type="text" name="list_row" class="input input-small" value="<?php echo ((isset($info["list_row"]) && ($info["list_row"] !== ""))?($info["list_row"]):10); ?>">
							</td>
			            </tr>
			            <tr>
			              <td width="20%"><label class="item-label">分类图标</label></td>
			              <td>
				              	<input type="file" id="upload_picture">
								<input type="hidden" name="icon" id="icon" value="<?php echo ((isset($info['icon']) && ($info['icon'] !== ""))?($info['icon']):''); ?>"/>
								<div class="upload-img-box">
								<?php if(!empty($info["icon"])): ?><div class="upload-pre-item"><img src="<?php echo (get_cover($info["icon"],'path')); ?>"/><a title="删除" href="javascript:;" class="j_delpic"><i class="fa fa-times-circle u-close"></i></a></div><?php endif; ?>
								</div>
								<script type="text/javascript">
								//上传图片
							    /* 初始化上传插件 */
								$("#upload_picture").uploadify({
							        "height"          : 30,
							        "swf"             : "/Public/static/uploadify/uploadify.swf",
							        "fileObjName"     : "download",
							        "buttonText"      : "上传图片",
							        "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
							        "width"           : 120,
							        'removeTimeout'	  : 1,
							        'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
							        "onUploadSuccess" : uploadPicture,
							        'onFallback' : function() {
							            alert('未检测到兼容版本的Flash.');
							        }
							    });
							    function delpic(){
							    	$("#icon").attr("value",0);
							    	$("#icon").parent().find('.upload-img-box').html('');
							    }
								function uploadPicture(file, data){
							    	//var data = $.parseJSON(data);
							    	var data = window["eval"]("(" + data + ")"); 
							    	var src = '';
							        if(data.status){
							        	$("#icon").val(data.id);
							        	src = data.url || '' + data.path;
							        	$("#icon").parent().find('.upload-img-box').html(
							        		'<div class="upload-pre-item"><img src="' + src + '"/><a title="删除" href="javascript:;" onclick="delpic()"><i class="fa fa-times-circle u-close"></i></a></div>'
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
						  </td>
			            </tr>
			        </tbody>
			      	</table>
			    </div>
			    <div id="tab2" class="tab-pane tab2 table_list">
				    <table width="100%">
			        <tbody>
			            <tr>
			              <td width="20%"><label class="item-label">网页标题:</label></td>
			              <td><input type="text" name="meta_title" class="input input-large" value="<?php echo ((isset($info["meta_title"]) && ($info["meta_title"] !== ""))?($info["meta_title"]):''); ?>"></td>
			            </tr>
			            <tr>
			              <td><label class="item-label">关键字:</label></td>
			              <td><textarea name="keywords"><?php echo ((isset($info["keywords"]) && ($info["keywords"] !== ""))?($info["keywords"]):''); ?></textarea></td>
			            </tr>
			            <tr>
			              <td><label class="item-label">描述:</label></td>
			              <td><textarea name="description"><?php echo ((isset($info["description"]) && ($info["description"] !== ""))?($info["description"]):''); ?></textarea></td>
			            </tr>
			        </tbody>
			      	</table>
			    </div>
			    <div id="tab3" class="tab-pane tab3 table_list">
				    <table width="100%">
			        <tbody>
			            <tr>
			              <td width="20%"><label class="item-label">频道模板:</label></td>
			              <?php $tpl_category = get_template('category');?>
			              <td>
			              	<select name="template_index" class="select_6 select">
				              	<?php if(is_array($tpl_category)): $i = 0; $__LIST__ = $tpl_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($info["template_index"]) == $key): ?>selected=selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			              	</select>
			              	<span class="check-tips">如：category_XXX.后缀</span>
			              </td>
			            </tr>
			            <tr>
			              <td><label class="item-label">列表模板:</label></td>
			              <td>
			              	<?php $tpl_list = get_template('list');?>
			              	<select name="template_lists" class="select_6 select">
				              	<?php if(is_array($tpl_list)): $i = 0; $__LIST__ = $tpl_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($info["template_lists"]) == $key): ?>selected=selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			              	</select>
			              	<span class="check-tips">如：list_XXX.后缀</span>
			              </td>
			            </tr>
			            <tr>
			              <td><label class="item-label">详情模板:</label></td>
			              <td>
			              	<?php $tpl_show = get_template('show');?>
			              	<select name="template_detail" class="select_6 select">
				              	<?php if(is_array($tpl_show)): $i = 0; $__LIST__ = $tpl_show;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($info["template_detail"]) == $key): ?>selected=selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			              	</select>
			              	<span class="check-tips">如：show_XXX.后缀</span>
			              </td>
			            </tr>
			        </tbody>
			      	</table>
			    </div>
			    <div id="tab4" class="tab-pane tab4 table_list">
				    <table width="100%">
			        <tbody>
			            <tr>
			              <td><textarea name="content"><?php echo ($info["content"]); ?></textarea>
			                <?php echo hook('adminArticleEdit', array('name'=>content,'value'=>$info['content']));?></td>
			            </tr>
			        </tbody>
			      	</table>
			    </div>
			    <div class="btn_wrap">
		          <div class="btn_wrap_pd">
						<input type="hidden" name="id" value="<?php echo ((isset($info["id"]) && ($info["id"] !== ""))?($info["id"]):''); ?>">
						<input type="hidden" name="pid" value="<?php echo isset($category['id'])?$category['id']:$info['pid'];?>">
						<button type="submit" id="submit" class="btn submit-btn J_ajax_post" target-form="form-horizontal">确 定</button>
						<button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
		          </div>
		        </div>
		    </form>
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
    
	<script type="text/javascript">
		<?php if(isset($info["id"])): ?>Think.setValue("allow_publish", <?php echo ((isset($info["allow_publish"]) && ($info["allow_publish"] !== ""))?($info["allow_publish"]):1); ?>);
		Think.setValue("check", <?php echo ((isset($info["check"]) && ($info["check"] !== ""))?($info["check"]):0); ?>);
		Think.setValue("model[]", <?php echo (json_encode($info["model"])); ?> || [1]);
		Think.setValue("type[]", <?php echo (json_encode($info["type"])); ?> || [2]);
		Think.setValue("display", <?php echo ((isset($info["display"]) && ($info["display"] !== ""))?($info["display"]):1); ?>);
		Think.setValue("reply", <?php echo ((isset($info["reply"]) && ($info["reply"] !== ""))?($info["reply"]):0); ?>);
		Think.setValue("reply_model[]", <?php echo (json_encode($info["reply_model"])); ?> || [1]);<?php endif; ?>
		$(function(){
			showTab();
			$("input[name=reply]").change(function(){
				var $reply = $(".form-item.reply");
				parseInt(this.value) ? $reply.show() : $reply.hide();
			}).filter(":checked").change();
		});
		//栏目类型设定
		var $attr = $('.j_model:checked').val();
		var jurl = $("#j-url").val();
		if(jurl.length<1){
			$('.j-link-input').hide();
		}
		if($attr > '2'){
			$('.j-link-input').show();
			$('.j-link').show();
		}
		$('.j_model').change(function(){
				var $val = $(this).val();
				if($val>'2'){
					$('.j-link-input').show();
					$('.j-link').show();
				}else{
					$('.j-link-input').hide();
				}
		})
	</script>

</body>
</html>