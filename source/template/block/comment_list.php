<?php
!defined('IN_KC') && exit('Access Denied');
?>
<?php foreach ($comments as $c) { ?>
<li class="comment high">
    <a href="<?php echo $rooturl . 'role/' . $c['author_id']; ?>">
        <img src="<?php echo $c['avatar']?:$config['default_avatar']; ?>" />
        <strong><?php echo $c['author']; ?></strong>
        <span class="verify"><?php echo ($c['is_v'])?'V':''; ?></span>
    </a>
    <span>：</span>
    <span><?php echo $c['text']; ?></span>
</li>
<?php } ?>