<?php
!defined('IN_KC') && exit('Access Denied');
/**
 * @file    role
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 10:04:46 AM
 */

$role = Role::get(_get('id'));
$role->src = _get('src');
$rs = $role->save();
var_export($rs);

