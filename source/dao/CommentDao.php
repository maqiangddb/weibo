<?php

use ptf\IdDao;

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class CommentDao extends IdDao {

    protected $table = 'comment';

    public function add ($args) {

        $c = $this->create();
        $c->role_id = $args['role_id'];
        $c->text = $args['text'];
        $c->twit_id = $args['twit_id'];
        $c->created = $this->now();
        $c->save();

        $logModel = new LogModel;
        $log = $logModel->create();
        $log->ip = $args['ip'];
        $log->role_id = $args['role_id'];
        $log->twit_id = $args['twit_id'];
        $log->comment_id = $c->id;
        $log->save();
    }

}

