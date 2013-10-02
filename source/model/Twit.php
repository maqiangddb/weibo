<?php

!defined('IN_KC') && exit('Access Denied');

/**
 * Description of Twit
 *
 * @file    Twit
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 3:15:17 PM
 */
class Twit extends Model {

    protected static $table = 'twit';


    public function add ($args) {

        $t = self::create();
        $t->role_id = $args['role_id'];
        $t->text = $args['text'];
        $t->setExpr('created', 'NOW()');
        $t->save();

        $log = Log::create();
        $log->ip = $args['ip'];
        $log->role_id = $args['role_id'];
        $log->twit_id = $t->id;
        $log->save();
    }

    public function getComments() {
        return Comment::search()
            ->where('twit_id', $this->id())
            ->order(array('id' => 'ASC'))
            ->findMany();
    }

    public static function formatHtml($text) { // this should be private, but...
        return preg_replace("/(@[^\s]+)(\sv)?($|\s)/", '[$1$2]', $text);
    }

    public function comment($text, $author_id) {
        //....
        $arr = array(
            'twit'=>$this->id,
            'text'=>$text,
            'author'=>$author_id,
            'time=NOW()'=>false,
        );
        Pdb::insert($arr, 'comment');
        $this->plusOne('comment_num');
        $this->hot(2);
    }

    public function retweet($args) {
        $t = self::create();
        $t->role_id = $args['role_id'];
        $t->origin_id = $this->id;
        $t->origin_comment_id = $args['comment_id'];
        $t->setExpr('created', 'NOW()');
        $t->save();

        $log = Log::create();
        $log->ip = $args['ip'];
        $log->role_id = $args['role_id'];
        $log->twit_id = $t->id;
        $log->save();

        return $t->id;
    }

    public static function getListForIndex($num = 10, $offset = 0) {
        $ret = self::search()
            ->join('role', array('role.id', 'twit.role_id'))
            ->
            ->limit($per_page)
            ->offset($offset)
            ->order(array('role.id' => 'DESC'))
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

    public static function fromArray($arr)
    {
        $o = parent::fromArray($arr);
        if ($o->origin) {
            $o->orgin = self::findOne($arr);
        }

        $o->text = self::formatHtml($o->text);
        $o->time = self::readableTime($o->time);
        $o->comments = $o->getComments();
        return $o;
    }

    /** translate Y-m-d to xx之前 or 今天XX
     *
     * @param type $date_time_str 形如 Y-m-d H:i:s （sql中获得的DateTime类型即可）
     */
    public function readableTime($date_time_str) {
        $date_time = new DateTime($date_time_str);
        $nowtime = new DateTime();
        $diff = $nowtime->diff($date_time);
        if ($diff->y==0 && $diff->m==0 && $diff->d==0) { // 同一天
            if ($diff->h<1) // 一个小时以内
                if ($diff->i==0) // 一分钟以内
                    return '刚刚';
                else
                    return $diff->i.'分钟前'; // minutes
            else
                return '今天';
        } else {
            return current(explode(' ', $date_time_str));
        }
    }
}

