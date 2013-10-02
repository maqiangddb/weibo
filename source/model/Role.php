<?php

/**
 * Description of Role
 *
 * @file    Role
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 10:13:11 AM
 */
class Role extends Model {

    public static $table = 'role';

    public static function getCurrentRole()
    {
        if (isset($_SESSION['se_role_id']) && $_SESSION['se_role_id']) {
            return self::findOne($_SESSION['se_role_id']);
        }
        return null;
    }

    public static function hasName($name)
    {
        $conds = array('name' => $name);
        return self::search()->where($conds)->findOne();
    }

    public static function getListForRoleIndex($per_page, $page_index)
    {
        $offset = ($page_index - 1) * $per_page;
        return self::search()->limit($per_page)->offset($offset)->findMany();
    }

    public static function getListLikeName($name)
    {
        return self::search()->where('name', 'like', "%$name%")->findMany();
    }

    public static function getByName($name) {
        return self::search()->where('name', $name)->findOne();
    }

    public function play()
    {
        $_SESSION['se_role_id'] = $this->id;
    }

}

