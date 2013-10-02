<?php
/**
 * @file    init
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 11:50:49 AM
 */

class baseController extends Controller
{
    public function __construct()
    {
        $this->page = new stdClass;
        $this->page->description = '伪博扮演，扮演整个世界';
        $this->page->keywords = array('伪博','扮演');

        ORM::configure($config['db']);

        $this->role = Role::getCurrentRole();
    }
}

