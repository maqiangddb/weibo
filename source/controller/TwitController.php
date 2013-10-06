<?php
/**
 * @file    twit
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 4:26:14 PM
 */

class TwitController extends BaseController
{
    public function addAction()
    {
        $role = $this->roleDao->getCurrentRole();
        if ($role) {
            $args = $this->param(array('text'));
            $args['role_id'] = $role->id;
            $args['ip'] = $this->ip();
            $this->twitDao->add($args);
        }
        $this->redirect('/');
    }

    public function commentAction()
    {
        $twit = $this->twitDao->findOne($this->param('twit_id'));
        if ($twit) {
            $args = $this->param(array('text', 'twit_id', 'role_id'));
            Comment::add($args);
            $twit = $this->twitDao->findOne($args['twit_id']);
            $this->comments = $twit->getComments();
            return $this->renderBlock('comment_list');
        } else {
            return false;
        }
    }

    public function retweetAction()
    {
        $twit = $this->twitDao->findOne($this->param('twit_id'));
        if ($twit) {
            $args = $this->param(array('role_id', 'comment_id'));
            $rs = $twit->retweet($args);
            return $this->json((bool)$rs);
        }
        return $this->json(false);
    }
}

