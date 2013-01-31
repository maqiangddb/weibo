<?php
!defined('IN_KC') && exit('Access Denied');
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 9:51:11 AM
 */

$page['scripts'][] = js_node('page/index');

?>
<div class="index">
    <?php if(!get_set($_SESSION['se_know_post'])) { ?>
    <div class="post">
        <span>公告：本伪博所有内容纯属虚构，仅供娱乐。</span>
        <a href="#" class="know">我知道了</a>
    </div>
    <?php } ?>
    <?php if ($scene_id) { ?>
    <div class="scene">
        <div>
            <span class="name"><?php echo $scene_info['name']; ?></span>
            <span>：<?php echo $scene_info['description']; ?></span>
        </div>
        <?php if ($scene_info['will_del']) { ?>
        <span class="del">此场景已经被申请删除</span>
        <?php } else { ?>
        <a class="del" href="<?php echo $rooturl.'scene/'.$scene_info['id'].'?method=del'; ?>">申请删除</a>
        <?php } ?>
    </div>
    <?php } ?>
    <?php if ($has_login && $reminds_count>0) { ?>
    <div class="remind">
        <a class="open-remind" href="#">新鲜事<span>(<?php echo $reminds_count; ?>)</span></a>
        <ul class="remind" style="display: none">
            <?php foreach ($reminds as $r) { ?>
            <li><a href="<?php echo ROOT.'twit/'.$r['id']; ?>"><span><?php echo $r['name']; ?>的微博</span>新增评论</a></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
    <?php if (get_set($_SESSION['se_role_id'])) { ?>
    <form action="twit" method="post" enctype="multipart/form-data">
        <input type="hidden" name="scene" value="<?php echo $scene_id; ?>" />
        <input type="hidden" name="method" value="post" />
        <div class="post-form clear-fix">
            <textarea name="text" placeholder="有什么需要表演的？"></textarea>
            <div><label>图片：</label><input type="file" name="image" /></div>
            <input type="submit" value="发布" />
        </div>
    </form>
    <?php } else { ?>
    <div class="choose"><a href="<?php echo ROOT; ?>role">选择一个角色</a>，开始吧(选择完角色才能发言)。</div>
    <?php } ?>
    <a href="?" class="new-msg" style="display: none">有<span class="new-msg-num"></span>条新微博，点击查看</a>
    <div class="content-top">
        <ul class="sort">
            <li class="<?php echo ($control=='index')?'on':''; ?>"><a href="<?php echo $rooturl.'?scene='.$scene_id; ?>">时间线</a></li>
            <li class="<?php echo ($control=='hot')?'on':''; ?>"><a href="<?php echo $rooturl.'hot?scene='.$scene_id; ?>">热度</a></li>
        </ul>
        <?php if (0): ?>
        <div class="control">
            <a href="<?php echo $rooturl.'scene'; ?>"  class="scene">场景列表</a>
            <a href="<?php echo ROOT; ?>scene?method=add" >新增场景</a>
        </div>
        <?php endif; ?>
    </div>
    <div class="scene-twit">
        <ul class="twit">
            <?php foreach ($twit_list as $t) { ?>
            <?php include _block('twit'); ?>
            <?php } ?>
        </ul>
        <ul class="scene">
            <li class="<?php echo empty($scene_id)?'on':''; ?>"><a href="?">所有场景</a></li>
            <?php foreach ($scenes as $s) { ?>
            <li class="<?php echo $scene_id==$s['id']?'on':''; ?>"><a href="?scene=<?php echo $s['id']; ?>"><?php echo $s['name']; ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="paginate">
        <?php if ($paginate->hasPrevious()) { ?><a href="<?php echo ROOT.'?offset='.$paginate->previousOffset(); ?>">上一页</a><?php } ?>
        <?php if ($paginate->hasNext()) { ?><a href="<?php echo ROOT.'?offset='.$paginate->nextOffset(); ?>">下一页</a><?php } ?>
    </div>
</div>


