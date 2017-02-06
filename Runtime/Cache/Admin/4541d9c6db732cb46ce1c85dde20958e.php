<?php if (!defined('THINK_PATH')) exit();?><input type="hidden" name="parse" value="0">

<link rel="stylesheet" href="/Public/static/kindeditor/default/default.css" />
<script charset="utf-8" src="/Public/static/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/Public/static/kindeditor/zh_CN.js"></script>
<script type="text/javascript">
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[name="<?php echo ($addons_data["name"]); ?>"]', {
			allowFileManager : false,
			themesPath: K.basePath,
			width: '100%',
			height: '<?php echo ($addons_config["editor_height"]); ?>',
			resizeType: <?php if(($addons_config["editor_resize_type"]) == "1"): ?>1<?php else: ?>0<?php endif; ?>,
			pasteType : 2,
			urlType : 'absolute',
			fileManagerJson : '<?php echo U('fileManagerJson');?>',
			//uploadJson : '<?php echo U('uploadJson');?>' }
			uploadJson : '<?php echo addons_url("EditorForAdmin://Upload/ke_upimg");?>'
		});
	});

	$(function(){
		//传统表单提交同步
		$('textarea[name="<?php echo ($addons_data["name"]); ?>"]').closest('form').submit(function(){
			editor.sync();
		});
		//ajax提交之前同步
		$('button[type="submit"],#submit,.J_ajax_post').click(function(){
			editor.sync();
		});
	})
</script>