<?php
namespace App\Controller;

use App\Controller\AppController;

class HeloController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('sample');
        $this->set('header', '* this is sample site *');
        $this->set('footer', 'copyright 2015 libro.');
    }

    public function index()
    {
        $str = $this->request->getData('text1');
        $msg = 'typed: ' . $str;
        if ($str == null)
            { $msg = "please type..."; }
        $this->set('message', $msg);
    }
}

