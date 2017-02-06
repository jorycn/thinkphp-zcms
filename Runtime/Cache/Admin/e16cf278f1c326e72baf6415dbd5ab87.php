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
<script type="text/javascript" src="/Public/static/popwin.js"></script>   
<style type="text/css">#dialog{display:none;}</style>
	<div class="g-wrap">
		<!-- 按钮工具栏 -->
		<div class="u-tab">
		    <ul class="cc tab-nav">
		    	<?php $_result=parse_config_attr($model['field_group']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><li data-tab="tab<?php echo ($key); ?>" <?php if(($key) == "1"): ?>class="current"<?php endif; ?>><a href="javascript:void(0);"><?php echo ($group); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		    </ul>
		</div>
		<!-- 数据表格 -->
		<div class="tab-content table_list">
		<!-- 表单 -->
		<form id="form" action="<?php echo U('update');?>" method="post" class="form-horizontal">
			<?php $_result=parse_config_attr($model['field_group']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><div id="tab<?php echo ($key); ?>" class="tab-pane <?php if(($key) == "1"): ?>in<?php endif; ?> tab<?php echo ($key); ?>">
					<table class="" width="100%">
				    <tbody>
						<?php if(is_array($fields[$key])): $i = 0; $__LIST__ = $fields[$key];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i; if($field['is_show'] == 1 || $field['is_show'] == 2): ?><tr>
					            <td width="20%"><label class="item-label"><?php echo ($field['title']); ?></label></td>
					            <td width="80%">
					            	<?php switch($field["type"]): case "num": ?><input type="text" class="input input-medium" name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>"><?php break;?>
			                            <?php case "string": ?><input type="text" class="input input-large" name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>"><?php break;?>
			                            <?php case "textarea": ?><label class="inputarea input-large">
			                                <textarea name="<?php echo ($field["name"]); ?>"><?php echo ($field["value"]); ?></textarea>
			                                </label><?php break;?>
			                            <?php case "datetime": ?><input type="text" name="<?php echo ($field["name"]); ?>" class="input input-large time" value="" placeholder="请选择时间" /><?php break;?>
			                            <?php case "bool": ?><select name="<?php echo ($field["name"]); ?>">
			                                    <?php $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($field["value"]) == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			                                </select><?php break;?>
			                            <?php case "select": ?><select name="<?php echo ($field["name"]); ?>">
			                                    <?php $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($field["value"]) == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			                                </select><?php break;?>
			                            <?php case "radio": $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label class="radio">
			                                    <input type="radio" value="<?php echo ($key); ?>" <?php if(($field["value"]) == $key): ?>checked<?php endif; ?> name="<?php echo ($field["name"]); ?>"><?php echo ($vo); ?>
			                                	</label><?php endforeach; endif; else: echo "" ;endif; break;?>
			                            <?php case "checkbox": $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label class="checkbox">
			                                    <input type="checkbox" value="<?php echo ($key); ?>" name="<?php echo ($field["name"]); ?>" <?php if(($field["value"]) == $key): ?>checked<?php endif; ?>><?php echo ($vo); ?>
			                                	</label><?php endforeach; endif; else: echo "" ;endif; break;?>
			                            <?php case "editor": ?><label class="inputarea">
			                                <textarea name="<?php echo ($field["name"]); ?>"><?php echo ($field["value"]); ?></textarea>
			                                <?php echo hook('adminArticleEdit', array('name'=>$field['name'],'value'=>$field['value']));?>
			                                </label><?php break;?>
			                            <?php case "picture": ?><div class="controls">
												<input type="file" id="upload_picture_<?php echo ($field["name"]); ?>">
												<input type="hidden" name="<?php echo ($field["name"]); ?>" id="cover_id_<?php echo ($field["name"]); ?>"/>
												<div class="upload-img-box">
												<?php if(!empty($data[$field['name']])): ?><div class="upload-pre-item"><img src="<?php echo (get_cover($data[$field['name']],'path')); ?>" width="125" height="75"/></div><?php endif; ?>
												</div>
											</div>
											<script type="text/javascript">
											//上传图片
										    /* 初始化上传插件 */
											$("#upload_picture_<?php echo ($field["name"]); ?>").uploadify({
										        "height"          : 30,
										        "swf"             : "/Public/static/uploadify/uploadify.swf",
										        "fileObjName"     : "download",
										        "buttonText"      : "上传图片",
										        "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
										        "width"           : 120,
										        'removeTimeout'	  : 1,
										        'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
										        "onUploadSuccess" : uploadPicture<?php echo ($field["name"]); ?>,
										        'onFallback' : function() {
										            alert('未检测到兼容版本的Flash.');
										        }
										    });
										    function delpic(){
										    	$("#cover_id_<?php echo ($field["name"]); ?>").attr("value",0);
										    	$("#cover_id_<?php echo ($field["name"]); ?>").parent().find('.upload-img-box').html('');
										    }
											function uploadPicture<?php echo ($field["name"]); ?>(file, data){
										    	/*var data = $.parseJSON(data);*/
										    	var data = window["eval"]("(" + data + ")"); 
										    	var src = '';
										        if(data.status){
										        	$("#cover_id_<?php echo ($field["name"]); ?>").val(data.id);
										        	src = data.url || '' + data.path
										        	$("#cover_id_<?php echo ($field["name"]); ?>").parent().find('.upload-img-box').html(
										        		'<div class="upload-pre-item j_<?php echo ($field["name"]); ?>"><img src="' + src + '" width="125" height="75"/><a title="删除" href="javascript:;" onclick="delpic()"><i class="fa fa-times-circle u-close"></i></a></div>'
										        	);
										        } else {
										        	updateAlert(data.info);
										        	setTimeout(function(){
										                $('#top-alert').find('button').click();
										                $(that).removeClass('disabled').prop('disabled',false);
										            },1500);
										        }
										    }
											</script><?php break;?>
			                            <?php case "file": ?><div class="controls">
												<input type="file" id="upload_file_<?php echo ($field["name"]); ?>">
												<input type="hidden" name="download[<?php echo ($field["name"]); ?>]" class="j_<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"/>
												<div class="upload-img-box">
													<?php if(isset($data[$field['name']])): ?><div class="upload-pre-file"><span class="upload_icon_all"></span><?php echo ($data[$field['name']]); ?></div><?php endif; ?>
												</div>
											</div>
											<script type="text/javascript">
											//上传图片
										    /* 初始化上传插件 */
											$("#upload_file_<?php echo ($field["name"]); ?>").uploadify({
										        "height"          : 30,
										        "swf"             : "/Public/static/uploadify/uploadify.swf",
										        "fileObjName"     : "download",
										        "buttonText"      : "上传附件",
										        "uploader"        : "<?php echo U('File/upload',array('session_id'=>session_id()));?>",
										        "width"           : 120,
										        'removeTimeout'	  : 1,
										        "onUploadSuccess" : uploadFile<?php echo ($field["name"]); ?>,
										        'onFallback' : function() {
										            alert('未检测到兼容版本的Flash.');
										        }
										    });
											function uploadFile<?php echo ($field["name"]); ?>(file, data){
												/*var data = $.parseJSON(data);*/
												var data = window["eval"]("(" + data + ")"); 
										        if(data.status){
										        	var name = "j_<?php echo ($field["name"]); ?>";
										        	$("input."+name).val(data.data);
										        	$("input."+name).parent().find('.upload-img-box').html(
										        		"<div class=\"upload-pre-file\"><span class=\"upload_icon_all\"></span>" + data.info + "</div>"
										        	);
										        } else {
										        	updateAlert(data.info);
										        	setTimeout(function(){
										                $('#top-alert').find('button').click();
										                $(that).removeClass('disabled').prop('disabled',false);
										            },1500);
										        }
										    }
											</script><?php break;?>
			                            <?php case "gallery": ?><div class="controls">
												<input type="file" id="upload_picture_<?php echo ($field["name"]); ?>">
												<div class="upload-img-box">
												<div class="upload-pre-item image-gallery">
													<fieldset>
													<legend>图片列表</legend>
													<?php if(!$data[$field['name']]):?>
														<ul class="imagelist" id="image_result"></ul>
													<?php else:?>
														<?php $images = explode(',', $data[$field['name']]);?>
														<ul class="imagelist" id="image_result">
															<?php if(is_array($images)): $i = 0; $__LIST__ = $images;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="imageitem" id="gallery_<?php echo ($vo["id"]); ?>">
																	<input type="hidden" name="<?php echo ($field["name"]); ?>[]" value="<?php echo ($vo["id"]); ?>">
																	<img height="160" width="160" src="<?php echo (get_product_image($vo["path"])); ?>" />
																	<a title="删除" href="<?php echo U('Admin/File/deletePic',array('id'=>$data['id'],'image_id'=>$vo['id'],'model'=>$data['model_id'],'fieldname'=>$field['name']));?>" class="J_ajax_get confirm"><i class="fa fa-times-circle"></i></a>
																</li><?php endforeach; endif; else: echo "" ;endif; ?>
														</ul>
													<?php endif?>
													</fieldset>
													<div style="clear:both;"></div>
												</div>
												</div>
											</div>
											<script type="text/javascript">
											//上传图片
										    /* 初始化上传插件 */
											$("#upload_picture_<?php echo ($field["name"]); ?>").uploadify({
										        "height"          : 30,
										        "swf"             : "/Public/static/uploadify/uploadify.swf",
										        "fileObjName"     : "download",
										        "buttonText"      : "上传图片",
										        "uploader"        : "<?php echo U('Admin/File/uploadPicture',array('session_id'=>session_id()));?>",
										        "width"           : 120,
										        'removeTimeout'	  : 1,
										        'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
										        "onUploadSuccess" : uploadPicture<?php echo ($field["name"]); ?>,
										        'onFallback' : function() {
										            alert('未检测到兼容版本的Flash.');
										        }
										    });
											function uploadPicture<?php echo ($field["name"]); ?>(file, data){
										    	//var data = $.parseJSON(data);
										    	var data = window["eval"]("(" + data + ")"); 
										    	var src = '';
										        if(data.status){
													var html = '<li class="imageitem" id="gallery_'+data.id+'">';
														html+= '<input type="hidden" name="<?php echo ($field["name"]); ?>[]" value="'+data.id+'">'; //隐藏域，是为了把图片地址入库。。
														html+= '<img height="160" width="160" src="'+data.path+'" />';

														html+=  '<a title="删除" href="javascript:remove('+data.id+')" class="J_ajax_get confirm"><i class="fa fa-times-circle"></i></a>';
														html+=  '</li>';
													$('#image_result').append(html);
										        } else {
										        	updateAlert(data.info);
										        	setTimeout(function(){
										                $('#top-alert').find('button').click();
										                $(that).removeClass('disabled').prop('disabled',false);
										            },1500);
										        }
										    }
										    function remove(id){
										    	var item = $('#gallery_'+id);
										    	item.remove();
										    }
											</script><?php break;?>
		                            	<?php case "array": ?><input type="text" class="input input-large" id='j_array' name="<?php echo ($field["name"]); ?>" readonly=readonly ><a class="btn"  id="xgwz"  href="javascript:void(0)" style="width:40px; height:18px; margin-left:5px;"  />选择</a><?php break;?>
			                            <?php default: ?>
			                            <input type="text" class="input input-large" name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>"><?php endswitch;?>
			                        <span class="check-tips"><?php if(!empty($field["remark"])): ?>（<?php echo ($field['remark']); ?>）<?php endif; ?></span>
					            </td>
							</tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				    </table> 
			     </div><?php endforeach; endif; else: echo "" ;endif; ?>
			<div class="btn_wrap">
	          <div class="btn_wrap_pd">
	            	<button class="btn submit-btn J_ajax_post" id="submit" type="submit" target-form="form-horizontal">确 定</button>
					<a class="btn btn-return" href="<?php echo U('article/index?cate_id='.$cate_id);?>">返 回</a>
					<?php if(C('OPEN_DRAFTBOX') and (ACTION_NAME == 'add' or $info['status'] == 3)): ?><button class="btn save-btn" url="<?php echo U('article/autoSave');?>" target-form="form-horizontal" id="autoSave">
						存草稿
					</button><?php endif; ?>
					<input type="hidden" name="id" value="<?php echo ((isset($info["id"]) && ($info["id"] !== ""))?($info["id"]):''); ?>"/>
					<input type="hidden" name="pid" value="<?php echo ((isset($info["pid"]) && ($info["pid"] !== ""))?($info["pid"]):''); ?>"/>
					<input type="hidden" name="model_id" value="<?php echo ((isset($info["model_id"]) && ($info["model_id"] !== ""))?($info["model_id"]):''); ?>"/>
					<input type="hidden" name="category_id" value="<?php echo ((isset($info["category_id"]) && ($info["category_id"] !== ""))?($info["category_id"]):''); ?>">
	          </div>
	        </div>
	    </form>
	    </div>
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
    
<link href="/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<?php if(C('COLOR_STYLE')=='blue_color') echo '<link href="/Public/static/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">'; ?>
<link href="/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">
$('#submit').click(function(){
	$('#form').submit();
});
$(function(){
	$("#xgwz").on('click' , function(){
		popWin.showWin("1000","600","请勾选出相关文章","<?php echo U('article/mydocument?showids=true');?>");
	});
    $('.time').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });
    showTab();
});
</script>

</body>
</html>