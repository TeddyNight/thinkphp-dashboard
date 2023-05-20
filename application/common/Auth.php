<?php
namespace app\common;

use think\facade\Session;

class Auth {
    public static function isRole($role)
    {
        return (Session::get('role') == $role);
    }

    public static function getRole()
    {
        if (Session::has('role')) {
            return Session::get('role');
        }
        else {
            return "";
        }
    }

    public static function getAccount()
    {
        if (Session::has('account')) {
            return Session::get('account');
        }
        else {
            return "";
        }
    }

    public static function isLogin()
    {
        return Session::has('account');
    }

    public static function login($account,$role)
    {
        Session::set('account',$account);
        Session::set('role',$role);
    }
}