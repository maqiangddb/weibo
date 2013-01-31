<?php
!defined('IN_KC') && exit('Access Denied');
/**
 * @file    longtian
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 26, 2012 6:19:24 PM
 */

if ($perm->check() || DEBUG) {
    require_once _class('Twit');
    $del_twits = Twit::listT(array('will_del'=>1));
    require_once _class('Scene');
    $del_scenes = Scene::ListS(array('will_del'=>1));

    require_once _class('Log');
    $log = Log::listL();
}

?>
