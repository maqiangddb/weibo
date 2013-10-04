<?php

use ptf\IdEntity;

/**
 * Description of Twit
 *
 * @file    Twit
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 3:15:17 PM
 */
class Twit extends IdEntity {

    public function getComments() {
        $commentDao = new CommentDao;
        return $commentDao
            ->where('twit_id', $this->id())
            ->orderBy(array('id' => 'ASC'))
            ->findMany();
    }

    public static function formatHtml($text) { // this should be private, but...
        return preg_replace("/(@[^\s]+)(\sv)?($|\s)/", '[$1$2]', $text);
    }

    // override
    public static function make($model, $arr)
    {
        $o = parent::make($model, $arr);
        if ($arr) {
            if ($o->origin) {
                $o->orgin = $this->model->findOne($arr);
            }

            $o->text = self::formatHtml($o->text);
            $o->time = self::readableTime($o->time);
        }
        return $o;
    }

    /** 
     * translate Y-m-d to xx之前 or 今天XX
     *
     * @param type $date_time_str 形如 Y-m-d H:i:s （sql中获得的DateTime类型即可）
     */
    public static function readableTime($date_time_str) {
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

