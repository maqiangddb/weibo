<?php
/**
 * @file    common
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 10:38:22 AM
 */
return array(
    // 网址=>控制器
    'routers' => array(
        array('GET', '/', array('Index', 'index')),
        array('GET', '/role/', array('Role', 'index')),
        array('GET', '/role/[:id]', array('Role', 'view')),
        array('GET', '/about', array('Index', 'about')),
    ),
);