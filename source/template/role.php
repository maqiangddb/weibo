<?php
!defined('IN_KC') && exit('Access Denied');
/**
 * @file    role
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 10:06:36 AM
 */

if ($validate_role) {
    $page['scripts'][] = js_node('jquery.form');
    $page['scripts'][] = js_node('widget');
    $page['scripts'][] = js_node('page/index');
}

?>
<?php if (get_set($validate_role)) { ?>
<div class="role-info">
    <div class="nav-bar">
        <a href="<?php echo ROOT; ?>role">&lt;返回角色列表</a>
        <a class="switch" href="<?php echo ROOT.'role/'.$info['id']; ?>?method=play">以此身份登录(扮演这个角色)</a>
    </div>
    <div class="info">
        <img src="<?php echo $info['avatar']?:$config['default_avatar']; ?>" />
        <span><?php echo $info['name']; ?></span>
        <div class="recent">最近30天发博<?php echo $recent_twit_num; ?>篇</div>
    </div>
    <div class="tag">
        <ul>
            <?php foreach ($role_tags as $tag) { ?>
            <li><span><?php echo $tag; ?></span></li>
            <?php } ?>
        </ul>
        <form action="<?php echo $base_url.$info['id']; ?>" method="post">
            <input type="hidden" name="method" value="add_tag" />
            <div class="add-tag-form">
                <input type="text" name="text" /><input type="submit" value="添加标签" />
            </div>
        </form>
    </div>
    <form method="post" action="?" enctype="multipart/form-data">
        <input type="hidden" name="method" value="edit" />
        <div class="edit-role-form">
            <div><input type="checkbox" id="is_v" name="is_v" <?php echo $info['is_v']? 'checked':''; ?> /><label for="is_v">加V认证</label></div>
            <div><label>头像：</label><input type="file" name="avatar" /></div>
            <input type="submit" value="更改" />
        </div>
    </form>

    <div>
        <ul class="twit">
            <?php foreach ($twits as $t) { ?>
            <?php include _block('twit'); ?>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } else { ?>
<?php
$page['scripts'][] = js_node('widget');
$page['scripts'][] = js_node('page/add_search_role');
?>
<div class="role">
    <div class="add">
        <form method="post" action="?" enctype="multipart/form-data">
            <input type="hidden" name="method" value="add" />
            <div class="search-add-role-form">
                <label>角色名称：</label>
                <input type="text" name="name" />
                <input type="submit" value="添加角色" class="" style="display: none" />
                <ul class="role-list" style="display: none"></ul>
            </div>
        </form>
    </div>
    <dl>
        <?php if ($recent_roles): ?>
        <dt>
            <span>最近扮演的角色</span>
        </dt>
        <?php foreach ($recent_roles as $r): ?>
        <dd>
            <a href="<?= ROOT . 'role/' . $r->id ?>"><?= $r->name ?></a></dd>
        <?php endforeach; ?>
        <?php endif; ?>
        <dt>
            <span>角色列表</span>
            <?php if ($tag) { ?>
            <span>[标签：<?php echo $tag; ?>]</span>
            <?php } ?>
        </dt>
        <?php foreach ($role_list as $role) { ?>
        <dd>
            <div class="info">
                <a href="<?php echo $rooturl.'role/'.$role['id']; ?>">
                    <img src="<?php echo $role['avatar']?:$config['default_avatar']; ?>" />
                    <span><?php echo $role['name']; ?></span>
                    <?php if ($role['is_v']) { ?><span class="verify">V</span><?php } ?>
                </a>
            </div>
            <div class="control">
                <?php if (!$role['top']) { ?>
                <a href="<?php echo $base_url.$role['id'].'?method=top'; ?>" title="这样就可以一直在上面了，再也不用费心寻找了">置顶</a>
                <?php } else { ?>
                <a href="<?php echo $base_url.$role['id'].'?method=untop'; ?>" title="滚到下面">取消置顶</a>
                <?php } ?>
                <a href="<?php echo ROOT.'role/'.$role['id']; ?>" title="添加标签，修改角色头像，加V等">角色信息</a><!-- 删除 -->
                <a class="switch" href="<?php echo ROOT.'role/'.$role['id']; ?>?method=play" title="扮演这个角色">以此身份登录</a><!-- 这里的参数形式也要修改 -->
            </div>
            <div class="tag">
                <ul>
                    <?php foreach ($role['tag'] as $tag) { ?>
                    <li><a href="?tag=<?php echo urlencode($tag); ?>"><?php echo $tag; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </dd>
        <?php } ?>
    </dl>
</div>
<?php } ?>
