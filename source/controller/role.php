<?php
/**
 * @file    role
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 10:04:46 AM
 */

class roleController extends baseController
{
    public function indexAction()
    {
        list($p, $n) = $this->param('p', 'n');
        $this->roles = Role::getListForIndex($n, $p);
        $this->renderView();
    }

    public function addAction()
    {
        $name = $this->param('name');
        if ($name) {
            if ($role = Role::hasName($name)) {
                $this->redirect('/role/'.$role->id);
            }
            $role = Role::create();
            $role->name = $name;
            $this->redirect('/role/' . $role->id);
        }
    }

    public function playAction()
    {
        $role = Role::findOne($this->id);
        if ($role) {
            $role->play();
        }
        $this->redirect('/');
    }

    public function editAction()
    {
        $role = Role::findOne($this->id);
        if ($role) {
            $params = $this->param(array('avatar'));
            $role->set($params);
            $role->save();
        }
        $this->redirect($base_url);
        break;
    }

    public function viewAction()
    {
        $this->role = Role::findOne($this->id);
        $this->renderView();
    }
}

