<?php

class IndexController extends AController
{
    public function indexAction()
    {
        $x = 'WAYLF';
        return At::setJsonRespon(null,null,$x);
    }
}