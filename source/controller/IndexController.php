<?php
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
        $this->twits = Twit::getListForIndex($n, $p);
        $this->rendView();
    }
}
