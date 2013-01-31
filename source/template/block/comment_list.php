<?php
!defined('IN_KC') && exit('Access Denied');
?>
<?php foreach ($comments as $c) { ?>
<li class="comment">
    <a href="<?php echo $rooturl . 'role/' . $c['author_id']; ?>">
        <img src="<?php echo $c['avatar']?:$config['default_avatar']; ?>" />
        <span><?php echo $c['author']; ?></span>
        <span class="verify"><?php echo ($c['is_v'])?'V':''; ?></span>
    </a>
    <span>：</span>
    <span><?php echo $c['text']; ?></span>
</li>
<?php } ?>