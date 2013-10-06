<?php

/**
 * @file    page404
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 11:13:21 AM
 */
class Page404Controller extends BaseController
{
    public function indexAction()
    {
        $this->layout('layout/simple');
        $this->showView('index/page404');
    }
}
