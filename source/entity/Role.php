<?php

use ptf\IdEntity;

/**
 * Description of Role
 *
 * @file    Role
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 10:13:11 AM
 */
class Role extends IdEntity {

    public function play()
    {
        $_SESSION['se_role_id'] = $this->id;
    }

}

