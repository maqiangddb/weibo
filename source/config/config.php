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
        array('GET', '/about', array('Index', 'about')),
        array('GET', '/role/', array('Role', 'index')),
        array('POST', '/role/', array('Role', 'add')),
        array('GET', '/role/[:id]', array('Role', 'view')),
        array('GET', '/role/[:id]/play', array('Role', 'play')),
        array('POST', '/twit/', array('Twit', 'add')),
    ),
);
