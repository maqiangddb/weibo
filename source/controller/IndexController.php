<?php

use ptf\lib\Paginate;

/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 27, 2012 6:24:01 PM
 */
class IndexController extends BaseController
{

    public function indexAction()
    {
        $p = $this->param('p', 1);
        $n = $this->param('n', 100);
        $this->twits = $this->twitDao->getListForIndex($n, $p);
        $this->role = $this->roleDao->getCurrentRole();
        $total = $this->twitDao->getTotalCount();
        $this->paginate = new Paginate($n, $total);
        $this->renderView('index/index');
    }
}
