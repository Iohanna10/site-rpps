<?php

namespace App\Controllers\test;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function test1()
    {
        echo view('test/website-under-construction/home/header/head');
        echo view('test/website-under-construction/home/screen-bg-1');
    }

    public function test2()
    {
        echo view('test/website-under-construction/home/header/head');
        echo view('test/website-under-construction/home/screen-bg-2');
    }

    public function test3()
    {
        echo view('test/website-under-construction/home/header/head');
        echo view('test/website-under-construction/home/screen-bg-3');
    }
}
