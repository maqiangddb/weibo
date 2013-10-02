<?php
/**
 * @file    twit
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 4:26:14 PM
 */

class twitController extends baseController
{
    public function addAction()
    {
        $role = Role::currentRole();
        if ($role) {
            $args = $this->param(array('text'));
            $args['role_id'] = $role->id;
            $args['ip'] = $this->ip();
            Twit::add($args);
        }
        $this->redirect('index');
    }

    public function commentAction()
    {
        $twit = Twit::findOne($this->param('twit_id'));
        if ($twit) {
            $args = $this->param(array('text', 'twit_id', 'role_id'));
            Comment::add($args);
            $twit = Twit::findOne($args['twit_id']);
            $this->comments = $twit->getComments();
            return $this->renderView('comment_list');
        } else {
            return false;
        }
    }

    public function retweetAction()
    {
        $twit = Twit::findOne($this->param('twit_id'));
        if ($twit) {
            $args = $this->param(array('role_id', 'comment_id'));
            $rs = $twit->retweet($args);
            return $this->json((bool)$rs);
        }
        return $this->json(false);
    }
}

$id = get_set($uri_arr[1]);

$validate_twit = $id && is_numeric($id);
if ($validate_twit) {
    $twit = new Twit($id);
}

