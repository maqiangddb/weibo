<?php
!defined('IN_KC') && exit('Access Denied');
/**
 * @file    role
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 10:04:46 AM
 */

if (count($_FILES) == 0 || !isset($_FILES['avatar'])) {
    die;
}

$_f = $_FILES['avatar'];
$ext = file_ext($_f['name']);
$new_name = uniqid().".$ext";
$fpath = write_upload(file_get_contents($_f['tmp_name']), $new_name);

echo json_encode(array('path' => $fpath));
exit;

