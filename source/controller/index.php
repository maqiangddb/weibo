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
        $this->twits = Twit::getListForIndex($per_page, $offset);
        $this->rendView();
    }
}
