<?php
!defined('IN_KC') && exit('Access Denied');
/**
 * @file    lib
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 27, 2012 6:27:14 PM
 * all kinds of functions
 */

function get_set(&$param, $or='') {
    return isset($param)? $param : $or;
}

function fill_empty(&$var, $filling) {
    if (empty($var)) {
        $var = $filling;
    }
}

function explo_path($path) {
    $ret = explode('/', $path);
    if (count($ret)==0) {
        $ret = array('index');
    }
    // if any of elem of array is empty, replace it with 'index'
    foreach ($ret as $k=>$v) {
        if ($v==='') {
            $ret[$k] = 'index';
        }
    }
    return $ret; // TODO 可以缩减
}

/**
 *
 * @global type $config
 * @param type $src
 * @param type $code
 * @return type
 * @version 0.3
 */
function js_node($src='', $code='') {
    $src_str = $src? ' src="' . ROOT . 'js/'.$src.'.js?v='.static_source_version('js').'"' : '';
    return '<script type="text/javascript"'.$src_str.'>'.$code.'</script>';
}

/**
 *
 * @global type $config
 * @param type $src
 * @param type $type
 * @return type
 * @version 0.3
 */
function css_node($src='', $type='css') {
    $rel = 'rel="stylesheet'.($type!='css'?'/'.$type:'').'"';
    $href = 'href="'.ROOT.'css/'.$src.'.'.$type.'?v='.static_source_version('css').'"';
    $type = 'type="text/css"';
    return "<link $rel $type $href />";
}

function js_var($var_name, $arr) {
    return js_node('', $var_name.'='.json_encode($arr));
}

/**
 *
 * @global type $config
 * @return \type
 * @throws Exception
 * @version 0.2
 */
function static_source_version($type='css') {
    global $config; // TODO
    if (DEBUG) {
        return time();
    } else if (ON_SERVER) {
        return $config['version'][$type];
    } else {
        throw new Exception;
    }
}

/** translate Y-m-d to xx之前 or 今天XX
 *
 * @param type $date_time_str 形如 Y-m-d H:i:s （sql中获得的DateTime类型即可）
 */
function friendly_time2($date_time_str) {
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
            return '今天'.end(explode(' ', $date_time_str));
    } else {
        return $date_time_str;
    }
}

function d($param, $var_dump=0) {
    global $config;
    if (DEBUG) {
        echo "<p><pre>\n";
        if ($var_dump) {
            var_dump($param);
        } else {
            print_r($param);
        }
        echo "</p></pre>\n";
    } else {
        return;
    }
}



function user_input($arr, $para_list) {
    if (!is_array($para_list)) {
        $para_list = array($para_list);
    }
    $ret = array();
    foreach ($para_list as $p) {
        $ret[$p] = trim(get_set($arr[$p]));
    }
    return $ret;
}

function image_resize ($file_content, $crop, $width, $height, $new_width, $new_height) {
    if ($new_width < 1 || $new_height < 1) {
        throw new Exception('specified size too small');
    } else if ($width<$new_width || $height<$new_height) {
        throw new Exception('too small');
    } else {
        $dst = imagecreatetruecolor($new_width, $new_height);
        $src_x = 0;
        $src_y = 0;
        if ($crop) {
            $ratio = $width / $height;
            $new_ratio = $new_width / $new_height;
            if ($ratio > $new_ratio) {
                $width = ceil($new_ratio * $height);
            } else if ($ratio < $new_ratio) {
                $height = ceil($width / $new_ratio);
            }
        }
        imagecopyresampled($dst, $file_content, 0, 0, $src_x, $src_y, $new_width, $new_height, $width, $height);
        return $dst;
    }
}

/**
 *
 * @param type $image
 * @param type $para resize crop width height
 * @return string
 * @throws Exception
 */
function make_image($image, $para=array()) {
    $para = array_merge(array(
        'crop' => 0,
        'resize' => 0,
        'width' => 50,
        'height' => 50,
    ), $para);
    $type = reset(explode('/', $image['type']));
    if ($type == 'image') {
        $arr = explode('.', $image['name']);
        if (count($arr) < 2) {
            throw new Exception('file name: '.$image['name']);
        }
        $extention = end($arr);
        $file_name = uniqid().'.'.$extention;
        $tmp_img = $image["tmp_name"];
        // resize and more
        if ($para['resize']) {
            list($width, $height) = getimagesize($tmp_img);
            $image_type = end(explode('/', $image['type']));
            switch ($image_type) {
                case 'jpeg':
                    $src = imagecreatefromjpeg($tmp_img);
                    $dst = image_resize($src, $para['crop'], $width, $height, $para['width'], $para['height']);
                    imagejpeg($dst, $tmp_img);
                    break;
                case 'png':
                    $src = imagecreatefrompng($tmp_img);
                    $dst = image_resize($src, $para['crop'], $width, $height, $para['width'], $para['height']);
                    imagepng($dst, $tmp_img);
                    break;
                case 'gif': // ??
                    $src = imagecreatefromgif($tmp_img);
                    $dst = image_resize($src, $para['crop'], $width, $height, $para['width'], $para['height']);
                    imagegif($dst, $tmp_img);
                    break;
                default :
                    break;
            }
        }
        $content = file_get_contents($tmp_img);

        global $config; // TODO
        global $root_path;
        if (ON_SERVER) {
            $up_domain = $config['up_domain'];
            $s = new SaeStorage();
            $s->write($up_domain , $file_name , $content);
            unlink($tmp_img);
            return $s->getUrl($up_domain ,$file_name);
        } else {
            $dst_root = $root_path.'data/upload/';
            $year_month_folder = date('Ym');
            $path = $year_month_folder;
            if (!file_exists($dst_root.$path)) {
                mkdir($dst_root.$path);
            }
            $date_folder = date('d');
            $path .= '/'.$date_folder;
            if (!file_exists($dst_root.$path)) {
                mkdir($dst_root.$path);
            }
            $path .= '/'.$file_name;
            file_put_contents($dst_root.$path, $content);
//            move_uploaded_file($tmp_img, $dst_root.$path);
            return ROOT . 'data/upload/' . $path;
        }
    } else { // maybe throw??
        return '';
    }
}

function out_json($arr, $quit=true) {
    echo json_encode($arr);
    if($quit){
        exit;
    }
}

function redirect($url='/') {
    header('Location:'.$url);
    exit();
}

function _tpl ($file_name) { // 漏洞？  还有，目录名是否可以变得更简便？
    return 'template/'.$file_name.'.php';
}

function _src ($file_name) {
    return 'source/'.$file_name.'.php';
}

function _class ($name) {
    return 'class/'.$name.'.php';
}

function _block($name) {
    return _tpl('block/'.$name);
}

function sae_log($msg){
    sae_set_display_errors(false);//关闭信息输出
    sae_debug($msg);//记录日志
    sae_set_display_errors(true);//记录日志后再打开信息输出，否则会阻止正常的错误信息的显示
}

?>