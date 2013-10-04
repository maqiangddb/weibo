<?php

use ptf\IdModel;

/**
 * Description of Role
 *
 * @file    Role
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 10:13:11 AM
 */
class RoleDao extends IdModel {

    public $table = 'role';

    public function getCurrentRole()
    {
        if (isset($_SESSION['se_role_id']) && $_SESSION['se_role_id']) {
            return $this->findOne($_SESSION['se_role_id']);
        }
        return null;
    }

    public function hasName($name)
    {
        $conds = array('name' => $name);
        return $this->where($conds)->findOne();
    }

    public function getList($per_page, $page_index)
    {
        $offset = ($page_index - 1) * $per_page;
        return $this->limit($per_page)->offset($offset)->findMany();
    }

    public function getListLikeName($name)
    {
        return $this->where('name', 'like', "%$name%")->findMany();
    }

    public function getByName($name) {
        return $this->where('name', $name)->findOne();
    }

    public function play()
    {
        $_SESSION['se_role_id'] = $this->id;
    }

    public function add($args)
    {
        $role = $this->create();
        $role->name = $args['name'];
        $role->save();
        return $role;
    }

}

