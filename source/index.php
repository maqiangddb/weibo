<?php
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 10:38:22 AM
 * app logic
 * 此框架由王霄池纯粹手写而成，当然参照了不少鸡爷的框架
 */

define('IN_KC', 1);

require 'lib.php';
require 'config/common.php';
if (ON_SERVER) {
    require 'config/server.php'; // sever中的配置会覆盖common中的配置
}

require 'init.php'; // 变量的初始化

date_default_timezone_set('PRC');
ob_start();
session_start();

require 'source/init.php';

if (isset($force_redirect)) { // 强制跳转 这个在整站关闭的时候也很有用啊
    include 'source/'.$force_redirect.'.php';
    $template = 'template/'.$force_redirect.'.php';
// 查看是否是合法的$control，如是，则包含文件，如否，则跳转向404页面
} else if (isset($config['controls'][$control])) {
    include 'source/'.$config['controls'][$control].'.php';
    if (!isset($template))
        $template = _tpl($config['controls'][$control]); // 默认的template
} else {
    // 404
    include 'source/page404.php';
    $template = 'template/page404.php';
}
include 'template/master.php';

?>