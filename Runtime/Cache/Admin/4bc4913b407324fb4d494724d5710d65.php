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
	<div class="g-wrap tab-wrap">
        <div class="u-tab">
		    <ul class="cc tab-nav">
		    	<li data-tab="tab1" class="current"><a href="javascript:void(0);">基 础</a></li>
				<li data-tab="tab2"><a href="javascript:void(0);">设 计</a></li>
				<li data-tab="tab3"><a href="javascript:void(0);">高 级</a></li>
		    </ul>
        </div>
        <div class="common-form tab-content">
		    <form id="form" action="<?php echo U('update');?>" method="post" class="form-horizontal doc-modal-form">
		    	<div id="tab1" class="tab-pane in tab1 table_list">
				    <table width="100%">
						<tr>
							<td width="20%"><label class="item-label">模型标识</label></td>
							<td><input type="text" class="input input-large" name="name" value="<?php echo ($info["name"]); ?>"><span class="check-tips">请输入文档模型标识</span></td>
						</tr>
						<tr>
							<td width="20%"><label class="item-label">模型名称</label>
							</td>
							<td><input type="text" class="input input-large" name="title" value="<?php echo ($info["title"]); ?>"><span class="check-tips">请输入模型的名称</span></td>
						</tr>
						<tr>
							<td width="20%"><label class="item-label">模型类型<span class="check-tips"></td>
							<td><select name="extend">
										<option value="0">独立模型</option>
										<option value="1">文档模型</option>
								</select>
						</td>
						</tr>
					</table>
			    </div>
			    <div id="tab2" class="tab-pane tab2 table_list">
				    <table width="100%">
						<tr>
							<td width="20%"><label class="item-label">字段管理</label></td>
							<td>
								<p class="check-tips mt10 mb10"><b>只有新增了字段，该表才会真正建立!</b></p>
								<h2>字段列表[ <a href="<?php echo U('Attribute/add?model_id='.$info['id']);?>">新增</a>
								<a href="<?php echo U('Attribute/index?model_id='.$info['id']);?>">管理</a> ] </h2>
								<ul class="dragsort">
									<?php if(is_array($fields)): foreach($fields as $k=>$field): ?><li >
												<em ><?php echo ($field['title']); ?> [<?php echo ($field['name']); ?>]</em>
											</li><?php endforeach; endif; ?>
								</ul>
							</td>
						</tr>
						<tr>
							<td><label class="item-label">表单显示分组</label>
							</td>
							<td><input type="text" class="input input-large" name="field_group" value="<?php echo ($info["field_group"]); ?>"><span class="check-tips">用于表单显示的分组，以及设置该模型表单排序的显示</span></td>
						</tr>
						<tr>
							<td><label class="item-label">表单显示排序</label></td>
							<td>
								<?php $_result=parse_field_attr($info['field_group']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="form-item cf edit_sort edit_sort_l form_field_sort">
										<span><?php echo ($vo); ?></span>
										<ul class="dragsort needdragsort" data-group="<?php echo ($key); ?>">
											<?php if(is_array($fields)): foreach($fields as $k=>$field): if((($field['group'] == $key) or($i == 1 and !isset($field['group']))) and ($field['is_show'] == 1)): ?><li class="getSort">
														<em data="<?php echo ($field['id']); ?>"><?php echo ($field['title']); ?> [<?php echo ($field['name']); ?>]</em>
														<input type="hidden" name="field_sort[<?php echo ($key); ?>][]" value="<?php echo ($field['id']); ?>"/>
													</li><?php endif; endforeach; endif; ?>
										</ul>
									</div><?php endforeach; endif; else: echo "" ;endif; ?>
							</td>
						</tr>
						<tr>
							<td><label class="item-label">列表定义</label></td>
							<td><textarea name="list_grid"><?php echo ($info["list_grid"]); ?></textarea><span class="check-tips">默认列表模板的展示规则</span></td>
						</tr>
						<tr>
							<td><label class="item-label">默认搜索字段</label></td>
							<td><input type="text" class="input input-large" name="search_key" value="<?php echo ($info["search_key"]); ?>"><span class="check-tips">默认列表模板的默认搜索项</span></td>
						</tr>
						<tr>
							<td><label class="item-label">高级搜索字段</label></td>
							<td><input type="text" class="input input-large" name="search_list" value="<?php echo ($info["search_list"]); ?>"><span class="check-tips">默认列表模板的高级搜索项</span></td>
						</tr>
					</table>
			    </div>
			    <div id="tab3" class="tab-pane tab3 table_list">
				    <table width="100%">
			        <tbody>
			            <tr>
			              <td width="20%"><label class="item-label">列表模板</label></td>
			              <td><input type="text" class="input input-large" name="template_list" value="<?php echo ($info["template_list"]); ?>"><span class="check-tips">自定义的列表模板，放在Application\Admin\View\Think下，不写则使用默认模板</span></td>
			            </tr>
			            <tr>
			              <td><label class="item-label">新增模板</label></td>
			              <td><input type="text" class="input input-large" name="template_add" value="<?php echo ($info["template_add"]); ?>"><span class="check-tips">自定义的新增模板，放在Application\Admin\View\Think下，不写则使用默认模板</span></td>
			            </tr>
			            <tr>
			              <td><label class="item-label">编辑模板</label></td>
			              <td><input type="text" class="input input-large" name="template_edit" value="<?php echo ($info["template_edit"]); ?>"><span class="check-tips">自定义的编辑模板，放在Application\Admin\View\Think下，不写则使用默认模板</span></td>
			            </tr>
			            <tr>
			              <td><label class="item-label">列表数据大小</label></td>
			              <td><input type="text" class="input input-small" name="list_row" value="<?php echo ($info["list_row"]); ?>"><span class="check-tips">默认列表模板的分页属性</span></td>
			            </tr>
			        </tbody>
			      	</table>
			    </div>
			    <div class="btn_wrap">
		          <div class="btn_wrap_pd">
						<input type="hidden" name="id" value="<?php echo ($info['id']); ?>"/>
						<button class="btn submit-btn J_ajax_post no-refresh" type="submit" target-form="form-horizontal">确 定</button>
						<button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
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
    
<script type="text/javascript" src="/Public/static/jquery.dragsort-0.5.1.min.js"></script>
<script type="text/javascript" charset="utf-8">
Think.setValue("extend", <?php echo ((isset($info["extend"]) && ($info["extend"] !== ""))?($info["extend"]):0); ?>);

$(function(){
	showTab();
})
//拖曳插件初始化
$(function(){
	$(".needdragsort").dragsort({
	     dragSelector:'li',
	     placeHolderTemplate: '<li class="draging-place">&nbsp;</li>',
	     dragBetween:true,	//允许拖动到任意地方
	     dragEnd:function(){
	    	 var self = $(this);
	    	 self.find('input').attr('name', 'field_sort[' + self.closest('ul').data('group') + '][]');
	     }
	 });
})
</script>

</body>
</html>