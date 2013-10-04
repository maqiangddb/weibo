<?php

use ptf\IdDao;

/**
 * Description of Twit
 *
 * @file    Twit
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 3:15:17 PM
 */
class TwitDao extends IdDao {

    protected $table = 'twit';

    protected $logDao;

    public function __construct()
    {
        parent::__construct();
        $this->logDao = new LogDao;
    }

    public function add ($args) {

        $t = $this->create();
        $t->role_id = $args['role_id'];
        $t->text = $args['text'];
        $t->setExpr('created', 'NOW()');
        $t->save();

        $log = $this->logModel->create();
        $log->ip = $args['ip'];
        $log->role_id = $args['role_id'];
        $log->twit_id = $t->id;
        $log->save();

        return $t;
    }

    public function retweet($args) {
        $t = $this->create();
        $t->role_id = $args['role_id'];
        $t->origin_id = $this->id;
        $t->origin_comment_id = $args['comment_id'];
        $t->setExpr('created', 'NOW()');
        $t->save();

        $log = $this->logModel->create();
        $log->ip = $args['ip'];
        $log->role_id = $args['role_id'];
        $log->twit_id = $t->id;
        $log->save();

        return $t->id;
    }

    public function getListForIndex($n = 10, $p = 1) {
        $ret = $this
            ->join('role', array('role.id', 'twit.role_id'))
            ->limit($n)
            ->offset(($p-1)*$n)
            ->orderBy(array('role.id' => 'DESC'))
            ->findMany();

        foreach($ret as $k => &$tw) {
                if ($t['origin']) {
                    $t['origin']['time'] = friendly_time2($t['origin']['time']);
                }
                $twit = new Twit($t['id']);
                $t['can_up'] = $twit->canUpBy($user_id);
                return $t;
        }
        return $ret;
    }

    public function getTotalCount()
    {
        return $this->count();
    }

}

