<?php
!defined('IN_KC') && exit('Access Denied');
/**
 * @file    add_scene
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 26, 2012 11:08:17 AM
 */
?>
<form action="?" method="post">
    <input type="hidden" name="method" value="<?php echo $method; ?>">
    <div>
        <div>
            <label>名称：</label>
            <?php if ($method=='add') { ?>
            <input type="text" name="name" />
            <?php } else { ?>
            <span><?php echo $name; ?></span>
            <?php } ?>
        </div>
        <div><label>描述：</label><textarea name="description"><?php echo $description; ?></textarea></div>
        <input type="submit" value="<?php echo $btn_caption; ?>" />
    </div>
</form>