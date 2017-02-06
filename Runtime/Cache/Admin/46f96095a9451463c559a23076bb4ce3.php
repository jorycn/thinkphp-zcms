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
            	<li data-tab="tab1" class="current"><a href="javascript:;">插件配置 [ <?php echo ($data["title"]); ?> ]</a></li>
            </ul>
        </div>
        <div class="common-form tab-content">
		    <form action="<?php echo U('saveConfig');?>" class="form-horizontal" method="post">
		    	<div id="tab1" class="tab-pane in tab1 table_list">
		    		<?php if(empty($custom_config)): ?><table width="100%">
				        <tbody>
				        	<?php if(is_array($data['config'])): foreach($data['config'] as $o_key=>$form): ?><tr>
					              <td width="20%"><label class="item-label"><?php echo ((isset($form["title"]) && ($form["title"] !== ""))?($form["title"]):''); ?>:</label></td>
					              <td width="80%">
					              	<?php switch($form["type"]): case "text": ?><div class="controls">
											<input type="text" name="config[<?php echo ($o_key); ?>]" class="input input-large" value="<?php echo ($form["value"]); ?>">
										</div><?php break;?>
										<?php case "password": ?><div class="controls">
											<input type="password" name="config[<?php echo ($o_key); ?>]" class="input input-large" value="<?php echo ($form["value"]); ?>">
										</div><?php break;?>
										<?php case "hidden": ?><input type="hidden" name="config[<?php echo ($o_key); ?>]" value="<?php echo ($form["value"]); ?>"><?php break;?>
										<?php case "radio": ?><div class="controls">
											<?php if(is_array($form["options"])): foreach($form["options"] as $opt_k=>$opt): ?><label class="radio">
													<input type="radio" name="config[<?php echo ($o_key); ?>]" value="<?php echo ($opt_k); ?>" <?php if(($form["value"]) == $opt_k): ?>checked<?php endif; ?>><?php echo ($opt); ?>
												</label><?php endforeach; endif; ?>
										</div><?php break;?>
										<?php case "checkbox": ?><div class="controls">
											<?php if(is_array($form["options"])): foreach($form["options"] as $opt_k=>$opt): ?><label class="checkbox">
													<?php is_null($form["value"]) && $form["value"] = array(); ?>
													<input type="checkbox" name="config[<?php echo ($o_key); ?>][]" value="<?php echo ($opt_k); ?>" <?php if(in_array(($opt_k), is_array($form["value"])?$form["value"]:explode(',',$form["value"]))): ?>checked<?php endif; ?>><?php echo ($opt); ?>
												</label><?php endforeach; endif; ?>
										</div><?php break;?>
										<?php case "select": ?><div class="controls">
											<select name="config[<?php echo ($o_key); ?>]">
												<?php if(is_array($form["options"])): foreach($form["options"] as $opt_k=>$opt): ?><option value="<?php echo ($opt_k); ?>" <?php if(($form["value"]) == $opt_k): ?>selected<?php endif; ?>><?php echo ($opt); ?></option><?php endforeach; endif; ?>
											</select>
										</div><?php break;?>
										<?php case "textarea": ?><div class="controls">
											<label class="inputarea input-large">
												<textarea name="config[<?php echo ($o_key); ?>]"><?php echo ($form["value"]); ?></textarea>
											</label>
										</div><?php break;?>
										<?php case "picture_union": ?><div class="controls">
											<input type="file" id="upload_picture_<?php echo ($o_key); ?>">
											<input type="hidden" name="config[<?php echo ($o_key); ?>]" id="cover_id_<?php echo ($o_key); ?>" value="<?php echo ($form["value"]); ?>"/>
											<div class="upload-img-box">
												<?php if(!empty($form['value'])): $mulimages = explode(",", $form["value"]); ?>
												<?php if(is_array($mulimages)): foreach($mulimages as $key=>$one): ?><div class="upload-pre-item" val="<?php echo ($one); ?>">
														<img src="<?php echo (get_cover($one,'path')); ?>"  ondblclick="removePicture<?php echo ($o_key); ?>(this)"/>
													</div><?php endforeach; endif; endif; ?>
											</div>
											</div>
											<script type="text/javascript">
												//上传图片
												/* 初始化上传插件 */
												$("#upload_picture_<?php echo ($o_key); ?>").uploadify({
													"height"          : 30,
													"swf"             : "/Public/static/uploadify/uploadify.swf",
													"fileObjName"     : "download",
													"buttonText"      : "上传图片",
													"uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
													"width"           : 120,
													'removeTimeout'   : 1,
													'fileTypeExts'    : '*.jpg; *.png; *.gif;',
													"onUploadSuccess" : uploadPicture<?php echo ($o_key); ?>,
													'onFallback' : function() {
											            alert('未检测到兼容版本的Flash.');
											        }
												});

												function uploadPicture<?php echo ($o_key); ?>(file, data){
													var data = $.parseJSON(data);
													var src = '';
													if(data.status){
														src = data.url || '' + data.path
														$("#cover_id_<?php echo ($o_key); ?>").parent().find('.upload-img-box').append(
															'<div class="upload-pre-item" val="' + data.id + '"><img src="' + src + '" ondblclick="removePicture<?php echo ($o_key); ?>(this)"/></div>'
														);
														setPictureIds<?php echo ($o_key); ?>();
													} else {
														updateAlert(data.info);
														setTimeout(function(){
															$('#top-alert').find('button').click();
															$(that).removeClass('disabled').prop('disabled',false);
														},1500);
													}
												}
												function removePicture<?php echo ($o_key); ?>(o){
													var p = $(o).parent().parent();
													$(o).parent().remove();
													setPictureIds<?php echo ($o_key); ?>();
												}
												function setPictureIds<?php echo ($o_key); ?>(){
													var ids = [];
													$("#cover_id_<?php echo ($o_key); ?>").parent().find('.upload-img-box').find('.upload-pre-item').each(function(){
														ids.push($(this).attr('val'));
													});
													if(ids.length > 0)
														$("#cover_id_<?php echo ($o_key); ?>").val(ids.join(','));
													else
														$("#cover_id_<?php echo ($o_key); ?>").val('');
												}
											</script><?php break;?>
										<?php case "group": ?><ul class="tab-nav nav">
												<?php if(is_array($form["options"])): $i = 0; $__LIST__ = $form["options"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><li data-tab="tab<?php echo ($i); ?>" <?php if(($i) == "1"): ?>class="current"<?php endif; ?>><a href="javascript:void(0);"><?php echo ($li["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
											</ul>
											<div class="tab-content">
											<?php if(is_array($form["options"])): $i = 0; $__LIST__ = $form["options"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tab): $mod = ($i % 2 );++$i;?><div id="tab<?php echo ($i); ?>" class="tab-pane <?php if(($i) == "1"): ?>in<?php endif; ?> tab<?php echo ($i); ?>">
													<?php if(is_array($tab['options'])): foreach($tab['options'] as $o_tab_key=>$tab_form): ?><label class="item-label">
														<?php echo ((isset($tab_form["title"]) && ($tab_form["title"] !== ""))?($tab_form["title"]):''); ?>
														<?php if(isset($tab_form["tip"])): ?><span class="check-tips"><?php echo ($tab_form["tip"]); ?></span><?php endif; ?>
													</label>
													<div class="controls">
														<?php switch($tab_form["type"]): case "text": ?><input type="text" name="config[<?php echo ($o_tab_key); ?>]" class="input input-large" value="<?php echo ($tab_form["value"]); ?>"><?php break;?>
															<?php case "password": ?><input type="password" name="config[<?php echo ($o_tab_key); ?>]" class="input input-large" value="<?php echo ($tab_form["value"]); ?>"><?php break;?>
															<?php case "hidden": ?><input type="hidden" name="config[<?php echo ($o_tab_key); ?>]" value="<?php echo ($tab_form["value"]); ?>"><?php break;?>
															<?php case "radio": if(is_array($tab_form["options"])): foreach($tab_form["options"] as $opt_k=>$opt): ?><label class="radio">
																		<input type="radio" name="config[<?php echo ($o_tab_key); ?>]" value="<?php echo ($opt_k); ?>" <?php if(($tab_form["value"]) == $opt_k): ?>checked<?php endif; ?>><?php echo ($opt); ?>
																	</label><?php endforeach; endif; break;?>
															<?php case "checkbox": if(is_array($tab_form["options"])): foreach($tab_form["options"] as $opt_k=>$opt): ?><label class="checkbox">
																		<?php is_null($tab_form["value"]) && $tab_form["value"] = array(); ?>
																		<input type="checkbox" name="config[<?php echo ($o_tab_key); ?>][]" value="<?php echo ($opt_k); ?>" <?php if(in_array(($opt_k), is_array($tab_form["value"])?$tab_form["value"]:explode(',',$tab_form["value"]))): ?>checked<?php endif; ?>><?php echo ($opt); ?>
																	</label><?php endforeach; endif; break;?>
															<?php case "select": ?><select name="config[<?php echo ($o_tab_key); ?>]">
																	<?php if(is_array($tab_form["options"])): foreach($tab_form["options"] as $opt_k=>$opt): ?><option value="<?php echo ($opt_k); ?>" <?php if(($tab_form["value"]) == $opt_k): ?>selected<?php endif; ?>><?php echo ($opt); ?></option><?php endforeach; endif; ?>
																</select><?php break;?>
															<?php case "textarea": ?><label class="inputarea input-large">
																	<textarea name="config[<?php echo ($o_tab_key); ?>]"><?php echo ($tab_form["value"]); ?></textarea>
																</label><?php break;?>
															<?php case "picture_union": ?><div class="controls">
																<input type="file" id="upload_picture_<?php echo ($o_tab_key); ?>">
																<input type="hidden" name="config[<?php echo ($o_tab_key); ?>]" id="cover_id_<?php echo ($o_tab_key); ?>" value="<?php echo ($tab_form["value"]); ?>"/>
																<div class="upload-img-box">
																	<?php if(!empty($tab_form['value'])): $mulimages = explode(",", $tab_form["value"]); ?>
																	<?php if(is_array($mulimages)): foreach($mulimages as $key=>$one): ?><div class="upload-pre-item" val="<?php echo ($one); ?>">
																			<img src="<?php echo (get_cover($one,'path')); ?>"  ondblclick="removePicture<?php echo ($o_tab_key); ?>(this)"/>
																		</div><?php endforeach; endif; endif; ?>
																</div>
																</div>
																<script type="text/javascript">
																	//上传图片
																	/* 初始化上传插件 */
																	$("#upload_picture_<?php echo ($o_tab_key); ?>").uploadify({
																		"height"          : 30,
																		"swf"             : "/Public/static/uploadify/uploadify.swf",
																		"fileObjName"     : "download",
																		"buttonText"      : "上传图片",
																		"uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
																		"width"           : 120,
																		'removeTimeout'   : 1,
																		'fileTypeExts'    : '*.jpg; *.png; *.gif;',
																		"onUploadSuccess" : uploadPicture<?php echo ($o_tab_key); ?>,
																		'onFallback' : function() {
																            alert('未检测到兼容版本的Flash.');
																        }
																	});

																	function uploadPicture<?php echo ($o_tab_key); ?>(file, data){
																		var data = $.parseJSON(data);
																		var src = '';
																		if(data.status){
																			src = data.url || '' + data.path
																			$("#cover_id_<?php echo ($o_tab_key); ?>").parent().find('.upload-img-box').append(
																				'<div class="upload-pre-item" val="' + data.id + '"><img src="' + src + '" ondblclick="removePicture<?php echo ($o_tab_key); ?>(this)"/></div>'
																			);
																			setPictureIds<?php echo ($o_tab_key); ?>();
																		} else {
																			updateAlert(data.info);
																			setTimeout(function(){
																				$('#top-alert').find('button').click();
																				$(that).removeClass('disabled').prop('disabled',false);
																			},1500);
																		}
																	}
																	function removePicture<?php echo ($o_tab_key); ?>(o){
																		var p = $(o).parent().parent();
																		$(o).parent().remove();
																		setPictureIds<?php echo ($o_tab_key); ?>();
																	}
																	function setPictureIds<?php echo ($o_tab_key); ?>(){
																		var ids = [];
																		$("#cover_id_<?php echo ($o_tab_key); ?>").parent().find('.upload-img-box').find('.upload-pre-item').each(function(){
																			ids.push($(this).attr('val'));
																		});
																		if(ids.length > 0)
																			$("#cover_id_<?php echo ($o_tab_key); ?>").val(ids.join(','));
																		else
																			$("#cover_id_<?php echo ($o_tab_key); ?>").val('');
																	}
																</script><?php break; endswitch;?>
														</div><?php endforeach; endif; ?>
												</div><?php endforeach; endif; else: echo "" ;endif; ?>
											</div><?php break; endswitch;?>
									<span class="check-tips"><?php echo ($form["tip"]); ?></span>
					              </td>
					            </tr><?php endforeach; endif; ?>
				        </tbody>
				      	</table>
			      	<?php else: ?>
			      		<?php if(isset($custom_config)): echo ($custom_config); endif; endif; ?>
			    </div>
			    <div class="btn_wrap">
		          <div class="btn_wrap_pd">
						<input type="hidden" name="id" value="<?php echo I('id');?>" readonly>
						<button class="btn submit-btn J_ajax_post" id="submit" type="submit" target-form="form-horizontal">确 定</button>
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
    
<script type="text/javascript" charset="utf-8">
	if($('ul.tab-nav').length){
		//当有tab时，返回按钮不显示
		$('.btn-return').hide();
	}
	$(function(){
		//支持tab
		showTab();
	})
</script>

</body>
</html>