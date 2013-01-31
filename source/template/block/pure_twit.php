<?php

!defined('IN_KC') && exit('Access Denied');
/**
 * @file    pure_twit
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 28, 2012 12:27:24 PM
 */
?>
<div class="content">
    <div class="in">
        <div class="avatar">
            <a href="<?php echo $rooturl.'role/'.$t['role_id']; ?>">
                <img title="<?php echo implode(',', $t['tag']); ?>" src="<?php echo $t['avatar']?:$config['default_avatar']; ?>" />
            </a>
        </div>
        <div>
            <a href="<?php echo $rooturl.'role/'.$t['role_id']; ?>"><span class="name"><?php echo $t['author'].($t['is_v']?'<span class="verify">V</span>':''); ?>：</span></a>
            <span class="text"><?php echo $t['text']; ?></span>
        </div>
    </div>
    <?php if ($t['image']) { ?><div class="image"><img src="<?php echo $t['image']; ?>" /></div><?php } ?>
    <?php if ($t['origin']) { ?>
    <div class="origin">
        <div class="avatar"><a href="<?php echo $rooturl.'role/'.$t['origin']['role_id']; ?>"><img src="<?php echo $t['origin']['avatar']?:$config['default_avatar']; ?>" /></a></div>
        <div>
            <a href="<?php echo $rooturl.'role/'.$t['origin']['role_id']; ?>"><span class="name"><?php echo $t['origin']['author'].($t['origin']['is_v']?'<span class="verify">V</span>':''); ?>：</span></a>
            <span class="text"><?php echo $t['origin']['text']; ?></span>
        </div>
        <?php if ($t['origin']['image']) { ?><div class="image"><img src="<?php echo $t['origin']['image']; ?>" /></div><?php } ?>
        <div class="control">
            <span class="time"><?php echo $t['origin']['time']; ?></span>
            <a class="">转发（<?php echo $t['origin']['retweet_num']; ?>）</a>
            <?php if (0) { ?><a class="">评论（<?php echo $t['origin']['comment_num']; ?>）</a><?php } ?>
        </div>
    </div>
    <?php } ?>
</div>