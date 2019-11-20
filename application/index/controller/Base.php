<?php
namespace app\index\controller;

use think\Controller;
use think\Session;

class Base extends Controller
{
    protected function _initialize()
    {
        parent::_initialize();
        define('USER_ID',Session::get('user_id'));
    }

    protected function isLogin()
    {
        if(empty(USER_ID)){
            $this->error('用户未登录,无权访问',url('/user/login'));
        }
    }


}