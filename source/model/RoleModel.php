<?php

use ptf\IdModel;

/**
 * Description of Role
 *
 * @file    Role
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 10:13:11 AM
 */
class RoleModel extends IdModel {

    public $table = 'role';

    public static function getCurrentRole()
    {
        if (isset($_SESSION['se_role_id']) && $_SESSION['se_role_id']) {
            return $this->findOne($_SESSION['se_role_id']);
        }
        return null;
    }

    public static function hasName($name)
    {
        $conds = array('name' => $name);
        return $this->where($conds)->findOne();
    }

    public static function getList($per_page, $page_index)
    {
        $offset = ($page_index - 1) * $per_page;
        return $this->limit($per_page)->offset($offset)->findMany();
    }

    public static function getListLikeName($name)
    {
        return $this->where('name', 'like', "%$name%")->findMany();
    }

    public static function getByName($name) {
        return $this->where('name', $name)->findOne();
    }

    public function play()
    {
        $_SESSION['se_role_id'] = $this->id;
    }

    public static function add($args)
    {
        $role = $this->create();
        $role->name = $args['name'];
        $role->save();
        return $role;
    }

}

