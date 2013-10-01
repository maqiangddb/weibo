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

    public function retweet($text, $role_id) {
        //....
        $info = $this->getInfo(!self::ORIGIN_EXPLODE);
        $origin_id = $this->id;
        $scene = $info['scene'];
        if ($info['origin'] != 0) { // is origin
            $text .= '//@'.$info['author'].($info['is_v']?' v':'').' ：'.$info['text'];
            $origin_id = $info['origin'];
        }
        $arr = array(
            'origin'     => $origin_id,
            'text'       => $text,
            'author'     => $role_id,
            'scene'      => $scene,
            'time=NOW()' => null,
        );
        Pdb::insert($arr, 'twit');
        $orgin = new self($this->id);
        $orgin->plusOne('retweet_num');

        $ip = $_SERVER['REMOTE_ADDR'];
        Log::update($ip, $role_id);

        if ($scene) {
            $scene = new Scene($scene);
            $scene->hit();
        }

        $this->hot(3);
    }

    private function plusOne($para) {
        //....
        $arr = array("$para=$para+1"=>false); // null is better than false
        $conds = array('id=?'=>$this->id);
        Pdb::update($arr, 'twit', $conds);
    }

    public function del() {
        //....
        $conds = array('id=?'=>$this->id);
        return Pdb::del($this->table, $conds);
    }

    public function prepareDel($will_del=1) {
        //....
        $conds = array('id=?'=>$this->id);
        Pdb::update(compact('will_del'), $this->table, $conds);
    }

    public function edit($arr) {
        //....
        $conds = array("id=?"=>$this->id);
        Pdb::update($arr, 'twit', $conds);
    }

    public static function getTotal() {
        //....
        return Pdb::count('twit');
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

