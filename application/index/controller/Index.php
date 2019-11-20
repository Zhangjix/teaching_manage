<?php
namespace app\index\controller;

use app\index\controller\Base;

class Index extends Base

{
    public function index()
    {
        $this->isLogin();//判断是否登录
        return $this->fetch('');
    }

}
