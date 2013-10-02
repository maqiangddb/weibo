<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class Comment extends Model {

    protected static $table = 'comment';


    public function add ($args) {

        $c = self::create();
        $c->role_id = $args['role_id'];
        $c->text = $args['text'];
        $c->twit_id = $args['twit_id'];
        $c->setExpr('created', 'NOW()');
        $c->save();

        $log = Log::create();
        $log->ip = $args['ip'];
        $log->role_id = $args['role_id'];
        $log->twit_id = $args['twit_id'];
        $log->comment_id = $c->id;
        $log->save();
    }

}

