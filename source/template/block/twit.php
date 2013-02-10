<?php
!defined('IN_KC') && exit('Access Denied');
/**
 * @file    twit
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 27, 2012 5:29:06 PM
 * need $t as $twit
 */
?>
<li class="twit" data-id="<?php echo $t['id']; ?>">
    <?php include _block('pure_twit'); ?>
    <div class="control row-fluid">
      <?php if ($t['scene']) { ?>
        <span class="scene">场景：<a href="<?php echo '?scene='.$t['scene_id']; ?>"><?php echo $t['scene']; ?></a></span>
      <?php } ?>
      <span class="time"><?php echo $t['time']; ?></span>
      <a href="<?php echo $rooturl.'twit/'.$t['id']; ?>">分享</a>
      <?php if (0) { ?>
      <?php if ($t['can_up']) { ?>
      <a class="up-btn" href="<?php echo $rooturl.'twit/'.$t['id']; ?>?method=up">顶</a>
      <?php } else { ?>
      <span>顶过</span>
      <?php } ?>
      <?php } ?>
      <a class="retweet-btn">转发（<?php echo $t['retweet_num']; ?>）</a>
      <span class="comment-btn">评论（<?php echo $t['comment_num']; ?>）</span>
    </div>
    <?php 
    $comments = $t['comments'];
    include _block('comment'); 
    ?>
    <div class="retweet" style="display: none">
        <form class="retweet" method="post" action="<?php echo ROOT.'twit/'.$t['id']; ?>">
            <input type="hidden" name="method" value="retweet" />
            <div class="retweet-form">
                <textarea name="text" placeholder="说点什么吧" class="span12"></textarea>
                <input type="submit" value="转发" class="btn" />
            </div>
        </form>
    </div>
</li>