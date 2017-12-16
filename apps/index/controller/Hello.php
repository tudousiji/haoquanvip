<?php
namespace app\index\controller;

class Hello
{

    public function index($name = 'Hello')
    {
        return 'Hello,' . $name . '！end';
    }

    public function index2($name = 'Hello2')
    {
        return 'Hello,' . $name . '!';
    }
}