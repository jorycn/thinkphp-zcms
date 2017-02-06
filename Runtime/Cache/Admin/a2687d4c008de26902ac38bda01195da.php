<?php if (!defined('THINK_PATH')) exit();?><div class="g-wrap">
  <div id="home_toptip"></div>
  <h2 class="h_a">系统信息</h2>
  <div class="home_info">
    <ul>
      <li> <em>操作系统</em> <span><?php echo (PHP_OS); ?></span> </li>
      <li> <em>Thinkphp版本</em><span><?php echo (THINK_VERSION); ?></span></li>
      <li> <em>运行环境</em> <span><?php echo ($_SERVER['SERVER_SOFTWARE']); ?></span> </li>
      <li> <em>PHP运行方式</em> <span>apache2handler</span> </li>
      <?php $system_info_mysql = M()->query("select version() as v;"); ?>
      <li> <em>MYSQL版本</em> <span><?php echo ($system_info_mysql["0"]["v"]); ?></span> </li>
      <li> <em>上传附件限制</em> <span><?php echo ini_get('upload_max_filesize');?></span> </li>
    </ul>
  </div>
  <h2 class="h_a">技术支持</h2>
  <div class="home_info" id="home_devteam">
    <ul>
      <li> <em>ZCMS</em> <span><a href="http://www.cmp580.com/">http://www.cmp580.com/</a></span> </li>
    </ul>
  </div>
</div>