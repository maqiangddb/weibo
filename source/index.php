<?php
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 10:38:22 AM
 * app logic
 * 此框架由王霄池纯粹手写而成，当然参照了不少鸡爷的框架
 */

// 打开错误提示
ini_set('display_errors', 1); // 在 SAE 上 ini_set() 不起作用，但也不会报错
error_reporting(E_ALL);

define('IN_KC', 1);
define('AROOT', __DIR__.'/');

require AROOT.'lib/lib.php';
require AROOT.'config/common.php';
if (ON_SERVER) {
    require 'config/server.php'; // sever中的配置会覆盖common中的配置
}

require AROOT.'init.php'; // 变量的初始化

date_default_timezone_set('PRC');
ob_start();
session_start();

require AROOT.'controller/init.php';

if (isset($force_redirect)) { // 强制跳转 这个在整站关闭的时候也很有用啊
    include 'controller/'.$force_redirect.'.php';
    $template = 'template/'.$force_redirect.'.php';
// 查看是否是合法的$control，如是，则包含文件，如否，则跳转向404页面
} else if (isset($config['controls'][$control])) {
    include 'controller/'.$config['controls'][$control].'.php';
    if (!isset($template))
        $template = _tpl($config['controls'][$control]); // 默认的template
} else {
    // 404
    include 'controller/page404.php';
    $template = 'template/page404.php';
}
include 'template/master.php';
