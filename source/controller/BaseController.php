<?php
/**
 * @file    init
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 11:50:49 AM
 */

use ptf\Controller;
use ptf\PdoWrapper;

class BaseController extends Controller
{
    protected $roleDao;
    protected $twitDao;

    public function __construct()
    {
        $this->roleDao = new RoleDao;
        $this->twitDao = new TwitDao;
    }

    public function init()
    {
        $this->page = new stdClass;
        $this->page->description = '伪博扮演，扮演整个世界';
        $this->page->keywords = array('伪博','扮演');

        PdoWrapper::config($this->config['db']);


        $this->role = $this->roleDao->getCurrentRole();

        $this->layout('layout/master');
    }
}

