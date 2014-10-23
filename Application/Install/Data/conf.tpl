<?php

// +----------------------------------------------------------------------
// | Author: Jroy 
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    /* 模块相关配置 */
    'AUTOLOAD_NAMESPACE' => array('Addons' => ZCMS_ADDON_PATH), //扩展模块列表
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common', 'User'),
    //'MODULE_ALLOW_LIST'  => array('Home','Admin'),

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => '[AUTH_KEY]', //默认数据加密KEY

    /* 调试配置 */
    'SHOW_PAGE_TRACE' => true,

    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 2, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数

    /* 数据库配置 */
    'DB_TYPE'   => '[DB_TYPE]', // 数据库类型
    'DB_HOST'   => '[DB_HOST]', // 服务器地址
    'DB_NAME'   => '[DB_NAME]', // 数据库名
    'DB_USER'   => '[DB_USER]', // 用户名
    'DB_PWD'    => '[DB_PWD]',  // 密码
    'DB_PORT'   => '[DB_PORT]', // 端口
    'DB_PREFIX' => '[DB_PREFIX]', // 数据库表前缀

    /* 文档模型配置 (文档模型核心配置，请勿更改) */
    'DOCUMENT_MODEL_TYPE' => array(1 => '内容', 2=> '单页', 3 => '内部链接',4=> '外部链接'),

    'ADMIN_JS' => __ROOT__.'/Public/Admin/js',
    'ADMIN_IMG' => __ROOT__.'/Public/Admin/images',
    'ADMIN_CSS' => __ROOT__.'/Public/Admin/css',

    //前台模板路径
    'HOME_TPL' => '/Home/View/default',
);
