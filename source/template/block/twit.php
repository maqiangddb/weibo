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
  <div class="content row-fluid">
    <div class="span1 left-col">
      <a href="<?php echo $rooturl.'role/'.$t['role_id']; ?>">
        <img class="img-polaroid" title="<?php echo implode(',', $t['tag']); ?>" src="<?php echo $t['avatar']?:$config['default_avatar']; ?>" />
      </a>
    </div>

    <div class="span11 right-col">
      <a href="<?php echo $rooturl.'role/'.$t['role_id']; ?>" class="">
        <?php echo $t['author']; ?>
      </a>
      <?php if ($t['is_v']): ?>
        <span class="verify">V</span>
      <?php endif ?>
      <span class="text"><?php echo $t['text']; ?></span>
      <?php if ($t['image']): ?>
        <div class="image">
          <img src="<?php echo $t['image']; ?>" class="img-polaroid" />
        </div>
      <?php endif ?>

      <?php if ($t['origin']): ?>
      <div class="box-bg">
        <div class="origin row-fluid">
          <div class="avatar span1">
            <a href="<?php echo $rooturl.'role/'.$t['origin']['role_id']; ?>">
              <img src="<?php echo $t['origin']['avatar']?:$config['default_avatar']; ?>" class="img-polaroid" />
            </a>
          </div>
          <div class="span11">
              <a href="<?php echo $rooturl.'role/'.$t['origin']['role_id']; ?>">
                <?php echo $t['origin']['author']; ?>
              </a>
              <?php if ($t['origin']['is_v']): ?>
                <span class="verify">V</span>
              <?php endif ?>
              <span class="text"><?php echo $t['origin']['text']; ?></span>
          </div>
          <?php if ($t['origin']['image']): ?>
            <div class="image row">
              <img src="<?php echo $t['origin']['image']; ?>" class="img-polaroid" />
            </div>
          <?php endif ?>
          <div class="control">
              <span class="time label label-info"><?php echo $t['origin']['time']; ?></span>
              <a class="">转发（<?php echo $t['origin']['retweet_num']; ?>）</a>
              <?php if (0) { ?><a class="">评论（<?php echo $t['origin']['comment_num']; ?>）</a><?php } ?>
          </div>
        </div>
      </div>
      <?php endif ?>

      <div class="control row-fluid">
        <?php if ($t['scene']) { ?>
          <span class="scene">场景：<a href="<?php echo '?scene='.$t['scene_id']; ?>"><?php echo $t['scene']; ?></a></span>
        <?php } ?>
        <span class="time label label-info"><?php echo $t['time']; ?></span>
        <a href="<?php echo $rooturl.'twit/'.$t['id']; ?>">分享</a>
        <a class="a-link retweet-btn">转发（<?php echo $t['retweet_num']; ?>）</a>
        <span class="comment-btn">评论（<?php echo $t['comment_num']; ?>）</span>
      </div>

      <div class="box-bg">
        <?php 
        $comments = $t['comments'];
        include _block('comment'); 
        ?>
      </div>

      <div class="retweet box-bg" style="display: none">
        <div class="row-fluid">
          <form class="retweet" method="post" action="<?php echo ROOT.'twit/'.$t['id']; ?>">
            <div class="span1">
              <img class="img-polaroid" src="<?php echo $t['avatar']?:$config['default_avatar']; ?>" />
            </div>
            <div class="span11">
              <textarea name="text" placeholder="说点什么吧" class="span12"></textarea>
            </div>
            <input type="hidden" name="method" value="retweet" />
            <div class="row">
              <input type="submit" value="转发" class="btn pull-right" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</li>