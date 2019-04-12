<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
	return "this is Index Index index";
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
