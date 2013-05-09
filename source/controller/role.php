<?php
!defined('IN_KC') && exit('Access Denied');
/**
 * @file    role
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 10:04:46 AM
 */

require_once _class('Role');
require_once _class('User');

$base_url = ROOT.'role/'; // TODO

extract(user_input($_GET, 'name'));
if ($name) {
    $id = Role::getIdByName($name);
    if ($is_ajax) {
        out_json(array('state'=>($id? 1 : 0)));
    }
} else {
    $id = get_set($uri_arr[1]);
}
$validate_role = $id && is_numeric($id);
if ($validate_role) {
    $role = new Role($id);
}

switch (get_set($_REQUEST['method'])) {
    case 'add':
        extract(user_input($_POST, 'name'));
        if ($name) {
            if ($role = Role::hasName($name)) {
                redirect($rooturl.'role/'.$role->id);
            }
            try { // 这里有 try，但别处没有try，这里是严谨而无趣的地方。。。
                $role = Role::add($name);
                $role->addToHistory();
                redirect($rooturl . 'role/' . $role->id);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
        break;
    case 'add_tag':
        extract(user_input($_POST, 'text'));
        if ($text && $validate_role) {
            $role->addTag($text);
        }
        break;
    case 'play':
        if ($validate_role) {
            $_SESSION['se_role_id'] = $id;
            $role->hot();
            $role->addToHistory();
            redirect(ROOT);
        }
        break;
    case 'edit':
        extract(user_input($_POST, array('is_v'))); // id will cover?
        $is_v = ($is_v=='on' || $is_v=='1')? 1 : 0;
        $avatar_img = get_set($_FILES['avatar']);
        if ($avatar_img && $avatar_img['name']) {
            $avatar = make_image('avatar', array(
                'resize'=>1,
                'crop'=>1,
                'width'=>50,
                'height'=>50
            ));
        }
        if (isset($role)) {
            $role->edit(compact('is_v', 'avatar'));
        }
        redirect($base_url);
        break;
    case 'watch':
        if ($validate_role && $has_login) {
            $user = new User($user_id);
            $user->watch($id);
        }
        break;
    case 'unwatch':
        if ($validate_role && $has_login) {
            $user = new User($user_id);
            $user->unwatch($id);
        }
        break;
    case 'top':
        if ($validate_role) {
            $role->top();
        }
        redirect($base_url);
        break;
    case 'untop':
        if ($validate_role) {
            $role->untop();
        }
        redirect($base_url);
        break;
    default:
        break;
}

if ($validate_role) {
    $info = $role->getInfo($has_login?$user_id:0);
    $role_tags = $role->getTags();
    $recent_twit_num = $role->countRecentTwit();
    $twits = $role->recentTwit();
    $twits = array_map(function ($t) use($user_id) {
        $t['time'] = friendly_time2($t['time']);
        if ($t['origin']) {
            $t['origin']['time'] = friendly_time2($t['origin']['time']);
        }
        $twit = new Twit($t['id']);
        $t['can_up'] = $twit->canUpBy($user_id);
        $t['comments'] = $twit->getComments();
        return $t;
    }, $twits);
} else {
    $conds = array(
        'num'=>100, // 默认100个？
        'view_from' => ($has_login? $user_id : 0),
    );
    extract(user_input($_GET, array('tag', 'keyword')));
    if ($tag) {
        $conds['tag'] = $tag;
    }
    if ($keyword) {
        $conds['keyword'] = $keyword;
    }
    $role_list = Role::listR($conds);
    if ($is_ajax) {
        out_json($role_list);
    } else {
        require_once _class('Xcon');
        $top_roles = Xcon::parse(get_set($_COOKIE['top_role']));
        $role_list = array_map(function ($role) use($top_roles) {
            $role['top'] = in_array($role['id'], $top_roles)? 1 : 0;
            return $role;
        }, $role_list);
        xcsort2($role_list, array('top', 'hot', 'id'));
    }
    
    $recent_roles = isset($_COOKIE['rh']) ? json_decode($_COOKIE['rh']) : array();
    $recent_roles = array_map(function ($role_id) {
        return new Role($role_id);
    }, $recent_roles);
}

function xcsort2(&$arr, $keys) {
    usort($arr, function ($a, $b) use($keys) {
        $none_zero = array_filter(array_map(function ($key) use($a, $b) {
            return $b[$key] - $a[$key];
        }, $keys), function ($d) {
            return $d != 0;
        });
        return (count($none_zero) == 0)? 0 : reset($none_zero);
    });
}

