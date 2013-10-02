<?php
!defined('IN_KC') && exit('Access Denied');


/**
 * Description of Role
 *
 * @file    Role
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 10:13:11 AM
 */
class Role extends Model {

    public static $table = 'role';

    public static function getCurrentRole()
    {
        if (isset($_SESSION['se_role_id']) && $_SESSION['se_role_id']) {
            return self::findOne($_SESSION['se_role_id']);
        }
        return null;
    }

    public static function hasName($name)
    {
        $conds = array('name' => $name);
        return self::search()->where($conds)->findOne();
    }

    public static function getListForRoleIndex($limit, $offset)
    {
        return self::search()->limit($limit)->offset($offset)->findMany();
    }

    public static function getListLikeName($name)
    {
        return self::search()->where('name', 'like', "%$name%")->findMany();
    }

    public function creatTweet ($args) {

        //....
        $t = Twit::create();
        $t->author = $this->id;
        $t->text = $args['text'];
        $t->setExpr('time', 'NOW()');
        $t->save();

        $log = Log::create();
        $log->ip = $args['ip'];
        $log->role_id = $this->id;
        $log->twit_id = $t->id;
        $log->save();
    }

    public function top() {
        $roles = new Xcon(get_set($_COOKIE['top_role']));
        $roles->push($this->id);
        setcookie('top_role', $roles->stringify(), time() + 3600*24*365);
    }

    public function untop() {
        $roles = new Xcon(get_set($_COOKIE['top_role']));
        $roles->del($this->id);
        setcookie('top_role', $roles->stringify(), time() + 3600*24*180);
    }

    public function addTag($tag) {
        $tag_id = Tag::getIdByText($tag);
        //....
        Pdb::insert(array(
            'role'=>$this->id,
            'tag'=>$tag_id,
        ), 'role_tag_relation', 'ON DUPLICATE KEY UPDATE role=role');
    }

    public function getTags() {
        //....
        $r = Pdb::fetchAll('role_tag.tag', 'role_tag,role,role_tag_relation', array(
            'role.id=?'=>$this->id,
            'role.id=role_tag_relation.role'=>false,
            'role_tag_relation.tag=role_tag.id'=>false
        ));
        return array_map(function ($elem) {
            return $elem['tag'];
        }, $r);
    }

    public function countRecentTwit($days=30) {
        //....
        return Pdb::count('twit', array(
            'author=?'=>$this->id,
            "time>(CURDATE()-INTERVAL $days DAY)"=>false
        ));
    }

    public function recentTwit($conds=array()) {
        $conds = array_merge(array(
            'num'=>10,
            'role'=>$this->id,
        ), $conds);
        return Twit::listT($conds);
    }

    public static function getIdByName($name) {
        //....
        $r = Pdb::fetchRow('id', 'role', array('name=?'=>$name));
        return $r? $r['id'] : $r;
    }

    public function hot() {
        //....
        Pdb::update(array('hot=hot+1'=>null), self::$table, array('id=?'=>$this->id));
        if (rand(1, 1000) == 23) { // 千分之一的几率冷却
            Pdb::update(array('hot=hot/2'), self::$table);
        }
    }
    
    public function addToHistory() {
        $history = array();
        if (isset($_COOKIE['rh'])) { // role history
            $history = json_decode($_COOKIE['rh']);
        }
        array_unshift($history, $this->id);
        $history = array_unique($history);
        while (count($history) > 3) {
            array_pop($history);
        }
        
        $historyStr = json_encode(array_values($history));
        if (!setcookie('rh', $historyStr, strtotime('+180 days'), ROOT)) { // 180 days
            throw new Exception('set cookie fail');
        }
    }
    
    public function __get($name) {
        if ($name == 'id') return $this->id;
        if (empty($this->info)) $this->info = $this->info();
        return $this->info[$name];
    }
    
    public function info() {
        if (!empty($this->info)) return $this->info;
        return Pdb::fetchRow('*', self::$table, $this->selfCond());
    }
}

?>
