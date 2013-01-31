<?php

!defined('IN_KC') && exit('Access Denied');
/**
 * @file    config
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 27, 2012 6:20:27 PM
 * config of server
 */

$config['version'] = array(
    'js'=>'13-1-31',
    'css'=>'13-1-31',
);
$config['up_domain'] = 'wbbystatic';

$config['db'] = array(
    'dsn' => 'mysql:'.implode(';', array('host='.SAE_MYSQL_HOST_M, 'port='.SAE_MYSQL_PORT, 'dbname='.SAE_MYSQL_DB)),
    'dsn_s' => 'mysql:'.implode(';', array('host='.SAE_MYSQL_HOST_S, 'port='.SAE_MYSQL_PORT, 'dbname='.SAE_MYSQL_DB)),
    'username' => SAE_MYSQL_USER,
    'pwd' => SAE_MYSQL_PASS
);

// rely on sever
$config['default_avatar'] = ROOT . 'img/default_avatar.png';
$config['qq_login']['callback'] = 'http://weibobanyan.sinaapp.com/login';
