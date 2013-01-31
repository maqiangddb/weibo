<?php
!defined('IN_KC') && exit('Access Denied');
/**
 * @file    add_scene
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 26, 2012 11:08:17 AM
 */
?>
<form action="?" method="post">
    <input type="hidden" name="method" value="add">
    <div>
        <div><label>名称：</label><input type="text" name="name" /></div>
        <div><label>描述：</label><textarea name="description"></textarea></div>
        <input type="submit" value="创建场景" />
    </div>
</form>